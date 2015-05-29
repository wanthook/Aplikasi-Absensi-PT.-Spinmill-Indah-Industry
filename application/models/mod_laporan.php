<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mod_laporan
 *
 * @author taufiq
 */
class Mod_laporan extends CI_Model
{
    function report_absen($kartu,$dateStart,$dateEnd)
    {
//        $this->
        $this->db->select("date_format(a.act_time,'%Y-%m-%d') tanggal,
                               a.act_function,
                               date_format(a.act_time,'%H:%i:%s') acttime,
                               a.act_time,
                               date_format(act_time,'%Y-%m-%d') `date`,
                               date_format(act_time,'%H:%i:00') `time`",FALSE);
        $this->db->from("activity a");
        $this->db->where("a.act_card = '$kartu'
                        and date_format(a.act_time,'%Y-%m-%d') between '$dateStart' and '$dateEnd'",NULL,false);
        
        $this->db->group_by("a.act_time, a.act_function");
        
        $this->db->order_by("a.act_time, a.act_function","asc");
        
        return $this->db->get();
    }
    
    function report_absen_manual($kartu,$dateStart,$dateEnd)
    {
//        $this->
        $this->db->select("date_format(a.act_time,'%Y-%m-%d') tanggal,
                               a.act_function,
                               date_format(a.act_time,'%H:%i:%s') acttime,
                               a.act_time,
                               date_format(act_time,'%Y-%m-%d') `date`,
                               date_format(act_time,'%H:%i:00') `time`",FALSE);
        $this->db->from("activity_manual a");
        $this->db->where("a.act_card = '$kartu'
                        and date_format(a.act_time,'%Y-%m-%d') between '$dateStart' and '$dateEnd'",NULL,false);
        
        $this->db->group_by("a.act_time, a.act_function");
        
        $this->db->order_by("a.act_time, a.act_function","asc");
        
        return $this->db->get();
    }
    
    function set_jadwal($person_id)
    {
        $this->db->select("id_jadwal, karyawan_id, tipe_jadwal",false);
        $this->db->from("set_jadwal_kerja");
        $this->db->where("karyawan_id='$person_id' and  hapus='1'",NULL,false);
        
        return $this->db->get()->row();
    }
    
    function jadwal_absen($person_id, $dateStart, $dateEnd)
    {
        $ret = array();
                
        $jadwal = $this->set_jadwal($person_id);
       
        if(count($jadwal)<1)
            return false;
        
        if($jadwal->tipe_jadwal=="N")
        {
            $ret = $this->jadwal_absen_normal($jadwal->id_jadwal, $dateStart, $dateEnd);
        }
        else if($jadwal->tipe_jadwal=="S")
        {
            $ret = $this->jadwal_absen_shift($jadwal->id_jadwal, $dateStart, $dateEnd);
        }
        else
            $ret = false;
        
        return $ret;
    }
    
    function jadwal_besok($person_id, $cur_date)
    {
        $tomorrow = date('Y-m-d', strtotime($cur_date . ' + 1 day'));
        
        $dataM = $this->jadwal_absen_manual($person_id, $tomorrow, $tomorrow);
        
        if(isset($dataM[$tomorrow]))
        {
            return $dataM[$tomorrow];
        }
        
        $data = $this->jadwal_absen($person_id, $tomorrow, $tomorrow);
        
        return (isset($data[$tomorrow])?$data[$tomorrow]:" ");
//        print_r($data[$tomorrow]);
    }
    
    function alasan($person_id,$date_start,$date_end)
    {
        return $this->alasan_karyawan($person_id, $date_start, $date_end);
    }
    
    private function jadwal_absen_normal($jadwal_id,$dateStart, $dateEnd)
    {
        $ret = array();
        
        $this->db->select("ja.jam_masuk masuk_senin,
		 ja.jam_pulang pulang_senin,
		 ja.libur libur_senin,
		 ja.pendek pendek_senin,
		 ja.istirahat istirahat_senin,
                 ja.kode_jam_kerja kode_senin,
		 
		 jb.jam_masuk masuk_selasa,
		 jb.jam_pulang pulang_selasa,
		 jb.libur libur_selasa,
		 jb.pendek pendek_selasa,
		 jb.istirahat istirahat_selasa,
                 jb.kode_jam_kerja kode_selasa,
		 
		 jc.jam_masuk masuk_rabu,
		 jc.jam_pulang pulang_rabu,
		 jc.libur libur_rabu,
		 jc.pendek pendek_rabu,
		 jc.istirahat istirahat_rabu,
                 jc.kode_jam_kerja kode_rabu,
		 
		 jd.jam_masuk masuk_kamis,
		 jd.jam_pulang pulang_kamis,
		 jd.libur libur_kamis,
		 jd.pendek pendek_kamis,
		 jd.istirahat istirahat_kamis,
                 jd.kode_jam_kerja kode_kamis,
		 
		 je.jam_masuk masuk_jumat,
		 je.jam_pulang pulang_jumat,
		 je.libur libur_jumat,
		 je.pendek pendek_jumat,
		 je.istirahat istirahat_jumat,
                 je.kode_jam_kerja kode_jumat,
		 
		 jf.jam_masuk masuk_sabtu,
		 jf.jam_pulang pulang_sabtu,
		 jf.libur libur_sabtu,
		 jf.pendek pendek_sabtu,
		 jf.istirahat istirahat_sabtu,
                 jf.kode_jam_kerja kode_sabtu,
		 
		 jg.jam_masuk masuk_minggu,
		 jg.jam_pulang pulang_minggu,
		 jg.libur libur_minggu,
		 jg.pendek pendek_minggu,
		 jg.istirahat istirahat_minggu
                 jg.kode_jam_kerja kode_minggu,",false);
        
        $this->db->from("jadwal_kerja_normal a");
        
        $this->db->join("jam_kerja ja","a.id_jam_kerja_senin = ja.id_jam_kerja","left");
        $this->db->join("jam_kerja jb","a.id_jam_kerja_selasa = jb.id_jam_kerja","left");
        $this->db->join("jam_kerja jc","a.id_jam_kerja_rabu = jc.id_jam_kerja","left");
        $this->db->join("jam_kerja jd","a.id_jam_kerja_kamis = jd.id_jam_kerja","left");
        $this->db->join("jam_kerja je","a.id_jam_kerja_jumat = je.id_jam_kerja","left");
        $this->db->join("jam_kerja jf","a.id_jam_kerja_sabtu = jf.id_jam_kerja","left");
        $this->db->join("jam_kerja jg","a.id_jam_kerja_minggu = jg.id_jam_kerja","left");
        
        $this->db->where("a.id_jadwal='$jadwal_id'",NULL,false);
        
        $data = $this->db->get()->row();
        
        
        $tanggal = $this->fungsi->getDateRange($dateStart,$dateEnd,"+1 days");
        
        if($data)
        {
            foreach ($tanggal as $tgl)
            {
//                echo $this->fungsi->convertDate($tgl,'w')."<br>";
                $convDate = strtoupper($this->fungsi->convertDate($tgl,'D'));
				
                if($convDate=="MON") //senin
                {
                    $ret[$tgl] = array(
                        "tanggal" =>$tgl,
                        "jam_masuk" =>$data->masuk_senin,
                        "jam_pulang" =>$data->pulang_senin,
                        "libur" =>$data->libur_senin,
                        "pendek" =>$data->pendek_senin,
                        "istirahat"=>$data->istirahat_senin,
                        "kode"=>$data->kode_senin
                    );
                }
                else if($convDate=="TUE") //selasa
                {
                    $ret[$tgl] = array(
                        "tanggal" =>$tgl,
                        "jam_masuk" =>$data->masuk_selasa,
                        "jam_pulang" =>$data->pulang_selasa,
                        "libur" =>$data->libur_selasa,
                        "pendek" =>$data->pendek_selasa,
                        "istirahat"=>$data->istirahat_selasa,
                        "kode"=>$data->kode_selasa
                    );
                }
                else if($convDate=="WED") //rabu
                {
                    $ret[$tgl] = array(
                        "tanggal" =>$tgl,
                        "jam_masuk" =>$data->masuk_rabu,
                        "jam_pulang" =>$data->pulang_rabu,
                        "libur" =>$data->libur_rabu,
                        "pendek" =>$data->pendek_rabu,
                        "istirahat"=>$data->istirahat_rabu,
                        "kode"=>$data->kode_rabu
                    );
                }
                else if($convDate=="THU") //kamis
                {
                    $ret[$tgl] = array(
                        "tanggal" =>$tgl,
                        "jam_masuk" =>$data->masuk_kamis,
                        "jam_pulang" =>$data->pulang_kamis,
                        "libur" =>$data->libur_kamis,
                        "pendek" =>$data->pendek_kamis,
                        "istirahat"=>$data->istirahat_kamis,
                        "kode"=>$data->kode_kamis
                    );
                }
                else if($convDate=="FRI") //jumat
                {
                    $ret[$tgl] = array(
                        "tanggal" =>$tgl,
                        "jam_masuk" =>$data->masuk_jumat,
                        "jam_pulang" =>$data->pulang_jumat,
                        "libur" =>$data->libur_jumat,
                        "pendek" =>$data->pendek_jumat,
                        "istirahat"=>$data->istirahat_jumat,
                        "kode"=>$data->kode_jumat
                    );
                }
                else if($convDate=="SAT") //sabtu
                {
                    $ret[$tgl] = array(
                        "tanggal" =>$tgl,
                        "jam_masuk" =>$data->masuk_sabtu,
                        "jam_pulang" =>$data->pulang_sabtu,
                        "libur" =>$data->libur_sabtu,
                        "pendek" =>$data->pendek_sabtu,
                        "istirahat"=>$data->istirahat_sabtu,
                        "kode"=>$data->kode_sabtu
                    );
                }
                else if($convDate=="SUN") //minggu
                {
                    $ret[$tgl] = array(
                        "tanggal" =>$tgl,
                        "jam_masuk" =>$data->masuk_minggu,
                        "jam_pulang" =>$data->pulang_minggu,
                        "libur" =>$data->libur_minggu,
                        "pendek" =>$data->pendek_minggu,
                        "istirahat"=>$data->istirahat_minggu,
                        "kode"=>$data->kode_minggu
                    );
                }
            }
        }
        return $ret;
    }    
    
    private function jadwal_absen_shift($jadwal_id, $dateStart, $dateEnd)
    {
        $ret = array();
        
        $this->db->select("b.tanggal_shift,
		 ba.jam_masuk,
		 ba.jam_pulang,
		 ba.libur,
		 ba.pendek,
		 ba.istirahat,
		 ba.warna,
                 ba.kode_jam_kerja",false);
        
        $this->db->from("jadwal_kerja_shift a");
        $this->db->from("jadwal_kerja_shift_detail b");
        
        $this->db->join("jam_kerja ba","b.id_jam_kerja = ba.id_jam_kerja","left");
        
        $this->db->where("a.id_jadwal = b.id_jadwal_shift
		and a.id_jadwal = '$jadwal_id'
		and (b.tanggal_shift between '$dateStart' and '$dateEnd')",NULL,false);
        
        $this->db->order_by("b.tanggal_shift","asc");
        
        $dataS = $this->db->get()->result();
        
        foreach($dataS as $data)
        {
            $ret[$data->tanggal_shift] = array(
                        "tanggal" =>$data->tanggal_shift,
                        "jam_masuk" =>$data->jam_masuk,
                        "jam_pulang" =>$data->jam_pulang,
                        "libur" =>$data->libur,
                        "pendek" =>$data->pendek,
                        "istirahat"=>$data->istirahat,
                        "warna"=>$data->istirahat,
                        "kode"=>$data->kode_jam_kerja
                    );
        }
        
        return $ret;
    }
    
    function jadwal_absen_manual($person_id, $dateStart, $dateEnd)
    {
        $ret = array();
        
        $this->db->select("b.tanggal,
		 ba.jam_masuk,
		 ba.jam_pulang,
		 ba.libur,
		 ba.pendek,
		 ba.istirahat,
		 ba.warna,
                 ba.kode_jam_kerja",false);
        
        $this->db->from("jadwal_kerja_manual a");
        $this->db->from("jadwal_kerja_manual_detail b");
        
        $this->db->join("jam_kerja ba","b.id_jam_kerja = ba.id_jam_kerja","left");
        
        $this->db->where("a.id_jadwal = b.id_jadwal_manual
		and a.person_id = '$person_id'
                and b.hapus='1'
		and (b.tanggal between '$dateStart' and '$dateEnd')",NULL,false);
        
        $this->db->order_by("b.tanggal","asc");
        
        $dataS = $this->db->get()->result();
        
        foreach($dataS as $data)
        {
            $ret[$data->tanggal] = array(
                        "tanggal" =>$data->tanggal,
                        "jam_masuk" =>$data->jam_masuk,
                        "jam_pulang" =>$data->jam_pulang,
                        "libur" =>$data->libur,
                        "pendek" =>$data->pendek,
                        "istirahat"=>$data->istirahat,
                        "warna"=>$data->istirahat,
                        "kode"=>$data->kode_jam_kerja
                    );
        }
        
        return $ret;
    }
    
    private function alasan_karyawan($person_id, $date_start, $date_end)
    {
        $ret = array();
        
        $this->db->select("a.tanggal_transaksi, 
                            a.waktu, 
                            a.keterangan,
                            b.kode_alasan,
                            b.nama_alasan",false);
        
        $this->db->from("alasan_karyawan a,
                         alasan b");
        
        $this->db->where("a.id_alasan = b.id_alasan
                          and a.person_id = '$person_id'
                          and a.hapus='1'
                          and a.tanggal_transaksi between '$date_start' and '$date_end'", NULL, false);
        
        $this->db->order_by("a.tanggal_transaksi","asc");
        
        $dataS = $this->db->get()->result();
        
        foreach($dataS as $data)
        {
            $ret[$data->tanggal_transaksi] = array(
                "tanggal" => $data->tanggal_transaksi,
                "waktu" => $data->waktu,
                "keterangan" => $data->keterangan,
                "kode_alasan" => $data->kode_alasan,
                "nama_alasan" => $data->nama_alasan
            );
        }
        
        return $ret;
    }
    
    function laporan_karyawan($search)
    {
        $ret = array();
        
        if(!empty($search))
        {
            $this->db->where($search,NULL,FALSE);
        }
        
        $this->db->select("laporan_karyawan.*, orang.pin, orang.nik");
        
        $this->db->from("laporan_karyawan");
        $this->db->join("orang","laporan_karyawan.person_id=orang.person_id","LEFT");
        
//        $this->db->where();
        
        return $this->db->get();
    }
    
    function input_batch_laporan($arr)
    {
        if(!empty($arr) && is_array($arr) && count($arr))
        {
            $this->db->insert_batch("laporan_karyawan",$arr);
            
            return true;
        }
        
        return false;
    }
    
    function update_laporan($arr)
    {
        if(!empty($arr) && is_array($arr) && count($arr))
        {
            $arr['modified_by'] = $this->Mod_login->getSessionPersonId();
            $arr['modify_date'] = date('Y-m-d H:i:s');
            
            $this->db->where('tanggal',$arr['tanggal']);
            $this->db->where('person_id',$arr['person_id']);
            
            $this->db->update("laporan_karyawan",$arr);
            
            return true;
        }
        
        return false;
    }
}
