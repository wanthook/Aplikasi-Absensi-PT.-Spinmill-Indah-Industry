<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of karyawan
 *
 * @author taufiq
 */
class Mod_karyawan extends CI_Model 
{
    
    private $tbl= 'orang';
    private $fieldId = 'person_id';
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
//            $this->db->like('kode_jam_kerja',$search);
            $this->db->where($search,null,false);
        }
        
        $this->db->from($this->tbl);
        
        return $this->db->count_all_results();
    }
    
    // get number of persons in database
    function count_all_active($search="")
    {
        if(!empty($search))
        {
//            $this->db->like('kode_jam_kerja',$search);
            $this->db->where($search,null,false);
        }
        
        $this->db->from($this->tbl);
        
        $this->db->where($this->fieldHapus, '1');
        
        return $this->db->count_all_results();
    }
    
    // get persons with paging
    function get_paged_list($limit = 10, $offset = 0, $search="", $order='nama_karyawan')
    {
        if(!empty($search))
        {
            $this->db->where($search,null,false);
        }
        
        $this->db->select("orang.pin,
            orang.nik,
            orang.kartu,
            orang.nama_karyawan,
            orang.id_jabatan,
            orang.id_divisi,
            orang.id_status,
            orang.tgl_masuk,
            orang.no_jamsostek,
            orang.no_asuransi,
            orang.no_bank,
            orang.no_npwp,
            orang.tgl_npwp,
            orang.inv_perusahaan,
            orang.foto,
            orang.jenis_jadwal,
            orang.kode_jadwal,
            orang.id_status_kontrak,
            orang.tgl_awal_kontrak,
            orang.tgl_akhir_kontrak,
            orang.id_jenkel,
            orang.tempat_lahir,
            orang.tanggal_lahir,
            orang.id_pendidikan,
            orang.tahun_lulus,
            orang.id_agama,
            orang.no_tlp,
            orang.no_ktp,
            orang.ktp_berlaku,
            orang.id_marital,
            orang.id_status_rumah,
            orang.nama_saudara,
            orang.alamat_saudara,
            orang.no_tlp_saudara,
            orang.alamat,
            orang.kota,
            orang.kode_pos,
            orang.alamat_ktp,
            orang.kota_ktp,
            orang.kode_pos_ktp,
            orang.nama_istri,
            orang.tempat_lahir_istri,
            orang.tanggal_lahir_istri,
            orang.no_asuransi_istri,
            orang.nama_anak_1,
            orang.tempat_lahir_anak_1,
            orang.tanggal_lahir_anak_1,
            orang.no_asurasi_anak_1,
            orang.nama_anak_2,
            orang.tempat_lahir_anak_2,
            orang.tanggal_lahir_anak_2,
            orang.no_asuransi_anak_2,
            orang.nama_anak_3,
            orang.tempat_lahir_anak_3,
            orang.tanggal_lahir_anak_3,
            orang.no_asuransi_anak_3,
            orang.nama_ayah,
            orang.nama_ibu,
            orang.alamat_orangtua,
            orang.kota_orangtua,
            orang.nama_ayah_mertua,
            orang.nama_ibu_mertua,
            orang.alamat_mertua,
            orang.kota_mertua,
            orang.hapus,
            orang.custom_1,
            orang.custom_2,
            orang.custom_3,
            orang.custom_4,
            orang.custom_5,
            orang.custom_6,
            orang.custom_7,
            orang.custom_8,
            orang.custom_9,
            orang.custom_10,
            orang.person_id,
            orang.created_by,
            orang.create_date,
            orang.modified_by,
            orang.modify_date,
            divisi.kode_divisi,
            divisi.nama_divisi,
            jabatan.kode_jabatan,
            jabatan.nama_jabatan
        ",false);
        
        $this->db->join('jabatan', 'jabatan.id_jabatan = orang.id_jabatan', 'left');
        $this->db->join('divisi', 'divisi.id_divisi = orang.id_divisi', 'left');
        
        $this->db->order_by($order,'asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    // get persons with paging
    function get_paged_list_active($limit = 10, $offset = 0, $search="", $order='nama_karyawan')
    {
        if(!empty($search))
        {
            $this->db->where($search,null,false);
        }
        
        $this->db->select("orang.pin,
            orang.nik,
            orang.kartu,
            orang.nama_karyawan,
            orang.id_jabatan,
            orang.id_divisi,
            orang.id_status,
            orang.tgl_masuk,
            orang.no_jamsostek,
            orang.no_asuransi,
            orang.no_bank,
            orang.no_npwp,
            orang.tgl_npwp,
            orang.inv_perusahaan,
            orang.foto,
            orang.jenis_jadwal,
            orang.kode_jadwal,
            orang.id_status_kontrak,
            orang.tgl_awal_kontrak,
            orang.tgl_akhir_kontrak,
            orang.id_jenkel,
            orang.tempat_lahir,
            orang.tanggal_lahir,
            orang.id_pendidikan,
            orang.tahun_lulus,
            orang.id_agama,
            orang.no_tlp,
            orang.no_ktp,
            orang.ktp_berlaku,
            orang.id_marital,
            orang.id_status_rumah,
            orang.nama_saudara,
            orang.alamat_saudara,
            orang.no_tlp_saudara,
            orang.alamat,
            orang.kota,
            orang.kode_pos,
            orang.alamat_ktp,
            orang.kota_ktp,
            orang.kode_pos_ktp,
            orang.nama_istri,
            orang.tempat_lahir_istri,
            orang.tanggal_lahir_istri,
            orang.no_asuransi_istri,
            orang.nama_anak_1,
            orang.tempat_lahir_anak_1,
            orang.tanggal_lahir_anak_1,
            orang.no_asurasi_anak_1,
            orang.nama_anak_2,
            orang.tempat_lahir_anak_2,
            orang.tanggal_lahir_anak_2,
            orang.no_asuransi_anak_2,
            orang.nama_anak_3,
            orang.tempat_lahir_anak_3,
            orang.tanggal_lahir_anak_3,
            orang.no_asuransi_anak_3,
            orang.nama_ayah,
            orang.nama_ibu,
            orang.alamat_orangtua,
            orang.kota_orangtua,
            orang.nama_ayah_mertua,
            orang.nama_ibu_mertua,
            orang.alamat_mertua,
            orang.kota_mertua,
            orang.hapus,
            orang.custom_1,
            orang.custom_2,
            orang.custom_3,
            orang.custom_4,
            orang.custom_5,
            orang.custom_6,
            orang.custom_7,
            orang.custom_8,
            orang.custom_9,
            orang.custom_10,
            orang.person_id,
            orang.created_by,
            orang.create_date,
            orang.modified_by,
            orang.modify_date,
            divisi.kode_divisi,
            divisi.nama_divisi,
            jabatan.kode_jabatan,
            jabatan.nama_jabatan
        ",false);
        
        $this->db->join('jabatan', 'jabatan.id_jabatan = orang.id_jabatan', 'left');
        $this->db->join('divisi', 'divisi.id_divisi = orang.id_divisi', 'left');
        
        $this->db->where("orang.".$this->fieldHapus,'1');
        $this->db->where('person_id !=','1');
        $this->db->order_by($order,'asc');        
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
    
    // delete person by id
    function delete($id)
    {
        $data['hapus'] = 0;
        
        $this->update($id, $data);
    }
    
    function get_karyawan_list_jadwal($search="",$isView=true)
    {
        if(!empty($search))
        {
            $this->db->where($search,NULL,false);
//            echo $search;
        }
        
        $this->db->from("orang");
        
        if($isView==false)
        {
            $this->db->where("person_id not in (select karyawan_id from set_jadwal_kerja where hapus=1)");
        }
        
        $this->db->where("hapus","1");
        $this->db->order_by("pin","ASC");
        
        return $this->db->get();
    }
    
    function insert_batch($arr)
    {
        if(is_array($arr))
        {
            return $this->db->insert_batch($this->tbl,$arr);
        }
        
        return false;
    }
    
    function get_personid($pin)
    {
        $this->db->select("person_id",false);
        
        $this->db->from("orang");
        
        $this->db->where("pin='$pin'",NULL,FALSE);
        
        $get = $this->db->get();
        
        if($get->num_rows()>0)
        {
            $row = $get->row_array();
            
            return $row['person_id'];
        }
        
        return false;
    }
}

?>
