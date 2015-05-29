<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mod_activity
 *
 * @author taufiq
 */
class Mod_activity extends CI_Model
{
    private $tbl = "activity";
    
    function __construct() 
    {
        parent::__construct();        
    }
    
    
    
    function cek_data_activity($card,$time,$func)
    {
        if(!empty($card) && !empty($time) && !empty($func))
        {
            $this->db->from($this->tbl);
            $this->db->where("act_card='$card' and act_time='$time' and act_function='$func'",NULL,FALSE);
            
            $numRows = $this->db->count_all_results();
            
            if($numRows>0)
                return true;
        }
        
        return false;
    }
}
