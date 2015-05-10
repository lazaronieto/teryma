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
        $this->inglEner = Load::Model('entradas/composicion')->contar("$año-01", 1);
        $this->inglFebr = Load::Model('entradas/composicion')->contar("$año-02", 1);
        $this->inglMarz = Load::Model('entradas/composicion')->contar("$año-03", 1);
        $this->inglAbri = Load::Model('entradas/composicion')->contar("$año-04", 1);
        $this->inglMayo = Load::Model('entradas/composicion')->contar("$año-05", 1);
        $this->inglJuni = Load::Model('entradas/composicion')->contar("$año-06", 1);
        $this->inglJuli = Load::Model('entradas/composicion')->contar("$año-07", 1);
        $this->inglAgos = Load::Model('entradas/composicion')->contar("$año-08", 1);
        $this->inglSept = Load::Model('entradas/composicion')->contar("$año-09", 1);
        $this->inglOctu = Load::Model('entradas/composicion')->contar("$año-10", 1);
        $this->inglNovi = Load::Model('entradas/composicion')->contar("$año-11", 1);
        $this->inglDici = Load::Model('entradas/composicion')->contar("$año-12", 1);
        
        $this->alemEner = Load::Model('entradas/composicion')->contar("$año-01", 2);
        $this->alemFebr = Load::Model('entradas/composicion')->contar("$año-02", 2);
        $this->alemMarz = Load::Model('entradas/composicion')->contar("$año-03", 2);
        $this->alemAbri = Load::Model('entradas/composicion')->contar("$año-04", 2);
        $this->alemMayo = Load::Model('entradas/composicion')->contar("$año-05", 2);
        $this->alemJuni = Load::Model('entradas/composicion')->contar("$año-06", 2);
        $this->alemJuli = Load::Model('entradas/composicion')->contar("$año-07", 2);
        $this->alemAgos = Load::Model('entradas/composicion')->contar("$año-08", 2);
        $this->alemSept = Load::Model('entradas/composicion')->contar("$año-09", 2);
        $this->alemOctu = Load::Model('entradas/composicion')->contar("$año-10", 2);
        $this->alemNovi = Load::Model('entradas/composicion')->contar("$año-11", 2);
        $this->alemDici = Load::Model('entradas/composicion')->contar("$año-12", 2);
        
        $this->autoEner = Load::Model('entradas/composicion')->contar("$año-01", 3);
        $this->autoFebr = Load::Model('entradas/composicion')->contar("$año-02", 3);
        $this->autoMarz = Load::Model('entradas/composicion')->contar("$año-03", 3);
        $this->autoAbri = Load::Model('entradas/composicion')->contar("$año-04", 3);
        $this->autoMayo = Load::Model('entradas/composicion')->contar("$año-05", 3);
        $this->autoJuni = Load::Model('entradas/composicion')->contar("$año-06", 3);
        $this->autoJuli = Load::Model('entradas/composicion')->contar("$año-07", 3);
        $this->autoAgos = Load::Model('entradas/composicion')->contar("$año-08", 3);
        $this->autoSept = Load::Model('entradas/composicion')->contar("$año-09", 3);
        $this->autoOctu = Load::Model('entradas/composicion')->contar("$año-10", 3);
        $this->autoNovi = Load::Model('entradas/composicion')->contar("$año-11", 3);
        $this->autoDici = Load::Model('entradas/composicion')->contar("$año-12", 3);
        
        $this->portEner = Load::Model('entradas/composicion')->contar("$año-01", 4);
        $this->portFebr = Load::Model('entradas/composicion')->contar("$año-02", 4);
        $this->portMarz = Load::Model('entradas/composicion')->contar("$año-03", 4);
        $this->portAbri = Load::Model('entradas/composicion')->contar("$año-04", 4);
        $this->portMayo = Load::Model('entradas/composicion')->contar("$año-05", 4);
        $this->portJuni = Load::Model('entradas/composicion')->contar("$año-06", 4);
        $this->portJuli = Load::Model('entradas/composicion')->contar("$año-07", 4);
        $this->portAgos = Load::Model('entradas/composicion')->contar("$año-08", 4);
        $this->portSept = Load::Model('entradas/composicion')->contar("$año-09", 4);
        $this->portOctu = Load::Model('entradas/composicion')->contar("$año-10", 4);
        $this->portNovi = Load::Model('entradas/composicion')->contar("$año-11", 4);
        $this->portDici = Load::Model('entradas/composicion')->contar("$año-12", 4);
    }
    
    protected function  after_filter() {
        if ( Input::isAjax() ){
            View::template(null); //si es ajax solo mostramos la vista
        }
    }
}