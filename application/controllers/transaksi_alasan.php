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
class Transaksi_alasan extends Secure_area
{
    //put your code here
    
    private $limit = 50;
    private $typePage = 'transaksi_alasan';
    private $tblHead = array("Tanggal Transaksi","PIN","Nama Karyawan","Kode Alasan","Waktu","Keterangan","Tanggal Modifikasi","Aksi");
    private $titleForm = "Form Transaksi Alasan";
    
    private $header_exc = array("PIN","JENIS","KODE JADWAL");
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Mod_alasan');
        $this->load->model('Mod_karyawan');
    }
    
    function index()
    {
        $this->search_table();
    }   
    
    function search_table()
    {
        $txtSearch = $this->input->post("txtSearch");
        $cmbAlasan = $this->input->post("cmbAlasanSearch");
        $txtTgl = explode("-",$this->input->post("txtTglSearch"));
        
        $tgl = "";
        if(count($txtTgl)>1)
        {
            $tgl = $txtTgl[2]."-".$txtTgl[1]."-".$txtTgl[0];
        }
        
//        if(empty($txtTgl))
//            $txtTgl = date("Y-m-d");
//        else
//            echo $this->fungsi->convertDate($txtTgl,"Y-m-d");
        
                
        $this->load->view($this->typePage.'/tabel',  $this->table($tgl, $cmbAlasan, $txtSearch, $txtSearch, $txtSearch));
        
    }
    
    private function table($tanggal_transaksi,$alasan,$pin,$nama,$kartu,$limit=100,$offset=0)
    {
        // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        
        // load data
        $datas = $this->Mod_alasan->list_transaksi_alasan($tanggal_transaksi,$alasan,$pin,$nama,$kartu,$limit,$offset)->result();

        $templateTable = $this->fungsi->template_table('tblTransaksiAlasan');
        
        //config paggination
        $config = $this->fungsi->template_pagging(
                        site_url($this->typePage.'/index/'),
                        count($datas),
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
                    $this->fungsi->convertDate($row->tanggal_transaksi,'d-m-Y'), 
                    $row->pin, 
                    $row->nama_karyawan, 
                    $row->kode_alasan, 
                    $row->waktu, 
                    $row->keterangan,
                    $this->fungsi->convertDate($row->modify_date,'d-m-Y H:i:s'),
                    anchor($this->typePage.'/update/'.$row->transaksi_id,'<span class="glyphicon glyphicon-pencil"></span>&nbsp;Ubah',array('class'=>'btn btn-warning btn-xs')).' '.
                    anchor($this->typePage.'/delete/'.$row->transaksi_id,'<span class="glyphicon glyphicon-remove"></span>&nbsp;Hapus',array('class'=>'btn btn-danger btn-xs','onclick'=>"return confirm('".$this->lang->line("common_delete")."')"))
                );
            }
        }
        $data['table'] = $this->table->generate();
        
        return $data;
    }
    
      
    function add()
    {
        $this->form();
    }
    
    function update($id)
    {
        $this->form_update($id);
    }
    
    function upload()
    {
        $this->form_upload();
    }
    
    function success()
    {
        $message = '<div class="alert alert-success">Data berhasil disimpan!</div>';
        
        $this->form($message);
    }
    
    function delete($id)
    {
        $this->Mod_alasan->delete_alasan_karyawan($id);
        
        redirect($this->typePage);
    }
    
    function fail()
    {
        $message = '<div class="alert alert-success">Data Gagal disimpan!</div>';
        $this->form($message);
    }
    
    function save_form()
    {
        $save = $this->save();
        
//        $this->form("Berhasil disimpan");
        
        if($save)
            redirect($this->typePage.'/success');
        else
            redirect($this->typePage.'/fail');
    }
    
    function edit_form($id)
    {
        $save = $this->edit($id);
        
//        $this->form("Berhasil disimpan");
        
        if($save)
            redirect($this->typePage.'/success');
        else
            redirect($this->typePage.'/fail');
    }
    
    private function save()
    {
        $data["tanggal_transaksi"] = $this->fungsi->convertDate($this->input->post("txtTgl"),"Y-m-d");
        $data["id_alasan"] = $this->input->post("cmbAlasan");
        $data["person_id"] = $this->input->post("cmbKaryawan");
        $data["waktu"] = $this->input->post("txtWaktu");
        $data["keterangan"] = $this->input->post("txtKeterangan");
        
        return $this->Mod_alasan->save_transaction_alasan($data);
    }
    
    private function edit($id)
    {
        $data["tanggal_transaksi"] = $this->fungsi->convertDate($this->input->post("txtTgl"),"Y-m-d");
        $data["id_alasan"] = $this->input->post("cmbAlasan");
        $data["person_id"] = $this->input->post("cmbKaryawan");
        $data["waktu"] = $this->input->post("txtWaktu");
        $data["keterangan"] = $this->input->post("txtKeterangan");
        $data["transaksi_id"] = $id;
        
        return $this->Mod_alasan->save_transaction_alasan($data,'update');
    }
    
    private function form($message="")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->typePage.'/save_form';
        $data['idForm'] = "formTransaksiAlasan";
        $data['button'] = "Save";
        $data['button_icon'] = "glyphicon-plus-sign";
        $data['message'] = $message;
        
        $this->load->view($this->typePage.'/form', $data);
    }
    
    private function form_update($id,$message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->typePage.'/edit_form/'.$id;
        $data['idForm'] = "formTransaksiAlasan";
        $data['button'] = "Ubah";
        $data['button_icon'] = "glyphicon-pencil";
        
        $edit_data = $this->Mod_alasan->list_transaksi_alasan_id($id)->row_array();
       
        $data['value'] = $edit_data;
        
        $data['value']['tanggal_transaksi'] = $this->fungsi->convertDate($data['value']['tanggal_transaksi'],"d-m-Y");
        
        if(!empty($message))
        {
            $data['message'] = $message;
        }
        
        $this->load->view($this->typePage.'/form',$data);
    }
    
    private function form_upload($message="")
    {
        $data['title'] = "Form Upload Transaksi Alasan";
        $data['action'] = $this->typePage.'/do_upload';
        $data['idForm'] = "formUploadTransaksiAlasan";
        $data['button'] = "Save";
        $data['button_icon'] = "glyphicon-plus-sign";
        $data['message'] = $message;
        
        $this->load->view($this->typePage.'/form_upload', $data);
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
    
    function do_import($file_name, $extension="xls")
    {
        
        
//        $table_name = 'alasan_karyawan';
//        
//        $dbMssql = $this->load->database('mssql',true);
//        
//        $this->load->library('excel');
//        
//        if($extension=="xls")
//        {        
//            $objR = PHPExcel_IOFactory::createReader('Excel5');
//        }
//        else if($extension=="xlsx")
//        {
//            $objR = PHPExcel_IOFactory::createReader('Excel2007');
//        }
//        else 
//        {
//            return "Jenis File Tidak Dikenal.";
//        }
////        $objR = PHPExcel_IOFactory::createReader('Excel5');
//        
//        $objPHPExcel = $objR->load('./uploads/'.$file_name);
//        
//        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//        
//        for($i=0 ; $i<count($sheetData) ; $i++)
//        {
//            if($i==0)
//            {
//                if($sheetData[$i+1]['A']=='TANGGAL'
//                   && $sheetData[$i+1]['B']=='PIN'
//                   && $sheetData[$i+1]['C']=='KODE_ALASAN'
//                   && $sheetData[$i+1]['D']=='WAKTU'
//                   && $sheetData[$i+1]['E']=='KETERANGAN')
//                {
//                    continue;
//                }
//                else
//                {
//                    return "Header tidak sama.";
//                }
//            }
//            
////            $dbMssql->query("select count(*) cnt from tblAbsManTest where TrsDate='".$sheetData[$i+1]['A']."' and PIN='".$sheetData[$i+1]['B']."'");
//            $res = $dbMssql->get_where($table_name,array('TrsDate'=>$sheetData[$i+1]['A'],'PIN'=>$sheetData[$i+1]['B'],'KdAls'=>$sheetData[$i+1]['C']),1);
//            
//            //kalo tanggal ama pin gak ada, maka gak ada kemungkinan duplikasi
//            if($res->num_rows()==0)
//            {
//                
//                $dbMssql->set('TrsDate',$sheetData[$i+1]['A']);
//                $dbMssql->set('PIN', $sheetData[$i+1]['B']);
//                $dbMssql->set('KdAls' , $sheetData[$i+1]['C']);
//                $dbMssql->set('TrsTime' , floatval($sheetData[$i+1]['D']),false);
//                $dbMssql->set('Remarks' , 'SYSTEMWEB');
//                $dbMssql->set('KdPrs' , 'IJ');
//                
//                $dbMssql->insert($table_name);
//            }
//        }
        
//        print_r($sheetData);
    }
    
    function sAlasan()
    {
        $aRet = array();
        
        if($this->input->get("id")!="")
        {
            $q = $this->input->get("id");
            $res = $this->Mod_alasan->get_by_id_active($q)->result();
        }
        else
        {
            $q = $this->input->get("q");
            $res = $this->Mod_alasan->get_paged_list_active(1000, 0, $q)->result();
        }
        
        foreach($res as $ress)
        {
            $aRet[] = array("id"=>$ress->id_alasan,"text"=>$ress->kode_alasan." - ".$ress->nama_alasan);
        }
        
        echo json_encode($aRet);
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
}
