<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of transaksi_absen_manual
 *
 * @author wanthook
 */
class Absen_manual extends Secure_area
{
    
    private $search,$limit,$offset,$order_by,$order_type,$group_by;
    
    private $typePage = 'absen_manual';
    
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model("Mod_absen_manual");
    }
    
    private function set_search($param)
    {
        $this->search = $param;
    }
    private function set_limit($param)
    {
        $this->limit = $param;
    }
    private function set_offset($param)
    {
        $this->offset = $param;
    }
    private function set_order_by($param)
    {
        $this->order_by = $param;
    }
    private function set_order_type($param)
    {
        $this->order_type = $param;
    }
    private function set_group_by($param)
    {
        $this->group_by = $param;
    }
    
    private function get_search()
    {
        return $this->search;
    }
    private function get_limit()
    {
        return $this->limit;
    }
    private function get_offset()
    {
        return $this->offset;
    }
    private function get_order_by()
    {
        return $this->order_by;
    }
    private function get_order_type()
    {
        return $this->order_type;
    }
    private function get_group_by()
    {
        return $this->group_by;
    }
    
    function index()
    {
        $data = $this->set_search_post();
        
        $this->load->view("absen_manual/home",$data);
    }
    
    private function set_search_post()
    {
        $ret = array();
        
        $txtSearch  = $this->input->post("txtSearch");
        $startDate  = $this->input->post("startDate");
        $endDate    = $this->input->post("endDate");
        
        $search_query = "";
        
        if(!empty($txtSearch))
        {
            $search_query = " (orang.pin like '%$txtSearch%' or orang.nama_karyawan like '%$txtSearch%') ";
        }
        
        if(!empty($startDate))
        {
            $sd = $this->fungsi->convertDate($startDate,"Y-m-d");
            
            if(!empty($search_query))
            {
                $search_query .= " and ";
            }
            
            if(!empty($endDate))
            {
                $ed = $this->fungsi->convertDate($endDate,"Y-m-d");
                
                $search_query .= " date between '$sd' and '$ed' ";
            }
            else
            {
                $search_query .= " date='$sd' ";
            }
        }
        
        $this->set_search($search_query);
        $this->set_limit(50);
        $this->set_offset($this->uri->segment(3));
        $this->set_order_by("date");
        $this->set_order_type("desc");
        
        $data = $this->get_data_absen_manual();
        
        $ret["table"] = $this->table_master($data);
        $ret["pagination"] = $this->pagination_master();
        
        return $ret;
        
        
    }
    
    private function table_master($data)
    {
        $ret = "";
        /*
         * table head
         */
        $head = array("PIN", "Nama", "Tanggal", "Jam Masuk", "Jam Pulang", "Alasan Manual", "Aksi");
                
        // open tag table
        $table = '<table class="table table-striped"  id="tblManual" >';
        
        //open head
        $table .= '<thead>';        
        //open head tag
        $table .= '<tr>';        
        $table .= '<th>'.implode('</th><th>', $head).'</th>';    
        
        $table = str_replace('<th>Aksi', '<th colspan="2">Aksi', $table);
        
        //close head tag
        $table .= '</tr>';
        //close head
        $table .= '</thead>';
        
        //open body
        $table .= '<tbody>';
        
        if(count($data)>0)
        {
            foreach ($data as $row)
            {    
                
                $table .= '<tr>';
                
                $buttonAction1 = anchor($this->typePage.'/update/'.$row->absen_manual_id,'<span class="glyphicon glyphicon-pencil"></span>&nbsp;Ubah',array('class'=>'btn btn-warning btn-xs'));
                $buttonAction2 = anchor($this->typePage.'/delete/'.$row->absen_manual_id,'<span class="glyphicon glyphicon-remove"></span>&nbsp;Hapus',array('class'=>'btn btn-danger btn-xs'));
                
                $arrData = array(
                    $row->pin,
                    $row->nama_karyawan,
                    $this->fungsi->convertDate($row->date,'d-m-Y'), 
                    $row->time_in,
                    $row->time_out,
                    $row->remarks, 
                    $buttonAction1,
                    $buttonAction2
                        );
                
                $table .= '<td class="nwrap">'.implode('</td><td class="nwrap">', $arrData).'</td>';        
                
                //close row
                $table .= '</tr>';
            }
        }
        else
        {
            $table .= '<tr><td colspan="'.count($head).'" align="center">'.$this->lang->line('common_empty_table').'</td></tr>';
            //$this->table->add_row(array('data' => $this->lang->line('lang_table_empty'), 'colspan' => count($head), 'align'=> 'center'));
        }
        
        //close body
        $table .= '</tbody>';
        
        // close tag table
        $table .= '</table>';
        
        return $table;
    }
    
    private function pagination_master()
    {
        //config paggination
        $config = $this->fungsi->template_pagging
                    (
                        site_url('absen_manual/index/'),
                        $this->Mod_absen_manual->get_absen_manual_count($this->get_search()),
                        $this->get_limit(),
                        3
                    );
        
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
    
    private function get_data_absen_manual()
    {
        $search = $this->get_search();
        $limit = $this->get_limit();
        $offset = $this->get_offset();
        $order_by = $this->get_order_by();
        $order_type = $this->get_order_type();
        $group_by = $this->get_group_by();
        
        return $this->Mod_absen_manual->get_absen_manual($search, $limit, $offset, $order_by, $order_type, $group_by)->result();
                
    }
}
