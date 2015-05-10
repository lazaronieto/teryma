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
 * @date 20-abr-2015
 * @time 23:20:49
 */

class Caja extends ActiveRecord {
    
     //Se desabilita el logger para no llenar el archivo de "basura"
    public $logger = FALSE;
    
    public function initialize(){
        //Relaciones
        //Una caja solo puede estar en un vagón
        $this->belongs_to('vias/vagon');
    }
    
    //función que busca caja por su numeración
    public function buscar ($id_caja) {
        return $this->find_first("id_caja = $id_caja");
    }
    
}