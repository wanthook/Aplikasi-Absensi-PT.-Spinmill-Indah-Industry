<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mod_absen_manual
 *
 * @author wanthook
 */
class mod_absen_manual extends CI_Model
{
    private $table = "absen_manual";
    private $hapus = "hapus";
    
    function count_absen_manual($search="")
    {
        $res = $this->get_absen_manual($search);
        
        return $res->num_rows();
    }
    
    function get_absen_manual($search="",$limit = 0, $offset = 0,$order_by="",$order_type="asc", $group_by="")
    {
        if(!empty($search))
        {
            $this->db->where($search);
        }
        
        if($limit>0)
        {
            if($offset>0)
            {
                $this->db->limit($limit,$offset);
            }
            else
            {
                $this->db->limit($limit);
            }
        }
        
        if(!empty($order_by))
        {
            $this->db->order_by($order_by,$order_type);
        }
        
        if(!empty($group_by))
        {
            $this->db->group_by($group_by);
        }
        
        $this->db->select($this->table.".*,orang.pin,orang.nama_karyawan");
        
        $this->db->from($this->table);
        $this->db->from("orang");
        
        $this->db->where("orang.person_id=".$this->table.".person_id",NULL,FALSE);
        $this->db->where($this->table.".".$this->hapus,"1");
        
        return $this->db->get();
        
    }
    
    function get_absen_manual_count($search)
    {
        $master = $this->get_absen_manual($search);
        
        return $master->num_rows();
    }
}
