<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @category app
 * @package models/e-s
 * @author Lázaro Nieto Aranda
 * @date 02-may-2015
 * @time 12:00:51
 */

class Tren extends ActiveRecord {
    
     //Se desabilita el logger para no llenar el archivo de "basura"
    public $logger = FALSE;
    
    public function initialize(){
        //Relaciones
        //Una tren solo puede estar en una vía
        $this->belongs_to('vias/vias');
    }
    
}