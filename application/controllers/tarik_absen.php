<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tarik_absen
 *
 * @author taufiq
 */
class Tarik_absen  extends Secure_area
{
    
    private $page = "tarik_absen";
    
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('Mod_tarik_absen');
        $this->load->model('Mod_karyawan');
                
    }
    
    function index()
    {
        $this->tabel();
    }
    
    function view($id)
    {
        $search = "log_id='$id'";
        
        $this->tabel_detail($search);
    }
    
    function tabel($search="", $limit = 100, $ofset=0,$msg="")
    {
        $head = array("Waktu","Jumlah Data","Aksi");
        
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        
        $data_absen_log = $this->Mod_tarik_absen->data_absen_log($search,$limit,$offset,'waktu','desc');
        
        
        $data_tabel = $data_absen_log->result();
        
        $template = $this->fungsi->template_table('tblTarikAbsen');
        
        $config_table = $this->fungsi->template_pagging
                    (
                        site_url($this->page.'/index/'),
                        $this->Mod_tarik_absen->get_count($search),
                        $limit,
                        $uri_segment
                    );
        
        $this->pagination->initialize($config_table);
        $data['pagination'] = $this->pagination->create_links();
        
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading($head);
        
        $this->table->set_template($template);
        
        
        if(empty($data_tabel))
        {
            $this->table->add_row(array('data' => $this->lang->line('common_empty_table'), 'colspan' => count($head), 'align'=> 'center'));
        }
        else
        {
            $i = 0 + $offset;
            foreach ($data_tabel as $row)
            {            
                
                $this->table->add_row
                    (
                        date('d-m-Y H:i:s', strtotime($row->waktu)), 
                        $row->jumlah_data, 
                        anchor($this->page.'/view/'.$row->log_id,'<span class="glyphicon glyphicon-file"></span>&nbsp;Lihat',array('class'=>'btn btn-primary btn-xs'))
                    );
            }
            
        }
        
        $data['table'] = $this->table->generate();
        $data['msg'] = $msg;
        
        $this->load->view($this->page.'/tabel', $data);
    }
    
    function tabel_detail($search="", $limit = 100, $ofset=0)
    {
        $head = array("No.","PIN","Nama Karyawan","Divisi","Tempat Absen","Tanggal Absen","Jam Absen","Status");
                        
        $data_absen_log = $this->Mod_tarik_absen->data_absen_log_detail($search,'PIN','asc');
        
        $karyawan  = $this->get_karyawan();
        
        $data_tabel = $data_absen_log->result();
        
        $template = $this->fungsi->template_table('tblTarikAbsenDetail');
        
        
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading($head);
        
        $this->table->set_template($template);
        
        
        if(empty($data_tabel))
        {
            $this->table->add_row(array('data' => $this->lang->line('common_empty_table'), 'colspan' => count($head), 'align'=> 'center'));
        }
        else
        {
            $i = 1 ;
            foreach ($data_tabel as $row)
            {            
                $nama = "";
                $divisi = "";
                
                if(isset($karyawan[$row->pin]))
                {
                    $nama = $karyawan[$row->pin]['nama'];
                    $divisi = $karyawan[$row->pin]['divisi'];

                }
                
                $this->table->add_row
                    (
                        $i,
                        $row->pin,
                        $nama,
                        $divisi,
                        $row->deskripsi_mesin,
                        date('d-m-Y', strtotime($row->tanggal)),
                        date('H:i:s', strtotime($row->tanggal)),
                        ($row->status=="1")?"OUT":(($row->status=="0")?"IN":"UNKNOWN")
                    );
                $i++;
            }
            
        }
        
        $data['table'] = $this->table->generate();
        
        $this->load->view($this->page.'/view', $data);
    }
    
    function get_karyawan()
    {
        $ret = array();
        
        $data_karyawan = $this->Mod_karyawan->get_paged_list_active(100000)->result();
        
        foreach($data_karyawan as $row)
        {
            $ret[$row->pin] = array('nama'=>$row->nama_karyawan,'divisi'=>$row->nama_divisi);
        }
        return $ret;
    }
    
    function do_import()
    {
//        $ret = array();
        
        $mesin = $this->Mod_tarik_absen->get_mesin()->result();
        $msg = array();
        
        if(!empty($mesin))
        {
            
            $data_mesin = array();
            foreach($mesin as $row)
            {
//                echo $row->alamat_ip;
                $dump = $this->get_absen_soap($row->alamat_ip,$row->comm_key,$row->mesin_id);
                
                $data_mesin = array_merge($data_mesin,$dump);
            }
            
            $count_data = count($data_mesin);
                
            if($count_data>0)
            {
                $arr_log = array("waktu"=>date("Y-m-d H:i:s"),
                                 "jumlah_data"=>$count_data);

                $log_id = $this->Mod_tarik_absen->save_log($arr_log);
                
                if($log_id>0)
                {
                    $this->Mod_tarik_absen->save_log_detail($data_mesin,$log_id);
                    
                    $msg = array("msg" => "Data berhasil disimpan sebanyak ".$count_data." data", "is_error"=>false);
                }
                else
                {
                    $msg = array("msg" => "Ada galat dalam menyimpan data, hubungi IT.", "is_error"=>true);
                }
                
            }
            else
            {
                $msg = array("msg" => "Tidak ada data yang disimpan, karena tidak ada data baru.", "is_error"=>true);
            }
        }
        else
        {
            $msg = array("msg" => "Tidak ada mesin yang bisa dibaca.", "is_error"=>true);
        }
        
        $this->message($msg);
    }
    
    private function get_absen_soap($ip,$key,$mesin_id)
    {
        $ret = array();
        
        $tr_no = 0;
        
        if(!empty($ip) && !empty($key))
        {
            $con = fsockopen($ip, "80", $errno, $errstr);
            
            if($con)
            {
                $soap_req = '<GetAttLog>
                                <ArgComKey xsi:type="xsd:integer">'.$key.'</ArgComKey>
                                <Arg><PIN xsi:type="xsd:integer">All</PIN></Arg>
                              </GetAttLog>';
                
                $new_line = "\r\n";
                
                fputs($con, "POST /iWsService HTTP/1.0".$new_line);
                fputs($con, "Host: ".$ip.$new_line);
                fputs($con, "Content-Type: text/xml".$new_line);
                fputs($con, "Content-Length: ".strlen($soap_req).$new_line.$new_line);
                fputs($con, $soap_req.$new_line);
                
                //$tr_no_raw = $this->Mod_tarik_absen->get_max_hkverified();
                //$tr_no = $tr_no_raw->tr_no+1;
                
                while($res = fgets($con,1024))
                {
                    
                    if(substr($res,0,1)!="<")
                    {
                        continue;
                    }
                    
                    if(stristr($res, "GetAttLogResponse"))
                    {
                        continue;
                    }
                    
                    $parser = xml_parser_create();
                    xml_parse_into_struct($parser, $res, $vals);                    
                    
                    $encode = pack("H*", md5($vals[1]['value'].$vals[2]['value']));
                    $encode = base64_encode($encode);
                    
                    if($this->Mod_tarik_absen->get_count_detail("checksum='".$encode."'")>0)
                    {
                        continue;
                    }
                    
                    $ret[] = array(
                                    "pin"=>$vals[1]['value'],
                                    "waktu"=>$vals[2]['value'],
                                    "verified"=>$vals[3]['value'],
                                    "status"=>$vals[4]['value'],
                                    "workcode"=>$vals[5]['value'],
                                    "code" => $encode,
                                    "mesin_id" => $mesin_id
                                );
                    
                    xml_parser_free($parser);
                }  
                
            }
        }
        
        return $ret;
    }
    
    function message($msg)
    {
        if($msg["is_error"]==false)
        {
            $message = '<div class="alert alert-success">'.$msg['msg'].'</div>';
        }
        else 
        {
            $message = '<div class="alert alert-danger">'.$msg['msg'].'</div>';
        }
        
        $this->tabel("",100,0,$message);
    }
}
