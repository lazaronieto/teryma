<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @category app
 * @package contrllers/entradas
 * @author Lázaro Nieto Aranda
 * @date 02-may-2015
 * @time 8:12:28
 */
Load::models('entradas/tren'); //cargamos el modelo
class EntradaController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre de la página actual
        $this->page_title = 'nueva entrada';
	//Se cambia el nombre del módulo actual
	$this->page_module = 'Entradas/Salidas';    
        
    }
    
    /**
     * Método principal
     */
    public function index() {
        $this->via='';
        $this->orden=0;
        $this->vagon='';
        if (Input::hasPost('tren')) {  //si se envia el formulario del tren
            $tren = new Tren(Input::post('tren')); //creamos el objeto y le damos los valores del formulario
            if ($tren->save()) { //verificamos si se guardaron los datos
                Flash::valid('Guardada Entrada, Añade Vagones');
                $via = Input::post('tren');
                if(isset($via['vias_id'])){ // si existe vias_id la guardamos en una sesión
                    Session::set('via', $via['vias_id']);
                    Session::set('orden', 1); //creamos una sesión para el orden de los vagones
                   //$this->via=$via['vias_id']; 
                   //$this->orden=1;
                    Router::toAction('vagon'); //redireccionamos al formulario de los vagones
                }
            }
        }
    }
    
    public function vagon() {
        $this->page_title = 'Composición';
        if (Input::hasPost('vagon')) {  //si se envia el formulario del vagon
            Load::models('entradas/vagon'); //cargamos el modelo
            $vag = Input::post('vagon'); $vagon;
            $id_vagon = $vag['id_vagon'];
            if(Load::model('entradas/vagon')->exists("id_vagon='$id_vagon'")){
                //si existe el vagón
                $vagon = Load::model('entradas/vagon')->find_first("id_vagon='$id_vagon'");
                $vagon->vias_id = Session::get('via');
            }  else {// si no existe
                $vagon = new Vagon(Input::post('vagon')); //creamos el objeto y le damos los valores del formulario
            }
            
            if ($vagon->save()) { //verificamos si se guardaron los datos
                Flash::valid('Guardado Exitoso, Añade Cajas');
                
                if(isset($vag['id_vagon'])){ // si existe id_vagon
                    $id_vagon = $vag['id_vagon']; // vamos ha buscar el id del vagón
                    $idVagon = Load::model('entradas/vagon')->find_by_sql("select id from vagon where id_vagon = '$id_vagon'");
                    Session::set('vagon', $idVagon->id);// ponemos el id en la sesión vagon
                    Router::toAction('vagon'); //redireccionamos al formulario de los vagones
                }
                //buscamos el último tren guardado
                $tren = Load::model('entradas/tren')->find_first("order: id desc");
                Session::set('tren',$tren->id);// sesion para guardar la caja en la composicion
                //armamos un array para la tabla composicion
                $arrayComp = array('vagon_id'=>Session::get('vagon'), 'tren_id'=>$tren->id, 'caja_id'=>null, 'caja2_id'=>null, 'orden'=>Session::get('orden'));
                Load::models('entradas/composicion');//cargamos el modelo composicion
                $composicion = new Composicion($arrayComp);//creamos el objeto con los valores del array
                $composicion->save();//guardamos para modificar luego si hay caja
            	Session::set('orden', Session::get('orden')+1);//incrementamos en uno la sesión orden
            }//fin de if($vagon->save())
        }
        
        if (Input::hasPost('caja')) {  //si se envia el formulario del caja
            Load::models('vias/caja'); //cargamos el modelo caja
            $caj = Input::post('caja'); $caja;
            $id_caja = $caj['id_caja'];
            if(Load::model('vias/caja')->exists("id_caja='$id_caja'")){
                //si existe la caja
                $caja = Load::model('entradas/vagon')->find_first("id_caja='$id_caja'");
                $caja->vagon_id = Session::get('vagon');
                $caja->carga = 'salida';
            }  else {// si no existe
                $caja = new Caja(Input::post('caja')); //creamos el objeto y le damos los valores del formulario
            }
            if ($caja->save()) { //verificamos si se guardaron los datos
                Flash::valid('Añade otra caja al vagón o vagón nuevo');
                //Router::toAction('vagon'); //redireccionamos al formulario de los vagones
				//buscamos el id de la caja recordar que todos los id son auto-increment
				$idCaja = Load::model('entradas/caja')->find_first("conditions: id_caja ='$caja->id_caja'", "columns: id");
				//buscamos la fila a modificar de composicion
				$fila = Load::model('entradas/composicion')->find_by_sql("select * from composicion where vagon_id = ".Session::get('vagon')." and tren_id = ".Session::get('tren'));
				//si la primera caja esta vacia colocamos el id de la caja
				if ($fila->caja_id == null){
					$fila->caja_id = $idCaja->id;
				}else{ //si no se la colocamos a la segunda caja
					$fila->caja2_id =$idCaja->id;
				}
				$fila->save(); //guardamos los cambios
            }
            
        }
    }
    
    protected function  after_filter() {
        if ( Input::isAjax() ){
            View::template(null); //si es ajax solo mostramos la vista
        }
    }
    
}