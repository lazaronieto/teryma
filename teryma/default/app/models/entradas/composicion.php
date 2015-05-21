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
        //Una composicón solo puede tener un vagón
        $this->belongs_to('entradas/vias');
        //un composición puede tener varias cajas
        $this->has_many('vias/caja');
        //un composición puede estar en varios trenes
        $this->has_many('entradas/tren');
    }
    
    // función para contar los vagones que salieron o entraron de la playa filtrados por fecha y tipo de vagón
    public function contar($fecha, $tipo) {
        return $this->find_by_sql("select count(*) as total from composicion 
            INNER JOIN tren ON composicion.tren_id = tren.id 
            INNER JOIN vagon ON composicion.vagon_id = vagon.id
            WHERE tren.fecha_at >= '$fecha-01' AND tren.fecha_at <= '$fecha-31' AND vagon.tipo_id = $tipo;");
    }
    
    //función que devuelve una fila de la composición filtrado por tren y vagón
    public function buscarFila ($vagon_id, $tren_id){
        return $this->find_by_sql("select * from composicion where vagon_id = $vagon_id and tren_id = $tren_id;");
    }
    
    // función para contar los vagones que salieron o entraron de la playa filtrados por tren y tipo de vagón
    public function contarTipo($tren, $tipo) {
        return $this->find_by_sql("select count(*) as total from composicion where tren_id = $tren and vagon_id IN (select id from vagon where tipo_id = $tipo ); ");
    }
}