<?php 
phpexcel();

$phpExcel = new PHPExcel();

$phpExcel->getProperties()->setCreator("Spinmill Indah Industry, PT.")
         ->setLastModifiedBy("Spinmill Indah Industry, PT.")
         ->setDescription("Laporan Absen XLSX")
         ->setKeywords("office 2007 openxml php")
         ->setCategory("Laporan Absen XLSX");

$col = 0;
$row = 1;

$sheet = 0;

$periode = "";

foreach($halaman as $hal)
{
    $ws = new PHPExcel_Worksheet($phpExcel, $hal['nama_divisi']);            
    $phpExcel->addSheet($ws, $sheet);
       
    /*
     * pilih sheet aktif
     */
    $phpExcel->setActiveSheetIndex($sheet);
    
    foreach($hal['data'] as $dataS)
    {
        if($periode=="")
        {
            $periode = $dataS['periode'];
        }
        /*
         * info karyawan pada excel
         * Nama: strtoupper($dataS['nama'])
         * Unit
         */
        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Nama :", PHPExcel_Cell_DataType::TYPE_STRING)
                                        ->setCellValueExplicitByColumnAndRow($col+1, $row, strtoupper($dataS['nama']), PHPExcel_Cell_DataType::TYPE_STRING)
                                        ->setCellValueExplicitByColumnAndRow($col, ++$row, "Unit Kerja :", PHPExcel_Cell_DataType::TYPE_STRING)
                                        ->setCellValueExplicitByColumnAndRow($col+1, $row, strtoupper($dataS['unit_kerja']), PHPExcel_Cell_DataType::TYPE_STRING)
                                        ->setCellValueExplicitByColumnAndRow($col, ++$row, "NIK :", PHPExcel_Cell_DataType::TYPE_STRING)
                                        ->setCellValueExplicitByColumnAndRow($col+1, $row, strtoupper($dataS['nik']), PHPExcel_Cell_DataType::TYPE_STRING)
                                        ->setCellValueExplicitByColumnAndRow($col, ++$row, "PIN :", PHPExcel_Cell_DataType::TYPE_STRING)
                                        ->setCellValueExplicitByColumnAndRow($col+1, $row, strtoupper($dataS['pin']), PHPExcel_Cell_DataType::TYPE_STRING);

        /*
         * ganti baris
         */
        $row+=1;

        /*
         * Simopan kordinat Awal
         * kordinat awal untuk style head
         */
        $cAwal = $phpExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getCoordinate();


        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Tanggal", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);

        $col += 1;

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Jadwal Kerja", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col+1, $row);

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row+1, "M", PHPExcel_Cell_DataType::TYPE_STRING);
        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col+1, $row+1, "K", PHPExcel_Cell_DataType::TYPE_STRING);

        $col += 2;

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Jam Kerja", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col+1, $row);

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row+1, "M", PHPExcel_Cell_DataType::TYPE_STRING);
        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col+1, $row+1, "K", PHPExcel_Cell_DataType::TYPE_STRING);

        $col += 2;

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Masuk", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col+1, $row);

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row+1, "C", PHPExcel_Cell_DataType::TYPE_STRING);
        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col+1, $row+1, "T", PHPExcel_Cell_DataType::TYPE_STRING);

        $col += 2;

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Pulang", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col+1, $row);

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row+1, "C", PHPExcel_Cell_DataType::TYPE_STRING);
        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col+1, $row+1, "T", PHPExcel_Cell_DataType::TYPE_STRING);

        $col += 2;

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Keterangan", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);

        $col += 1;

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Lembur\nAktual", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);

        $col += 1;

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Hitung\nLembur", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);

        $col += 1;

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Shift\nMalam", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);

        $col += 1;

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Lembur\nLibur\nNas", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);

        $col += 1;

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Hitung\nLibur\nNas", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);

        $col += 1;

        $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Total\nLembur", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col, $row+1);


        /*
         * posisikan kursor pada posisi setelah head
         * pada kolom pertama dan baris setelah head
         */
        $col=0;
        $row+=2;


        if(count($dataS['tabel']>0))
        {
            $hitLembur = 0;
            $hitNas = 0;
            $sMalam = 0;
            $totLem = 0;
    //        print_r($dataS['tabel']);
            foreach($dataS['tabel'] as $tabel)
            {
                $col = 0;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['tanggal'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['jadwal_masuk'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['jadwal_keluar'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['jam_masuk'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['jam_keluar'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['masuk_cepat'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['masuk_telat'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['keluar_cepat'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['keluar_telat'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, str_replace("&nbsp;","", $tabel['als']), PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['jam_lemact'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['hit_lemact'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['shift3'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['jam_libnas'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tabel['hit_libnas'], PHPExcel_Cell_DataType::TYPE_STRING);

                $col += 1;

                $tSementara = $tabel['hit_lemact'] + $tabel['hit_libnas'];
                $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $tSementara, PHPExcel_Cell_DataType::TYPE_STRING);

                $hitLembur += $tabel['hit_lemact'];
                $hitNas += $tabel['hit_libnas'];
                $sMalam += $tabel['shift3'];
                $totLem += $tSementara;


                $row += 1;
            }

            $col = 0;

            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, "Jumlah", PHPExcel_Cell_DataType::TYPE_STRING)
                                   ->mergeCellsByColumnAndRow($col, $row, $col+10, $row);

            $col += 11;

            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $hitLembur, PHPExcel_Cell_DataType::TYPE_STRING);

            $col += 1;

            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $sMalam, PHPExcel_Cell_DataType::TYPE_STRING);

            $col += 2;

            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $hitNas, PHPExcel_Cell_DataType::TYPE_STRING);

            $col += 1;

            $phpExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $totLem, PHPExcel_Cell_DataType::TYPE_STRING);

        }

        /*
         * Simopan kordinat Akhir
         * kordinat akhir untuk style head
         */
        $cAkhir = $phpExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getCoordinate();

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
                                                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                                                        'color' => array('argb' => '00000000')
                                                    )
                                                )
                            )
                    );

        $col = 0;
        $row += 2;
    }
    
    $sheet += 1;
}

$phpExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Laporan Absen Periode '.$periode.'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
$objWriter->save('php://output');

$phpExcel->disconnectWorksheets();
unset($phpExcel);
?>