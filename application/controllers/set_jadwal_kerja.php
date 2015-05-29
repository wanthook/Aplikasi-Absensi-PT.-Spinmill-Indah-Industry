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
class set_jadwal_kerja extends Secure_area
{
    private $limit = 100;
    private $typePage = 'set_jadwal_kerja';
    private $titleForm = 'Form Set Jadwal';
    
    private $tblHead = array('PIN', 'Kartu', 'Nama Karyawan', 'Divisi','Jabatan','Tipe Jadwal','Kode Jadwal','Modifikasi Terakhir', 'Aksi');
    
    private $header_exc = array("PIN","JENIS","KODE JADWAL");
    
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('Mod_set_jadwal_kerja');
    }
    
    function index()
    {
        $this->table();
    }
    
    function table($search="")
    {
        // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        
        // load data
        $datas = $this->Mod_set_jadwal_kerja->get_data_list($this->limit, $offset,$search)->result();
//        print_r($datas);
        //set template table
        $templateTable = $this->fungsi->template_table('tblSetJadwalKerja');
        
        //config paggination
        $config = $this->fungsi->template_pagging(
                        site_url($this->typePage.'/index/'),
                        $this->Mod_set_jadwal_kerja->count_all($search),
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
                    $row->pin, 
                    $row->kartu, 
                    $row->nama_karyawan, 
                    $row->nama_divisi, 
                    $row->nama_jabatan, 
                    ($row->tipe_jadwal=="N"?"Normal":($row->tipe_jadwal=="S"?"Shift":"")), 
                    ($row->tipe_jadwal=="N"?$row->kode_jadwal_normal:($row->tipe_jadwal=="S"?$row->kode_jadwal_shift:"")), 
                    date('d-m-Y H:i:s', strtotime($row->modify_date)), 
//                  anchor($this->typePage.'/view/'.$row->id_alasan,'<span class="glyphicon glyphicon-file"></span>&nbsp;Lihat',array('class'=>'btn btn-primary btn-xs')).' '.
                    anchor($this->typePage.'/update/'.$row->id_set_jadwal,'<span class="glyphicon glyphicon-pencil"></span>&nbsp;Ubah',array('class'=>'btn btn-warning btn-xs')).' '.
                    anchor($this->typePage.'/delete/'.$row->id_set_jadwal,'<span class="glyphicon glyphicon-remove"></span>&nbsp;Hapus',array('class'=>'btn btn-danger btn-xs','onclick'=>"return confirm('".$this->lang->line("common_delete")."')"))
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
        
        $strSearch = "";
        
        if(!empty($searchText))
        {
        
            $strSearch = "(b.pin like '%$searchText%' or b.kartu like '%$searchText%')";
        }
        
        $this->table($strSearch);
    }
    
    function add($message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->typePage.'/save';
        $data['idForm'] = "formSetJadwalKerja";
        $data['button'] = "Simpan";
        $data['button_icon'] = "glyphicon-plus-sign";
        $data['message'] = $message;
         // set validation properties
//        $this->_set_rules();
                
        $this->load->view($this->typePage.'/form',$data);
    }
    
    function update($id,$message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->typePage.'/edit/'.$id;
        $data['idForm'] = "formSetJadwalKerja";
        $data['button'] = "Ubah";
        $data['button_icon'] = "glyphicon-pencil";
        
        $edit_data = $this->Mod_set_jadwal_kerja->get_data_list(10,0,"a.id_set_jadwal='".$id."'")->row();
//        print_r($edit_data);
        $data['txtId'] = $edit_data->id_set_jadwal;
        $data['txtKaryawan'] = $edit_data->karyawan_id;
        $data['txtJadwal'] = $edit_data->id_jadwal;
        $data['txtJenisJadwal'] = $edit_data->tipe_jadwal;
        
        if(!empty($message))
        {
            $data['message'] = $message;
        }
        
        $this->load->view($this->typePage.'/form',$data);
    }
    
    function form_upload($message = "")
    {
        $data['title'] = "Form Upload Set Jadwal";
        $data['action'] = $this->typePage.'/do_upload';
        $data['idForm'] = "formUploadSetJadwal";
        $data['button'] = "Simpan";
        $data['button_icon'] = "glyphicon-plus-sign";
        $data['message'] = $message;
        
        $this->load->view($this->typePage.'/form_upload',$data);
    }
    
    function save()
    {
        $data = $this->set_data();
            
        $id = $this->Mod_set_jadwal_kerja->save($data);

        redirect($this->typePage.'/success');
    }
    
    function edit($id)
    {
        $data = $this->set_data();
        
        if($data)
        {
            $update = $this->Mod_set_jadwal_kerja->update($id,$data);

            $message = '<div class="alert alert-success">'.$this->lang->line('common_edit').'</div>';

            $this->update($id,$message);
        }
    }
    
    function do_upload()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'application/vnd.ms-office';
        $config['max_size']	= '0';
        $config['overwrite'] = true;

        $this->load->library('upload', $config);
        
        $this->upload->initialize($config);
        
        $this->upload->set_allowed_types('*');
        
        $msg = '';
        
        if (!$this->upload->do_upload('txtUploadFile')) 
        {
            $msg = $this->upload->display_errors();

        } 
        else 
        { //else, set the success message
            $msgs = $this->upload->data();
            
            $fileExt = $this->upload->get_extension($msgs['file_name']);
            $fileExt = str_replace(".", "", $fileExt);
            $fileExt = strtolower($fileExt);
            
            $msg = $this->do_import($msgs['file_name'],$fileExt);
        }
        
        $this->form_upload($msg);
    }
    
    private function do_import($file_name, $extension="xls")
    {
        $table_name = 'tblMastKarTest';
        
//        $dbMssql = $this->load->database('mssql',true);
        $this->load->helper('date');
        
        $this->load->library('excel');
        
//        $fileInfo = get_file_info('./uploads/'.$file_name);
//        
//        print_r($fileInfo);
        
        if($extension=="xls")
        {        
            $objR = PHPExcel_IOFactory::createReader('Excel5');
        }
        else if($extension=="xlsx")
        {
            $objR = PHPExcel_IOFactory::createReader('Excel2007');
        }
        else 
        {
            return "Jenis File Tidak Dikenal.";
        }
        
        $objPHPExcel = $objR->load('./uploads/'.$file_name);
        
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,false);
//        print_r($sheetData);
        $arr_batch = array();
        
        $arr_ins = array();
        $arr_upd = array();
        
        for($i=0 ; $i<count($sheetData) ; $i++)
        {
            if($i==0)
            {
                for($j=0; $j<3 ; $j++)
                {
                    if(trim($sheetData[$i][$j])==$this->header_exc[$j])
                        continue;
                    else
                        return "Header tidak sama pada ".$this->header_exc[$j];
                }
                continue;
                
            }
            //echo "bla";
            $cek_pin = $this->Mod_set_jadwal_kerja->cek_pin($sheetData[$i][0]);
            
            $type_jadwal = $this->code_jenis($sheetData[$i][1]);
            
            if(!$type_jadwal)
            {
                continue;
            }
//            echo $i."<br>";
            $code_jadwal = $this->get_jadwal($type_jadwal, $sheetData[$i][2]);
            
            if(!$code_jadwal)
            {
                continue;
            }
            
            $id_orang = $this->get_orang($sheetData[$i][0]);
            
            if(!$id_orang)
            {
                continue;
            }
            
            if(!empty($cek_pin))
            {
                $arr_upd[] = array("data"=>array("id_jadwal"=>$code_jadwal,"karyawan_id"=>$id_orang,"tipe_jadwal"=>$type_jadwal),
                                   "id_set_jadwal"=>$cek_pin);
            }
            else
            {
                $arr_ins[] = array("id_jadwal"=>$code_jadwal,"karyawan_id"=>$id_orang,"tipe_jadwal"=>$type_jadwal);
            }
            
            
        }
        
        $cnt_upd = 0;
        $cnt_ins = 0;
        
        if(count($arr_upd)>0)
        {
//            print_r($arr_upd);
            foreach($arr_upd as $arrU)
            {
//                print_r($arrU);
                
                $this->Mod_set_jadwal_kerja->update($arrU["id_set_jadwal"],$arrU["data"]);
                
                $cnt_upd++;
            }
        }
        
        if(count($arr_ins)>0)
        {
            $this->Mod_set_jadwal_kerja->batch_save($arr_ins);
            
            $cnt_ins = count($arr_ins);
        }
        
        return "Data yang disimpan sebanyak ".$cnt_ins." orang. Data yang diupdate sebanyak ".$cnt_upd." orang.";
    }
    
    private function set_data()
    {
        $data = array();
        
        $data['id_jadwal'] = $this->input->post('txtJadwal');
        $data['karyawan_id'] = $this->input->post('txtKaryawan');
        $data['tipe_jadwal'] = $this->input->post('txtJenisJadwal');
        
        if(!empty($data['id_jadwal']) && !empty($data['karyawan_id']) && !empty($data['tipe_jadwal']))
            return $data;
        
        return false;
    }
    
    function sKaryawan()
    {
        $q     = $this->input->get("q");
        $id     = $this->input->get("id");
        $key = $this->input->get("key");
        
        $isView = false;
        
        if(!empty($key))
        {
            $isView = true;
        }
        
        $sKaryawan = array();
        
        if(!empty($q))
        {
            $search = "(pin like '%$q%' or nama_karyawan like '%$q%')";
            
            $res = $this->Mod_karyawan->get_karyawan_list_jadwal($search,$isView)->result();
            
            foreach($res as $resA)
            {
                $sKaryawan[] = array("id"=>$resA->person_id,"text"=>$resA->pin." - ".$resA->nama_karyawan);
            }
        }
        else
        {
            $res = $this->Mod_karyawan->get_karyawan_list_jadwal("person_id='$id'",$isView)->result();
            
            foreach($res as $resA)
            {
                $sKaryawan[] = array("id"=>$resA->person_id,"text"=>$resA->pin." - ".$resA->nama_karyawan);
            }
        }
        
        echo json_encode($sKaryawan);
        
    }
    
    function sJadwal($typ="",$query="")
    {
        $type   = $this->input->get("type");
        $q     = $this->input->get("q");
        $id     = $this->input->get("id");
        
        $json = true;
        
        if(!empty($typ) && !empty($query))
        {
            $type = $typ;
            $q = $query;
            
            $json = false;
        }
        $ret = null;
        if($type=="N")
        {
            if(!empty($id))
            {
                $ret = $this->sJadwalNorm($id,true, $json);
            }
            else
            {
                $ret = $this->sJadwalNorm($q,false, $json);
            }
        }
        else if($type=="S")
        {
            if(!empty($id))
            {
                $ret = $this->sJadwalShift($id, true, $json);
            }
            else
            {
                $ret = $this->sJadwalShift($q, false, $json);
            }
        }
        
        if(!$json)
        {
            return $ret;
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
    
    function delete($id)
    {
        $this->Mod_set_jadwal_kerja->delete($id);
        
        redirect($this->typePage);
    }
    
    function success()
    {
        $message = '<div class="alert alert-success">'.$this->lang->line('common_save').'</div>';
        
        $this->add($message);
    }
    
    private function code_jenis($str)
    {
        $sStr = strtoupper($str);
        
        if($sStr=="NORMAL")
        {
            return "N";
        }
        else if($sStr=="SHIFT")
        {
            return "S";
        }
        
        return false;
    }
    
    private function get_jadwal($typ,$str)
    {
        $tTyp = trim($typ);
        $tStr = trim($str);
        
        if(!empty($tTyp) && !empty($tStr))
        {         
            $sStr = strtoupper($tStr);

            $aJadwal = $this->sJadwal($tTyp, $sStr);
            
            if(count($aJadwal)>0)
            {
                return $aJadwal[0]["id"];
            }
        }
        
        return false;
    }
    
    private function get_orang($pin)
    {
        $this->load->model('Mod_karyawan');
        
        return $this->Mod_karyawan->get_personid($pin);
        
    }
    
}
