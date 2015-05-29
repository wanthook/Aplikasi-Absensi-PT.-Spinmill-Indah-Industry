<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of upload_log
 *
 * @author taufiq
 */
class upload_log extends Secure_area
{
    //put your code here
    function __construct() 
    {
        parent::__construct();
        $this->load->model('Mod_tarik_absen');
        $this->load->model('Mod_karyawan');
    }
    
    function upload()
    {
        $data = $this->get_data();
        
        $data_count = count($data);
        
        $arr_cetak = array();
        
        if($data_count>0)
        {
             $arr_log = array("waktu"=>date("Y-m-d H:i:s"),
                              "jumlah_data"=>$data_count);

             $log_id = $this->Mod_tarik_absen->save_log($arr_log);
             
             $arr_cetak['log_id'] = $log_id;
             $arr_cetak = array_merge($arr_cetak,$arr_log);
             
             $msg = "";
             
             if($log_id>0)
            {
                // $tr_no_raw = $this->Mod_tarik_absen->get_max_hkverified();
                // $tr_no = $tr_no_raw->tr_no+1;
                 
                $this->Mod_tarik_absen->save_log_detail($data,$log_id);

                $msg = "Data berhasil disimpan sebanyak ".$data_count." data";
            }
            else
            {
                $msg = "Ada galat dalam menyimpan data, hubungi IT.";
            }
            
            $arr_cetak['msg'] = $msg;
        }
        
        print_r($arr_cetak);
    }
    
    private function get_data()
    {
        $ret = array();
        
        $fOpen = fopen(base_url("uploads/log/1_attlog.dat"),"r");
        
        // $tr_no_raw = $this->Mod_tarik_absen->get_max_hkverified();
        // $tr_no = $tr_no_raw->tr_no+1;
        
        $mesin_id = "2";
        
        while(! feof($fOpen))
        {
            $gets = fgets($fOpen);
            
            
            $dataArr = explode("\t", $gets);
            
            if(count($dataArr)<2)
            {
                continue;
            }
            
//            print_r($dataArr);
            $pin = trim($dataArr[0]);
            $waktu = trim($dataArr[1]);
            $verivied = trim($dataArr[2]);
            $status = trim($dataArr[3]);
            $workcode = trim($dataArr[4]);
            
            
            $encode = pack("H*", md5($pin.$waktu));
            $encode = base64_encode($encode);
            
            if($this->Mod_tarik_absen->get_count_detail("checksum='".$encode."'")>0)
            {
                continue;
            }
            
            $ret[] = array(
                        "pin"=>$pin,
                        "waktu"=>$waktu,
                        "verified"=>$verivied,
                        "status"=>$status,
                        "workcode"=>$workcode,
                        "code" => $encode,
                        "mesin_id" => $mesin_id
                    );
            
            // $tr_no++;
        }

        fclose($fOpen);
        
        return $ret;
        
    }
}
