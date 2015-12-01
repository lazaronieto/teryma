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
Load::lib('fpdf/fpdf');
class PdfController extends BackendController {
    
    public function index($via) {
        //View::template(NULL);
        $this->page_title = 'Vía '.$via;
        $this->via =$via;
        
        $this->pd1=new FPDF();
        $this->pd1->AddPage();
        // Colores, ancho de línea y fuente en negrita
        $this->pd1->SetFillColor(255,0,0);
        $this->pd1->SetTextColor(255);
        $this->pd1->SetDrawColor(0,0,0);
        $this->pd1->SetLineWidth(.3);
        $this->pd1->SetFont('Arial','B');
        // Cabecera
        $w = array(30, 30, 30, 30, 40);
        $header = array('via'.$via, 'vagon', 'caja 1', 'caja 2', 'tipo');
        for($i=0;$i<count($header);$i++){
            $this->pd1->Cell($w[$i],7,$header[$i],1,0,'C',true);
        }
        $this->pd1->Ln();
        //Restauración de colores y fuentes
        $this->pd1->SetFillColor(224,235,255);
        $this->pd1->SetTextColor(0);
        $this->pd1->SetFont('');
        // Datos
        $fill = false;
        $linea=1;
        $vagones = Load::Model('vias/vagon')->vagonesVia($via);
        foreach($vagones as $row):
            $tipo = Load::model('vias/tipo')->tipoId($row->tipo_id);
            $cajas = $row->getCaja();
            $this->pd1->Cell($w[0],6,$linea,'LR',0,'C',$fill);
            $this->pd1->Cell($w[1],6,$row->id_vagon,'LR',0,'C',$fill);
            if (count($cajas)==2){
                $i=2;
                foreach ($cajas as $caja):
                    $this->pd1->Cell($w[$i],6,$caja->id_caja,'LR',0,'C',$fill);
                    $i++;
                 endforeach;
            }
            if (count($cajas)==1) {
                foreach ($cajas as $caja):
                    $this->pd1->Cell($w[2],6,$caja->id_caja,'LR',0,'C',$fill);
                 endforeach;
                 $this->pd1->Cell($w[3],6,'---','LR',0,'C',$fill);
            }
            if (count($cajas)==0) {
                $this->pd1->Cell($w[2],6,'---','LR',0,'C',$fill);
                $this->pd1->Cell($w[3],6,'---','LR',0,'C',$fill);
            }
            $this->pd1->Cell($w[4],6,$tipo -> tipo,'LR',0,'C',$fill);
            $fill = !$fill;
            $this->pd1->Ln();
            $linea++;
        endforeach;
        // Línea de cierre
        $this->pd1->Cell(array_sum($w),0,'','T');
    }
    
    
}