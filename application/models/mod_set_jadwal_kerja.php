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
class Mod_set_jadwal_kerja extends CI_Model
{
    private $tbl1= 'set_jadwal_kerja a';
    private $tbl2= 'orang b';
    
    private $joinTbl1= 'divisi c';
    private $joinTbl2= 'jabatan d';
    private $joinTbl3= 'jadwal_kerja_normal e';
    private $joinTbl4= 'jadwal_kerja_shift f';
    
    private $fieldId = 'id_set_jadwal';
    private $fieldHapus = 'hapus';
    
    function __construct() 
    {
        parent::__construct();        
    }
    
    function count_all($search="")
    {
//        if(!empty($search))
//        {
//            
//        }
//        $this->db->from($this->tbl1);
//        $this->db->join($this->joinTbl3,"a.id_jadwal=e.id_jadwal","left");
//        $this->db->join($this->joinTbl4,"a.id_jadwal=f.id_jadwal","left");
//        
//        $this->db->from($this->tbl2);        
//        $this->db->join($this->joinTbl1,"b.id_divisi = c.id_divisi","left");
//        $this->db->join($this->joinTbl2,"b.id_jabatan = d.id_jabatan","left");
//        
//        $this->db->where("a.karyawan_id","b.person_id",false);
//        $this->db->where("b.hapus",'1',false);
//        
//        $num_rows = $this->db->get()->num_rows();
//        
//        return $num_rows;
        
        $result = $this->get_data_list(0,0,$search);
        
        return $result->num_rows();
        
    }
    
    function get_data_list($limit = 0, $offset = 0, $search="", $order="",$order_type="asc")
    {
        
        if(!empty($search))
        {
            $this->db->where($search,NULL,false);
        }
        
        $this->db->select("a.id_jadwal,
                 a.karyawan_id,
                 a.tipe_jadwal,
                 a.created_by,
		 a.create_date,
		 a.modified_by,
		 a.modify_date,
                 a.id_set_jadwal,
                 b.pin,
		 b.kartu,
		 b.nik,
		 b.nama_karyawan,
		 d.kode_jabatan,
		 d.nama_jabatan,
		 c.kode_divisi,
		 c.nama_divisi,		 
		 e.kode_jadwal_normal,
		 f.kode_jadwal_shift
		 ");
        
        $this->db->from($this->tbl1);
        $this->db->join($this->joinTbl3,"a.id_jadwal=e.id_jadwal","left");
        $this->db->join($this->joinTbl4,"a.id_jadwal=f.id_jadwal","left");
        
        $this->db->from($this->tbl2);        
        $this->db->join($this->joinTbl1,"b.id_divisi = c.id_divisi","left");
        $this->db->join($this->joinTbl2,"b.id_jabatan = d.id_jabatan","left");
        
        $this->db->where("a.karyawan_id","b.person_id",false);
        $this->db->where("b.hapus",'1',false);
        $this->db->where("a.hapus",'1',false);
        
        if(!empty($order))
        {
            $this->db->order_by($order,$order_type);
        }
        
        if($limit>0)
        {
            $this->db->limit($limit,$offset);
        }
        
        
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
            
            $this->db->insert("set_jadwal_kerja",$data);
            
            $ret = $this->db->insert_id();
        }
        
        
        return $ret;
    }
    
    function batch_save($data)
    {
        $ret = 0;
        
        if(!empty($data) && is_array($data))
        {
            for($i=0 ; $i<count($data) ; $i++)
            {
                $data[$i]['created_by'] = $this->Mod_login->getSessionPersonId();
                $data[$i]['create_date'] = date('Y-m-d H:i:s');
                $data[$i]['modified_by'] = $this->Mod_login->getSessionPersonId();
                $data[$i]['modify_date'] = date('Y-m-d H:i:s');
            }
            
            $ret = $this->db->insert_batch("set_jadwal_kerja",$data);
        }
        
        return $ret;
    }


    // update person by id
    function update($id, $data)
    {
        $data['modified_by'] = $this->Mod_login->getSessionPersonId();
        $data['modify_date'] = date('Y-m-d H:i:s');
        
        $this->db->where($this->fieldId, $id);
        return $this->db->update("set_jadwal_kerja", $data);
    }
    
    // delete person by id
    function delete($id)
    {
        $data['hapus'] = 0;
        
        $this->update($id, $data);
    }     
    
    function cek_pin($pin)
    {
        $this->db->select("a.id_set_jadwal",FALSE);
        
        $this->db->from("set_jadwal_kerja a");
        $this->db->from("orang b");
        
        $this->db->where("a.karyawan_id = b.person_id and a.hapus = '1' and b.pin = '$pin'",NULL,FALSE);
        
        $get = $this->db->get();
        
        if($get->num_rows()>0)
        {
            $row = $get->row_array(0);
            
            return $row['id_set_jadwal'];
        }
        
        return false;
    }
}
