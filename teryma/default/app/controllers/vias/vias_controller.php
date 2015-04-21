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
        //$vias = new Vias();
        //$this->vias = $vias -> getVias();
        $this->vias = Load::model('vias/vias')->getVias();
    }
    
    public function listarVia($via){
		$this->page_title = 'Vía '.$via;
		$this->vagones = Load::Model('vias/vagon')->find_all_by_sql("select * from vagon where vias_id = '$via'");
	}


}