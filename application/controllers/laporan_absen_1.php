<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of transaksi_alasan
 *
 * @author taufiq
 */
class Laporan_absen extends Secure_area
{
    //put your code here
    
    private $limit = 50;
    private $typePage = 'laporan_absen';
//    private $tblHead = array("Tanggal Transaksi","PIN","Nama Karyawan","Kode Alasan","Waktu","Keterangan","Tanggal Modifikasi");
//    private $titleForm = "Form Transaksi Alasan";
    
    private $master_data, $karyawan;
    
    function __construct()
    {
        parent::__construct();
        
//        $this->load->model('Mod_alasan');
        $this->load->model('Mod_karyawan');
        $this->load->model("Mod_laporan");
    }
    
    function index()
    {
        $this->form_report();        
    }       
    
   //////////////////////////////////////////////////////////////////
    
    private function form_report($message="")
    {
        $data['title'] = "Laporan Absen Karyawan";
        $data['action'] = $this->typePage.'/pdf_absen';
        $data['idForm'] = "formLaporanAbsenKaryawan";
        $data['button'] = "Download PDF";
        $data['button2'] = "Download Excel";
        $data['button_icon'] = "glyphicon-save";
        $data['message'] = $message;
        
        $this->load->view($this->typePage.'/form', $data);
    }  
    
    private function arr_report_komulatif($arrList,$periode)
    {
        $ret = array();
        
        $tgl = $this->fungsi->getDateRange(date("Y-m-d",strtotime("-1 month ".$periode."-22")), $periode."-21", "+1 days","d");
        
        
        
        $tbl = '';
        
        
        
        $arrHead = array();
        
        $arrHead = array("No.","PIN","TMK","SEX","Nama Karyawan");
        
        foreach ($tgl as $d)
        {
            $arrHead[] = $d; 
        }
        
        $arrHead = array_merge($arrHead, array("Total Lembur","Shift III","JML Getpass"));
        
        $ret[0] = $arrHead;
        
                
        $no = 1;
        
        if(count($arrList>0))
        {
            foreach($arrList as $arr)
            {
                
                $arrLst = array();
                
                $arrList = array($no,$arr['pin'],$arr['tmk'],$arr['sex'],$arr['nama']);
                
                
                
                $totLembur = 0;
                $totShift = 0;
                $totGp = 0;
                
                $arrDet = array();
                
                foreach($arr['detail'] as $detail)
                {
                    
                    
                    $str = "";
//                    print_r($detail);
//                    if(isset($detail['kode_als']))
//                    {
//                        
//                    }
//                    if($detail['kode_als']!="-" && $detail['kode_als']!="&nbsp;")
//                    {
//                        $str = $detail['kode'];
//                    }
                    $str = $detail['kode'];
                    if(isset($detail['kode']) && $detail['kode']!="-" && $detail['kode']!="&nbsp;")
                    {
                        $str = $detail['kode'];
                    }
//                    else if($detail['gp']>0 && $detail['libur']!="1")
//                    {
//                        $str = "GP";
//                    }
//                    else if($detail['lembur']>0 && $detail['libur']!="1")
//                    {
//                        $str = $detail['lembur'];
//                    }
//                    else
//                    {
//                        $str = "0";
//                    }
                    
                    $totLembur += $detail['lembur'];
                    $totShift += $detail['s3'];
                    $totGp += $detail['gp'];
                    
                    $arrDet[] = $str;
                    
                }
                
                $arrList = array_merge($arrList,$arrDet);
                
                $arrList = array_merge($arrList,array($totLembur,$totShift,$totGp));
                
                $ret[] = $arrList;

                $no++;
            }
        }
        //print_r($ret);
        return $ret;
    }
    
    private function komulatif_proc($arr)
    {
        
        $ret = array();
        
        print_r($arr);
        
        foreach($arr as $listA)
        {
            $detInf = array();
//            print_r($listA);
//            echo $listA['jam_masuk']=='-' && $listA['jam_keluar']=='-';
//            echo ($listA['hit_lemact']!=0)."<br>";
            
            if($listA['hit_lemact']>0)
            {
                $detInf['kode'] = $listA['hit_lemact'];   
            }
            else if($listA['als']!="&nbsp;" || $listA['als']!="-")
            {
                $detInf['kode'] = $listA['kode_als'];    
            }
            else if($listA['gp']>0 && $listA['libur']!="1")
            {
                 $detInf['kode'] = "GP";
            }
            else if($listA['lembur']>0 && $listA['libur']!="1")
            {
                 $detInf['kode'] = $listA['lembur'];
            }
            else if($listA['jam_masuk']=='-' && $listA['jam_keluar']=='-' && $listA['libur']!='1')
            {
//                echo "kesini";
                $detInf['kode'] = 'M';                     
            }
            else if(($listA['jam_masuk']=='-' || $listA['jam_keluar']=='-') && $listA['libur']!='1')
            {
                $detInf['kode'] = 'TA';     
            }
            else if($listA['jam_masuk']!='-' && $listA['jam_keluar']!='-' && $listA['libur']!='1')
            {
                $detInf['kode'] = '0';     
            }
            else
            {
                $detInf['kode'] = '-';     
            }

            $detInf['lembur'] = $listA['hit_lemact']+$listA['hit_libnas'];
            $detInf['s3'] = 0+$listA['shift3'];
            $detInf['gp'] = $listA['gp'];
            $detInf['libur'] = $listA['libur'];
            
            
            $ret[$listA['tgl']] = $detInf;
        }
        print_r($ret);
        return $ret;
    }
    
