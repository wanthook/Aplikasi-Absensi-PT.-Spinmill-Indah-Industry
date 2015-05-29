<?php 
phpexcel();

$phpExcel = new PHPExcel();

$phpExcel->getProperties()->setCreator("Spinmill Indah Industry, PT.")
         ->setLastModifiedBy("Spinmill Indah Industry, PT.")
         ->setDescription("Laporan Absen Komulatif XLSX")
         ->setKeywords("office 2007 openxml php")
         ->setCategory("Laporan Absen Komulatif XLSX");

$col = 0;
$row = 1;

$phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "PT. Spinmill Indah Industry", PHPExcel_Cell_DataType::TYPE_STRING)
                                    ->setCellValueExplicitByColumnAndRow($col, ++$row, "Periode :", PHPExcel_Cell_DataType::TYPE_STRING)
                                    ->setCellValueExplicitByColumnAndRow($col+1, $row, $periode, PHPExcel_Cell_DataType::TYPE_STRING);

$row+=3;

$cAwal = null;
$cAkhir = null;
$cAkhirHead = null;

$cAwal = $phpExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getCoordinate();

$r = 0;

foreach($tabel as $tbl)
{
    
    
    for($i=0 ; $i < count($tbl) ; $i++)
    {
        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tbl[$i], PHPExcel_Cell_DataType::TYPE_STRING);
        
        if($r==0)
        {
            $cAkhirHead = $phpExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getCoordinate();
        }
        
        $col++;
    }
    
    $cAkhir = $phpExcel->getActiveSheet()->getCellByColumnAndRow($col-1, $row)->getCoordinate();
    
    $col=0;
    $row+=1;
    $r++;
    
}

/*
* buat style garis untuk head
*/
$phpExcel->getActiveSheet()->getStyle
       (
           $cAwal.":".$cAkhir
       )->applyFromArray
           (
               array
                   (
                       'font'        =>array
                                       (
                                           'color' =>array('rgb' => '000000')
                                       ),
                       'alignment'    => array
                                       (
                                           'wrap'       => false,
                                           'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                           'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
                                       ),
                       'borders'       => array
                                       (
                                           'allborders' => array
                                           (
                                               'style' => PHPExcel_Style_Border::BORDER_THIN,
                                               'color' => array('argb' => '00000000')
                                           )
                                       )
                   )
           );

$phpExcel->getActiveSheet()->getStyle
       (
           $cAwal.":".$cAkhirHead
       )->applyFromArray
           (
               array
                   (
                       'font'        =>array
                                       (
                                           'color' =>array('rgb' => '000000'),
                                           'bold' => true
                                       ),
                       'alignment'    => array
                                       (
                                           'wrap'       => true,
                                           'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                           'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
                                       ),
                       'borders'       => array
                                       (
                                           'allborders' => array
                                           (
                                               'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                                               'color' => array('argb' => '00000000')
                                           )
                                       )
                   )
           );

$phpExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Laporan Absen Komulatif Periode '.$periode.'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
$objWriter->save('php://output');

$phpExcel->disconnectWorksheets();
unset($phpExcel);
?>