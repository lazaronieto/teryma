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
 * @date 05-may-2015
 * @time 10:53:15
 */

Load::models('entradas/tren'); //cargamos el modelo
class SalidaController extends BackendController {
    
    protected function before_filter() {
        //Se cambia el nombre de la página actual
        $this->page_title = 'nueva salida';
	//Se cambia el nombre del módulo actual
	$this->page_module = 'Entradas/Salidas';    
        
    }
    
    public function index() {
        if (Input::hasPost('tren')) {  //si se envia el formulario del tren
            $tren = new Tren(Input::post('tren')); //creamos el objeto y le damos los valores del formulario
            if ($tren->save()) { //verificamos si se guardaron los datos
                Flash::valid('Guardada La Salida');
                //buscamos el último tren guardado
                $ultimo = Load::model('entradas/tren')->find_first("order: id desc");
                //buscamos los vagones que hay en la via del tren con limite nº vagones
                $vagones = Load::model('entradas/vagon')->find_all_by_sql("select * from vagon where vias_id = '$ultimo->vias_id' ORDER BY  orden DESC LIMIT $ultimo->vagones");
                foreach($vagones as $row)://recorremos los vagones
                    $cajas = Load::model('vias/caja')->find("vagon_id = $row->id ");//bucamos las cajas del vagón
                    $caja1=null; $caja2=null; $orden=1; // dos variables para las id de las cajas y una para el orden
                    foreach ($cajas as $value) :
                        if($caja1==null){
                            $caja1=$value->id;
                        }  else {
                            $caja2=$value->id;
                        }
                        //$value->delete(); //eliminamos caja
                    endforeach;
                    //armamos un array para guardar composición
                    $arrayComp = array('vagon_id'=>$row->id, 'tren_id'=>$ultimo->id, 'caja_id'=>$caja1, 'caja2_id'=>$caja2, 'orden'=>$orden);
                    $orden++; //aumentamos orden
                    Load::models('entradas/composicion'); //cargamos el modelo composicion
                    $composicion = new Composicion($arrayComp);//creamos el objeto con los valores del array
                    $composicion->save();//guardamos
                    //toca actualizar la via del vagón a vía 99
                    $row->vias_id=99;
                    $row->save();
                endforeach;
            }
        }
    }
    protected function  after_filter() {
        if ( Input::isAjax() ){
            View::template(null); //si es ajax solo mostramos la vista
        }
    }
}