    function pdf_absen()
    {
        $pPeriode = explode("-", $this->input->post("txtPeriode"));
        $karyawan = $this->input->post("cmbKaryawan");
        $divisi = $this->input->post("cmbDivisi");
        $btn = $this->input->post("cmdDownload");
        
        $type = $this->input->post("cmbLaporan");
                
//        $this->laporan_pdf($pPeriode[1]."-".$pPeriode[0],$karyawan,$divisi);
        if($type=="D")
        {
            if($btn=="pdf")
            {
                $this->laporan_pdf($pPeriode[1]."-".$pPeriode[0],$karyawan,$divisi);
            }
            else if($btn=="xls")
            {
                $this->laporan_xls($pPeriode[1]."-".$pPeriode[0],$karyawan,$divisi);
            }
        }
        else if("K")
        {
            if($btn=="pdf")
            {
                $this->laporan_komulatif_pdf($pPeriode[1]."-".$pPeriode[0],$karyawan,$divisi);
            }
            else if($btn=="xls")
            {
                $this->laporan_komulatif_xls($pPeriode[1]."-".$pPeriode[0],$karyawan,$divisi);
//                $this->laporan_xls($pPeriode[1]."-".$pPeriode[0],$karyawan,$divisi);
            }
        }
    }
    
    
    
    /*
     * fungsi laporan_pdf
     * untuk menciptakan laporan berbentuk PDF yang akan didownload di browser
     * 
     */
    private function laporan_pdf($periode, $karyawan, $divisi)
    {
        $this->load->helper("pdf_helper");
        
        $periodeArr = explode("-", $periode);
        
        $data = array();
        
        $dataArr = array();
        
        $listKaryawan = array();
        
        $search = "";
        
        if(!empty($karyawan))
        {
            $search = " orang.person_id='$karyawan' ";
        }
        elseif (!empty ($divisi)) 
        {
            $search = " divisi.id_divisi='$divisi' ";
        }
        
        $listKaryawan = $this->Mod_karyawan->get_paged_list_active(10000, $offset = 0, $search)->result();
        
        if(count($listKaryawan)>0)
        {
            foreach ($listKaryawan as $list)
            {
                
                $listAbsen = $this->list_absen($list->kartu, $periode,$list->person_id);
                
                if($listAbsen==false)
                    continue;
                
                $dataArr[] = array(
                    "nama" => $list->nama_karyawan,
                    "nik" => $list->nik,
                    "pin" => $list->pin,
                    "unit_kerja" => $list->nama_divisi,
                    "periode" => $this->fungsi->bacaBulan($periodeArr[1])." ".$periodeArr[0],
                    "tabel" => $this->table_report($listAbsen)
                );
            }
        }
        
        $data["halaman"] = $dataArr;
        
        $repPdf = $this->load->view($this->typePage.'/laporan_absen_pdf',$data);
    }
    
    /*
     * fungsi laporan_pdf
     * untuk menciptakan laporan berbentuk PDF yang akan didownload di browser
     * 
     */
    private function laporan_komulatif_pdf($periode, $karyawan, $divisi)
    {
        $this->load->helper("pdf_helper");
        
        $periodeArr = explode("-", $periode);
        
        $data = array();
        
        $dataArr = array();
        
        $listKaryawan = array();
        
        $search = "";
        
        if(!empty($karyawan))
        {
            $search = " orang.person_id='$karyawan' ";
        }
        elseif (!empty ($divisi)) 
        {
            $search = " divisi.id_divisi='$divisi' ";
        }
        
        $listKaryawan = $this->Mod_karyawan->get_paged_list_active(10000, $offset = 0, $search)->result();
        
        if(count($listKaryawan)>0)
        {
            $arrData = array();
            
            foreach ($listKaryawan as $list)
            {
                $listAbsen = $this->list_absen($list->kartu, $periode,$list->person_id);
                
                if($listAbsen==false)
                {
                    continue;
                }
                
                $info = array();
                
                $info["nama"] = $list->nama_karyawan;
                $info["nik"] = $list->nik;
                $info["pin"] = $list->pin;
                $info["tmk"] = $list->tgl_masuk;
                $info["sex"] = $list->id_jenkel;
                
                $info['detail'] = $this->komulatif_proc($listAbsen);
                
                $arrData[] = $info;
                
               
            }
            
            $data['tabel'] = $this->table_report_komulatif($arrData, $periode);
            $data['periode'] = $periode;
        }
        
        $repPdf = $this->load->view($this->typePage.'/laporan_absen_komulatif_pdf',$data);
    }
    
    
    
    private function laporan_xls($periode, $karyawan, $divisi)
    {
        $this->load->helper("xls_helper");
        
        $periodeArr = explode("-", $periode);
        
        $data = array();
        
        $dataArr = array();
        
        $listKaryawan = array();
        
        $search = "";
        
        if(!empty($karyawan))
        {
            $search = " orang.person_id='$karyawan' ";
        }
        elseif (!empty ($divisi)) 
        {
            $search = " divisi.id_divisi='$divisi' ";
        }
        
        $listKaryawan = $this->Mod_karyawan->get_paged_list_active(10000, $offset = 0, $search)->result();
        
        if(count($listKaryawan)>0)
        {
            foreach ($listKaryawan as $list)
            {
                
                $listAbsen = $this->list_absen($list->kartu, $periode,$list->person_id);
                
                if($listAbsen==false)
                    continue;
                
                $dataArr[] = array(
                    "nama" => $list->nama_karyawan,
                    "nik" => $list->nik,
                    "pin" => $list->pin,
                    "pin" => $list->pin,
                    "tmk" => $list->tgl_masuk,
                    "sex" => $list->id_jenkel,
                    "unit_kerja" => $list->nama_divisi,
                    "periode" => $this->fungsi->bacaBulan($periodeArr[1])." ".$periodeArr[0],
                    "tabel" => $listAbsen
                );
            }
        }
        
        $data["halaman"] = $dataArr;
        
        $repPdf = $this->load->view($this->typePage.'/laporan_absen_xls',$data);
    }
    
    
    /*
     * fungsi laporan_xlsx
     * untuk menciptakan laporan berbentuk PDF yang akan didownload di browser
     * 
     */
    private function laporan_komulatif_xls($periode, $karyawan, $divisi)
    {
        $this->load->helper("xls_helper");
        
        $periodeArr = explode("-", $periode);
        
        $data = array();
        
        $dataArr = array();
        
        $listKaryawan = array();
        
        $search = "";
        
        if(!empty($karyawan))
        {
            $search = " orang.person_id='$karyawan' ";
        }
        elseif (!empty ($divisi)) 
        {
            $search = " divisi.id_divisi='$divisi' ";
        }
        
        $listKaryawan = $this->Mod_karyawan->get_paged_list_active(10000, $offset = 0, $search)->result();
        
        if(count($listKaryawan)>0)
        {
            $arrData = array();
            
            foreach ($listKaryawan as $list)
            {
                $listAbsen = $this->list_absen($list->kartu, $periode,$list->person_id);
                
                if($listAbsen==false)
                {
                    continue;
                }
                
                $info = array();
                
                $info["nama"] = $list->nama_karyawan;
                $info["nik"] = $list->nik;
                $info["pin"] = $list->pin;
                $info["tmk"] = $list->tgl_masuk;
                $info["sex"] = $list->id_jenkel;
                
                $info['detail'] = $this->komulatif_proc($listAbsen);
                
                $arrData[] = $info;
                
               
            }
            
            $data['tabel'] = $this->arr_report_komulatif($arrData, $periode);
            $data['periode'] = $periode;
        }
//        print_r($data);
//        $repPdf = $this->load->view($this->typePage.'/laporan_absen_komulatif_xls',$data);
    }
    
