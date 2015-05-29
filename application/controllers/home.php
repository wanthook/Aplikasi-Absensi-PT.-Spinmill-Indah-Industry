<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once ("secure_area.php");

/**
 * Description of home
 *
 * @author taufiq
 */
class Home extends Secure_area
{
    function __construct() 
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->load->view("home");
    }
    
    function logout()
    {
        $this->Mod_login->logout();
    }
}

?>
