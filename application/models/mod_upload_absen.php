<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mod_set_jadwal_kerja
 *
 * @author taufiq
 */
class Mod_upload_absen extends CI_Model
{
    private $tbl1= 'upload_absen';
        
    private $fieldId = 'id_alasan';
    private $fieldHapus = 'hapus';
    
    function __construct() 
    {
        parent::__construct();        
    }
    
    function count_all($search="")
    {
        
        if(!empty($search))
        {
            $this->db->where($search,NULL,false);
        }
        
        $this->db->from($this->tbl1);        
        
        
        return $this->db->count_all_results();
        
    }
    
    function get_data_list($limit = 10, $offset = 0, $search="", $order="",$order_type="asc")
    {
        
        if(!empty($search))
        {
            $this->db->where($search,NULL,false);
        }
        
        $this->db->from($this->tbl1);        
        
        if(!empty($order))
        {
            $this->db->order_by($order,$order_type);
        }
        
        $this->db->limit($limit,$offset);
        
        return $this->db->get();
    }
    
    function save($data)
    {
        $ret = 0;
        
        if(!empty($data) && is_array($data))
        {
            $this->load->helper('date');
            $data['created_by'] = $this->Mod_login->getSessionPersonId();
            $data['create_date'] = date('Y-m-d H:i:s');
            $data['modified_by'] = $this->Mod_login->getSessionPersonId();
            $data['modify_date'] = date('Y-m-d H:i:s');
            
            $this->db->insert($this->tbl1,$data);
            
            $ret = $this->db->insert_id();
        }
        
        
        return $ret;
    }
    
    function save_activity($arr)
    {
        $ret = 0;
        
        if(!empty($arr) && is_array($arr))
        {
            $ret = $this->db->insert_batch("activity",$arr);
        }
        
        return $ret;
    }
    
    // update person by id
    function update($id, $data)
    {
        $data['modified_by'] = $this->Mod_login->getSessionPersonId();
        $data['modify_date'] = date('Y-m-d H:i:s');
        
        $this->db->where($this->fieldId, $id);
        $this->db->update($this->tbl1, $data);
    }
    
    // delete person by id
    function delete($id)
    {
        $data['hapus'] = 0;
        
        $this->update($id, $data);
    }     
    
    function cek_activity($card,$time,$function)
    {
        $this->db->from("activity");
        
        $this->db->where("act_card='$card' and act_time='$time' and act_function='$function'",NULL,FALSE);
        
        $row = $this->db->count_all_results();
        
        if($row>0)
            return true;
        
        return false;
    }
}