    ////////////////////////////////////////////////////////////////////////
    
    private function table_report($arrList)
    {
        $tbl = '';
        
        //open table
        $tbl .= '<table border="1">';
        
        //open head
        $tbl .= '<thead>';
        
        $tbl .= '<tr align="center"> 
                    <th rowspan="2" style="width:50px">Tanggal</th>
                    <th colspan="2" style="width:75px">Jadwal Kerja</th> 
                    <th colspan="2" style="width:75px">Jam Kerja</th> 
                    <th colspan="2" style="width:45px">Masuk</th> 
                    <th colspan="2" style="width:45px">Pulang</th> 
                    <th rowspan="2" style="width:300px">Keterangan</th> 
                    <th rowspan="2" style="width:30px">Lembur<br>Aktual</th> 
                    <th rowspan="2" style="width:30px">Hitung<br>Lembur</th> 
                    <th rowspan="2" style="width:30px">Shift<br>Malam</th> 
                    <th rowspan="2" style="width:30px">Lembur<br>Libur Nas</th> 
                    <th rowspan="2" style="width:30px">Hitung<br>Libur Nas</th> 
                    <th rowspan="2" style="width:30px">Total<br>Lembur</th>                     
                </tr>
                <tr align="center">
                    <th>M</th>
                    <th>K</th>
                    <th>M</th>
                    <th>K</th>
                    <th>C</th>
                    <th>T</th>
                    <th>C</th>
                    <th>T</th>
                </tr>';
        
        //close head
        $tbl .= '</thead>';
        
        if(is_array($arrList))
        {
            
            $tbl .= "<tbody>";
            $totSf3 = 0;
            $totLibNas = 0;
            $totLemAct = 0;
            $totLemb = 0;
            if(count($arrList)>0)
            {
                foreach($arrList as $lst)
                {
                    $tLembur = $lst['hit_libnas']+$lst['hit_lemact'];
                    
                    $tbl .= '<tr>
                                <td align="center">'.$lst['tanggal'].'</td>
                                <td align="center">'.$lst['jadwal_masuk'].'</td>
                                <td align="center">'.$lst['jadwal_keluar'].'</td>
                                <td align="center">'.$lst['jam_masuk'].'</td>
                                <td align="center">'.$lst['jam_keluar'].'</td>
                                <td align="center">'.$lst['masuk_cepat'].'</td>
                                <td align="center">'.$lst['masuk_telat'].'</td>
                                <td align="center">'.$lst['keluar_cepat'].'</td>
                                <td align="center">'.$lst['keluar_telat'].'</td>
                                <td align="center">'.$lst['als'].'</td>
                                <td align="center">'.(($lst['jam_lemact']>0)?$lst['jam_lemact']:'&nbsp;').'</td>
                                <td align="center">'.(($lst['hit_lemact']>0)?$lst['hit_lemact']:'&nbsp;').'</td>
                                <td align="center">'.$lst['shift3'].'</td>
                                <td align="center">'.(($lst['jam_libnas']>0)?$lst['jam_libnas']:'&nbsp;').'</td>
                                <td align="center">'.(($lst['hit_libnas']>0)?$lst['hit_libnas']:'&nbsp;').'</td>
                                <td align="center">'.(($tLembur!=0)?$tLembur:'&nbsp;').'</td>
                            </tr>
                        ';
                    $totSf3 += $lst['shift3'];
                    $totLibNas += $lst['hit_libnas'];
                    $totLemAct += $lst['hit_lemact'];
                    $totLemb += $tLembur;
                }
            }
            else
            {
                $tbl .= '<tr><td colspan="16">Data Kosong</td></tr>';
            }
            
            $tbl .= '<tr>
                        <td colspan="10" align="center"><strong>Jumlah</strong></td>
                        <td align="center">&nbsp;</td>
                        <td align="center"><strong>'.$totLemAct.'</strong></td>
                        <td align="center"><strong>'.$totSf3.'</strong></td>
                        <td align="center">&nbsp;</td>
                        <td align="center"><strong>'.$totLibNas.'</strong></td>
                        <td align="center"><strong>'.(($totLemb!=0)?$totLemb:'&nbsp;').'</strong></td>
                    </tr>';
            
            $tbl .= "</tbody>";
        }
        
        
        //close table
        $tbl .= '</table>';
        
        return $tbl;
    }
    
