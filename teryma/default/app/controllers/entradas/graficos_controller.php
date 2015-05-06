<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @category app
 * @package controllers/entradas
 * @author Lázaro Nieto Aranda
 * @date 06-may-2015
 * @time 11:29:28
 */

class GraficosController extends BackendController {
    
    protected function before_filter() {
        //Se cambia el nombre de la página actual
        $this->page_title = 'Gráficos';
	//Se cambia el nombre del módulo actual
	$this->page_module = 'Entradas/Salidas';    
        
    }

	/**
     * Método principal
     */
    public function index() {
        if (Input::hasPost('año')) {
            $año = Input::post('año');
        }  else {
            $año = date('Y');
        }
        $this->ingles = Load::Model('entradas/composicion')->find_by_sql("select count(*) as total from composicion 
            INNER JOIN tren ON composicion.tren_id = tren.id 
            INNER JOIN vagon ON composicion.vagon_id = vagon.id
            WHERE tren.fecha_at >= '$año-01-01' AND tren.fecha_at <= '$año-12-31' AND vagon.tipo_id = 1;");
        $this->aleman = Load::Model('entradas/composicion')->find_by_sql("select count(*) as total from composicion 
            INNER JOIN tren ON composicion.tren_id = tren.id 
            INNER JOIN vagon ON composicion.vagon_id = vagon.id
            WHERE tren.fecha_at >= '$año-01-01' AND tren.fecha_at <= '$año-12-31' AND vagon.tipo_id = 2;");
        $this->autos = Load::Model('entradas/composicion')->find_by_sql("select count(*) as total from composicion 
            INNER JOIN tren ON composicion.tren_id = tren.id 
            INNER JOIN vagon ON composicion.vagon_id = vagon.id
            WHERE tren.fecha_at >= '$año-01-01' AND tren.fecha_at <= '$año-12-31' AND vagon.tipo_id = 3;");
        $this->porta = Load::Model('entradas/composicion')->find_by_sql("select count(*) as total from composicion 
            INNER JOIN tren ON composicion.tren_id = tren.id 
            INNER JOIN vagon ON composicion.vagon_id = vagon.id
            WHERE tren.fecha_at >= '$año-01-01' AND tren.fecha_at <= '$año-12-31' AND vagon.tipo_id = 4;");
        Flash::valid($this->ingles->total);
    }
    
    protected function  after_filter() {
        if ( Input::isAjax() ){
            View::template(null); //si es ajax solo mostramos la vista
        }
    }
}