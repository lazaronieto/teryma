<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @category app
 * @package models/vias
 * @author Lázaro Nieto Aranda
 * @date 16-abr-2015
 * @time 14:47:23
 */

class Vias extends ActiveRecord {
    
    //Se desabilita el logger para no llenar el archivo de "basura"
    public $logger = FALSE;
    
    public function initialize(){
        //Relaciones
        //Un especialidad tiene muchos profesionales
        $this->has_many('vias/vagon');
    }

    public function getVias() { 
        return $this->find();
        //return $this->find_all_by_sql("SELECT * FROM vias  ORDER BY id ASC");
    }
}