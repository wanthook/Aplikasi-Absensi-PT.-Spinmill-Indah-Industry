<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of set_jadwal_kerja
 *
 * @author taufiq
 */
class Upload_absen extends Secure_area
{
    private $limit = 50;
    private $typePage = 'upload_absen';
    private $titleForm = 'Form Upload Access';
    
    private $tblHead = array('Tanggal', 'Periode Awal', 'Periode Akhir', 'Jumlah Data','Ukuran File','Status','Tanggal Upload System');
    
    
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('Mod_upload_absen');
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
        $datas = $this->Mod_upload_absen->get_data_list($this->limit, $offset,$search)->result();

        $templateTable = $this->fungsi->template_table('tblUploadAbsen');
        
        //config paggination
        $config = $this->fungsi->template_pagging(
                        site_url($this->typePage.'/index/'),
                        $this->Mod_upload_absen->count_all($search),
                        $this->limit,
                        $uri_segment
                    );
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        // generate table data
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading($this->tblHead);
        
        $this->table->set_template($templateTable);
        
        if(empty($datas))
        {
            $this->table->add_row(array('data' => $this->lang->line('common_empty_table'), 'colspan' => count($this->tblHead), 'align'=> 'center'));
        }
        else
        {
        
            $i = 0 + $offset;
            foreach ($datas as $row)
            {            
                
                $this->table->add_row(
                    $this->fungsi->convertDate($row->tanggal,'d-m-Y'), 
                    $this->fungsi->convertDate($row->tanggal_awal,'d-m-Y H:i:s'), 
                    $this->fungsi->convertDate($row->tanggal_akhir,'d-m-Y H:i:s'), 
                    $row->jumlah_data, 
                    $row->ukuran_file, 
                    ($row->status=="1"?"Sukses":($row->status=="0"?"Gagal":"")), 
                    $this->fungsi->convertDate($row->modify_date,'d-m-Y H:i:s')
                );
            }
        }
        $data['table'] = $this->table->generate();
        
