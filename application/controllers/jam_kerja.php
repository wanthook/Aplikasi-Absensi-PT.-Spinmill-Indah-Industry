<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

/**
 * Description of login
 *
 * @author taufiq
 */
class Jam_kerja extends Secure_area
{
    private $limit = 25;
    private $typePage = 'jam_kerja';
    private $titleForm = 'Form Master Jam Kerja';
    
    private $tblHead = array('Kode Jam Kerja', 'Jam Masuk', 'Jam Keluar', 'Libur', 'Pendek', 'Istirahat','Modifikasi Terakhir', 'Aksi');
    
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
        $datas = $this->Mod_jam_kerja->get_paged_list_active($this->limit, $offset,$search)->result();
        
        //set template table
        $templateTable = $this->fungsi->template_table('tblJamKerja');
        
        //config paggination
        $config = $this->fungsi->template_pagging(
                        site_url($this->typePage.'/index/'),
                        $this->Mod_jam_kerja->count_all_active($search),
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
                    $row->kode_jam_kerja, 
                    $row->jam_masuk,
                    $row->jam_pulang,
                    ($row->libur==1)?'Y':'N',
                    ($row->pendek==1)?'Y':'N',
                    ($row->istirahat==1)?'Satu':'Setengah',
                    date('d-m-Y H:i:s', strtotime($row->modify_date)), 
//                anchor($this->typePage.'/view/'.$row->id_jam_kerja,'<span class="glyphicon glyphicon-file"></span>&nbsp;Lihat',array('class'=>'btn btn-primary btn-xs')).' '.
                anchor($this->typePage.'/update/'.$row->id_jam_kerja,'<span class="glyphicon glyphicon-pencil"></span>&nbsp;Ubah',array('class'=>'btn btn-warning btn-xs')).' '.
                anchor($this->typePage.'/delete/'.$row->id_jam_kerja,'<span class="glyphicon glyphicon-remove"></span>&nbsp;Hapus',array('class'=>'btn btn-danger btn-xs','onclick'=>"return confirm('".$this->lang->line("common_delete")."')"))
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
        $data['idForm'] = "formMasterJamKerja";
        $data['button'] = "Simpan";
        $data['button_icon'] = "glyphicon-plus-sign";
        $data['message'] = $message;
        
        $this->load->view($this->typePage.'/form',$data);
    }
    
    function update($id,$message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->typePage.'/edit/'.$id;
        $data['idForm'] = "formMasterJamKerja";
        $data['button'] = "Ubah";
        $data['button_icon'] = "glyphicon-pencil";
        
        $edit_data = $this->Mod_jam_kerja->get_by_id_active($id)->row_array();
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
        
        if ($this->form_validation->run('jam_kerja') == FALSE)
        {
            $message = '';
            $this->add($message);
        }
        else
        {
            $data = $this->_set_data();
            
            $id = $this->Mod_jam_kerja->save($data);
            
            redirect($this->typePage.'/success');
                        
        }
        
        
    }
            
    function edit($id)
    {
        $this->_set_rules();
        
        if ($this->form_validation->run('jam_kerja') == FALSE)
        {
            $message = '';
            $this->update($id,$message);
        }
        else
        {
            $data = $this->_set_data();
            
            $update = $this->Mod_jam_kerja->update($id,$data);
            
            $message = '<div class="alert alert-success">'.$this->lang->line('common_edit').'</div>';
        
            $this->update($id,$message);
            
                        
        }
    }
    
    function delete($id)
    {
        $this->Mod_jam_kerja->delete($id);
        
        redirect('jam_kerja');
    }
    
    function _set_data($param="")
    {
        if(!empty($param))
        {
//            print_r($param);
            $data['txtKodeJamKerja'] = $param['kode_jam_kerja'];
            $data['txtJamMasuk'] = $param['jam_masuk'];
            $data['txtJamPulang'] = $param['jam_pulang'];
            $data['txtLibur'] = $param['libur'];
            $data['txtPendek'] = $param['pendek'];
            $data['txtIstirahat'] = $param['istirahat'];
            $data['txtWarna'] = $param['warna'];
            
            return $data;
        }
        
        $data['kode_jam_kerja'] = $this->input->post('txtKodeJamKerja');
        $data['jam_masuk'] = $this->input->post('txtJamMasuk');
        $data['jam_pulang'] = $this->input->post('txtJamPulang');
        $data['libur'] = $this->input->post('txtLibur');
        $data['pendek'] = $this->input->post('txtPendek');
        $data['istirahat'] = $this->input->post('txtIstirahat');
        $data['warna'] = $this->input->post('txtWarna');
        
        return $data;
    }
    
    // validation rules
    function _set_rules()
    {
        
        $this->form_validation->set_message('required', '%s Harus Diisi!!!');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }
}

?>
