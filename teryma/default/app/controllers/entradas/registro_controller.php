<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @category app
 * @package cotrollers/entradas
 * @author Lázaro Nieto Aranda
 * @date 05-may-2015
 * @time 15:02:55
 */

class RegistroController extends BackendController {
    
    protected function before_filter() {
        //Se cambia el nombre de la página actual
        $this->page_title = 'Registro de circulación';
	//Se cambia el nombre del módulo actual
	$this->page_module = 'Entradas/Salidas';    
        
    }
    
    public function index() {
        if (Input::hasPost('fecha')) {
            $fecha = Input::post('fecha');
            $this->registro = Load::Model('entradas/tren')->find_all_by_sql("select * from tren where fecha_at = '$fecha' order by hora_at ASC");
        }
    }
            
    
    protected function  after_filter() {
        if ( Input::isAjax() ){
            View::template(null); //si es ajax solo mostramos la vista
        }
    }
}