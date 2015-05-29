<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

/**
 * Description of login
 *
 * @author taufiq
 */
class Jadwal_kerja_normal extends Secure_area
{
    private $limit = 25;
    private $typePage = 'jadwal_kerja_normal';
    private $titleForm = 'Kode Form Jadwal Kerja Normal';
    private $actionUrl = 'jadwal_kerja_normal';
    
    private $tblHead = array('Kode Jadwal', 'Keterangan Jadwal', 'Modifikasi Terakhir', 'Aksi');
    private $tblHeadA = array('PIN', 'Kartu', 'NIK', 'Nama Karyawan', 'Aksi');
    
    private $tmpl = array (
                    'table_open'          => '<table class="table table-bordered tablesorter" id="tblJadwalKerjaNormal">',
                    
                    'thead_open'          => '<thead>',
                    'thead_close'         => '</thead>',
            
                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',
                    
                    'tbody_open'          => '<tbody>',
                    'tbody_close'         => '</tbody>',
            
                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );
    
    function __construct() 
    {
        parent::__construct();
        $this->load->model('Mod_jam_kerja');
    }
    
    function index()
    {
        $this->table();
    }   
    
    function table($search="",$ofset = 0)
    {
        // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        
        // load data
        $datas = $this->Mod_jadwal_kerja_normal->get_paged_list_active($this->limit, $offset,$search)->result();
        
         // generate pagination
        $config['base_url'] = site_url($this->typePage.'/index/');
        $config['total_rows'] = $this->Mod_jadwal_kerja_normal->count_all_active($search);
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        
        $config['cur_tag_open'] = '<li class="disabled"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        // generate table data
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading($this->tblHead);
        
        $this->table->set_template($this->tmpl);
//        print_r($datas);
        $i = 0 + $offset;
        foreach ($datas as $row)
        {            
            $this->table->add_row(
                    $row->kode_jadwal_normal, 
                    $row->keterangan_jadwal_normal,
                    date('d-m-Y H:i:s', strtotime($row->modify_date)), 
//                anchor($this->typePage.'/view/'.$row->id_jam_kerja,'<span class="glyphicon glyphicon-file"></span>&nbsp;Lihat',array('class'=>'btn btn-primary btn-xs')).' '.
                anchor($this->typePage.'/update/'.$row->id_jadwal,'<span class="glyphicon glyphicon-pencil"></span>&nbsp;Ubah',array('class'=>'btn btn-warning btn-xs')).' '.
                anchor($this->typePage.'/delete/'.$row->id_jadwal,'<span class="glyphicon glyphicon-remove"></span>&nbsp;Hapus',array('class'=>'btn btn-danger btn-xs','onclick'=>"return confirm('".$this->lang->line("common_delete")."')"))
            );
        }
        
        if(empty($datas))
        {
            $this->table->add_row(array('data' => 'Data tidak ada', 'colspan' => count($this->tblHead), 'align'=> 'center'));
        }
        
        $data['table'] = $this->table->generate();
        
        // load view
        $this->load->view($this->typePage.'/tabel', $data);
    }
    
    function table_karyawan($id)
    {
                
        // load data
        $datas = $this->Mod_jadwal_kerja_normal->get_list_karyawan($id)->result();
        
        // generate table data
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading($this->tblHeadA);
        
        $template = $this->tmpl;
        $template['table_open'] = '<table class="table table-bordered tablesorter" id="tblKaryawanJadwalKerjaNormal">';
        
        $this->table->set_template($template);
        foreach ($datas as $row)
        {            
            $this->table->add_row(
                    $row->pin, 
                    $row->kartu,
                    $row->nik,
                    $row->nama_karyawan, 
//                anchor($this->typePage.'/view/'.$row->id_jam_kerja,'<span class="glyphicon glyphicon-file"></span>&nbsp;Lihat',array('class'=>'btn btn-primary btn-xs')).' '.
                anchor($this->typePage.'/update/'.$row->id_jadwal_normal,'<span class="glyphicon glyphicon-pencil"></span>&nbsp;Ubah',array('class'=>'btn btn-warning btn-xs')).' '.
                anchor($this->typePage.'/delete/'.$row->id_jadwal_normal,'<span class="glyphicon glyphicon-remove"></span>&nbsp;Hapus',array('class'=>'btn btn-danger btn-xs','onclick'=>"return confirm('".$this->lang->line("common_delete")."')"))
            );
        }
        
        if(empty($datas))
        {
            $this->table->add_row(array('data' => 'Data tidak ada', 'colspan' => count($this->tblHeadA), 'align'=> 'center'));
        }
        return $this->table->generate();
       
    }
    
    function search()
    {
        $where = "";

        //txtSearch
        $txtSearch = $this->input->post('txtSearch');        
        
        if(!empty($txtSearch))
            $where .= "(kode_jadwal_normal like '%$txtSearch%' or keterangan_jadwal_normal like '%$txtSearch%')";
        
        $this->table($where);
    }
    
