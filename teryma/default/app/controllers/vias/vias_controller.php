<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @category app
 * @package controllers/vias
 * @author Lázaro Nieto Aranda
 * @date 16-abr-2015
 * @time 14:07:23
 */
//Load::models('vias/vias');

class ViasController extends BackendController {

    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre de la página actual
        $this->page_title = 'playa de vías';
	//Se cambia el nombre del módulo actual
	$this->page_module = 'Estado de las vías';    
        
    }

	/**
     * Método principal
     */
    public function index() {
        Redirect::toAction('listar');
    }

	/**
     * Método para listar
     */
    public function listar() {
        $this->vias = Load::model('vias/vias')->getVias();
        foreach($this->vias as $row):
            $row->vagones = Load::Model('vias/vagon')->vagonesVia($row->id);
            foreach($row->vagones as $vag):
                $vag->tipo = Load::model('vias/tipo')->tipoId($vag->tipo_id);
                $cajas = $vag->getCaja();
                if (count($cajas)==2){
                    $vag->caja1 = $cajas[0]->id_caja;
                    $vag->caja2 = $cajas[1]->id_caja;
                    $vag->img = 2;
                    $vag->cont = 2;
                }
                if (count($cajas)==1){
                    if($vag->tipo->tipo=='aleman' || $vag->tipo->tipo=='portacontenedor'){
                        $vag->img = 1;
                        $vag->cont = 2;
                        $vag->caja1 = $cajas[0]->id_caja;
                        $vag->caja2 = ' --- ';
                    }elseif ($vag->tipo->tipo=='ingles') {
                        $vag->img = 1;
                        $vag->cont = 1;
                        $vag->caja1 = $cajas[0]->id_caja;
                        $vag->caja2 = null;
                    }
                    
                }
                if (count($cajas)==0){
                    if($vag->tipo->tipo=='aleman' || $vag->tipo->tipo=='portacontenedor'){
                        $vag->img = 0;
                        $vag->cont = 2;
                        $vag->caja1 = ' --- ';
                        $vag->caja2 = ' --- ';
                    }elseif ($vag->tipo->tipo=='ingles') {
                        $vag->img = 0;
                        $vag->cont = 1;
                        $vag->caja1 = ' --- ';
                        $vag->caja2 = null;
                    }
                }
            endforeach;
        endforeach;
    }
    
    public function listarVia($via){
        $this->page_title = 'Vía '.$via;
        $this->vagones = Load::Model('vias/vagon')->vagonesVia($via);
        foreach($this->vagones as $row):
            $row->tipo = Load::model('vias/tipo')->tipoId($row->tipo_id);
            $cajas = $row->getCaja();
            if (count($cajas)==2){
                $row->caja1 = $cajas[0]->id_caja;
                $row->caja2 = $cajas[1]->id_caja;
            }
            if (count($cajas)==1){
                $row->caja1 = $cajas[0]->id_caja;
                $row->caja2 = ' --- ';
            }
            if (count($cajas)==0){
                $row->caja1 = ' --- ';
                $row->caja2 = ' --- ';
            }
            
        endforeach;
        $this->via= $via;
    }
    
    public function ordenar($orden){
        View::template(NULL);
        //if (Input::hasPost(orden)) {
            //$orden = Input::hasPost(orden);
            $suborden = explode("y", $orden);//separo las dos vías
            $ordenVia1 = explode('_', $suborden[0]);//separo la vía de los vagones en la primera vía
            $ordenVia2 = explode('_', $suborden[1]);//separo la vía de los vagones en la segunda vía
            $ordenVagonVia1 = explode(',',$ordenVia1[1]);// las id en formato va-1 de los vagones primera vía
            $or=1;
            foreach($ordenVagonVia1 as $vag):
                $vagon=$this->vag = Load::model('vias/vagon')->find(substr($vag, 3));
                $vagon->vias_id = substr($ordenVia1[0], 2) ;
                $vagon->orden = $or;
                $vagon->update();
                $or++;
            endforeach;
            $or=1;
            
            try{
            if(isset($ordenVia2[1])){
                $ordenVagonVia2 = explode(',',$ordenVia2[1]);
                foreach($ordenVagonVia2 as $vag):
                    $vagon=$this->vag = Load::model('vias/vagon')->find(substr($vag, 3));
                    $vagon->vias_id = substr($ordenVia2[0], 2) ;
                    $vagon->orden = $or;
                    $vagon->update();
                    $or++;
                endforeach;
            }
            }
            catch (Exception $e){
                
            }
            Redirect::toAction('listar');
        //}
    }
    
    protected function  after_filter() {
        if ( Input::isAjax() ){
            View::template(null); //si es ajax solo mostramos la vista
        }
    }

}