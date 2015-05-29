<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

/**
 * Description of login
 *
 * @author taufiq
 */
class Jadwal_kerja_manual extends Secure_area
{
    private $limit = 25;
    private $typePage = 'jadwal_kerja_manual';
    private $titleForm = 'Form Kode Jadwal Kerja Manual';
    private $actionUrl = 'jadwal_kerja_manual';
    
//    private $tblHead = array('Kode Jadwal', 'Keterangan Jadwal', 'Modifikasi Terakhir', 'Aksi');
    private $tblHead = array('PIN', 'Nama Karyawan', 'Modifikasi Terakhir', 'Aksi');
    
    private $tblHeadDay = array('Senin', 'Selasa', 'Rabu', 'Kamis','Jum\'at','Sabtu','Minggu');
    
    private $temp_data_tbl = array();
    
    private $tmpl = array (
                    'table_open'          => '<table class="table table-bordered tablesorter" id="tblJadwalKerjaManual">',
                    
                    'thead_open'          => '<thead>',
                    'thead_close'         => '</thead>',
            
                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',
                    
                    'tbody_open'          => '<tbody>',
                    'tbody_close'         => '</tbody>',
            
                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );
    
    private $tmpl_date = array (
                    'table_open'          => '<table class="table table-bordered tablesorter" id="tblJadwalKerjaManualDate">',
                    
                    'thead_open'          => '<thead>',
                    'thead_close'         => '</thead>',
            
                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',
                    
                    'tbody_open'          => '<tbody>',
                    'tbody_close'         => '</tbody>',
            
                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );
    
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model("Mod_jadwal_kerja_manual");
    }
    
    function index()
    {
        $this->table();
    }   
    
    function table($search="",$ofset = 0)
    {
        // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        
        // load data
        $datas = $this->Mod_jadwal_kerja_manual->get_data_master($search,$this->limit, $offset)->result();
//        print_r($datas);
         // generate pagination
        $config['base_url'] = site_url($this->typePage.'/index/');
        $config['total_rows'] = $this->Mod_jadwal_kerja_manual->get_data_master($search)->num_rows();
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        
        $config['cur_tag_open'] = '<li class="disabled"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        // generate table data
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading($this->tblHead);
        
        $this->table->set_template($this->tmpl);
//        print_r($datas);
        $i = 0 + $offset;
        foreach ($datas as $row)
        {            
            $this->table->add_row(
                    $row->pin, 
                    $row->nama_karyawan,
                    date('d-m-Y H:i:s', strtotime($row->modify_date)), 
//                anchor($this->typePage.'/view/'.$row->id_jam_kerja,'<span class="glyphicon glyphicon-file"></span>&nbsp;Lihat',array('class'=>'btn btn-primary btn-xs')).' '.
                anchor($this->typePage.'/update/'.$row->id_jadwal,'<span class="glyphicon glyphicon-pencil"></span>&nbsp;Ubah',array('class'=>'btn btn-warning btn-xs')).' '.
                anchor($this->typePage.'/delete/'.$row->id_jadwal,'<span class="glyphicon glyphicon-remove"></span>&nbsp;Hapus',array('class'=>'btn btn-danger btn-xs','onclick'=>"return confirm('".$this->lang->line("common_delete")."')"))
            );
        }
        
        if(empty($datas))
        {
            $this->table->add_row(array('data' => 'Data tidak ada', 'colspan' => count($this->tblHead), 'align'=> 'center'));
        }
        
        $data['table'] = $this->table->generate();
        
        // load view
        $this->load->view($this->typePage.'/tabel', $data);
    }
    
    private function table_date($date="",$id="")
    {
        $date_start="";
        $date_end="";
        
        if($date=="")
        {
            $periode = date("Y-m");
            
        }
        else
        {
            $tgl = explode("-", $date);
            $periode = $tgl[1]."-".$tgl[0];
        }
        
        $date_start = date("Y-m-d",strtotime("-1 month ".$periode."-22"));
        $date_end   = $periode."-21";
        
        //get detail data
        $detData = $this->Mod_jadwal_kerja_manual->open_detail($date_start,$date_end,$id)->result_array();
//        print_r($detData);
        
        // generate table data
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading($this->tblHeadDay );
        
        $this->table->set_template($this->tmpl_date);
        
        //get total date range month
        $dateS  = $this->fungsi->getDateRange($date_start,$date_end,"+1 days");
//        $totalDate = $this->fungsi->days_in_month(intval($tgl[0]),intval($tgl[1]));
        
        
        $posFirstDate = date('N',  strtotime($date_start));
        $posLastDate = date('N'.  strtotime($date_end));
        
        //cek blank first
        switch ($posFirstDate)
        {
            case 1: $blank = 0; break;
            case 2: $blank = 1; break;
            case 3: $blank = 2; break;
            case 4: $blank = 3; break;
            case 5: $blank = 4; break;
            case 6: $blank = 5; break;
            case 7: $blank = 6; break;
        }       
        
        //variabel mingguan
        $mingguan = $blank;
        $arrMingguan = array();
        for($b=0 ; $b<$blank ; $b++)
        {
            $arrMingguan[] = "";
        }
        
        foreach($dateS as $date)
        {
            $mingguan ++;
            if($mingguan<8)
            {
                //cari hasil db ada gak yang tanggal tersebut
                $dataDetail = $this->change_data_detail($detData, $date);
                
                if(!empty($dataDetail))
                    $arrMingguan[$mingguan-1] = array('data'=>date("d",  strtotime($date))."\n<br>".$dataDetail['kode_jam_kerja']."\n<br>".$dataDetail['jam_masuk']." - ".$dataDetail['jam_pulang'],'style'=>'background-color:'.$dataDetail['warna'].';','class'=>'cellTgl', 'dt'=>$date);
                else
                    $arrMingguan[$mingguan-1] = array('data'=>date("d",  strtotime($date)),'class'=>'cellTgl', 'dt'=>$date);
            }
            else
            {
                $this->table->add_row($arrMingguan);
                unset($arrMingguan);
                
                $mingguan = 1; 
                
                $dataDetail = $this->change_data_detail($detData, $date);
                
                if(!empty($dataDetail))
                    $arrMingguan[$mingguan-1] = array('data'=>date("d",  strtotime($date))."\n<br>".$dataDetail['kode_jam_kerja']."\n<br>".$dataDetail['jam_masuk']." - ".$dataDetail['jam_pulang'],'style'=>'background-color:'.$dataDetail['warna'].';','class'=>'cellTgl', 'dt'=>$date);
                else
                    $arrMingguan[$mingguan-1] = array('data'=>date("d",  strtotime($date)),'class'=>'cellTgl', 'dt'=>$date);
            }
        }        
        
        if(!empty($arrMingguan))
        {
            //cek blank Last
            switch ($posLastDate)
            {
                case 1: $blank = 6; break;
                case 2: $blank = 5; break;
                case 3: $blank = 4; break;
                case 4: $blank = 3; break;
                case 5: $blank = 2; break;
                case 6: $blank = 1; break;
                case 7: $blank = 0; break;
            }
            
            $mingguan = $posLastDate;
            for($b=$mingguan ; $b<7 ; $b++)
            {
                $arrMingguan[$b] = "";
            }
            $this->table->add_row($arrMingguan);
        }
        
        // load view
        return $this->table->generate();
    }
    
    function load_stable()
    {
        $date = $this->input->get("date");
        $id = $this->input->get("id");
        
        echo $this->table_date($date,$id);
    }
    
    function add_stable_temp()
    {
        $periode = $this->input->post('per');
        $jadwal = $this->input->post('jad');
        $tanggal = $this->input->post('tgl');
        
        
        $resJad = $this->Mod_jam_kerja->get_by_id($jadwal)->result_array();
        $detJad = $resJad[0];
        $data['tanggal'] = $tanggal;
        $data['id_jam_kerja'] = $jadwal;
        $data['hapus'] = '1';
        
        if($this->Mod_jadwal_kerja_manual->exist_temp_stable($data['tanggal']))
        {
            $this->Mod_jadwal_kerja_manual->update_temp_stable($data);
        }
        else
        {
            $this->Mod_jadwal_kerja_manual->add_temp_stable($data);
        }
        
        $json = array(
            "kode" => $detJad["kode_jam_kerja"],
            "jam" => $detJad["jam_masuk"]." - ".$detJad["jam_pulang"],
            "warna" => $detJad["warna"]
        );

        echo json_encode($json);
        
    }
    
    function delete_stable_temp()
    {
        $periode = $this->input->post('per');
        $tanggal = $this->input->post('tgl');
        
        $dFormat = new DateTime($tanggal."-".$periode);
        
        $this->Mod_jadwal_kerja_manual->delete_temp_stable($tanggal);
        
        $json = array(
            "kode" => "",
            "jam" => "",
            "warna" => ""
        );

        echo json_encode($json);
    }
    
    
    function search()
    {
        $where = "";

        $txtSearch = $this->input->post('txtSearch');
        
        if(!empty($txtSearch))
        {
            $where .= "(orang.pin like '%$txtSearch%' or orang.nama_karyawan like '%$txtSearch%')";
        }
            //$where .= "(kode_jadwal_manual like '%$txtSearch%' or keterangan_jadwal_shift like '%$txtSearch%')";
        
        $this->table($where);
        
    }
    
    function add($message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->actionUrl.'/save';
        $data['idForm'] = "formJadwalKerjaManual";
        $data['button'] = "Simpan";
        $data['button_icon'] = "glyphicon-plus-sign";
        $data['message'] = $message;
        
        $this->Mod_jadwal_kerja_manual->free_up_temp_stable();
//        if(empty($message))
            
        //$data['tabelDate'] = $this->table_date();
        
        $this->load->view($this->typePage.'/form',$data);
    }
    
    function success()
    {
        $message = '<div class="alert alert-success">'.$this->lang->line('common_save').'</div>';
        
        $this->add($message);
    }
    
    function save()
    {
        $this->_set_rules();
        
        if ($this->form_validation->run('jadwalKerjaManual') == FALSE)
        {
            $message = '';
            $this->add($message);
        }
        else
        {
            $data = $this->_set_data();
            
            $id = $this->Mod_jadwal_kerja_manual->save($data);
            
            if($id)
            {
                $this->Mod_jadwal_kerja_manual->save_detail($id);
            }
            
            redirect($this->typePage.'/success');
                        
        }
        
        
    }
    
    function update($id,$message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->actionUrl.'/edit/'.$id;
        $data['idForm'] = "formJadwalKerjaManual";
        $data['button'] = "Ubah";
        $data['button_icon'] = "glyphicon-pencil";
        
        $this->Mod_jadwal_kerja_manual->free_up_temp_stable();
        
        $search = "id_jadwal='$id'";
        
        $edit_data = $this->Mod_jadwal_kerja_manual->get_data_master($search)->row_array();
        
        $dataSet = $this->_set_data($edit_data);
        
        $data = array_merge($data,$dataSet);
//        print_r($data);
        if(!empty($message))
        {
            $data['message'] = $message;
        }
        
        $this->load->view($this->typePage.'/form',$data);
    }
            
    function edit($id)
    {
        $this->_set_rules();
        
        if ($this->form_validation->run('jadwalKerjaManual') == FALSE)
        {
            $message = '';
            $this->update($id,$message);
        }
        else
        {
            $data = $this->_set_data();
            
            $update = $this->Mod_jadwal_kerja_manual->update($id,$data);
            
            $this->Mod_jadwal_kerja_manual->update_detail($id);
//            if($update)
//            {
//                $this->Mod_jadwal_kerja_shift->update_detail($id);
//            }
            
            $message = '<div class="alert alert-success">'.$this->lang->line('common_edit').'</div>';
        
            $this->update($id,$message);
            
                        
        }
    }
    
    function delete($id)
    {
        $this->Mod_jadwal_kerja_manual->delete($id);
        
        redirect($this->typePage);
    }
    
    function _set_data($param="")
    {
        if(!empty($param))
        {
            
            $data['txtPinKerjaManual'] = $param['person_id'];
            return $data;
        }
        
        $data['person_id'] = $this->input->post('txtPinKerjaManual');


        
        return $data;
    }
    
    // validation rules
    function _set_rules()
    {
        $this->form_validation->set_message('required', '%s Harus Diisi!!!');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }
    
    function rolekey_exists($key)
    {
        if($this->Mod_jadwal_kerja_manual->role_exists($key))
        {
            $this->form_validation->set_message('rolekey_exists', '%s sudah ada di database');
            return false;
        }
        
        return true;
    }
    
    function sJadwal()
    {
        $aArr = array();
        
        if($this->input->get("id")!="")
        {
            $q = $this->input->get("id");
            $res = $this->Mod_jam_kerja->get_by_id_active($q)->result();
        }
        else
        {
            $q = $this->input->get("q");
            $res = $this->Mod_jam_kerja->get_paged_list_active(10, 0, $q)->result();
        }
        
        
        
        foreach($res as $aArrs)
        {
            $aArr[] = array("id"=>$aArrs->id_jam_kerja,"text"=>$aArrs->kode_jam_kerja." (".$aArrs->jam_masuk." - ".$aArrs->jam_pulang.")");
        }
        
        echo json_encode($aArr);
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
    
    function change_data_detail($arr, $date)
    {
        $ret = array();
        
        foreach($arr as $arrs)
        {
            if($arrs['tanggal']==$date)
            {
                $ret = $arrs;
                break;
            }
        }
        
        return $ret;
    }
    
//    function change_data_detail($arr, $date)
//    {
//        $ret = array();
//        
//        foreach($arr as $arrs)
//        {
//            if($arrs['dt']==$date)
//            {
//                $ret = $arrs;
//                break;
//            }
//        }
//        
//        return $ret;
//    }
}

?>