    private function table_report_komulatif($arrList,$periode)
    {
        $tbl = '';
        
        $tgl = $this->fungsi->getDateRange(date("Y-m-d",strtotime("-1 month ".$periode."-22")), $periode."-21", "+1 days","d");
        
        $tblTgl = '';
        foreach ($tgl as $d)
        {
            $tblTgl .= '<th style="width:15px" align="center">'.$d.'</th>'; 
        }
        
        //open table
        $tbl .= '<table border="1">';
        
        //open head
        $tbl .= '<thead>';
        
        $tbl .= '<tr align="center"> 
                    <th style="width:20px" align="center">No.</th>
                    <th style="width:30px" align="center">PIN</th> 
                    <th style="width:45px" align="center">TMK</th> 
                    <th style="width:20px" align="center">SEX</th> 
                    <th style="width:130px" align="center">Nama Karyawan</th> 
                    '.$tblTgl.'
                    <th style="width:30px" align="center">Total<br>Lembur</th> 
                    <th style="width:30px" align="center">Shift III</th> 
                    <th style="width:30px" align="center">JML<br>Getpass</th>         
                </tr>';
        
        //close head
        $tbl .= '</thead>';
        
        $tbl .= '<tbody>';
        
        $no = 1;
        
        if(count($arrList>0))
        {
            foreach($arrList as $arr)
            {
                $tbl .= '<tr>';

                $tbl .= '<td style="width:20px">'.$no.'</td>
                        <td style="width:30px" align="center">'.$arr['pin'].'</td> 
                        <td style="width:45px" align="center">'.$arr['tmk'].'</td> 
                        <td style="width:20px" align="center">'.$arr['sex'].'</td> 
                        <td style="width:130px" align="center">'.$arr['nama'].'</td>';
                
                $totLembur = 0;
                $totShift = 0;
                $totGp = 0;
                
                foreach($arr['detail'] as $detail)
                {
                    $str = "";
                    //print_r($detail);
                    if($detail['kode_als']!="&nbsp;")
                    {
                        $str = $detail['kode'];
                    }
                    if($detail['gp']>0 && $detail['libur']!="1")
                    {
                        $str = "GP";
                    }
                    else if($detail['lembur']>0 && $detail['libur']!="1")
                    {
                        $str = $detail['lembur'];
                    }
                    else
                    {
                        $str = "0";
                    }
                    
                    $totLembur += $detail['lembur'];
                    $totShift += $detail['s3'];
                    $totGp += $detail['gp'];
                    
                    $tbl .= '<td style="width:15px" align="center">'.$str.'</td>';
                    
                }
                $tbl .= '<td style="width:30px" align="center">'.$totLembur.'</td>';
                $tbl .= '<td style="width:30px" align="center">'.$totShift.'</td>';
                $tbl .= '<td style="width:30px" align="center">'.$totGp.'</td>';
                
                $tbl .= '</tr>';

                $no++;
            }
        }
        
        $tbl .= '</tbody>';
        
        
        //close table
        $tbl .= '</table>';
        
        return $tbl;
    }
    
    ////////////////////////////////////////////////////////////////////////
    
