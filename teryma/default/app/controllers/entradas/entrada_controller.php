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
        $num;
        if (Input::hasPost('tren')) {  //si se envia el formulario del tren
            $tren = new Tren(Input::post('tren')); //creamos el objeto y le damos los valores del formulario
            if ($tren->save()) { //verificamos si se guardaron los datos
                Flash::valid('Guardado Exitoso, Añade Vagones');
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
            Session::set('orden', Session::get('orden')+1);
            Load::models('entradas/vagon'); //cargamos el modelo
            $vagon = new Vagon(Input::post('vagon')); //creamos el objeto y le damos los valores del formulario
            if ($vagon->save()) { //verificamos si se guardaron los datos
                Flash::valid('Guardado Exitoso, Añade Cajas');
                $vag = Input::post('vagon');
                if(isset($vag['id_vagon'])){ // si existe id_vagon
                    $id_vagon = $vag['id_vagon']; // vamos ha buscar el id del vagón
                    $idVagon = Load::Model('entradas/vagon')->find_by_sql("select id from vagon where id_vagon = '$id_vagon'");
                    Session::set('vagon', $idVagon->id);// ponemos el id en la sesión vagon
                    Router::toAction('vagon'); //redireccionamos al formulario de los vagones
                }
            }
        }
        
        if (Input::hasPost('caja')) {  //si se envia el formulario del caja
            Load::models('vias/caja'); //cargamos el modelo caja
            $caja = new Caja(Input::post('caja')); //creamos el objeto y le damos los valores
            if ($caja->save()) { //verificamos si se guardaron los datos
                Flash::valid('Añade otra caja al vagón o vagón nuevo');
                //Router::toAction('vagon'); //redireccionamos al formulario de los vagones
            }
            
        }
    }
    
    protected function  after_filter() {
        if ( Input::isAjax() ){
            View::template(null); //si es ajax solo mostramos la vista
        }
    }
    
}