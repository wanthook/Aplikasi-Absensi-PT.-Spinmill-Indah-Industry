<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mod_log
 *
 * @author taufiq
 */
class Mod_log extends CI_Model
{
    //put your code here
    function __construct() 
    {
        parent::__construct();
    }
    
    function createLog($type, $memo, $user)
    {
        $sql = "insert into log 
                set type='".$type."', 
                    memo='".$memo."', 
                    user = '".$user."', 
                    created_by = '".$this->session->userdata('person_id')."', 
                    create_date=now()";
        
        return $this->db->query($sql);
    }
}

?>
