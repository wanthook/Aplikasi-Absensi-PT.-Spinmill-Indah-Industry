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
class Proses_absensi extends Secure_area
{
    //put your code here
    
    private $limit = 50;
    private $typePage = 'proses_absensi';
    
    private $lembur_setengah_hari = 3.5;
    private $lembur_setengah_hari_istirahat_setengah = 4.5;
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
        $this->form();        
    }       
    
   //////////////////////////////////////////////////////////////////
    
    private function form($message="")
    {
        $data['title'] = "Proses Absen Karyawan";
        $data['action'] = $this->typePage.'/proses';
        $data['idForm'] = "formLaporanAbsenKaryawan";
        $data['button'] = "Proses Laporan";
        $data['button_icon'] = "glyphicon-save";
        $data['message'] = $message;
        
        $this->load->view($this->typePage.'/form', $data);
    } 
    
    function proses()
    {
        $pPeriode = explode("-", $this->input->post("txtPeriode"));
        $karyawan = $this->input->post("cmbKaryawan");
        $divisi = $this->input->post("cmbDivisi");
        
        $hsl = $this->proc_absen($pPeriode[1]."-".$pPeriode[0], $karyawan, $divisi);
        
        $this->form("Proses selesai, data terbaru ".$hsl['insert_count'].". Data terupdate ".$hsl['update_count'].".");
    }
    
    private function proc_absen($periode, $karyawan, $divisi)
    {
        $periodeArr = explode("-", $periode);
        
        $ret = array('insert_count' => 0, 'update_count' => 0);
        
        $data = array();
        
        $ins = array();
        $upd = array();
        
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
//                print_r($listAbsen);
                if($listAbsen==false)
                {
                    continue;
                }
                
                foreach($listAbsen as $vLA)
                {
//                    print_r($vLA);
                    
                    $src = "laporan_karyawan.tanggal='".$vLA['tgl']."' and laporan_karyawan.person_id='".$list->person_id."'";
                    
                    $sSrc = $this->Mod_laporan->laporan_karyawan($src);
                    
                    if($sSrc->num_rows() > 0)
                    {
//                        $rSrc = $sSrc->result();
                        
                        $upd[] = array(
                            'tanggal' => $vLA['tgl'],
                            'person_id' => $list->person_id,
                            'pin' => $list->pin,
                            'jadwal_masuk' => $vLA['jadwal_masuk'],
                            'jadwal_keluar' => $vLA['jadwal_keluar'],
                            'jadwal_libur' => $vLA['jadwal_libur'],
                            'jadwal_pendek' => $vLA['jadwal_pendek'],
                            'jadwal_istirahat' => $vLA['jadwal_istirahat'],
                            'jam_masuk' => $vLA['jam_masuk'],
                            'jam_keluar' => $vLA['jam_keluar'],
                            'masuk_cepat' => $vLA['masuk_cepat'],
                            'masuk_telat' => $vLA['masuk_telat'],
                            'keluar_cepat' => $vLA['keluar_cepat'],
                            'keluar_telat' => $vLA['keluar_telat'],
                            'shift3' => $vLA['shift3'],
                            'als' => $vLA['als'],
                            'kode_als' => $vLA['kode_als'],
                            'jam_lemact' => $vLA['jam_lemact'],
                            'hit_lemact' => $vLA['hit_lemact'],
                            'jam_libnas' => $vLA['jam_libnas'],
                            'hit_libnas' => $vLA['hit_libnas'],
                            'gp' => $vLA['gp'],
                            'libur' => $vLA['libur']
                        );
                    }
                    else
                    {
                        $ins[] = array(
                            'tanggal' => $vLA['tgl'],
                            'person_id' => $list->person_id,
                            'pin' => $list->pin,
                            'jadwal_masuk' => $vLA['jadwal_masuk'],
                            'jadwal_keluar' => $vLA['jadwal_keluar'],
                            'jadwal_libur' => $vLA['jadwal_libur'],
                            'jadwal_pendek' => $vLA['jadwal_pendek'],
                            'jadwal_istirahat' => $vLA['jadwal_istirahat'],
                            'jam_masuk' => $vLA['jam_masuk'],
                            'jam_keluar' => $vLA['jam_keluar'],
                            'masuk_cepat' => $vLA['masuk_cepat'],
                            'masuk_telat' => $vLA['masuk_telat'],
                            'keluar_cepat' => $vLA['keluar_cepat'],
                            'keluar_telat' => $vLA['keluar_telat'],
                            'shift3' => $vLA['shift3'],
                            'als' => $vLA['als'],
                            'kode_als' => $vLA['kode_als'],
                            'jam_lemact' => $vLA['jam_lemact'],
                            'hit_lemact' => $vLA['hit_lemact'],
                            'jam_libnas' => $vLA['jam_libnas'],
                            'hit_libnas' => $vLA['hit_libnas'],
                            'gp' => $vLA['gp'],
                            'libur' => $vLA['libur'],
                            'created_by' => $this->Mod_login->getSessionPersonId(),
                            'create_date' => date('Y-m-d H:i:s'),
                            'modified_by' => $this->Mod_login->getSessionPersonId(),
                            'modify_date' => date('Y-m-d H:i:s')
                        );
                    }
                }
            }
            
            
            
            if(count($ins)>0)
            {
                $this->Mod_laporan->input_batch_laporan($ins);
                
                $ret['insert_count'] = count($ins);
            }
            
            if(count($upd)>0)
            {
                foreach($upd as $val)
                {
                    $this->Mod_laporan->update_laporan($val);                    
                }
                $ret['update_count'] = count($upd);
            }
            
        }
        
        return $ret;
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
             *      kode   => kode_jam_kerja
             */
            $dataJadwal = $this->Mod_laporan->jadwal_absen($person_id,$dateStart, $dateEnd);
            
            /*
             * Ambil data jadwal manual absen dari model laporan (Mod_laporan) dengan parameter
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
            $dataJadwalManual = $this->Mod_laporan->jadwal_absen_manual($person_id,$dateStart, $dateEnd);
            
            foreach($dataJadwalManual as $key => $value)
            {
                $dataJadwal[$key] = $value;
            }
            
            /*
             * Jenis Jadwal karyawan ini apa
             * hasil
             * $var->id_jadwal
             * $var->karyawan_id
             * $var->tipe_jadwal
             */
            $setJadwal = $this->Mod_laporan->set_jadwal($person_id);            
            
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
             * deklarasi $actBefore
             * digunakan untuk menampung status hari sebelumnya
             */
            $statBefore = "";
            
            $beforeTutup = false;
        
            
            /*
             * perulangan pengolahan data absen yang telah ditarik
             */
            foreach($dataAbsen as $absen)
            {
//                print_r($absen);
                /*
                 * cek data pertama
                 * apakah merupakan cekroll keluar (act_function=2)
                 * kalau benar, maka diabaikan
                 */
                if($isFirst)
                {
                    /*
                     * rubah var $isFirst menjadi false, karena sudah dicek
                     */
                    $isFirst = false;
                    
                    /*
                     * lihat tanggal yang sedang dipilih
                     */
                    $tglFirst = $this->fungsi->convertDate($absen->act_time,"d");
                    
                    /*
                     * jika kode absen adalah keluar(2) dan tanggal dipilih adalah 22
                     * maka akan masuk proses pengecekan jam pulang, apakah pulang shift3 atau pulang biasa
                     * terkadang ada cek pulang normal tapi tidak ada kdoe jam masuknya
                     */
                    if($absen->act_function=="2" && $tglFirst=="22" && !$beforeTutup)
                    {
                        /*
                         * ekstrak waktu H:i:s ke dalam satuan detik, untuk mengetahui jam pulang tersebut secara integer
                         * agar mudah membandingkannya
                         */
                        $timeAct = $this->fungsi->convertDate(date("Y-m-d")." ".$absen->acttime,"U");
                        
                        /*
                         * ekstrak waktu detik jam 1 siang pada tanggal tersebut, untuk melihat nilai integernya
                         */
                        $timeStop = $this->fungsi->convertDate(date("Y-m-d")." 13:00:00","U");
                        
                        /*
                         * cek apakah jam absen lebih kecil dari jam 1 siang.
                         * Jika benar akan di skip
                         * Jika tidak, maka jam dimasukkan kedalam laporan
                         * mantap gak tuh wkwkwkwkwkwk :v
                         */
                        if($timeAct < $timeStop)
                        {
                            continue;
                        }
                        else
                        {
                            $arrData[$absen->tanggal][2] = $absen->act_time;
                            
                            $beforeTutup = true;
                        }
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
                        
                        $beforeTutup = false;
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
                     * cek beda tanggal kemarin dengan tanggal saat ini
                     */
                    $dateDif = $this->fungsi->dateDif($tglBefore, $dateShift3, "%d");
//                    echo "\n";
                    /*
                     * pengecekan $tglBefore dengan $dateShift3 serta beda tanggal kemarin dengan tanggal sekarang.
                     * jika benar, ada kemungkinan tanggal tersebut merupakan shift3
                     * jika beda tanggal adalah 1 hari, maka benar
                     * jika beda tanggal lebih dari satu hari
                     * 
                     */
//                    echo "masuk ".$absen->act_time." $dateDif\n";
                    if($tglBefore == $dateShift3 && $statBefore!="2" && $dateDif<2)
                    {
//                        echo "masuk".$absen->act_time."\n";
                        /*
                         * apakah $tmBefore lebih besar dari pukul "22:00:00" (shift 3 masuk pukul 23:00:00)
                         * jika benar, berarti tanggal dan jam terpilih tersebut merupakan shift3
                         * dengan penambahan key array sf3 bernilai 1
                         */
                        //echo "masuk".$absen->act_time." act=".$absen->acttime."\n";
                        if(strtotime($tmBefore)>strtotime("18:00:00"))
                        {
//                            echo "YES";
//                            if(!$beforeTutup)
//                            {
                                $arrData[$tglBefore][2] = $absen->act_time;
                                $arrData[$tglBefore]["sf3"] = 1;
//                                echo "masuk ".$absen->act_time." $dateDif\n";
                                $beforeTutup = true;
//                            }
                            
                            
                        }
                        else
                        {
//                            echo "masuk".$absen->act_time."\n";
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
//                        echo "masuk ".$absen->acttime." $dateDif\n";
                        if(strtotime($absen->act_time)<= strtotime($absen->tanggal." 09:00:00"))
                        {
                            $arrData[date("Y-m-d",  strtotime("-1 day ".$absen->tanggal))][2] = $absen->act_time;
                        }
                        else
                        {
                            $arrData[$absen->tanggal][2] = $absen->act_time;
                        }
                        
                    }
                }
                
                /*
                * variabel $tglBefore diisi tanggal $tglCurrent
                * untuk digunakan pengecekan shift3 dan menghindari kesalahan
                * ketika status sebelumnya ternyata pulang
                */
               $statBefore = $absen->act_function;
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
//            print_r($arrData);
            foreach($listTanggal as $lT)
            {
                $expDate = explode("-", $lT);
                
                $kdAls = "";
                
                $jad_masuk = (isset($dataJadwal[$lT])?$dataJadwal[$lT]["jam_masuk"]:"-");
                $jad_keluar = (isset($dataJadwal[$lT])?$dataJadwal[$lT]["jam_pulang"]:"-");
                
                $jad_libur = (isset($dataJadwal[$lT])?$dataJadwal[$lT]["libur"]:"-");
                $jad_pendek = (isset($dataJadwal[$lT])?$dataJadwal[$lT]["pendek"]:"-");
                $jad_istirahat = (isset($dataJadwal[$lT])?$dataJadwal[$lT]["istirahat"]:"-");
                
                $setengah_hari = (isset($dataJadwal[$lT])?$dataJadwal[$lT]["pendek"]:"-");
                
                $kode_jam = (isset($dataJadwal[$lT])?$dataJadwal[$lT]["kode"]:"-");
                
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
                            
//                            if($setJadwal->tipe_jadwal=='S')
//                            {
//                                $jamLemAct = 1.5;
//                                
//                                $hitLiburNas += $jamLemAct;
//                            }
                            
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
                        if($dataAlasan[$lT]["kode_alasan"]=="SPL" || $dataAlasan[$lT]["kode_alasan"]=="SLA")
                        {
                            if($dataAlasan[$lT]["kode_alasan"] == "SPL")
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
                                $jamLemAct = ((floor((strtotime($jm_keluar)-strtotime($jad_masuk))/3600)-1)-$jamWajib);


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
                                            $hitLemAct = $this->HitungLembur($jamLemAct, $this->fungsi->TimeToDecimal2($dataAlasan[$lT]["waktu"]), 2);
                                        }
                                    }
                                    else
                                    {
                                        //echo "kesini";
                                        /*
                                         * cek apakah hasil perhitungan lebih dari 0
                                         * karena, jika ada nilai 0, maka akan bernilai negatif (-0.5 )
                                         */
                                        $hitLemAct = ($this->fungsi->TimeToDecimal2($dataAlasan[$lT]["waktu"])*2)-0.5;
        //                                if($jamLemAct>0)
        //                                {
        //                                    $hitLemAct = ($jamLemAct*2)-0.5;
        //                                }
                                    }

                                     //$als = "SPL ".$jamLemAct;
                                    $als = "SPL ".($this->fungsi->TimeToDecimal2($dataAlasan[$lT]["waktu"]));
                                }
                            }
                            
                            else if($dataAlasan[$lT]["kode_alasan"] == "SLA")
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
//                                $jamLemAct = ((floor((strtotime($jm_keluar)-strtotime($jad_masuk))/3600)-1)-$jamWajib);
                                $jamLemAct = ((floor((strtotime($jad_keluar)-strtotime($jm_masuk))/3600)-1)-$jamWajib);

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
                                            $hitLemAct = $this->HitungLembur($jamLemAct, $this->fungsi->TimeToDecimal2($dataAlasan[$lT]["waktu"]), 2);
                                        }
                                    }
                                    else
                                    {
                                        //echo "kesini";
                                        /*
                                         * cek apakah hasil perhitungan lebih dari 0
                                         * karena, jika ada nilai 0, maka akan bernilai negatif (-0.5 )
                                         */
                                        $hitLemAct = ($this->fungsi->TimeToDecimal2($dataAlasan[$lT]["waktu"])*2)-0.5;
        //                                if($jamLemAct>0)
        //                                {
        //                                    $hitLemAct = ($jamLemAct*2)-0.5;
        //                                }
                                    }

                                     //$als = "SPL ".$jamLemAct;
                                    $als = "SLA ".($this->fungsi->TimeToDecimal2($dataAlasan[$lT]["waktu"]));
                                }
                            }
                           
                        }
                        else if($dataAlasan[$lT]["kode_alasan"]=="SPO")
                        {
                            $jamL = floor((strtotime($arrData[$lT]["2"])-strtotime($arrData[$lT]["1"]))/3600)-1;
                            
                             if($jamL>0)
                            {
                                $hitLemAct += $this->HitungLibNas($jamL);
                            }
                            
                            if($setJadwal->tipe_jadwal=='S')
                            {
                                $jamLemAct = 1.5;
                                
                                $hitLemAct += $jamLemAct;
                            }
                            
                            $als = "SPO ".$jamL;
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
                                
                                if($setengah_hari == "1" && stristr($kode_jam, "M"))
                                {
                                    $jamLemAct += $this->lembur_setengah_hari_istirahat_setengah;
                                }
                                
                                $hitLemAct += $jamLemAct;
                            }
                        }
                    }
                    else
                    {
                        if($jm_masuk != "-" && $jm_keluar != "-")
                        {

                            $jamLemAct = $this->HitungLembur(0, 0,2);
                            
                            if($setengah_hari == "1" && stristr($kode_jam, "M"))
                            {
                                $jamLemAct += $this->lembur_setengah_hari_istirahat_setengah;
                            }
                            
                            $hitLemAct += $jamLemAct;
                        }
                    }
                    
                    if(isset($libnas[$lT]))
                    {
                        $als = "Libur Nasional";
                        $kdAls = "LN";
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
                        $kdAls = "LN";
                    }
                    
                    /*
                     * cek masuk atau tidak
                     * 
                     */
                                        
                    if($jm_masuk != "-" && $jm_keluar != "-")
                    {
                        if($setengah_hari == "1" && stristr($kode_jam, "M"))
                        {
                            $jamLemAct += $this->lembur_setengah_hari;
                        }
                        
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
//                if(!empty($gp))
//                {
//                    echo $lT." ".$gp."\n";
//                }
                /*
                 * lembur off
                 */

                $ret[] = array(
                    "tanggal" => $expDate[2]."-".$this->fungsi->singkatanBulan($expDate[1])."-".$expDate[0],
                    "tgl" => $lT,
                    "jadwal_masuk" =>$jad_masuk,
                    "jadwal_keluar" =>$jad_keluar,
                    "jadwal_libur" =>$jad_libur,
                    "jadwal_pendek" =>$jad_pendek,
                    "jadwal_istirahat" =>$jad_istirahat,
                    "jam_masuk" =>$jm_masuk,
                    "jam_keluar" =>$jm_keluar,
                    "masuk_cepat" =>$mskC,
                    "masuk_telat" =>$mskT,
                    "keluar_cepat" =>$plgC,
                    "keluar_telat" =>$plgT,
                    "shift3" => ($sf3>0)?$sf3:"",
                    "als" => $als,
                    "kode_als" => $kdAls,
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
   
    
}
