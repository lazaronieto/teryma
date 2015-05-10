<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @category app
 * @package models/entradas
 * @author Lázaro Nieto Aranda
 * @date 05-may-2015
 * @time 10:42:10
 */

class Composicion extends ActiveRecord {
    
     //Se desabilita el logger para no llenar el archivo de "basura"
    public $logger = FALSE;
    
    public function initialize(){
        //Relaciones
        //Una tren solo puede estar en una vía
        $this->belongs_to('vias/vias');
    }
    
    public function contar($fecha, $tipo) {
        return $this->find_by_sql("select count(*) as total from composicion 
            INNER JOIN tren ON composicion.tren_id = tren.id 
            INNER JOIN vagon ON composicion.vagon_id = vagon.id
            WHERE tren.fecha_at >= '$fecha-01' AND tren.fecha_at <= '$fecha-31' AND vagon.tipo_id = $tipo;");
    }
}