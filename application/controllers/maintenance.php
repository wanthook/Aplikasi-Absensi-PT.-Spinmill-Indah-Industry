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
class Maintenance extends CI_Controller
{
    function __construct() 
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->load->view('maintenance');
    }
}

?>