        // load view
        $this->load->view($this->typePage.'/tabel', $data);
    }
    
    function search()
    {
        $searchText = $this->input->post('txtSearch');
        
        $this->table($searchText);
    }
    
    function add($message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->typePage.'/do_upload';
        $data['idForm'] = "formUploadAbsen";
        $data['button'] = "Upload";
        $data['button_icon'] = "glyphicon-plus-sign";
        $data['message'] = $message;
        
         // set validation properties
//        $this->_set_rules();
                
        $this->load->view($this->typePage.'/form',$data);
    }
    
    function do_upload()
    {
        $txtPeriode = explode("-",$this->input->post("txtPeriode"));
        
        $config['upload_path'] = './uploads/';
        $config['max_size']	= '0';
        $config['overwrite']	= 'true';

        $this->load->library('upload', $config);
        
        $this->upload->initialize($config);
        
        $this->upload->set_allowed_types('*');
        
        $msg = '';
        
        if (!$this->upload->do_upload('txtFile')) 
        {
            echo $msg = $this->upload->display_errors();

        } 
        else 
        { 
            $msgs = $this->upload->data();
            
            $msg = $this->do_import($msgs,$txtPeriode[1]."-".$txtPeriode[0]);
        }
        
//        $this->form($msg);
    }
    
    function do_import($filename,$periode)
    {
        $statusProccess = 0;        
        
        $connect = $this->odbc($filename['full_path'], "PRIMINTI");
        
        $sqlAcc = "select * from tActivities where 1=1";
        
        $sqlAbsIn = " and ftTime>=#".date('Y-m-d',strtotime($periode."-22 -1 month"))." 00:00:00"."#".
                    " and ftTime<=#".date('Y-m-d',strtotime($periode."-21"))." 23:59:59"."#".
                    " and fsFunctionCode='1'";

        $sqlAbsOut = " and ftTime>=#".date('Y-m-d',strtotime($periode."-22 -1 month"))." 00:00:00"."#".
                     " and ftTime<=#".date('Y-m-d',strtotime($periode."-22"))." 23:59:59"."#".
                     " and fsFunctionCode='2'";
        
        
        /*
         * Sinkron untuk in saja
         */
        $sql = $sqlAcc.$sqlAbsIn;
        $res = odbc_exec($connect, $sql);
        
        $arrBatch = array();
        
        while($row = odbc_fetch_object($res))
        {
            if(!$this->Mod_upload_absen->cek_activity($row->fsCardNo,$row->ftTime,$row->fsFunctionCode))
            {
                $arrBatch[] = array(
                    "act_card" => $row->fsCardNo,
                    "act_time" => $row->ftTime,
                    "act_dir_flag" => $row->fcDirFlag,
                    "act_event_flag" => $row->fsEventFlag,
                    "act_term_no" => $row->fsTermNo,
                    "act_function" => $row->fsFunctionCode,
                    "created_by" => $this->Mod_login->getSessionPersonId(),
                    "create_date" => date("Y-m-d H:i:s"),
                    "modified_by" => $this->Mod_login->getSessionPersonId(),
                    "modify_date" => date("Y-m-d H:i:s")
                );
            }
            else
                continue;
        }
        
        /*
         * Sinkron untuk out saja
         */
        $sql = $sqlAcc.$sqlAbsOut;
        $res = odbc_exec($connect, $sql);
        
        while($row = odbc_fetch_object($res))
        {
            if(!$this->Mod_upload_absen->cek_activity($row->fsCardNo,$row->ftTime,$row->fsFunctionCode))
            {
                $arrBatch[] = array(
                    "act_card" => $row->fsCardNo,
                    "act_time" => $row->ftTime,
                    "act_dir_flag" => $row->fcDirFlag,
                    "act_event_flag" => $row->fsEventFlag,
                    "act_term_no" => $row->fsTermNo,
                    "act_function" => $row->fsFunctionCode,
                    "created_by" => $this->Mod_login->getSessionPersonId(),
                    "create_date" => date("Y-m-d H:i:s"),
                    "modified_by" => $this->Mod_login->getSessionPersonId(),
                    "modify_date" => date("Y-m-d H:i:s")
                );
            }
            else
                continue;
        }
        
        $statusProccess = $this->Mod_upload_absen->save_activity($arrBatch);
        
        $data['tanggal'] = date("Y-m-d H:i:s");
        $data['tanggal_awal'] = date('Y-m-d',strtotime($periode."-22 -1 month"));
        $data['tanggal_akhir'] = date('Y-m-d',strtotime($periode."-21"));
        $data['jumlah_data'] = count($arrBatch);
        $data['ukuran_file'] = $filename['file_size'];
        $data['status'] = $statusProccess;
        
        $this->Mod_upload_absen->save($data);
//        print_r($data);
//        $this->add("Data berhasil disimpan.");
    }
    
    private function odbc($filename,$pass)
    {
//        echo $filename;
        return odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=".$filename, "", $pass);
    }
    
    private function set_data()
    {
        $data['id_jadwal'] = $this->input->post('txtJadwal');
        $data['karyawan_id'] = $this->input->post('txtKaryawan');
        $data['tipe_jadwal'] = $this->input->post('txtJenisJadwal');
        
        return $data;
    }
    
    function sKaryawan()
    {
        $q     = $this->input->get("q");
        $id     = $this->input->get("id");
        
        $sKaryawan = array();
        
        if(!empty($q))
        {
            $res = $this->Mod_karyawan->get_karyawan_list_jadwal("(pin like '%$q%' or nama_karyawan like '%$q%')")->result();
            
            foreach($res as $resA)
            {
                $sKaryawan[] = array("id"=>$resA->person_id,"text"=>$resA->pin." - ".$resA->nama_karyawan);
            }
        }
        else
        {
            $res = $this->Mod_karyawan->get_karyawan_list_jadwal("person_id='$id'",true)->result();
            
            foreach($res as $resA)
            {
                $sKaryawan[] = array("id"=>$resA->person_id,"text"=>$resA->pin." - ".$resA->nama_karyawan);
            }
        }
        
        echo json_encode($sKaryawan);
        
    }
    
    function sJadwal()
    {
        $type   = $this->input->get("type");
        $q     = $this->input->get("q");
        $id     = $this->input->get("id");
        
        if($type=="N")
        {
            if(!empty($id))
                $this->sJadwalNorm($id,true, true);
            else
                $this->sJadwalNorm($q,false, true);
        }
        else if($type=="S")
        {
            if(!empty($id))
                $this->sJadwalShift($id, true, true);
            else
                $this->sJadwalShift($q, false, true);
        }
    }
    
    function sJadwalNorm($id="",$isPrimary,$json)
    {
        $aArr = array();
        
        if($id!="")
        {
            if($isPrimary)
                $q = "id_jadwal='$id'";
            else
                $q = "(kode_jadwal_normal like '%$id%' or keterangan_jadwal_normal like '%$id%')";
            $res = $this->Mod_jadwal_kerja_normal->get_paged_list_active(10, 0, $q)->result();
            
            foreach($res as $aArrs)
            {
                $aArr[] = array("id"=>$aArrs->id_jadwal,"text"=>"(".$aArrs->kode_jadwal_normal.") - ".$aArrs->keterangan_jadwal_normal);
            }

            if($json)
                echo json_encode($aArr);
            else
                return $aArr;
        }
    }
    
    function sJadwalShift($id="",$isPrimary,$json=true)
    {
        $aArr = array();
        
        if($id!="")
        {
            if($isPrimary)
                $q = "id_jadwal='$id'";
            else
                $q = "(kode_jadwal_shift like '%$id%' or keterangan_jadwal_shift like '%$id%')";
            
            $res = $this->Mod_jadwal_kerja_shift->get_paged_list_active(10, 0, $q)->result();
        }
            
        foreach($res as $aArrs)
        {
            $aArr[] = array("id"=>$aArrs->id_jadwal,"text"=>"(".$aArrs->kode_jadwal_shift.") - ".$aArrs->keterangan_jadwal_shift);
        }
        
        if($json)
            echo json_encode($aArr);
        else
            return $aArr;
    }
    
    function success()
    {
        $message = '<div class="alert alert-success">'.$this->lang->line('common_save').'</div>';
        
        $this->add($message);
    }
}