    function add($message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->actionUrl.'/save';
        $data['idForm'] = "formJadwalKerjaNormal";
        $data['button'] = "Simpan";
        $data['button_icon'] = "glyphicon-plus-sign";
        $data['message'] = $message;        
        
        $this->load->view($this->typePage.'/form',$data);
    }
    
    function success()
    {
        $message = '<div class="alert alert-success">'.$this->lang->line('common_save').'</div>';
        
        $this->add($message);
    }
    
    function save()
    {
        $this->_set_rules();
        
        if ($this->form_validation->run('jadwalKerjaNormal') == FALSE)
        {
            $message = '';
            $this->add($message);
        }
        else
        {
            $data = $this->_set_data();
            
            $id = $this->Mod_jadwal_kerja_normal->save($data);
            
            redirect($this->typePage.'/success');
                        
        }
        
        
    }
    
    function update($id,$message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->actionUrl.'/edit/'.$id;
        $data['idForm'] = "formJadwalKerjaNormal";
        $data['button'] = "Ubah";
        $data['button_icon'] = "glyphicon-pencil";
        //$data['table_kar'] = $this->table_karyawan($id);
        
        $edit_data = $this->Mod_jadwal_kerja_normal->get_by_id_active($id)->row_array();
        
        $dataSet = $this->_set_data($edit_data);
        
        $data = array_merge($data,$dataSet);
//        print_r($data);
        if(!empty($message))
        {
            $data['message'] = $message;
        }
        
        $this->load->view($this->typePage.'/form',$data);
    }
            
    function edit($id)
    {
        $this->_set_rules();
        
        if ($this->form_validation->run('jadwalKerjaNormalEdit') == FALSE)
        {
            $message = '';
            $this->update($id,$message);
        }
        else
        {
            $data = $this->_set_data();
            
            $update = $this->Mod_jadwal_kerja_normal->update($id,$data);
            
            $message = '<div class="alert alert-success">'.$this->lang->line('common_edit').'</div>';
        
            $this->update($id,$message);
            
                        
        }
    }
    
    function delete($id)
    {
        $this->Mod_jadwal_kerja_normal->delete($id);
        
        redirect($this->typePage);
    }
    
    function _set_data($param="")
    {
        if(!empty($param))
        {
            
            $data['txtKodeJadwalKerjaNormal'] = $param['kode_jadwal_normal'];
            $data['txtKeteranganJadwalKerjaNormal'] = $param['keterangan_jadwal_normal'];
            $data['cmbSenin'] = $param['id_jam_kerja_senin'];
            $data['cmbSelasa'] = $param['id_jam_kerja_selasa'];
            $data['cmbRabu'] = $param['id_jam_kerja_rabu'];
            $data['cmbKamis'] = $param['id_jam_kerja_kamis'];
            $data['cmbJumat'] = $param['id_jam_kerja_jumat'];
            $data['cmbSabtu'] = $param['id_jam_kerja_sabtu'];
            $data['cmbMinggu'] = $param['id_jam_kerja_minggu'];
            
            return $data;
        }
        
        $data['kode_jadwal_normal'] = $this->input->post('txtKodeJadwalKerjaNormal');
        $data['keterangan_jadwal_normal'] = $this->input->post('txtKeteranganJadwalKerjaNormal');
        $data['id_jam_kerja_senin'] = $this->input->post('cmbSenin');
        $data['id_jam_kerja_selasa'] = $this->input->post('cmbSelasa');
        $data['id_jam_kerja_rabu'] = $this->input->post('cmbRabu');
        $data['id_jam_kerja_kamis'] = $this->input->post('cmbKamis');
        $data['id_jam_kerja_jumat'] = $this->input->post('cmbJumat');
        $data['id_jam_kerja_sabtu'] = $this->input->post('cmbSabtu');
        $data['id_jam_kerja_minggu'] = $this->input->post('cmbMinggu');


        
        return $data;
    }
    
    // validation rules
    function _set_rules()
    {
        $this->form_validation->set_message('required', '%s Harus Diisi!!!');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }
    
    function rolekey_exists($key)
    {
        if($this->Mod_jadwal_kerja_normal->role_exists($key))
        {
            $this->form_validation->set_message('rolekey_exists', '%s sudah ada di database');
            return false;
        }
        
        return true;
    }
    
    function sJadwal($json=true)
    {
        $aArr = array();
        
        if($this->input->get("id")!="")
        {
            $q = $this->input->get("id");
            $res = $this->Mod_jam_kerja->get_by_id_active($q)->result();
        }
        else
        {
            $q = $this->input->get("q");
            $res = $this->Mod_jam_kerja->get_paged_list_active(10, 0, $q)->result();
        }
        
        
        
        foreach($res as $aArrs)
        {
            $aArr[] = array("id"=>$aArrs->id_jam_kerja,"text"=>$aArrs->kode_jam_kerja." (".$aArrs->jam_masuk." - ".$aArrs->jam_pulang.")");
        }
        
        if($json)
            echo json_encode($aArr);
        else
            return $aArr;
    }
}

?>