    /*
     * fungsi list_absen($card, $periode,$person_id)
     * fungsi ini bersifat privat, hanya class laporan_absen yang dapat menggunakannya
     * fungsi ini digunakan untuk memproses absen berdasarkan parameter
     * $card = nomor kartu absen (String)
     * $periode = periode absen dengan format YYYY-mm (String)
     * $person_id = primary key dari tabel orang
     */
    private function list_absen($card, $periode,$person_id)
    {
        /*
         * deklarasi $ret
         * digunakan untuk menampung hasil proses absen dan dikirmkan ke fungsi yang memanggil
         */
        $ret = array();
        
        
        /*
         * membatasi data yang diproses
         * hanya yang memiliki $card dan $periode saja yang akan diproses
         */
        if(!empty($card) && !empty($periode))
        {
            
            /*
             * deklarasi $dateStart
             * digunakan untuk menampung tanggal periodik
             * tanggal yang dimasukkan adalah tanggal awal
             * tanggal awal dimulai pada tanggal 22 bulan sebelum bulan terpilih
             */
            $dateStart = date("Y-m-d",strtotime("-1 month ".$periode."-22"));
            
            /*
             * deklarasi $dateEnd
             * digunakan untuk menampung tanggal periodik
             * tanggal yang dimasukkan adalah tanggal akhir
             * tanggal akhir adalah tanggal 21 bulan terpilih
             * Dikarenakan untuk memproses shift3 maka, tanggal akhir dibuat tanggal 22.
             */
            $dateEnd   = $periode."-22";
            
            /*
             * Ambil list urutan tanggal dari fungsi dengan parameter
             * $dateStart = Tanggal awal
             * $periode."-21" = Tanggal akhir 
             * "+1 days" penambahan setiap tanggal 1 hari
             */
            $listTanggal = $this->fungsi->getDateRange($dateStart, $periode."-21", "+1 days");
            
            /*
             * Ambil data absen dari model laporan (Mod_laporan) dengan parameter
             * $card = kartu absen
             * $dateStart = Tanggal awal
             * $dateEnd = Tanggal akhir
             */
            $dataAbsen      = $this->Mod_laporan->report_absen($card, $dateStart, $dateEnd)->result();
            
             /*
             * Ambil data absen manual dari model laporan (Mod_laporan) dengan parameter
             * $card = kartu absen
             * $dateStart = Tanggal awal
             * $dateEnd = Tanggal akhir
             */
            $dataAbsenManual = $this->Mod_laporan->report_absen_manual($card, $dateStart, $dateEnd)->result();
            
            
            /*
             * menggabungkan data absen real dengan manual
             * lalu melakukan pengurutan berdasarkan tanggal secara asc
             */
            
            $dataAbsen = array_merge($dataAbsen,$dataAbsenManual);
            
            usort($dataAbsen, array($this,'sort_date'));
//            usort($dataAbsen, 'sort_date');
            
            /*
             * Ambil data jadwal absen dari model laporan (Mod_laporan) dengan parameter
             * $person_id = id primary key dari karyawan
             * $dateStart = Tanggal awal
             * $dateEnd = Tanggal akhir
             * 
             * hasil
             * key = YYYY-mm-dd
             *      tanggal     => YYYY-mm-dd
             *      jam_masuk   => HH:ii:ss
             *      jam_pulang  => HH:ii:ss
             *      libur       => 0/1
             *      pendek      => 0/1
             *      istirahat   => 1=Satu, 2=setengah
             */
            $dataJadwal = $this->Mod_laporan->jadwal_absen($person_id,$dateStart, $dateEnd);
            
            /*
             * Jika tidak ada jadwal, maka lewatkan.
             * Tidak akan diproses karena tidak ada jadwal
             */
//            if($dataJadwal==false)
//            {
//                return false;
//            }
            
            /*
             * Ambil data transaksi alasan dari model laporan (Mod_laporan) dengan parameter
             * $person_id = id primary key dari karyawan
             * $dateStart = Tanggal awal
             * $dateEnd = Tanggal akhir
             * 
             * hasil
             * key = YYYY-mm-dd
             *      tanggal     => YYYY-mm-dd
             *      waktu       => Decimal (10,2)
             *      keterangan  => TEXT
             *      kode_alasan => TEXT
             *      nama_alasan => TEXT
             */
            $dataAlasan = $this->Mod_laporan->alasan($person_id,$dateStart, $dateEnd);
            
            /*
             * Ambil data libur nasional dengan parameter
             * $dateStart = Tanggal awal
             * $dateEnd = Tanggal akhir
             */
            $libnas = $this->get_libnas($dateStart, $dateEnd);
                        
            
            /*
             * deklarasi $isFirst
             * digunakan untuk pengecekan looping awal/pertama
             */ 
            $isFirst = true;
            
            /*
             * deklarasi $tmBefore
             * digunakan untuk menampung waktu yang dipakai untuk menentukan
             * apakah absen berada di shift 3, dengan jam masuk pukul 22:00:00
             */
            $tmBefore = "";
            
            /*
             * deklarasi $tglCurrent
             * digunakan untuk menampung tanggal terpilih pada proses looping
             */
            $tglCurrent = ""; 
            
            /*
             * deklarasi $tglBefore
             * digunakan untuk menampung tanggal terpilih sebelumnya pada proses looping
             */
            $tglBefore = "";
            
            /*
             * perulangan pengolahan data absen yang telah ditarik
             */
            foreach($dataAbsen as $absen)
            {
                
                /*
                 * cek data pertama
                 * apakah merupakan cekroll keluar (act_function=2)
                 * kalau benar, maka diabaikan
                 */
                if($isFirst)
                {
                    $isFirst = false;
                    if($absen->act_function=="2")
                    {
                        continue;
                    }
                }
                
                /*
                 * pengecekan untuk absen dengan cekroll masuk (act_function=1)
                 */
                if($absen->act_function=="1")
                {
                    
                    /*
                     * simpan tanggal terpilih ke variabel $tglCurrent
                     */
                    $tglCurrent=$absen->tanggal;
                    
                    /*
                     * pengecekan tanggal terpilih sebelumnya dengan tanggal terpilih saat ini
                     * apakah tidak sama?
                     * tidak sama berarti tanggal terpilih merupakan cekroll masuk yang benar
                     * jika sama, berarti ada kesalahan user dalam menentukan cekroll masuk atau keluar.
                     * maka ketika salah, akan diabaikan data tersebut.
                     */
                    if($tglBefore!=$tglCurrent)
                    {
                        
                        /*
                         * apakah didalam array $arrData (data tampungan proses) terdapat data pada
                         * tanggal sebelumnya?
                         */
                        if(isset($arrData[$tglBefore][1]))
                        {
                            
                            /*
                             * $timeBefore diisi objek dari DateTime pada data tampungan $arrData pada tanggal sebelumnya
                             * hanya data cekroll masuk (1)
                             */
                            $timeBefore = new DateTime($arrData[$tglBefore][1]);
                            
                            /*
                             * $timeCurent diisi objek dari DateTime pada data tanggal dan waktu terpilih
                             */
                            $timeCurent = new DateTime($absen->act_time);
                            
                            /*
                             * cek apakah $timeBefore lebih besar dari jam "21:00:00"
                             * dan
                             * cek apakah $timeCurrent lebih kecil dari jam "09:00:00"
                             * 
                             * pengecekan kondisi ini digunakan untuk menghindari kesalahan user dalam menekan cekroll keluar
                             * terkadang user pada shift3 menggunakan cekroll pada saat pulang dengan menekan cekroll masuk (1).
                             * ketika kondisi ini benar, maka merupakan data sampah dan harus diabaikan
                             */
                            if(strtotime($timeBefore->format("H:i:s"))>strtotime("21:00:00") && strtotime($timeCurent->format("H:i:s")) < strtotime("09:00:00"))
                            {
                                continue;
                            }                            
                        } 
                        
                        /*
                         * variabel $tglBefore diisi tanggal $tglCurrent
                         * untuk digunakan pengecekan shift3
                         */
                        $tglBefore = $tglCurrent;
                        
                        /*
                         * simpan jam masuk pada $arrData dengan data absen act_time
                         */
                        $arrData[$tglCurrent][1] = $absen->act_time;
                        
                        /*
                         * $tmBefore diisi tanggan absen act_time
                         * yang nantinya akan menjadi parameter penentu, apakah termasuk shift3 atau bukan
                         */
                        $tmBefore = $absen->acttime;
                    }
                    else
                    {
                        continue;
                    }
                    
                }
                
                /*
                 * pengecekan untuk absen dengan cekroll keluar (act_function=2)
                 */
                else if($absen->act_function=='2')
                {
                    
                    /*
                     * $dateShift3 diinputkan tanggal terpilih dikurangi satu hari (hari kemarin)
                     * digunakan untuk mengecek shift3
                     */
                    $dateShift3 = date("Y-m-d",strtotime("-1 day ".$absen->tanggal));
                    
                    /*
                     * pengecekan $tglBefore dengan $dateShift3
                     * jika benar, ada kemungkinan tanggal tersebut merupakan shift3
                     * 
                     */
                    if($tglBefore == $dateShift3)
                    {
                        
                        /*
                         * apakah $tmBefore lebih besar dari pukul "22:00:00" (shift 3 masuk pukul 23:00:00)
                         * jika benar, berarti tanggal dan jam terpilih tersebut merupakan shift3
                         * dengan penambahan key array sf3 bernilai 1
                         */
                        if(strtotime($tmBefore)>strtotime("22:00:00"))
                        {
                            $arrData[$tglBefore][2] = $absen->act_time;
                            $arrData[$tglBefore]["sf3"] = 1;
                        }
                        else 
                        {
                            continue;
                        }
//                        if(strtotime($absen->acttime)>strtotime("13:00:00"))
//                            continue;
//                        $arrData[$tglBefore][2] = $absen->act_time;
                    }
                    
                    /*
                     * bukan merupakan pulang shift3. Pulang shift1 atau shift2 (tidak beda hari)
                     */
                    else
                    {
                        $arrData[$absen->tanggal][2] = $absen->act_time;
                    }
                }
            }
            
            /*
             * proses pemetaan data dengan proses perhitungan lembur
             * perulangan berdasarkan list tanggal yang telah dibuat berdasarkan periode.
             * hasilnya akan disimpan ke variabel array $ret dengan key
             * tanggal          = berisi tanggal absen
             * jadwal_masuk     = berisi jam jadwal masuk
             * jadwal_keluar    = berisi jam jadwal keluar
             * jam_masuk        = berisi jam absen masuk
             * jam_keluar       = berisi jam absen keluar
             * masuk_cepat      = berisi perhitungan antara jadwal_masuk - jam_masuk jika hasilnya positif
             * masuk_telat      = berisi perhitungan antara jadwal_masuk - jam_masuk jika hasilnya negatif
             * keluar_cepat     = berisi perhitungan antara jadwal_keluar - jam_keluar jika hasilnya positif
             * keluar_telat     = berisi perhitungan antara jadwal_keluar - jam_keluar jika hasilnya negatif
             * shift3           = berisi nilai 1 untuk shift3 atau kosong jika bukan shift3
             * als              = berisi alasan
             * jam_lemact       = Lembur actual,
             * hit_lemact       = Nilai lembur actual,
             * jam_libnas       = berisi jumlah jam ketika libur nasional
             * hit_libnas       = perhitungan libur nasional berdasarkan jam_libnas
             * gp               = get pass,
             * libur            = libur
             * 
             */
            foreach($listTanggal as $lT)
            {
                $expDate = explode("-", $lT);
                
                $kdAls = "";
                
                $jad_masuk = (isset($dataJadwal[$lT])?$dataJadwal[$lT]["jam_masuk"]:"-");
                $jad_keluar = (isset($dataJadwal[$lT])?$dataJadwal[$lT]["jam_pulang"]:"-");
                $jm_masuk = (isset($arrData[$lT])?(isset($arrData[$lT]["1"])?$this->fungsi->convertDate($arrData[$lT]["1"],"H:i:s"):"-"):"-");
                $jm_keluar = (isset($arrData[$lT])?(isset($arrData[$lT]["2"])?$this->fungsi->convertDate($arrData[$lT]["2"],"H:i:s"):"-"):"-");
                $sf3 = (isset($arrData[$lT])?(isset($arrData[$lT]["sf3"])?$arrData[$lT]["sf3"]:0):0);
                $als = (isset($dataAlasan[$lT])?$dataAlasan[$lT]["nama_alasan"]:"-");
                
                $als_code = (isset($dataAlasan[$lT])?$dataAlasan[$lT]["kode_alasan"]:"-");
                
                $is_libur = (isset($dataJadwal[$lT])?$dataJadwal[$lT]["libur"]:"0");
                
                $kdIstirahat = (isset($dataJadwal[$lT])?$dataJadwal[$lT]["istirahat"]:"1");
                
                $kdAls = (isset($dataAlasan[$lT])?$dataAlasan[$lT]["kode_alasan"]:"");
                
                $jadwalbesok = $this->Mod_laporan->jadwal_besok($person_id,$lT);
                
                $mskC = "";
                $mskT = "";
                $plgC = "";
                $plgT = "";
                
                $jamLibNas = 0;
                $hitLiburNas = 0;
                
                $jamLemAct = 0;
                $hitLemAct = 0;
                
                if(($jad_masuk!="" && !empty($jad_masuk) && $jad_masuk!="-") && ($jm_masuk!="" && !empty($jm_masuk) && $jm_masuk!="-"))
                {
                    $jad_jam = (strtotime($jad_masuk)-  strtotime($jm_masuk))/60;
//                    echo abs((strtotime($jad_masuk)- strtotime($jm_masuk))/60)."<br>";
                    if($jad_jam>=0)
                        $mskC = floor(abs($jad_jam));
                    else
                        $mskT = floor(abs($jad_jam));  
                }
                if(($jad_keluar!="" && !empty($jad_keluar) && $jad_keluar!="-") && ($jm_keluar!="" && !empty($jm_keluar) && $jm_keluar!="-"))
                {
                    $jad_jam = (strtotime($jad_keluar)-  strtotime($jm_keluar))/60;
//                    echo abs((strtotime($jad_masuk)- strtotime($jm_masuk))/60)."<br>";
                    if($jad_jam>=0)
                        $plgC = floor(abs($jad_jam));
                    else
                        $plgT = floor(abs($jad_jam));  
                }
                
                                
                /*
                 * Perhitungan Libnas, SPL
                 * cek apakah ada alasan dengan menggunakan isset 
                 * untuk menghindari error karena key kode alasan kosong
                 */
                if(isset($dataAlasan[$lT]["kode_alasan"]))
                {
                    
                    /*
                     * cek apakah ada libur nasional di tanggal terpilih
                     * jika ya, lanjut
                     */
                    if(isset($libnas[$lT]))
                    {
                        
                        /*
                         * cek apakah ada inputan alasan lembur untuk libur nasional
                         * untuk karyawan dengan kode_alasan "LN"
                         */
                        if($dataAlasan[$lT]["kode_alasan"]=="LN")
                        {
                            
                            /*
                             * $jamLibNas menampung perhitungan waktu lembur
                             * $jm_keluar-$jm_masuk lalu dibagi 3600 (1 jam 3600 detik) lalu dikurang 1 jam
                             */
                            $jamLibNas = floor((strtotime($jm_keluar)-strtotime($jm_masuk))/3600)-1;
                            
                            /*
                             * setelah mendapatkan berapa jam lembur libur nasional
                             * maka dihitung dengan fungsi HitungLibNas dengan parameter variabel $jamLibNas
                             */
                            if($jamLibNas>0)
                            {
                                $hitLiburNas = $this->HitungLibNas($jamLibNas);
                            }
                            
                            $als = "Libur Nasional ".$jamLibNas;
                        }
                    }
                    
                    /*
                     * Jika tidak ada libur nasional, lanjut
                     */
                    else
                    {
                        
                        /*
                         * cek apakah ada inputan alasan lembur untuk surat perintah lembur
                         * untuk karyawan dengan kode_alasan "SPL"
                         */
                        if($dataAlasan[$lT]["kode_alasan"]=="SPL")
                        {
                            
                            /*
                             * $jamWajib menampung perhitungan waktu jam wajib
                             * $jad_keluar-$jad_masuk lalu dibagi 3600 (1 jam 3600 detik) lalu dikurang 1 jam istirahat
                             */   
                            $jamWajib = floor((strtotime($jad_keluar)-strtotime($jad_masuk))/3600)-1;
                            
                            /*
                             * $jamLemAct menampung perhitungan waktu lembur Aktual
                             * $jm_keluar-$jm_masuk lalu dibagi 3600 (1 jam 3600 detik) lalu dikurang 1 jam
                             */
                            $jamLemAct = ((floor((strtotime($jm_keluar)-strtotime($jm_masuk))/3600)-1)-$jamWajib);
                            
                            
                            /*
                             * cek apakah aktual sesuai dengan waktu inputan spl
                             */
                            if($jamLemAct >= $dataAlasan[$lT]["waktu"])
                            {
                            
                                /*
                                 * ketika terjadi transaksi SPL dan kode istirahat adalah setengah jam (NILAI = 2)
                                 * maka ada hitungan sendiri untuk SPL nya.
                                 */
                                if($kdIstirahat=="2")
                                {
    //                                $hitLemAct = $this->HitungLembur($this->fungsi->TimeToDecimal($dataAlasan[$lT]["waktu"]), $this->fungsi->TimeToDecimal($dataAlasan[$lT]["waktu"]), 2);
                                    if($jamLemAct>0)
                                    {
                                        $hitLemAct = $this->HitungLembur($jamLemAct, $this->fungsi->TimeToDecimal($dataAlasan[$lT]["waktu"]), 2);
                                    }
                                }
                                else
                                {

                                    /*
                                     * cek apakah hasil perhitungan lebih dari 0
                                     * karena, jika ada nilai 0, maka akan bernilai negatif (-0.5 )
                                     */
                                    $hitLemAct = ($this->fungsi->TimeToDecimal($dataAlasan[$lT]["waktu"])*2)-0.5;
    //                                if($jamLemAct>0)
    //                                {
    //                                    $hitLemAct = ($jamLemAct*2)-0.5;
    //                                }
                                }
                                
                                 //$als = "SPL ".$jamLemAct;
                                $als = "SPL ".$this->fungsi->TimeToDecimal($dataAlasan[$lT]["waktu"]);
                            }
                           
                        }
                    }
                }
                /*
                 * lembur otomatis
                 */
                else if($kdIstirahat=="2")
                {
                    if(isset($jadwalbesok["libur"]))
                    {
                    
                        if($jadwalbesok["libur"]=="1")
                        {
                            if($jm_masuk != "-" && $jm_keluar != "-")
                            {
                                $jamLemAct = $this->HitungLembur(0, 0,2);    
                                $hitLemAct += 4.5;
                            }
                        }
                        else
                        {
                            if($jm_masuk != "-" && $jm_keluar != "-")
                            {

                                $jamLemAct = $this->HitungLembur(0, 0,2);
                                $hitLemAct += $jamLemAct;
                            }
                        }
                    }
                    else
                    {
                        if($jm_masuk != "-" && $jm_keluar != "-")
                        {

                            $jamLemAct = $this->HitungLembur(0, 0,2);
                            $hitLemAct += $jamLemAct;
                        }
                    }
                }
                else
                {
                    /*
                     * cek apakah ada libur nasional di tanggal terpilih
                     * jika ya, lanjut
                     */
                    if(isset($libnas[$lT]))
                    {
                        $als = "Libur Nasional";
                    }
                    
                    /*
                     * cek masuk atau tidak
                     * 
                     */
                                        
                    if($jm_masuk != "-" && $jm_keluar != "-")
                    {
                        
                        
                        /*
                         * cek apakah lembur otomatis
                         * waktu istirahat hanya setengah jam
                         * 
                         */
                        if($kdIstirahat=="2")
                        {
                            $jamLemAct = $this->HitungLembur(0, 0,2);
                            $hitLemAct += $jamLemAct;
                        }
                    }
                }
                
                /*
                 * cek GP
                 * 
                 */
                $gp = $this->gp($mskT,$plgC);
                
                /*
                 * lembur off
                 */

                $ret[] = array(
                    "tanggal" => $expDate[2]."-".$this->fungsi->singkatanBulan($expDate[1])."-".$expDate[0],
                    "tgl" => $lT,
                    "jadwal_masuk" =>$jad_masuk,
                    "jadwal_keluar" =>$jad_keluar,
                    "jam_masuk" =>$jm_masuk,
                    "jam_keluar" =>$jm_keluar,
                    "masuk_cepat" =>$mskC,
                    "masuk_telat" =>$mskT,
                    "keluar_cepat" =>$plgC,
                    "keluar_telat" =>$plgT,
                    "shift3" => ($sf3>0)?$sf3:"",
                    "als" => $als,
                    "kode_als" => $als_code,
                    "jam_lemact" => $jamLemAct,
                    "hit_lemact" => $hitLemAct,
                    "jam_libnas" => $jamLibNas,
                    "hit_libnas" => $hitLiburNas,
                    "gp" => $gp,
                    "libur" => $is_libur
                );
            }                
            
        }
//        print_r($ret);
        return $ret;
    }
    
