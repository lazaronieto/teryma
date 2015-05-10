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
            $this->registro = Load::Model('entradas/tren')->buscarDia($fecha);
            foreach($this->registro as $row):
                $row->tipo1 = Load::Model('entradas/composicion')->contarTipo($row->id, 1);
                $row->tipo2 = Load::Model('entradas/composicion')->contarTipo($row->id, 2);
                $row->tipo3 = Load::Model('entradas/composicion')->contarTipo($row->id, 3);
                $row->tipo4 = Load::Model('entradas/composicion')->contarTipo($row->id, 4);
            endforeach;
        }
    }
            
    
    protected function  after_filter() {
        if ( Input::isAjax() ){
            View::template(null); //si es ajax solo mostramos la vista
        }
    }
}