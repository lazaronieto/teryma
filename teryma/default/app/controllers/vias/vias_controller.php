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
        if (Input::hasPost('orden')) {
            
        }
    }
    
    public function listarVia($via){
        $this->page_title = 'Vía '.$via;
        $this->vagones = Load::Model('vias/vagon')->find_all_by_sql("select * from vagon where vias_id = '$via' order by orden");
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
            $ordenVagonVia2 = explode(',',$ordenVia2[1]);// las id en formato va-1 de los vagones segunda vía
            $or=1;
            foreach($ordenVagonVia1 as $vag):
                $vagon=$this->vag = Load::model('vias/vagon')->find(substr($vag, 3));
                $vagon->vias_id = substr($ordenVia1[0], 2) ;
                $vagon->orden = $or;
                $vagon->update();
                $or++;
            endforeach;
            $or=1;
            foreach($ordenVagonVia2 as $vag):
                $vagon=$this->vag = Load::model('vias/vagon')->find(substr($vag, 3));
                $vagon->vias_id = substr($ordenVia2[0], 2) ;
                $vagon->orden = $or;
                $vagon->update();
                $or++;
            endforeach;
            Redirect::toAction('listar');
        //}
    }
    
    protected function  after_filter() {
        if ( Input::isAjax() ){
            View::template(null); //si es ajax solo mostramos la vista
        }
    }

}