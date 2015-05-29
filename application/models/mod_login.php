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
class Mod_login extends CI_Model 
{
    private $tbl= 'user';
    private $fieldId = 'user_id';
    private $fieldHapus = 'hapus';
    
    function __construct() 
    {
        parent::__construct();
    }
    
    function is_logging()
    {
        return $this->session->userdata('person_id')!=false;
    }
    
    function getSessionPersonId()
    {
        if($this->is_logging())
        {
            return $this->session->userdata('person_id');
        }
        return false;
    }
    
    function login($username,$password)
    {
        $sql = $this->db->get_where('user',array('username'=>$username,'password'=>md5($password),'hapus'=>'1'),1);
        if($sql->num_rows()==1)
        {
            $row = $sql->row();
            $this->session->set_userdata('person_id',$row->user_id);
            $this->session->set_userdata('username',$username);
            return true;
        }
        
        return false;        
    }
    
    function getInfoKaryawanLogin()
    {
        if($this->is_logging())
        {
            return $this->getOrangInfo($this->session->userdata('person_id'));
        }
        
        return false;
    }
    
    function logout()
    {
        $this->Mod_log->createLog('LOGOUT','UserId='.$this->session->userdata('person_id').';UserName='.$this->session->userdata('username').';',$this->session->userdata('person_id'));
        $this->session->sess_destroy();
        redirect('login');
    }
    
    function getOrangInfo($person_id)
    {
        $sql = $this->db->get_where($this->tbl,array($this->fieldId=>$person_id,  $this->fieldHapus=>'1'),1);
        
        if($sql->num_rows()==1)
        {
            return $sql->row();
        }
        else
        {
            //create object with empty properties.
            $fields = $this->db->list_fields('user');
            $person_obj = new stdClass;

            foreach ($fields as $field)
            {
                    $person_obj->$field='';
            }

            return $person_obj;
        }
    }
}

?>
