<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

/**
 * Description of login
 *
 * @author taufiq
 */
class Libur extends Secure_area
{
    private $limit = 25;
    private $typePage = 'libur';
    private $titleForm = 'Form Master Libur';
    private $actionUrl = 'libur';
    
    private $tblHead = array('Tanggal Libur', 'Keterangan', 'Modifikasi Terakhir', 'Aksi');
        
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('Mod_libur');
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
        $datas = $this->Mod_libur->get_paged_list_active($this->limit, $offset,$search,"tanggal_libur","desc")->result();
        
        //set template table
        $templateTable = $this->fungsi->template_table('tblAlasan');
        
        //config paggination
        $config = $this->fungsi->template_pagging(
                        site_url($this->typePage.'/index/'),
                        $this->Mod_libur->count_all_active($search),
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
                    $row->tanggal_libur, 
                    $row->keterangan_libur, 
                    date('d-m-Y H:i:s', strtotime($row->modify_date)), 
//                  anchor($this->typePage.'/view/'.$row->id_alasan,'<span class="glyphicon glyphicon-file"></span>&nbsp;Lihat',array('class'=>'btn btn-primary btn-xs')).' '.
                    anchor($this->typePage.'/update/'.$row->id_libur,'<span class="glyphicon glyphicon-pencil"></span>&nbsp;Ubah',array('class'=>'btn btn-warning btn-xs')).' '.
                    anchor($this->typePage.'/delete/'.$row->id_libur,'<span class="glyphicon glyphicon-remove"></span>&nbsp;Hapus',array('class'=>'btn btn-danger btn-xs','onclick'=>"return confirm('".$this->lang->line("common_delete")."')"))
                );
            }
        }
        $data['table'] = $this->table->generate();
        
        // load view
        $this->load->view($this->typePage.'/tabel', $data);
    }
    
    function search()
    {
        $searchText = $this->input->post('txtSearch');
        
        $this->table($searchText);
    }
    
    function add($message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->typePage.'/save';
        $data['idForm'] = "formMasterLibur";
        $data['button'] = "Simpan";
        $data['button_icon'] = "glyphicon-plus-sign";
        $data['message'] = $message;
        
        $this->load->view($this->typePage.'/form',$data);
    }
    
    function update($id,$message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->typePage.'/edit/'.$id;
        $data['idForm'] = "formMasterLibur";
        $data['button'] = "Ubah";
        $data['button_icon'] = "glyphicon-pencil";
        
        $edit_data = $this->Mod_libur->get_by_id_active($id)->row_array();
        $dataSet = $this->_set_data($edit_data);
        
        $data = array_merge($data,$dataSet);
        
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
            $data = $this->_set_data();
            
            $id = $this->Mod_libur->save($data);
            
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
            $data = $this->_set_data();
            
            $update = $this->Mod_libur->update($id,$data);
            
            $message = '<div class="alert alert-success">'.$this->lang->line('common_edit').'</div>';
        
            $this->update($id,$message);
            
                        
        }
    }
    
    function delete($id)
    {
        $this->Mod_libur->delete($id);
        
        redirect($this->typePage);
    }
    
    function _set_data($param="")
    {
        if(!empty($param))
        {
            $dtFormat1 = $this->fungsi->convertDate($param['tanggal_libur'],'d-m-Y');
            
            $data['txtTanggalLibur'] = $dtFormat1;
            $data['txtKeteranganLibur'] = $param['keterangan_libur'];
            
            return $data;
        }
        $dtFormat1 = $this->fungsi->convertDate($this->input->post('txtTanggalLibur'),'Y-m-d');
        
        $data['tanggal_libur'] = $dtFormat1;
        $data['keterangan_libur'] = $this->input->post('txtKeteranganLibur');
        
        return $data;
    }
    
    // validation rules
    function _set_rules()
    {
        $this->form_validation->set_rules('txtTanggalLibur', 'Tanggal Libur', 'trim|required|xss_clean');
        $this->form_validation->set_rules('txtKeteranganLibur', 'Keterangan Libur', 'trim|required|xss_clean');
         
        $this->form_validation->set_message('required', '%s Harus Diisi!!!');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }
}

?>
