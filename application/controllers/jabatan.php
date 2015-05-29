<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

/**
 * Description of login
 *
 * @author taufiq
 */
class Jabatan extends Secure_area
{
    private $limit = 50;
    private $typePage = 'jabatan';
    private $titleForm = 'Form Master Jabatan';
    
    private $tblHead = array('Kode Jabatan', 'Nama Jabatan', 'Modifikasi Terakhir', 'Aksi');
    
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('Mod_jabatan');
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
        $datas = $this->Mod_jabatan->get_paged_list_active($this->limit, $offset,$search)->result();
        
        //set template table
        $templateTable = $this->fungsi->template_table('tblJabatan');
        
        //config paggination
        $config = $this->fungsi->template_pagging(
                        site_url($this->typePage.'/index/'),
                        $this->Mod_jabatan->count_all_active($search),
                        $this->limit,
                        $uri_segment
                    );
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        // generate table data
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading($this->tblHead);
        
        $this->table->set_template($templateTable);
        
        if(empty($datas))
        {
            $this->table->add_row(array('data' => $this->lang->line('common_empty_table'), 'colspan' => count($this->tblHead), 'align'=> 'center'));
        }
        else
        {
        
            $i = 0 + $offset;
            foreach ($datas as $row)
            {            
                
                $this->table->add_row(
                    $row->kode_jabatan, 
                    $row->nama_jabatan, 
                    date('d-m-Y H:i:s', strtotime($row->modify_date)), 
//                  anchor($this->typePage.'/view/'.$row->id_alasan,'<span class="glyphicon glyphicon-file"></span>&nbsp;Lihat',array('class'=>'btn btn-primary btn-xs')).' '.
                    anchor($this->typePage.'/update/'.$row->id_jabatan,'<span class="glyphicon glyphicon-pencil"></span>&nbsp;Ubah',array('class'=>'btn btn-warning btn-xs')).' '.
                    anchor($this->typePage.'/delete/'.$row->id_jabatan,'<span class="glyphicon glyphicon-remove"></span>&nbsp;Hapus',array('class'=>'btn btn-danger btn-xs','onclick'=>"return confirm('".$this->lang->line("common_delete")."')"))
                );
            }
        }
        $data['table'] = $this->table->generate();
        
        // load view
        $this->load->view($this->typePage.'/tabel', $data);
    }
    
    function search()
    {
        $searchText = "kode_jabatan like '%".$this->input->post('txtSearch')."%' or nama_jabatan like '%".$this->input->post('txtSearch')."%'";
        
        $this->table($searchText);
    }
    
    function add($message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->typePage.'/save';
        $data['idForm'] = "formMasterJabatan";
        $data['button'] = "Simpan";
        $data['button_icon'] = "glyphicon-plus-sign";
        $data['message'] = $message;
                
        $this->load->view($this->typePage.'/form',$data);
    }
    
    function update($id,$message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->typePage.'/edit/'.$id;
        $data['idForm'] = "formMasterJabatan";
        $data['button'] = "Ubah";
        $data['button_icon'] = "glyphicon-pencil";
        
        $edit_data = $this->Mod_jabatan->get_by_id_active($id)->row_array();
        $data['txtKodeJabatan'] = $edit_data['kode_jabatan'];
        $data['txtKeteranganJabatan'] = $edit_data['nama_jabatan'];
        
        if(!empty($message))
        {
            $data['message'] = $message;
        }
        
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
        
        if ($this->form_validation->run() == FALSE)
        {
            $message = '';
            $this->add($message);
        }
        else
        {
            $data['kode_jabatan'] = $this->input->post('txtKodeJabatan');
            $data['nama_jabatan'] = $this->input->post('txtKeteranganJabatan');
            
            $id = $this->Mod_jabatan->save($data);
            
//            $this->form_validation->
            redirect($this->typePage.'/success');
                        
        }
        
        
    }    
           
    function edit($id)
    {
        $this->_set_rules();
        
        if ($this->form_validation->run() == FALSE)
        {
            $message = '';
            $this->update($id,$message);
        }
        else
        {
            $data['kode_jabatan'] = $this->input->post('txtKodeJabatan');
            $data['nama_jabatan'] = $this->input->post('txtKeteranganJabatan');
            
            $update = $this->Mod_jabatan->update($id,$data);
            
            $message = '<div class="alert alert-success">'.$this->lang->line('common_edit').'</div>';
        
            $this->update($id,$message);
            
                        
        }
    }
    
    function delete($id)
    {
        $this->Mod_jabatan->delete($id);
        
        redirect($this->typePage);
    }
    
    // validation rules
    function _set_rules()
    {
        
        $this->form_validation->set_rules('txtKodeJabatan', 'Kode Jabatan', 'trim|required|xss_clean');
        $this->form_validation->set_rules('txtKeteranganJabatan', 'Keterangan Jabatan', 'trim|required|xss_clean');
         
        $this->form_validation->set_message('required', '%s Harus Diisi!!!');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }
}

?>