    private function get_libnas($date_start, $date_end)
    {
        $ret = array();
        
        $this->load->model("Mod_libur");
        
        $search = "(tanggal_libur between '$date_start' and '$date_end')";
        
        $datas = $this->Mod_libur->get_list_libur($search,"tanggal_libur")->result();
        
        foreach($datas as $data)
        {
            $ret[$data->tanggal_libur] = array(
                "tanggal" => $data->tanggal_libur,
                "ket" => $data->keterangan_libur
            );
        }
        return $ret;
        
    }
    
    function sKaryawan()
    {
        $aRet = array();
        
        if($this->input->get("id")!="")
        {
            $q = $this->input->get("id");
            $res = $this->Mod_karyawan->get_by_id_active($q)->result();
        }
        else
        {
            $q = $this->input->get("q");
            $sql = "(pin like '%$q%' or nama_karyawan like '%$q%')";
            $res = $this->Mod_karyawan->get_paged_list_active(1000, 0, $sql)->result();
        }
        
        foreach($res as $ress)
        {
            $aRet[] = array("id"=>$ress->person_id,"text"=>$ress->pin." - ".$ress->nama_karyawan);
        }
        
        echo json_encode($aRet);
    }
    
    private function HitungLibNas($jam,$jJam=7)
    {
        $hit = 0;
        
        if($jam<=$jJam)
            $hit = $jam*2;
        else if($jam>$jJam)
        {
            $hit = 14;
            
            if(($jam-$jJam)==1)
            {
                $hit += (1*3);
            }
            else if(($jam-$jJam)>1)
            {
                $hit += (1*3);
                $hit += (($jam-8)*4);
            }
        }
            
            return $hit;
    }
    
