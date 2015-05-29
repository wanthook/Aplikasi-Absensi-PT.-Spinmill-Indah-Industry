<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mod_tarik_absen
 *
 * @author taufiq
 */
class Mod_tarik_absen extends CI_Model
{
    private $tbl1 = "absen_log";
    
    private $tbl2 = "absen_log_detail";
    
    private $tms, $dbAbsen;
    
    function __construct() 
    {
        parent::__construct();
    }
    
    function data_absen_log($search="",$limit = 100, $offset = 0,$order="",$order_type="asc")
    {
        if(!empty($search))
        {
            $this->db->where($search,NULL,FALSE);
        }
        
        if(!empty($order))
        {
            $this->db->order_by($order,$order_type);
        }
        
        if($limit!=0)
        {
            $this->db->limit($limit,$offset);
        }
        
        $this->db->from($this->tbl1);
        
        return $this->db->get();
    }
    
    function data_absen_log_detail($search="",$limit = 100, $offset = 0,$order="",$order_type="asc")
    {
       if(!empty($search))
        {
            $this->db->where($search,NULL,FALSE);
        }
        
        if(!empty($order))
        {
            $this->db->order_by($order,$order_type);
        }
        
        if($limit!=0)
        {
            $this->db->limit($limit,$offset);
        }
        $this->db->select($this->tbl2.'.*,mesin.deskripsi_mesin');

        $this->db->from($this->tbl2);
        
        $this->db->join('mesin','mesin.mesin_id='.$this->tbl2.'.mesin_id');
        
        return $this->db->get();
    }
    
    function get_count($search)
    {
        return $this->data_absen_log($search,0)->num_rows();
    }
    
    function get_count_detail($search)
    {
        return $this->data_absen_log_detail($search,0)->num_rows();
    }
    
    function get_mesin()
    {
        $this->db->from("mesin");
        $this->db->where("flag='1'",NULL,FALSE);
        
        return $this->db->get();
    }
    
    function save_log($log)
    {
        $ret = 0;
        
        if(!empty($log) && is_array($log))
        {
            $this->load->helper('date');
            $data['created_by'] = $this->Mod_login->getSessionPersonId();
            $data['create_date'] = date('Y-m-d H:i:s');
            $data['modified_by'] = $this->Mod_login->getSessionPersonId();
            $data['modify_date'] = date('Y-m-d H:i:s');
            
            $this->db->insert($this->tbl1, $log);
            
            $ret = $this->db->insert_id();
        }
        
        
        return $ret;
    }
    
    function save_log_detail($arr,$id)
    {
        if(!empty($arr))
        {
            $ins = array();
            $ins_ms = array();
			
            foreach($arr as $arrX)
            {
                $ins[] = array(
                    'pin' => $arrX['pin'],
                    'tanggal' => $arrX['waktu'],
                    'verivied' => $arrX['verified'],
                    'status' => $arrX['status'],
                    'workcode' => $arrX['workcode'],
                    'checksum' => $arrX['code'],
                    'mesin_id' => $arrX['mesin_id'],
                    'log_id' => $id,
                    'created_by' => $this->Mod_login->getSessionPersonId(),
                    'create_date' => date('Y-m-d H:i:s'),
                    'modified_by' => $this->Mod_login->getSessionPersonId(),
                    'modify_date' => date('Y-m-d H:i:s')
                );
                
                $ins_act[] = array(
                    'act_card'=> $arrX['pin'],
                    'act_time'=> $arrX['waktu'],
                    'act_dir_flag'=>'',
                    'act_event_flag'=> $arrX['verified'],
                    'act_term_no'=> $arrX['workcode'],
                    'act_function'=> $arrX['status']+1,
                    'created_by' => $this->Mod_login->getSessionPersonId(),
                    'create_date' => date('Y-m-d H:i:s'),
                    'modified_by' => $this->Mod_login->getSessionPersonId(),
                    'modify_date' => date('Y-m-d H:i:s')
                );
            }
            
            $this->db->insert_batch($this->tbl2,$ins);
            $this->db->insert_batch("activity",$ins_act);
            
        }
    }
}
