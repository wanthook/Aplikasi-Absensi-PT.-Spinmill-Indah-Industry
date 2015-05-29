<?php

/**
 * Description of crud_jam_kerja
 *
 * @author taufiq
 */
class Mod_libur extends CI_Model 
{
    
    private $tbl= 'libur';
    private $fieldId = 'id_libur';
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
            $this->db->like('tanggal_libur',$search)
                     ->or_like('keterangan_libur',$search);
        }
        
        return $this->db->count_all($this->tbl);
    }
    
    // get number of persons in database
    function count_all_active($search="")
    {
        if(!empty($search))
        {
            $this->db->like('tanggal_libur',$search)
                     ->or_like('keterangan_libur',$search);
        }
        
        $this->db->where($this->fieldHapus, '1');
        return $this->db->count_all($this->tbl);
    }
    
    // get persons with paging
    function get_paged_list($limit = 10, $offset = 0, $search="", $order='tanggal_libur',$asc = "asc")
    {
        if(!empty($search))
        {
            $this->db->like('tanggal_libur',$search)
                     ->or_like('keterangan_libur',$search);
        }
        
        $this->db->order_by($order,$asc);
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    // get persons with paging
    function get_paged_list_active($limit = 10, $offset = 0, $search="", $order='tanggal_libur',$asc = "asc")
    {
        if(!empty($search))
        {
            $this->db->like('tanggal_libur',$search)
                     ->or_like('keterangan_libur',$search);
        }
        
        $this->db->where($this->fieldHapus,'1');
        $this->db->order_by($order,$asc);        
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    // get persons with paging
    function get_list_libur($search,$order_by,$order="asc")
    {
        if(!empty($search))
        {
            $this->db->where($search,NULL, false);
        }
        $this->db->from($this->tbl);
        $this->db->where($this->fieldHapus,'1');
        $this->db->order_by($order_by,$order);        
        return $this->db->get();
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
    
    // delete person by id
    function delete($id)
    {
        $data['hapus'] = 0;
        
        $this->update($id, $data);
    }    
    
}

?>