    private function HitungLembur($jamLembur, $limit, $isHalf = 2)
    {
        $ret = 0;
        
        if(!empty($jamLembur) && !empty($limit))
        {
            
            $jL = 0;
            
            $jL = $limit;
//            if($jamLembur > $limit)
//            {
//                $jL = $limit;
//            }
//            else
//            {
//                $jL = $jamLembur;
//            }
            
            /*
             * jika lembur istirahat setengah
             */
            if($isHalf==2)
            {
               
                if($jL>0)
                {
                    $ret = (1*1.5)+(($jL-1)*2);
                    $ret += 0.5 * 2;
                }
            }
            
        }
        else
        {
            /*
            * jika lembur otomatis karena istirahat setengah
            */
            if($isHalf==2)
            {
                $ret = 0.5 * 1.5;
            }
        }
        
        return $ret;
    }
    
    /*
     * fungsi gp untuk menghintung getpass
     * $time = total menit telat
     */
    private function gp($masuk,$pulang)
    {
        $time = $masuk+$pulang;
        
        $ret = 0;
        
        if($time>5)
        {
            $ret = ceil($time/60)*60;
        }
        
        return $ret;
    }
    
    private static function sort_date($a, $b) 
    {
        // $aD = strtotime($a['act_time']);
        // $bD = strtotime($b['act_time']);
		
		$aD = strtotime($a->act_time);
        $bD = strtotime($b->act_time);

        return $aD - $bD;
    }
    
//    private function sort_date($a, $b) 
//    {
//        $aD = strtotime($a['act_time']);
//        $bD = strtotime($b['act_time']);
//
//        return $aD - $bD;
//    }
    
    
    //=================================================//
    
