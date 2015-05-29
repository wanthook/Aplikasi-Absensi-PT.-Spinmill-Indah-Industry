<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of secure_area
 *
 * @author taufiq
 */
class Secure_area extends CI_Controller {
    
    function __construct($module_id=null)
    {
        parent::__construct();	
        
        if(!$this->Mod_login->is_logging())
        {
                redirect('login');
        }

        //load up global data
        $karyawan_login_info = $this->Mod_login->getInfoKaryawanLogin();

        $data['user_info']=$karyawan_login_info;
        $this->load->vars($data);
    }
}

?>
