<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @category app
 * @package contrllers/e-s
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
        if (Input::hasPost('tren')) {  //si se envia el formulario
                $persona = new Tren(Input::post('tren')); //creamos el objeto y le damos los valores del formulario
                if ($persona->save()) { //verificamos si se guardaron los datos
                    Flash::valid('Guardado Exitoso');
                }
         }
    }
    
    protected function  after_filter() {
        if ( Input::isAjax() ){
            View::template(null); //si es ajax solo mostramos la vista
        }
    }
    
}