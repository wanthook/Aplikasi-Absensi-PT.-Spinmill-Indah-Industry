<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author taufiq
 */
class Login extends CI_Controller
{
    function __construct() 
    {
        parent::__construct();
    }
    
    function index()
    {
        if($this->Mod_login->is_logging())
        {
            redirect('home');
        }
        else
        {
            $this->form_validation->set_rules('txtUsername', 'Username', 'trim|required|callback_login_check');
            $this->form_validation->set_error_delimiters('<div class="alert-danger fade in">', '</div>');

            if($this->form_validation->run() == FALSE)
            {
                $this->load->view('login');
            }
            else
            {
                redirect('home');
            }
        }
    }
    
    function login_check($username)
    {
        $password = $this->input->post('txtPassword');
        
        if(!$this->Mod_login->login($username,$password))
        {
            $this->form_validation->set_message('login_check', $this->lang->line('login_invalid_username_and_password'));
            return false;
        }
        $this->Mod_log->createLog('LOGIN','UserId='.$this->session->userdata('person_id').';UserName='.$username.';',$this->session->userdata('person_id'));
        return true;
    }
}

?>
