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
    
    //fución que devuelve el último tren guardado
    public function ultimo (){
        return $this->find_first("order: id desc");
    }
    
    //función que devuelve todos los trenes del día indicado en $fecha
    public function buscarDia ($fecha){
        $fecha2=date("Y-m-d",strtotime($fecha));
        return $this->find_all_by_sql("select * from tren where fecha_at = '$fecha2' order by hora_at ASC");
    }
    
}