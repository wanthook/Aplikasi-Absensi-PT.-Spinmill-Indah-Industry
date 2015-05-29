<?php
/**
 * Description of orang
 *
 * @author taufiq
 */
class Mod_jadwal_kerja_manual extends CI_Model 
{
    
    private $tbl= 'jadwal_kerja_manual';
    private $det_tbl= 'jadwal_kerja_manual_detail';
    private $temp_tbl= 'temp_jadwal_kerja_manual_detail';
    private $fieldId = 'id_jadwal';
    
    private $orang_tbl = "orang";
    private $fieldHapus = 'hapus';
    
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model("Mod_jam_kerja");
    }
       
    function get_data_master($search="",$limit=0,$offset=0,$sort_by="",$sort_method="",$group_by="")
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
        
        $this->db->select("$this->tbl.*,
                           orang.pin,
                           orang.nama_karyawan",false);
        
        $this->db->from($this->tbl);
        $this->db->from($this->orang_tbl);
        
        $this->db->where("$this->tbl.person_id","$this->orang_tbl.person_id",false);
        $this->db->where("$this->orang_tbl.hapus","1",false);
        
        return $this->db->get();
    }
    
    
    
//    // get number of persons in database
//    function count_all($search="")
//    {
//        if(!empty($search))
//        {
//            $this->db->like('kode_jadwal_shift',$search);
//            $this->db->or_like('keterangan_jadwal_shift',$search);
//        }
//        
//        return $this->db->count_all($this->tbl);
//    }
//    
//    // get number of persons in database
//    function count_all_active($search="")
//    {
//        if(!empty($search))
//        {
//            $this->db->like('kode_jadwal_shift',$search);
//            $this->db->or_like('keterangan_jadwal_shift',$search);
//        }
//        
//        $this->db->where($this->fieldHapus, '1');
//        return $this->db->count_all($this->tbl);
//    }
//    
//    // get persons with paging
//    function get_paged_list($limit = 10, $offset = 0, $search="", $order='kode_jadwal_shift')
//    {
//        if(!empty($search))
//        {
//            $this->db->where($search,null,false);
//        }        
//        
//        $this->db->order_by($order,'asc');        
//        return $this->db->get($this->tbl, $limit, $offset);
//    }
//    
//    // get persons with paging
//    function get_paged_list_active($limit = 10, $offset = 0, $search="", $order='kode_jadwal_shift')
//    {
//        if(!empty($search))
//        {
//            $this->db->where($search,null,false);
//        }
//                
//        $this->db->where($this->tbl.".".$this->fieldHapus,'1');
//        $this->db->order_by($order,'asc');        
//        return $this->db->get($this->tbl, $limit, $offset);
//    }
//    
//    // get person by id
//    function get_by_id($id)
//    {
//        $this->db->where($this->fieldId, $id);
//        return $this->db->get($this->tbl);
//    }
//    
//    // get person by id
//    function get_by_id_active($id)
//    {
//        $this->db->where($this->fieldHapus,'1');
//        $this->db->where($this->fieldId, $id);
//        return $this->db->get($this->tbl);
//    }
    
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
        $this->db->where('person_id',$key);
        $query = $this->db->get($this->tbl);
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    
    /*
     * ini buat temporary detail
     */
    
    // add temp shift table detail
    function add_temp_stable($data)
    {
        $ret = 0;
        
        if(!empty($data) && is_array($data))
        {
            $this->load->helper('date');
            $data['created_by'] = $this->Mod_login->getSessionPersonId();
            $data['create_date'] = date('Y-m-d H:i:s');
            
            $this->db->insert($this->temp_tbl, $data);
            
            $ret = $this->db->insert_id();
        }
        
        
        return $ret;
    }
    
    function update_temp_stable($data)
    {
        $ret = 0;
        
        if(!empty($data) && is_array($data))
        {
            $this->load->helper('date');
//            $data['modified_by'] = $this->Mod_login->getSessionPersonId();
//            $data['modify_date'] = date('Y-m-d H:i:s');
            
            $this->db->where("tanggal",$data['tanggal']);
            $this->db->where("created_by",$this->Mod_login->getSessionPersonId());
            
            $this->db->update($this->temp_tbl, $data);
        }
        
        
        return $ret;
    }
    
    function get_temp_stable()
    {
        $this->db->where("created_by",$this->Mod_login->getSessionPersonId());
        
        return $this->db->get($this->temp_tbl);
    }
    
    function exist_temp_stable($date)
    {
        //echo $date;
        $this->db->where("tanggal",$date);
        $this->db->where("created_by",$this->Mod_login->getSessionPersonId());
        
        $tot = $this->db->count_all_results($this->temp_tbl);
        
        if($tot>0)
            return true;
        
        return false;
    }
    
    function exist_detail_table($id_shift,$date)
    {
        //echo $date;
        $this->db->where("id_jadwal_manual",$id_shift);
        $this->db->where("tanggal",$date);
        //$this->db->where("created_by",$this->Mod_karyawan->getSessionPersonId());
        
        $tot = $this->db->count_all_results($this->det_tbl);
        if($tot>0)
            return true;
        
        return false;
    }
    
    function free_up_temp_stable()
    {
        $this->db->delete($this->temp_tbl, array('created_by' => $this->Mod_login->getSessionPersonId())); 
    }
    
    function delete_temp_stable($date)
    {
        if($this->exist_temp_stable($date))
        {
            $this->db->where("tanggal",$date);
            $this->db->where("created_by",$this->Mod_login->getSessionPersonId());
            
            $this->db->update($this->temp_tbl,array('hapus'=>0));
        }
        
        else
        {
            $this->add_temp_stable(array('tanggal'=>$date,'hapus'=>0));
        }
        
    }
    
    function save_detail($id)
    {
        $this->load->helper('date');
        
        $ret = 0;
        
        $batch = array();
        
        $temp = $this->get_temp_stable()->result_array();
        
        foreach ($temp as $temps)
        {
            $batch[] = array
                       (
                            'tanggal'=>$temps['tanggal'],
                            'id_jam_kerja'=>$temps['id_jam_kerja'],
                            'id_jadwal_manual'=>$id,
                            'created_by'=>$this->Mod_login->getSessionPersonId(),
                            'create_date'=>date('Y-m-d H:i:s'),
                            'modified_by'=>$this->Mod_login->getSessionPersonId(),
                            'modify_date'=>date('Y-m-d H:i:s')
                       );
        }
        
        $ret = $this->db->insert_batch($this->det_tbl,$batch);
        
        return $ret;
    }
    
    function update_detail($id_manual)
    {
        $this->load->helper('date');
                
        $ret = 0;
        
        $batch = array();
        
        $temp = $this->get_temp_stable()->result_array();
//        print_r($temp);
        $data = array();
        
        foreach ($temp as $temps)
        {
            
            if($this->exist_detail_table($id_manual, $temps['tanggal']))
            {
                
//                echo "kesini";
                $data['id_jam_kerja'] = $temps['id_jam_kerja'];
                $data['hapus'] = $temps['hapus'];
                
                $this->db->where('id_jadwal_manual',$id_manual);
                $this->db->where('tanggal',$temps['tanggal']);
                
                $ret = $this->db->update($this->det_tbl,$data);
            }
            else
            {
                if($temps['hapus'] > 0)
                {
                    $data['tanggal'] = $temps['tanggal'];
                    $data['id_jam_kerja'] = $temps['id_jam_kerja'];
                    $data['id_jadwal_manual'] = $id_manual;
                    $data['created_by'] = $this->Mod_login->getSessionPersonId();
                    $data['create_date'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = $this->Mod_login->getSessionPersonId();
                    $data['modify_date'] = date('Y-m-d H:i:s');
//                    print_r($data);
                    $ret = $this->db->insert($this->det_tbl,$data);
                }
            }
            
            unset($data);
        }
        
        return $ret;
        
    }
    
    function open_detail($date_start, $date_end, $id="")
    {
        $select = "date_format(".$this->det_tbl.".tanggal,'%d') dt,".
                    $this->det_tbl.".tanggal,".
                    $this->det_tbl.".id_jam_kerja,".
                    $this->det_tbl.".id_jadwal_manual,".
                    $this->det_tbl.".id_jadwal_manual_detail,".
                    $this->det_tbl.".hapus,".
                    $this->det_tbl.".created_by,".
                    $this->det_tbl.".create_date,".
                    $this->det_tbl.".modified_by,".
                    $this->det_tbl.".modify_date,
                    jam_kerja.kode_jam_kerja,
                    jam_kerja.jam_masuk,
                    jam_kerja.jam_pulang,
                    jam_kerja.libur,
                    jam_kerja.pendek,
                    jam_kerja.warna";
        
        $where = "(".$this->det_tbl.".tanggal between '$date_start' and '$date_end')
                      and ".$this->det_tbl.".id_jadwal_manual = '$id'
                      and ".$this->det_tbl.".hapus = '1'";
        
        $this->db->select($select,false);
        $this->db->where($where,null,false);
        $this->db->join('jam_kerja', 'jam_kerja.id_jam_kerja = '.$this->det_tbl.'.id_jam_kerja', 'left');
        return $this->db->get($this->det_tbl);
    }
    
//    function open_detail($periode="",$id="")
//    {
//        
//        
//        $select = "date_format(".$this->det_tbl.".tanggal_shift,'%d') dt,".
//                    $this->det_tbl.".tanggal_shift,".
//                    $this->det_tbl.".id_jam_kerja,".
//                    $this->det_tbl.".id_jadwal_shift,".
//                    $this->det_tbl.".id_jadwal_shift_detail,".
//                    $this->det_tbl.".hapus,".
//                    $this->det_tbl.".created_by,".
//                    $this->det_tbl.".create_date,".
//                    $this->det_tbl.".modified_by,".
//                    $this->det_tbl.".modify_date,
//                    jam_kerja.kode_jam_kerja,
//                    jam_kerja.jam_masuk,
//                    jam_kerja.jam_pulang,
//                    jam_kerja.libur,
//                    jam_kerja.pendek,
//                    jam_kerja.warna";
//        
//        $where = "date_format(".$this->det_tbl.".tanggal_shift,'%Y-%m') = '$periode'
//                      and ".$this->det_tbl.".id_jadwal_shift = '$id'
//                      and ".$this->det_tbl.".hapus = '1'";
//        
//        $this->db->select($select,false);
//        $this->db->where($where,null,false);
//        $this->db->join('jam_kerja', 'jam_kerja.id_jam_kerja = '.$this->det_tbl.'.id_jam_kerja', 'left');
//        return $this->db->get($this->det_tbl);
//    }
}

?>
