<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

phpexcel();

$head_style = array('font' =>array('color' =>array('rgb' => '000000'),'bold' => true),
                    'alignment' => array('wrap' => false,'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
                    'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,'color' => array('argb' => '00000000')))
                    );
$content_style = array('font' =>array('color' =>array('rgb' => '000000'),'bold' => false),
                    'alignment' => array('wrap' => true,'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
                    'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '00000000')))
                    );

$phpExcel = new PHPExcel();

$phpExcel->getProperties()->setCreator("Spinmill Indah Industry, PT.")
         ->setLastModifiedBy("Spinmill Indah Industry, PT.")
         ->setDescription("Laporan Absen Kantin XLSX")
         ->setKeywords("office 2007 openxml php")
         ->setCategory("Laporan Absen Kantin XLSX");

$tanggal = "";

$sheet = 0;

$periode = "";
//print_r($data);
foreach($data as $dataX)
{
    $col = 0;
    $row = 1;
    $tanggal = $dataX['tanggal'];
    /*
     * buat sheet dengan label vendor
     */
    $ws = new PHPExcel_Worksheet($phpExcel, $dataX['vendor']);            
    $phpExcel->addSheet($ws, $sheet);
   
    
    /*
     * pilih sheet aktif
     */
    $phpExcel->setActiveSheetIndex($sheet);
    
    /*
     * buat info
     * =================================
     *      A(0)        B(1)      C(2)
        1  Tanggal      :	04-02-2015
        2  Vendor       : 	Vendor
        3  Jumlah PIN   :	1
        4  Jumlah Log   :	2
     * =================================
     */
    
    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col,$row,"Tanggal",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+1,$row,":",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+2,$row,$dataX['tanggal'],PHPExcel_Cell_DataType::TYPE_STRING);
    
    $row+=1;
    
    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col,$row,"Vendor",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+1,$row,":",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+2,$row,$dataX['vendor'],PHPExcel_Cell_DataType::TYPE_STRING);
    
    $row+=1;
    
    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col,$row,"Jumlah PIN",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+1,$row,":",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+2,$row,$dataX['jumlah_tiket'],PHPExcel_Cell_DataType::TYPE_STRING);
    
    $row+=1;
    
    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col,$row,"Jumlah Log",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+1,$row,":",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+2,$row,$dataX['jumlah_log'],PHPExcel_Cell_DataType::TYPE_STRING);
    
    $row+=2;
    
    /*
     * buat header table
     * ================
          A(0)    B(1)      C(2)            D(3)           E(4)         F(5)          G(6)
       6  NO      PIN       NAMA         WAKTU LOG        SHIFT         JADWAL      MESIN LOG
     * =================
     */
    
    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col,$row,"NO",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+1,$row,"PIN",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+2,$row,"NAMA",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+3,$row,"WAKTU LOG",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+4,$row,"SHIFT",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+5,$row,"JADWAL",PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+6,$row,"MESIN LOG",PHPExcel_Cell_DataType::TYPE_STRING);
    
    $phpExcel->getActiveSheet()->getStyle($phpExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getCoordinate().":".$phpExcel->getActiveSheet()->getCellByColumnAndRow($col+6, $row)->getCoordinate())->applyFromArray($head_style);
    $row+=1;
    
    /*
     * ISI KONTENT
     */
    $cColCon = $col;
    $cRowCon = $row;
    if(count($dataX['data'])>0)
    {
        $no = 1;
        foreach($dataX['data'] as $dX)
        {
            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col,$row,$no,PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+1,$row,$dX->pin,PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+2,$row,$dX->nama_karyawan,PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+3,$row,$dX->jam,PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+4,$row,$dX->shift,PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+5,$row,$dX->jadwal,PHPExcel_Cell_DataType::TYPE_STRING)
                               ->setCellValueExplicitByColumnAndRow($col+6,$row,$dX->mesin_nama,PHPExcel_Cell_DataType::TYPE_STRING);
            $row++;
            $no++;
        }
    }
    else
    {
        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col,$row,"TIDAK ADA DATA",PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col,$row, $col+6, $row);
        $row++;
    }
    
    $phpExcel->getActiveSheet()->getStyle($phpExcel->getActiveSheet()->getCellByColumnAndRow($cColCon, $cRowCon)->getCoordinate().":".$phpExcel->getActiveSheet()->getCellByColumnAndRow($col+6, $row-1)->getCoordinate())->applyFromArray($content_style);
    
    $sheet ++;
}

