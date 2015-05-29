<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mod_vendor
 *
 * @author wanthook
 */
class Mod_vendor extends CI_Model
{
    //put your code here
    
    private $table = "vendor_kantin";
    private $table_act = "activity_kantin";
    private $table_mesin = "mesin_kantin";
    private $table_karyawan = "orang";
    private $table_jadwal = "jadwal_kantin";
    
    private $hapus = "hapus";
    
    function get_mesin_kantin()
    {
        $this->db->from($this->table_mesin);
        
        $this->db->where($this->hapus,'1');
        
        return $this->db->get();
    }
    
    function get_act_kantin($search="",$limit=0,$offset=0,$sort_by="",$sort_method="",$group_by="")
    {
        if(!empty($search))
        {
            $this->db->where($search,NULL, false);
        }
        
        if($limit!=0)
        {
            $this->db->limit($limit,$offset);
        }
        
        if(!empty($sort_by))
        {
            if(!empty($sort_method))
            {
                $this->db->order_by($sort_by,$sort_method);
            }
            else
            {
                $this->db->order_by($sort_by,"ASC");
            }
        }
        
        if(!empty($group_by))
        {
            $this->db->group_by($group_by);
        }
        
        $this->db->select("$this->table_act.pin,
                 $this->table_karyawan.nama_karyawan,
		 $this->table_act.waktu,
                 date_format($this->table_act.waktu,'%H:%i:%s') jam,
		 $this->table_act.mesin_id,
		 $this->table_mesin.mesin_nama,
		 $this->table_mesin.mesin_deskripsi,
		 $this->table.vendor_nama,
		 $this->table.vendor_deskripsi,
                 $this->table_jadwal.shift,
                 $this->table_jadwal.jadwal",FALSE);
        
        $this->db->from($this->table_act);
            $this->db->join($this->table_jadwal,$this->table_jadwal.".waktu_in<=date_format(".$this->table_act.".waktu".",'%H:%i:%s') and ".$this->table_jadwal.".waktu_out>=date_format(".$this->table_act.".waktu".",'%H:%i:%s')",'LEFT');
        $this->db->from($this->table_mesin);
            $this->db->join($this->table,"$this->table_mesin.vendor_id = $this->table.vendor_id",'LEFT');
            
        $this->db->from($this->table_karyawan);
        
        
        
        $this->db->where($this->table_act.".".$this->hapus,'1');
        
        $this->db->where("$this->table_act.mesin_id = $this->table_mesin.mesin_id");
        $this->db->where("$this->table_act.pin = $this->table_karyawan.pin");
        
        return $this->db->get();
    }
    
    function get_vendor($search="",$limit=0,$offset=0,$sort_by="",$sort_method="",$group_by="")
    {
        if(!empty($search))
        {
            $this->db->where($search,NULL, false);
        }
        
        if($limit!=0)
        {
            $this->db->limit($limit,$offset);
        }
        
        if(!empty($sort_by))
        {
            if(!empty($sort_method))
            {
                $this->db->sort_by($sort_by,$sort_method);
            }
            else
            {
                $this->db->sort_by($sort_by,"ASC");
            }
        }
        
        if(!empty($group_by))
        {
            $this->db->group_by($group_by);
        }
        
        $this->db->from($this->table);
        
        $this->db->where($this->hapus,'1');
        
        return $this->db->get();
        
    }
    
    function save_activity($arr)
    {
        if(is_array($arr) && count($arr)>0)
        {
            $arr_batch = array();
            
            foreach($arr as $arrX)
            {
                $arr_batch[] = array('pin'=>$arrX['pin'],
                                     'waktu' => $arrX['waktu'],
                                     'mesin_id' => $arrX['mesin_id'],
                                     'created_by' => $this->Mod_login->getSessionPersonId(),
                                     'create_date' => date('Y-m-d H:i:s'),
                                     'modified_by' => $this->Mod_login->getSessionPersonId(),
                                     'modify_date' => date('Y-m-d H:i:s')
                                    );
            }
            
            if(count($arr_batch)>0)
            {
                $this->db->insert_batch($this->table_act,$arr_batch);
            }
        }
    }
    
}
