<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @category app
 * @package controllers
 * @author Lázaro Nieto Aranda
 * @date 26-abr-2015
 * @time 16:28:28
 */
//Load::lib('fpdf/fpdf');
class PdfController extends BackendController {
    
    public function index($via) {
        //View::template(NULL);
        $this->page_title = 'Vía '.$via;
        $this->via =$via;
    }
    
    
}