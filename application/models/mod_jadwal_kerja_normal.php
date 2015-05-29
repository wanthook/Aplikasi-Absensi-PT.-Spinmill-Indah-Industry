<?php
/**
 * Description of orang
 *
 * @author taufiq
 */
class Mod_jadwal_kerja_normal extends CI_Model 
{
    
    private $tbl= 'jadwal_kerja_normal';
    
    private $tbl_set = 'set_jadwal_kerja';
    
    private $fieldId = 'id_jadwal';
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
            $this->db->like('kode_jadwal_normal',$search);
            $this->db->or_like('keterangan_jadwal_normal',$search);
        }
        
        return $this->db->count_all($this->tbl);
    }
    
    // get number of persons in database
    function count_all_active($search="")
    {
        if(!empty($search))
        {
            $this->db->like('kode_jadwal_normal',$search);
            $this->db->or_like('keterangan_jadwal_normal',$search);
        }
        
        $this->db->where($this->fieldHapus, '1');
        return $this->db->count_all($this->tbl);
    }
    
    // get number of persons in database
    function count_all_set($search="")
    {
        if(!empty($search))
        {
            $this->db->like('kode_jadwal_normal',$search);
            $this->db->or_like('keterangan_jadwal_normal',$search);
        }
        
        return $this->db->count_all($this->tbl_set);
    }
    
    // get number of persons in database
    function count_all_active_set($search="")
    {
        if(!empty($search))
        {
            $this->db->like('kode_jadwal_normal',$search);
            $this->db->or_like('keterangan_jadwal_normal',$search);
        }
        
        $this->db->where($this->fieldHapus, '1');
        return $this->db->count_all($this->tbl_set);
    }
    
    // get persons with paging
    function get_paged_list($limit = 10, $offset = 0, $search="", $order='kode_jadwal_normal')
    {
        if(!empty($search))
        {
            $this->db->where($search,null,false);
        }
        
        $this->db->join('jam_kerja h1', 'h1.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_senin', 'left');
        $this->db->join('jam_kerja h2', 'h2.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_selasa', 'left');
        $this->db->join('jam_kerja h3', 'h3.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_rabu', 'left');
        $this->db->join('jam_kerja h4', 'h4.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_kamis', 'left');
        $this->db->join('jam_kerja h5', 'h5.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_jumat', 'left');
        $this->db->join('jam_kerja h6', 'h6.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_sabtu', 'left');
        $this->db->join('jam_kerja h7', 'h7.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_minggu', 'left');
        
        $this->db->order_by($order,'asc');        
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    // get persons with paging
    function get_paged_list_active($limit = 10, $offset = 0, $search="", $order='kode_jadwal_normal')
    {
        if(!empty($search))
        {
            $this->db->where($search,null,false);
        }
        
        $this->db->join('jam_kerja h1', 'h1.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_senin', 'left');
        $this->db->join('jam_kerja h2', 'h2.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_selasa', 'left');
        $this->db->join('jam_kerja h3', 'h3.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_rabu', 'left');
        $this->db->join('jam_kerja h4', 'h4.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_kamis', 'left');
        $this->db->join('jam_kerja h5', 'h5.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_jumat', 'left');
        $this->db->join('jam_kerja h6', 'h6.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_sabtu', 'left');
        $this->db->join('jam_kerja h7', 'h7.id_jam_kerja = '.$this->tbl.'.id_jam_kerja_minggu', 'left');
        
        $this->db->where($this->tbl.".".$this->fieldHapus,'1');
        $this->db->order_by($order,'asc');        
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    // get persons with paging
    function get_paged_list_set($limit = 10, $offset = 0, $search="", $order='kode_jadwal_normal')
    {
        
        if(!empty($search))
        {
            $this->db->where($search,null,false);
        }
        
        $this->db->select('a.*,
                           count(b.id_set_jadwal) tot_kar',false);
        
        $this->db->join($this->tbl_set.' b',"a.id_jadwal_normal = b.id_jadwal and b.tipe_jadwal='N'",'left');
        
        $this->db->order_by($order,'asc');    
        
//        $this->db->where('a.'.$this->fieldHapus,'1');
        
        return $this->db->get($this->tbl.' a', $limit, $offset);        
    }
    
    // get persons with paging
    function get_paged_list_active_set($limit = 10, $offset = 0, $search="", $order='kode_jadwal_normal')
    {
        if(!empty($search))
        {
            $this->db->where($search,null,false);
        }
        
        $this->db->select('a.*,
                           count(b.id_set_jadwal) tot_kar',false);
        
        $this->db->join($this->tbl_set.' b',"a.id_jadwal_normal = b.id_jadwal and b.tipe_jadwal='N'",'left');
        
        $this->db->order_by($order,'asc');    
        
        $this->db->where('a.'.$this->fieldHapus,'1');
        
        return $this->db->get($this->tbl.' a', $limit, $offset);     
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
    
    function role_exists($key)
    {
        $this->db->where('kode_jadwal_normal',$key);
        $query = $this->db->get($this->tbl);
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    
    function get_list_karyawan($jadwal_id)
    {
        $sql = "select a.id_jadwal,
                        a.karyawan_id,
                        a.tipe_jadwal,
                        a.id_set_jadwal, 
                        b.pin, 
                        b.nik, 
                        b.kartu, 
                        b.nama_karyawan, 
                        c.kode_divisi, 
                        c.nama_divisi
                from set_jadwal_kerja a left join orang b on a.karyawan_id = b.person_id
                                        left join divisi c on b.id_divisi = c.id_divisi
                where a.tipe_jadwal = 'N'
                                and a.id_jadwal = '".mysql_real_escape_string($jadwal_id)."'
                order by b.nama_karyawan asc";
        
        $this->db->query($sql);
    }
}

?>
