<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @category 
 * @package 
 * @author Lázaro Nieto Aranda
 * @date 20-abr-2015
 * @time 10:31:17
 */

class Tipo extends ActiveRecord {
    
     //Se desabilita el logger para no llenar el archivo de "basura"
    public $logger = FALSE;
    
    public function initialize(){
        //Relaciones
        //Un vagón solo puede ser de un tipo
        $this->belongs_to('vias/vagon');
    }
    
}