    function build_all()
    {
        $this->build_karyawan();
        
        $this->buid_jadwal();
        print_r($this->karyawan);
    }
    
    private function build_karyawan()
    {
        $listKaryawan = $this->Mod_karyawan->get_paged_list_active(10000, $offset = 0, "")->result();
        
        if(count($listKaryawan)>0)
        {
            foreach ($listKaryawan as $karyawan) 
            {
                $info = array();
                
                $info["nama"]   = $karyawan->nama_karyawan;
                $info["nik"]    = $karyawan->nik;
                $info["pin"]    = $karyawan->pin;
                $info["tmk"]    = $karyawan->tgl_masuk;
                $info["sex"]    = $karyawan->id_jenkel;
                $info["id"]    = $karyawan->person_id;
                
                $this->karyawan[] = $info;
            }
        }
        
    }
    
    function buid_jadwal()
    {
        if(count($this->karyawan)>0)
        {
            foreach($this->karyawan as $key => $value)
            {
                $dataJadwal = $this->Mod_laporan->jadwal_absen($value["id"],'2014-11-22', '2014-12-21');
                
                $this->karyawan[$key]["jadwal"] = $dataJadwal; 
            }
        }
    }
    
    function masak()
    {
        $pin = '11622';
        $dS = '2014-11-22';
        $dE = '2014-12-21';
        
        
        $dataAbsen = $this->Mod_laporan->report_absen($pin,$dS,$dE)->result();
        
        
        
        print_r($dataAbsen);
    }
}
