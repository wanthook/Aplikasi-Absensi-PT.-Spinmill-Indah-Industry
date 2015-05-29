<?php
/**
 * Description of orang
 *
 * @author taufiq
 */
class Mod_modul extends CI_Model 
{
    function __construct() 
    {
        parent::__construct();
    }
    
    function getAllModules()
    {
        $this->db->from('modul');
        $this->db->order_by('modul_order','ASC');
        
        return $this->db->get();
    }
    
    function getAllowedModules($person_id)
    {
        $this->db->from("modul");
        $this->db->join("user_modul","modul.modul_id=user_modul.modul_id","left");
        $this->db->where("user_modul.user_id = '".$person_id."' and user_modul.hapus='1' and modul.hapus = '1'");
        $this->db->order_by('modul.modul_order','ASC');
        
        return $this->db->get();
        
    }
    
    function createParentChild($modules)
    {
        $arr = array();
        
        if($modules->num_rows()>0)
        {
                        
            foreach ($modules->result() as $row)
            {
                if($row->modul_parent == '0')
                {
                    $arr[] = array
                           (
                                'id' => $row->modul_id,
                                'name' => $row->modul_name,
                                'desc' => $row->modul_desc,
                                'route' => $row->modul_route,
                                'icon' => $row->modul_icon,
                                'child' => $this->getChildMenu($modules, $row->modul_id)
                           );
                }
            }
            
            return $arr;
        }
        
        return null;
    }
    
    function getChildMenu($modules,$parentId)
    {
        $arr = array();
        
        if($modules->num_rows()>0)
        {
            foreach($modules->result() as $row)
            {
                if($row->modul_parent == $parentId)
                {
                    $arr[] = array
                           (
                                'id' => $row->modul_id,
                                'name' => $row->modul_name,
                                'desc' => $row->modul_desc,
                                'route' => $row->modul_route,
                                'icon' => $row->modul_icon
                           );
                }
            }
            return $arr;
        }
        
        return null;
    }
}

?>
