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
 * @time 15:00:06
 */

class Vagon extends ActiveRecord {
    
     //Se desabilita el logger para no llenar el archivo de "basura"
    public $logger = FALSE;
    
    public function initialize(){
        //Relaciones
        //Un vagón solo puede estar en una vía
        $this->belongs_to('vias/vias');
        //Un vagón solo puede ser de un tipo
        $this->belongs_to('vias/tipo');
        //un vagón puede tener varias cajas
        $this->has_many('vias/caja');
    }
    
    //función que devuelve todos los vagones de una vía
    public function vagonesVia($via){
        return $this->find_all_by_sql("select * from vagon where vias_id = ".$via." order by orden asc");
    }
    
    //función que busca vagón por su numeración
    public function buscar ($id_vagon) {
        return $this->find_first("id_vagon='$id_vagon'");
    }
}