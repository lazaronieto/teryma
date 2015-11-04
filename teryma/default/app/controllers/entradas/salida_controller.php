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
                //buscamos el último tren guardado para conocer el id
                $idUltimo = Load::model('entradas/tren')->ultimo();
                //buscamos los vagones que hay en la via del tren con limite nº vagones
                $vagones = Load::model('entradas/vagon')->vagonesVia($tren->vias_id, $tren->vagones);
                foreach($vagones as $row)://recorremos los vagones
                    $cajas = Load::model('vias/caja')->buscarVagon($row->id );//bucamos las cajas del vagón
                    $caja1=null; $caja2=null; $orden=1; // dos variables para las id de las cajas y una para el orden
                    foreach ($cajas as $caja): //recorremos las cajas
                        if($caja1==null){ // si la primera es null le damos el id de la caja
                            $caja1=$caja->id;
                            $caja->vagon_id=0; //la ponemos en un vagón ficticio
                            $caja->update();
                        }  else { // si hay otra caja le damos el id de la segunda
                            $caja2=$caja->id;
                            $caja->vagon_id=0; //la ponemos en un vagón ficticio
                            $caja->save();
                        }
                    endforeach;
                    //armamos un array para guardar composición
                    $arrayComp = array('vagon_id'=>$row->id, 'tren_id'=>$idUltimo->id, 'caja_id'=>$caja1, 'caja2_id'=>$caja2, 'orden'=>$orden);
                    $orden++; //aumentamos orden
                    $caja1=null; $caja2=null;// vaciamos las id de las cajas para el siguiente
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