//foreach($halaman as $hal)
//{
//    
//    if($periode=="")
//    {
//        $periode = $hal['periode'];
//    }
//    /*
//     * info karyawan pada excel
//     * Nama: strtoupper($hal['nama'])
//     * Unit
//     */
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Nama :", PHPExcel_Cell_DataType::TYPE_STRING)
//                                    ->setCellValueExplicitByColumnAndRow($col+1, $row, strtoupper($hal['nama']), PHPExcel_Cell_DataType::TYPE_STRING)
//                                    ->setCellValueExplicitByColumnAndRow($col, ++$row, "Unit Kerja :", PHPExcel_Cell_DataType::TYPE_STRING)
//                                    ->setCellValueExplicitByColumnAndRow($col+1, $row, strtoupper($hal['unit_kerja']), PHPExcel_Cell_DataType::TYPE_STRING)
//                                    ->setCellValueExplicitByColumnAndRow($col, ++$row, "NIK :", PHPExcel_Cell_DataType::TYPE_STRING)
//                                    ->setCellValueExplicitByColumnAndRow($col+1, $row, strtoupper($hal['nik']), PHPExcel_Cell_DataType::TYPE_STRING)
//                                    ->setCellValueExplicitByColumnAndRow($col, ++$row, "PIN :", PHPExcel_Cell_DataType::TYPE_STRING)
//                                    ->setCellValueExplicitByColumnAndRow($col+1, $row, strtoupper($hal['pin']), PHPExcel_Cell_DataType::TYPE_STRING);
//    
//    /*
//     * ganti baris
//     */
//    $row+=1;
//    
//    /*
//     * Simopan kordinat Awal
//     * kordinat awal untuk style head
//     */
//    $cAwal = $phpExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getCoordinate();
//    
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Tanggal", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);
//    
//    $col += 1;
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Jadwal Kerja", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col+1, $row);
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row+1, "M", PHPExcel_Cell_DataType::TYPE_STRING);
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col+1, $row+1, "K", PHPExcel_Cell_DataType::TYPE_STRING);
//    
//    $col += 2;
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Jam Kerja", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col+1, $row);
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row+1, "M", PHPExcel_Cell_DataType::TYPE_STRING);
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col+1, $row+1, "K", PHPExcel_Cell_DataType::TYPE_STRING);
//    
//    $col += 2;
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Masuk", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col+1, $row);
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row+1, "C", PHPExcel_Cell_DataType::TYPE_STRING);
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col+1, $row+1, "T", PHPExcel_Cell_DataType::TYPE_STRING);
//    
//    $col += 2;
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Pulang", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col+1, $row);
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row+1, "C", PHPExcel_Cell_DataType::TYPE_STRING);
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col+1, $row+1, "T", PHPExcel_Cell_DataType::TYPE_STRING);
//    
//    $col += 2;
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Keterangan", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);
//    
//    $col += 1;
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Lembur\nAktual", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);
//    
//    $col += 1;
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Hitung\nLembur", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);
//    
//    $col += 1;
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Shift\nMalam", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);
//    
//    $col += 1;
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Lembur\nLibur\nNas", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);
//    
//    $col += 1;
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Hitung\nLibur\nNas", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);
//    
//    $col += 1;
//    
//    $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Total\nLembur", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);
//    
//        
//    /*
//     * posisikan kursor pada posisi setelah head
//     * pada kolom pertama dan baris setelah head
//     */
//    $col=0;
//    $row+=2;
//    
//    
//    if(count($hal['tabel']>0))
//    {
//        $hitLembur = 0;
//        $hitNas = 0;
//        $sMalam = 0;
//        $totLem = 0;
////        print_r($hal['tabel']);
//        foreach($hal['tabel'] as $tabel)
//        {
//            $col = 0;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['tanggal'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['jadwal_masuk'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['jadwal_keluar'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['jam_masuk'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['jam_keluar'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['masuk_cepat'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['masuk_telat'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['keluar_cepat'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['keluar_telat'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, str_replace("&nbsp;","", $tabel['als']), PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['jam_lemact'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['hit_lemact'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['shift3'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['jam_libnas'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['hit_libnas'], PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $col += 1;
//            
//            $tSementara = $tabel['hit_lemact'] + $tabel['hit_libnas'];
//            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tSementara, PHPExcel_Cell_DataType::TYPE_STRING);
//            
//            $hitLembur += $tabel['hit_lemact'];
//            $hitNas += $tabel['hit_libnas'];
//            $sMalam += $tabel['shift3'];
//            $totLem += $tSementara;
//            
//            
//            $row += 1;
//        }
//        
//        $col = 0;
//        
//        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Jumlah", PHPExcel_Cell_DataType::TYPE_STRING)
//                               ->mergeCellsByColumnAndRow($col, $row, $col+10, $row);
//        
//        $col += 11;
//        
//        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $hitLembur, PHPExcel_Cell_DataType::TYPE_STRING);
//        
//        $col += 1;
//        
//        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $sMalam, PHPExcel_Cell_DataType::TYPE_STRING);
//        
//        $col += 2;
//        
//        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $hitNas, PHPExcel_Cell_DataType::TYPE_STRING);
//        
//        $col += 1;
//        
//        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $totLem, PHPExcel_Cell_DataType::TYPE_STRING);
//        
//    }
//    
//    /*
//     * Simopan kordinat Akhir
//     * kordinat akhir untuk style head
//     */
//    $cAkhir = $phpExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getCoordinate();
//    
//    /*
//     * buat style garis untuk head
//     */
//    $phpExcel->getActiveSheet()->getStyle
//            (
//                $cAwal.":".$cAkhir
//            )->applyFromArray
//                (
//                    array
//                        (
//                            'font'        =>array
//                                            (
//                                                'color' =>array('rgb' => '000000'),
//                                                'bold' => true
//                                            ),
//                            'alignment'    => array
//                                            (
//                                                'wrap'       => true,
//                                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//                                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
//                                            ),
//                            'borders'       => array
//                                            (
//                                                'allborders' => array
//                                                (
//                                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
//                                                    'color' => array('argb' => '00000000')
//                                                )
//                                            )
//                        )
//                );
//    
//    $col = 0;
//    $row += 2;
//    
//}

$phpExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Laporan Absen Kantin Tanggal '.$tanggal.'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
$objWriter->save('php://output');

$phpExcel->disconnectWorksheets();
unset($phpExcel);
?>