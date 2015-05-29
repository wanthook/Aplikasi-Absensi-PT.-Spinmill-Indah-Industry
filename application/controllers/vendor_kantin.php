<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'secure_area.php';
/**
 * Description of vendor_kantin
 *
 * @author wanthook
 */
class vendor_kantin extends Secure_area
{
    private $typePage = "vendor_kantin";
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Mod_vendor');
    }
    
    function index()
    {
        $this->laporan_kantin();
    }
    
    function laporan_kantin($message="")
    {
        $data['title'] = "Laporan Absen Kantin Karyawan";
        $data['action'] = $this->typePage.'/download';
        $data['idForm'] = "formLaporanAbsenKantinKaryawan";
        $data['button'] = "Download Excel";
        $data['button_icon'] = "glyphicon-save";
        $data['message'] = $message;
        
        $this->load->view($this->typePage.'/form', $data);
    }
    
    function download()
    {
        $this->load->helper("xls_helper");
        
        $pPeriode = explode("-", $this->input->post("txtPeriode"));
        $pKaryawan = $this->input->post('cmbKaryawan');
        $pVendor = $this->input->post('cmbVendor');
        
        $pCmd = $this->input->post('cmdDownload');
        
        $data = array();
        
        if($pCmd)
        {
            $data['data'] = $this->arr_absen_kantin($pPeriode,$pKaryawan,$pVendor);
//            print_r($data);
            $this->load->view($this->typePage."/laporan_absen_xls",$data);
            
        }
    }
    
    /*
     * periode harus array ya
     */
    private function arr_absen_kantin($periode, $karyawan_id="", $vendor_id="")
    {
        $ret = array();
        
        $sVendor = "";
//        $sAct = " date_format(activity_kantin.waktu,'%Y-%m-%d')='".$periode[2]."-".$periode[1]."-".$periode[0]."' ";
        $sBesok = strtotime( "+1 days ". $periode[2]."-".$periode[1]."-".$periode[0]." 04:30:00" );
        $tBesok = date("Y-m-d H:i:s",$sBesok);
        $sAct = " (activity_kantin.waktu between '".$periode[2]."-".$periode[1]."-".$periode[0]." 10:30:00' and '".$tBesok."') ";
        
        
        $this->tarik_activity();
        
        if(!empty($vendor_id))
        {
            $sVendor = "vendor_id = '$vendor_id'";            
        }
        
        $vendor = $this->Mod_vendor->get_vendor($sVendor)->result();
        
        foreach($vendor as $vendorX)
        {
            
            $sActX = " and mesin_kantin.vendor_id = '$vendorX->vendor_id' ";
            
            if(!empty($karyawan_id))
            {
                $sActX .= " and  orang.person_id='$karyawan_id' ";
            }
            
            $tiket = $this->Mod_vendor->get_act_kantin($sAct.$sActX,0,0,"","","pin")->num_rows();
            $log = $this->Mod_vendor->get_act_kantin($sAct.$sActX,0,0,"pin,waktu","ASC");                        
                        
            $ar['tanggal'] = $periode[0]."-".$periode[1]."-".$periode[2];
            $ar['vendor'] = $vendorX->vendor_nama;
            $ar['jumlah_tiket'] = $tiket;
            $ar['jumlah_log'] = $log->num_rows();
            $ar['data'] = $log->result();
            
            $ret[] = $ar;
            
        }
        
        return $ret;
    }
    
    private function tarik_activity()
    {
        $res_mesin = $this->Mod_vendor->get_mesin_kantin();
        
        foreach($res_mesin->result() as $mesin)
        {
            $tarikan = $this->tarik_mesin($mesin->mesin_ip, $mesin->mesin_password, $mesin->mesin_id);
//            print_r($tarikan);
            $this->Mod_vendor->save_activity($tarikan);
        }
    }
    
    private function tarik_mesin($ip,$key,$mesin_id)
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
                    
//                    $encode = pack("H*", md5($vals[1]['value'].$vals[2]['value']));
//                    $encode = base64_encode($encode);
                    
                    $cSearch = "activity_kantin.pin = '".$vals[1]['value']."' and activity_kantin.waktu = '".$vals[2]['value']."'";
                    
                    if($this->Mod_vendor->get_act_kantin($cSearch)->num_rows()>0)
                    {
                        continue;
                    }
                    
                    $ret[] = array(
                                    "pin"=>$vals[1]['value'],
                                    "waktu"=>$vals[2]['value'],
                                    "verified"=>$vals[3]['value'],
                                    "status"=>$vals[4]['value'],
                                    "workcode"=>$vals[5]['value'],
                                    "mesin_id" => $mesin_id
                                );
                    
                    xml_parser_free($parser);
                }  
                
            }
        }
        
        return $ret;
    }
            
    function sVendor()
    {
        $aRet = array();
        
        $search = "";
        
        if($this->input->get("id")!="")
        {
            $q = $this->input->get("id");
            
            $search = "vendor_id='$q'";
        }
        else
        {
            $q = $this->input->get("q");
            
            $search = "vendor_nama like '%$q%'";
        }
        
        $res = $this->Mod_vendor->get_vendor($search)->result();
        
        foreach($res as $ress)
        {
            $aRet[] = array("id"=>$ress->vendor_id,"text"=>$ress->vendor_nama);
        }
        
        echo json_encode($aRet);
    }
}
