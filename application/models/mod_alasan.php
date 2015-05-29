<?php

/**
 * Description of crud_alasan
 *
 * @author taufiq
 */
class Mod_alasan extends CI_Model 
{
    
    private $tbl= 'alasan';
    private $fieldId = 'id_alasan';
    private $fieldHapus = 'hapus';
    
    function __construct() 
    {
        parent::__construct();
    }
    
    // get number of persons in database
    function count_all($search="")
    {
        if(!empty($search))
        {
            $this->db->like('kode_alasan',$search)
                     ->like('nama_alasan',$search);
        }
        
        return $this->db->count_all($this->tbl);
    }
    
    // get number of persons in database
    function count_all_active($search="")
    {
        if(!empty($search))
        {
            $this->db->like('kode_alasan',$search)
                     ->like('nama_alasan',$search);
        }
        
        $this->db->where($this->fieldHapus, '1');
        return $this->db->count_all($this->tbl);
    }
    
    // get persons with paging
    function get_paged_list($limit = 10, $offset = 0, $search="", $order='kode_alasan')
    {
        if(!empty($search))
        {
            $this->db->like('kode_alasan',$search)
                     ->or_like('nama_alasan',$search);
        }
        
        $this->db->order_by('kode_alasan','asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    // get persons with paging
    function get_paged_list_active($limit = 10, $offset = 0, $search="", $order='kode_alasan')
    {
        if(!empty($search))
        {
            $this->db->like('kode_alasan',$search)
                     ->or_like('nama_alasan',$search);
        }
        
        $this->db->where($this->fieldHapus,'1');
        $this->db->order_by('kode_alasan','asc');        
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    // get person by id
    function get_by_id($id)
    {
        $this->db->where($this->fieldId, $id);
        return $this->db->get($this->tbl);
    }
    
    // get person by id
    function get_by_id_active($id)
    {
        $this->db->where($this->fieldHapus,'1');
        $this->db->where($this->fieldId, $id);
        return $this->db->get($this->tbl);
    }
    
    // add new person
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
            
            $this->db->insert($this->tbl, $data);
            
            $ret = $this->db->insert_id();
        }
        
        
        return $ret;
    }
    
    // update person by id
    function update($id, $data)
    {
        $data['modified_by'] = $this->Mod_login->getSessionPersonId();
        $data['modify_date'] = date('Y-m-d H:i:s');
        
        $this->db->where($this->fieldId, $id);
        $this->db->update($this->tbl, $data);
    }
    
    function update_alasan_karyawan($id, $data)
    {
        $data['modified_by'] = $this->Mod_login->getSessionPersonId();
        $data['modify_date'] = date('Y-m-d H:i:s');
        
        $this->db->where("transaksi_id", $id);
        $this->db->update("alasan_karyawan", $data);
    }
    
    // delete person by id
    function delete($id)
    {
        $data['hapus'] = 0;
        
        $this->update($id, $data);
    }    
    
    // delete person by id
    function delete_alasan_karyawan($id)
    {
        $data['transaksi_id'] = $id;
        $data['hapus'] = 0;
        
        $this->save_transaction_alasan($data,"update");
    }   
    
    function get_alasan_id($search)
    {
        
    }
    
    function list_transaksi_alasan_id($id)
    {
        $this->db->select("a.tanggal_transaksi,
                            a.id_alasan,
                            b.kode_alasan,
                            b.nama_alasan,
                            a.person_id,
                            c.pin,
                            c.nik,
                            c.kartu,
                            c.nama_karyawan,
                            a.waktu,
                            a.keterangan,
                            a.transaksi_id,
                            a.created_by,
                            a.create_date,
                            a.modified_by,
                            a.modify_date",false);
        $this->db->from("alasan_karyawan a");
        $this->db->join("alasan b","a.id_alasan = b.id_alasan","left");
        $this->db->join("orang c","a.person_id = c.person_id","left");
        
        $this->db->where("a.hapus = '1'",NULL,false);
        
        $this->db->where("a.transaksi_id='".$id."'",NULL,false);
        
        
        $this->db->order_by("transaksi_id","desc");
        
        return $this->db->get();
    }
    
    function list_transaksi_alasan($tanggal_transaksi,$alasan,$pin,$nama,$kartu,$limit=100,$offset=0)
    {
        $this->db->select("a.tanggal_transaksi,
                            a.id_alasan,
                            b.kode_alasan,
                            b.nama_alasan,
                            a.person_id,
                            c.pin,
                            c.nik,
                            c.kartu,
                            c.nama_karyawan,
                            a.waktu,
                            a.keterangan,
                            a.transaksi_id,
                            a.created_by,
                            a.create_date,
                            a.modified_by,
                            a.modify_date",false);
        $this->db->from("alasan_karyawan a");
        $this->db->join("alasan b","a.id_alasan = b.id_alasan","left");
        $this->db->join("orang c","a.person_id = c.person_id","left");
        
        $this->db->where("a.hapus = '1'",NULL,false);
        
        if(!empty($tanggal_transaksi))
        {
            $this->db->where("a.tanggal_transaksi='".$tanggal_transaksi."'",NULL,false);
                    
        }
        else
        {
            $this->db->where("a.tanggal_transaksi='".date("Y-m-d")."'",NULL,false);
        }
        
        if(!empty($alasan))
        {
            $this->db->where("b.id_alasan='".$alasan."'",NULL,false);
        }
        
        if(!empty($pin) && !empty($nama) && !empty($kartu))
        {
            $this->db->where("(c.pin='".$pin."' or c.nama_karyawan like '%".$nama."%' or c.kartu='".$kartu."')",NULL,false);
        }
        
        $this->db->order_by("transaksi_id","desc");
        
        $this->db->order_by("pin","asc");
        
        $this->db->limit($limit,$offset);
        
        return $this->db->get();
        
    }
    
    /*
     * $mode value is insert or update
     */
    function save_transaction_alasan($data,$mode="insert")
    {
        if(!is_array($data) && empty($data))
            return false;
        
        $this->load->helper("date");
                
        $data['modified_by'] = $this->Mod_login->getSessionPersonId();
        $data['modify_date'] = date('Y-m-d H:i:s');
        
        if($mode=="insert")
        {
            $data['created_by'] = $this->Mod_login->getSessionPersonId();
            $data['create_date'] = date('Y-m-d H:i:s');       
            
            $this->db->insert("alasan_karyawan", $data);
            
            return $this->db->insert_id();
        }
        else if($mode=="update")
        {
            $this->db->where("transaksi_id", $data["transaksi_id"]);
            return $this->db->update("alasan_karyawan", $data);
        }
        
        return false;
        
    }
    
}

?>
