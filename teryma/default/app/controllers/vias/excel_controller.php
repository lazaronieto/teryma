<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @category app
 * @package controllers/vias
 * @author Lázaro Nieto Aranda
 * @date 27-abr-2015
 * @time 16:53:50
 */
Load::lib('PHPExcel/PHPExcel');
class ExcelController extends BackendController {
    
    public function index($via) {
        View::template(NULL);
        $this->page_title = 'Vía '.$via;
        $this->via =$via;
        
        
        $excel = new PHPExcel(); //nueva instancia
        $excel->getProperties()->setCreator("Teryma"); //autor
        $excel->getProperties()->setTitle("Via ".$via); //titulo

        //inicio estilos
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo->applyFromArray(
          array('alignment' => array( //alineacion
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'font' => array( //fuente
              'bold' => true,
              'size' => 20
            )
        ));

        $subtitulo = new PHPExcel_Style(); //nuevo estilo

        $subtitulo->applyFromArray(
          array('fill' => array( //relleno de color
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('argb' => 'FFCCFFCC')
            ),
            'borders' => array( //bordes
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));

        $bordes = new PHPExcel_Style(); //nuevo estilo

        $bordes->applyFromArray(
          array('borders' => array(
              'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
              'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ));
        //fin estilos

        $excel->createSheet(0); //crear hoja
        $excel->setActiveSheetIndex(0); //seleccionar hora
        $excel->getActiveSheet()->setTitle("Listado"); //establecer titulo de hoja

        //orientacion hoja
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        //tipo papel
        $excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

        //establecer impresion a pagina completa
        $excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        //fin: establecer impresion a pagina completa

        //establecer margenes
        $margin = 0.5 / 2.54; // 0.5 centimetros
        $marginBottom = 1.2 / 2.54; //1.2 centimetros
        $excel->getActiveSheet()->getPageMargins()->setTop($margin);
        $excel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $excel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $excel->getActiveSheet()->getPageMargins()->setRight($margin);
        //fin: establecer margenes

        $fila=1;
        $excel->getActiveSheet()->SetCellValue("A$fila", "Via ".$via);
        $excel->getActiveSheet()->mergeCells("A$fila:E$fila"); //unir celdas
        $excel->getActiveSheet()->setSharedStyle($titulo, "A$fila:E$fila"); //establecer estilo

        //titulos de columnas
        $fila+=1;
        $excel->getActiveSheet()->SetCellValue("A$fila", 'Silla');
        $excel->getActiveSheet()->SetCellValue("B$fila", 'VAGON');
        $excel->getActiveSheet()->SetCellValue("C$fila", 'CAJA 1');
        $excel->getActiveSheet()->SetCellValue("D$fila", 'CAJA 2');
        $excel->getActiveSheet()->SetCellValue("E$fila", 'TIPO');
        $excel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:E$fila"); //establecer estilo
        $excel->getActiveSheet()->getStyle("A$fila:E$fila")->getFont()->setBold(true); //negrita

        //rellenar con contenido
        $vagones = Load::Model('vias/vagon')->vagonesVia($via); //buscamos los vagones de la vía
        $linea=1; // variable para salto de linea
        foreach($vagones as $row): //recorremos los vagones
            $fila+=1;
            $tipo = Load::model('vias/tipo')->tipoId($row->tipo_id); //buscamos de que tipo es
            $cajas = $row->getCaja(); //obtenemos las cajas por la relación en los modelos
            $excel->getActiveSheet()->SetCellValue("A$fila", $linea);
            $excel->getActiveSheet()->SetCellValue("B$fila",$row->id_vagon);
            if (count($cajas)==2){ //si tiene dos cajas
                $i='C';
                foreach ($cajas as $caja):
                    $excel->getActiveSheet()->SetCellValue($i.$fila,$caja->id_caja);
                    $i='D';
                 endforeach;
            }
            if (count($cajas)==1) { //si tiene una sola caja
                foreach ($cajas as $caja):
                    $excel->getActiveSheet()->SetCellValue("C$fila",$caja->id_caja);
                 endforeach;
                 $excel->getActiveSheet()->SetCellValue("D$fila",'---');
            }
            if (count($cajas)==0) {
                $excel->getActiveSheet()->SetCellValue("C$fila",'---');
                $excel->getActiveSheet()->SetCellValue("D$fila",'---');
            }
            $excel->getActiveSheet()->SetCellValue("E$fila",$tipo -> tipo);
            $linea++;
            //Establecer estilo
            $excel->getActiveSheet()->setSharedStyle($bordes, "A$fila:E$fila");

        endforeach;

        //recorrer las columnas
        foreach (range('A', 'E') as $columnID) {
          //autodimensionar las columnas
          $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);  
        }

        //establecer pie de impresion en cada hoja
        $excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');

        $this->objWriter = new PHPExcel_Writer_Excel5($excel); //Escribir archivo
    }
    
}