<?php 
tcpdf();
$obj_pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', true);
//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('helvetica', '', 8);
$obj_pdf->setFontSubsetting(false);
$obj_pdf->AddPage();

ob_start();
//echo $this->load->view("page/header_report",null,true); 
?>
<html>
    <body>
        <?php
        $countHal = count($halaman);
        $i = 1;
        foreach($halaman as $hal)
        {
        ?>
        <table>
            <tbody>
                <tr align="center"><td><h1>Laporan Kehadiran Karyawan</h1></td></tr>
                <tr align="center"><td><h3>PT. Spinmill Indah Industry</h3></td></tr>
                <tr align="center"><td>Periode : <?php echo $hal['periode']; ?></td></tr>
                <tr>
                    <td>
                        <!-- Table untuk info karyawan -->
                        <table>
                            <tbody>
                                <tr>
                                    <td style="width:50px;">Nama</td>
                                    <td style="width:5px;">:</td>
                                    <td><?php echo strtoupper($hal['nama']); ?></td>
                                </tr>
                                <tr>
                                    <td>Unit Kerja</td>
                                    <td>:</td>
                                    <td><?php echo strtoupper($hal['unit_kerja']); ?></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td><?php echo strtoupper($hal['nik']); ?></td>
                                </tr>
                                <tr>
                                    <td>PIN</td>
                                    <td>:</td>
                                    <td><?php echo strtoupper($hal['pin']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End Table untuk info karyawan -->
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $hal['tabel']; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
            if($i!=$countHal)
            {
                echo '<br pagebreak="true" />';
            }
        $i++;
        }
        ?>
    </body>
</html>
<?php 
//echo $this->load->view("page/footer_report",array('appJs'=>'appReportTimbangan'),true); 

$content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, 0, true, 0);
$obj_pdf->Output('output.pdf', 'I');
?>