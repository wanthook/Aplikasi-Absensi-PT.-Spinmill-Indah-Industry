<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

/**
 * Description of login
 *
 * @author taufiq
 */
class Karyawan extends Secure_area
{
    private $limit = 25;
    private $typePage = 'karyawan';
    private $titleForm = 'Form Master Karyawan';
    private $actionUrl = 'karyawan';
    
    private $tblHead = array('PIN', 'NIK', 'Kartu', 'Nama Karyawan', 'Jabatan', 'Divisi', 'Status Karyawan', 'Modifikasi Terakhir', 'Aksi');
    
    private $tmpl = array (
                    'table_open'          => '<table class="table table-bordered tablesorter" id="tblKaryawan">',
                    
                    'thead_open'          => '<thead>',
                    'thead_close'         => '</thead>',
            
                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',
                    
                    'tbody_open'          => '<tbody>',
                    'tbody_close'         => '</tbody>',
            
                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );
    
    private $header_exc = array('KARTU',
                            'PIN',
                            'NIK',
                            'Nama Karyawan',
                            'Kode Jabatan',
                            'Kode Divisi',                            
                            'Alamat',
                            'Kota',
                            'Kode pos',
                            'Alamat KTP',
                            'Kota KTP',
                            'Kode pos KTP',
                            'Nomor Telepon',
                            'Tgl Lahir(YYYY-MM-DD)',
                            'Tempat Lahir',
                            'Jenis Kelamin(L/P)',
                            'Status(A/N)',
                            'Tgl Status(YYYY-MM-DD)',
                            'Status Menikah(Y/N)',
                            'Nomor Jamsostek',
                            'Nomor Asuransi',
                            'Nomor Bank',
                            'Nomor NPWP',
                            'Tgl NPWP',
                            'Inventaris Perusahaan',
                            'Pendidikan(1-6)',
                            'Tahun Lulus(YYYY)',
                            'Agama(1-6)',
                            'Nomor KTP',
                            'Tgl KTP Berlaku(YYYY-MM-DD)',
                            'Status Rumah(1-4)',
                            'Nama Saudara',
                            'Alamat Saudara',
                            'Nomor Telepon Saudara',
                            'Nama Istri Karyawan',
                            'Tempat Lahir Istri',
                            'Tgl Lahir Istri(YYYY-MM-DD)',
                            'Nomor Asuransi Istri',
                            'Nama Anak Pertama',
                            'Tempat Lahir Anak Pertama',
                            'Tgl Lahir Anak Pertama(YYYY-MM-DD)',
                            'Nomor Asuransi Anak Pertama',
                            'Nama Anak Kedua',
                            'Tempat Lahir Anak Kedua',
                            'Tgl Lahir Anak Kedua(YYYY-MM-DD)',
                            'Nomor Asuransi Anak Kedua',
                            'Nama Anak Ketiga',
                            'Tempat Lahir Anak Ketiga',
                            'Tgl Lahir Anak Ketiga(YYYY-MM-DD)',
                            'Nomor Asuransi Anak Ketiga',
                            'Nama Ayah',
                            'Nama Ibu',
                            'Alamat Orang Tua',
                            'Kota Orang tua',
                            'Nama Ayah Mertua',
                            'Nama Ibu Mertua',
                            'Alamat Mertua',
                            'Kota Mertua',
                            'JenisJad(N/S)',
                            'KdJad',
                            'Karyawan Sementara(Y/N)',
                            'Tgl Awal Kontrak(YYYY-MM-DD)',
                            'Tgl Akhir Kontrak(YYYY-MM-DD)',
                            'Status Kontrak(Y/N)'
            );
    
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model("Mod_jabatan");
        $this->load->model("Mod_divisi");
    }
    
    function index()
    {
        $this->table();
    }   
    
    function table($search="",$ofset = 0)
    {
        // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        
        // load data
        $datas = $this->Mod_karyawan->get_paged_list_active($this->limit, $offset,$search)->result();
        
//        print_r($this->Mod_karyawan->get_paged_list_active($this->limit, $offset,$search)->row());
        
         // generate pagination
        $config['base_url'] = site_url($this->typePage.'/index/');
        $config['total_rows'] = $this->Mod_karyawan->count_all_active($search);
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        
        $config['cur_tag_open'] = '<li class="disabled"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        // generate table data
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading($this->tblHead);
        
        $this->table->set_template($this->tmpl);
//        print_r($datas);
        $i = 0 + $offset;
        foreach ($datas as $row)
        {            
            $this->table->add_row(
                    $row->pin, 
                    $row->nik,
                    $row->kartu,
                    $row->nama_karyawan,
                    $row->nama_jabatan,
                    $row->nama_divisi,
                    (($row->id_status=='A')?'Aktif':'Tidak Aktif'),
                    date('d-m-Y H:i:s', strtotime($row->modify_date)), 
//                anchor($this->typePage.'/view/'.$row->id_jam_kerja,'<span class="glyphicon glyphicon-file"></span>&nbsp;Lihat',array('class'=>'btn btn-primary btn-xs')).' '.
                anchor($this->typePage.'/update/'.$row->person_id,'<span class="glyphicon glyphicon-pencil"></span>&nbsp;Ubah',array('class'=>'btn btn-warning btn-xs')).' '.
                anchor($this->typePage.'/delete/'.$row->person_id,'<span class="glyphicon glyphicon-remove"></span>&nbsp;Hapus',array('class'=>'btn btn-danger btn-xs','onclick'=>"return confirm('".$this->lang->line("common_delete")."')"))
            );
        }
        
        if(empty($datas))
        {
            $this->table->add_row(array('data' => 'Data tidak ada', 'colspan' => 8, 'align'=> 'center'));
        }
        
        $data['table'] = $this->table->generate();
        
        // load view
        $this->load->view('karyawan/tabel', $data);
    }
    
    function search()
    {
        $where = "";

        //txtSearch
        $txtSearch = $this->input->post('txtSearch');
        
        //txtSearch
        $cmbJabatan = $this->input->post('cmbJabatan');
        
        //txtSearch
        $cmbDivisi = $this->input->post('cmbDivisi');
        
        
        if(!empty($txtSearch))
            $where .= "(pin like '%$txtSearch%' or nik like '%$txtSearch%' or nama_karyawan like '%$txtSearch%')";
        if(!empty($cmbJabatan))
        {
            if(!empty($where))
                $where .= " and id_jabatan='$where'";
            else
                $where .= " id_jabatan='$where'";
        }
        if(!empty($cmbDivisi))
        {
            if(!empty($where))
                $where .= " and id_divisi='$where'";
            else
                $where .= " id_divisi='$where'";
        }
        
        $this->table($where);
    }
    
    function add($message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->actionUrl.'/save';
        $data['idForm'] = "formMasterKaryawan";
        $data['button'] = "Simpan";
        $data['button_icon'] = "glyphicon-plus-sign";
        $data['message'] = $message;
        
        $this->load->view('karyawan/form',$data);
    }
    
    function form_upload($message = "")
    {
        $data['title'] = "Form Upload Karyawan Manual";
        $data['action'] = $this->actionUrl.'/do_upload';
        $data['idForm'] = "formUploadKaryawanManual";
        $data['button'] = "Simpan";
        $data['button_icon'] = "glyphicon-plus-sign";
        $data['message'] = $message;
        
        $this->load->view($this->actionUrl.'/form_upload',$data);
    }
    
    function do_upload()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'application/vnd.ms-office';
        $config['max_size']	= '0';
        $config['overwrite'] = true;

        $this->load->library('upload', $config);
        
        $this->upload->initialize($config);
        
        $this->upload->set_allowed_types('*');
        
        $msg = '';
        
        if (!$this->upload->do_upload('txtUploadFile')) 
        {
            $msg = $this->upload->display_errors();

        } 
        else 
        { //else, set the success message
            $msgs = $this->upload->data();
            
            $msg = $this->do_import($msgs['file_name']);
//            print_r($msgs);
        }
        
        $this->form_upload($msg);
    }
    
    private function do_import($file_name)
    {
        $table_name = 'tblMastKarTest';
        
//        $dbMssql = $this->load->database('mssql',true);
        $this->load->helper('date');
        
        $this->load->library('excel');
        
        $objR = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objR->load('./uploads/'.$file_name);
        
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,false);
//        print_r($sheetData);
        $arr_batch = array();
        $arr_ins = array();
        
        for($i=0 ; $i<count($sheetData) ; $i++)
        {
            if($i==0)
            {
                /*
                 * update by wanthook
                 * warning type : Undefined offset: 65
                 * error target : if(trim($sheetData[$i][$j])==$this->header_exc[$j])
                 */
                for($j=0; $j<count($this->header_exc) ; $j++)
                {
                    if(trim($sheetData[$i][$j])==$this->header_exc[$j])
                        continue;
                    else
                        return "Header tidak sama pada ".$this->header_exc[$j];
                }
                continue;
                
            }
            
            if(!isset($sheetData[$i][1]) || empty($sheetData[$i][1]))
            {
                break;
            }
            
//          Cek apakah pin sudah ada apa belum
//            $res = $dbMssql->get_where($table_name,array('PIN'=>$sheetData[$i][0]),1);
            $res = $this->Mod_karyawan->get_paged_list(1,0,"pin='".$sheetData[$i][1]."'")->num_rows();
            
            //kalo tanggal ama pin gak ada, maka gak ada kemungkinan duplikasi
            if($res==0)
            {
                $sheetData[$i][5]."<br>";
                $id_jabatan = $this->Mod_jabatan->get_paged_list_active(1,0,"kode_jabatan='".$sheetData[$i][4]."'")->row();
                $id_divisi = $this->Mod_divisi->get_paged_list_active(1,0,"kode_divisi='".$sheetData[$i][5]."'")->row();
//                $id_pendidikan = $this->Mod_pendidikan->get_paged_list_active(1,0,"kode_pendidikan='".$sheetData[$i][26]."'")->row();
                
                $arr_batch = array(
                    'kartu' =>$sheetData[$i][0],
                    'pin' =>$sheetData[$i][1],
                    'nik' =>$sheetData[$i][2],
                    'nama_karyawan' =>strtoupper($sheetData[$i][3]),
                    'id_jabatan' =>$id_jabatan->id_jabatan, //perlu fungsi
                    'id_divisi' =>$id_divisi->id_divisi, //perlu fungsi
                    'no_jamsostek' =>$sheetData[$i][19],
                    'no_asuransi' =>$sheetData[$i][20],
                    'no_bank' =>$sheetData[$i][21],
                    'no_npwp' =>$sheetData[$i][22],
                    'tgl_npwp' =>$this->fungsi->convertDate($sheetData[$i][23],'Y-m-d'),
                    'inv_perusahaan' =>$sheetData[$i][24],
                    'id_pendidikan' =>$sheetData[$i][25], //perlu fungsi
                    'tahun_lulus' =>$sheetData[$i][26],
                    'id_agama' =>$sheetData[$i][27], //perlu fungsi
                    'no_ktp' =>$sheetData[$i][28],
                    'ktp_berlaku' =>$this->fungsi->convertDate($sheetData[$i][29],'Y-m-d'),
                    'id_status_rumah' =>$sheetData[$i][30], //perlu fungsi
                    'nama_saudara' =>strtoupper($sheetData[$i][31]), 
                    'alamat_saudara' =>strtoupper($sheetData[$i][32]),
                    'no_tlp_saudara' =>$sheetData[$i][33],
                    'alamat' =>strtoupper($sheetData[$i][6]),
                    'kota' =>strtoupper($sheetData[$i][7]),
                    'kode_pos' =>$sheetData[$i][8],
                    'alamat_ktp' =>$sheetData[$i][9],
                    'kota_ktp' =>$sheetData[$i][10],
                    'kode_pos_ktp' =>$sheetData[$i][11],
                    'no_tlp' =>$sheetData[$i][12],
                    'tanggal_lahir' =>$this->fungsi->convertDate($sheetData[$i][13],'Y-m-d'),
                    'tempat_lahir' =>strtoupper($sheetData[$i][14]),
                    'id_jenkel' =>strtoupper($sheetData[$i][15]), //perlu fungsi
                    'id_status' =>  $this->statPerson(strtoupper($sheetData[$i][16])),
                    'tgl_masuk' =>$this->fungsi->convertDate($sheetData[$i][17],'Y-m-d'),
                    'id_marital' =>strtoupper($sheetData[$i][18]),
                    'nama_istri' =>strtoupper($sheetData[$i][34]),
                    'tempat_lahir_istri' =>strtoupper($sheetData[$i][35]),
                    'tanggal_lahir_istri' =>$this->fungsi->convertDate($sheetData[$i][36],'Y-m-d'),
                    'no_asuransi_istri' =>$sheetData[$i][37],
                    'nama_anak_1' =>strtoupper($sheetData[$i][38]),
                    'tempat_lahir_anak_1' =>strtoupper($sheetData[$i][39]),
                    'tanggal_lahir_anak_1' =>$this->fungsi->convertDate($sheetData[$i][40],'Y-m-d'),
                    'no_asurasi_anak_1' =>$sheetData[$i][41],
                    'nama_anak_2' =>strtoupper($sheetData[$i][42]),
                    'tempat_lahir_anak_2' =>strtoupper($sheetData[$i][43]),
                    'tanggal_lahir_anak_2' =>$this->fungsi->convertDate($sheetData[$i][44],'Y-m-d'),
                    'no_asuransi_anak_2' =>$sheetData[$i][45],
                    'nama_anak_3' =>strtoupper($sheetData[$i][46]),
                    'tempat_lahir_anak_3' =>strtoupper($sheetData[$i][47]),
                    'tanggal_lahir_anak_3' =>$this->fungsi->convertDate($sheetData[$i][48],'Y-m-d'),
                    'no_asuransi_anak_3' =>$sheetData[$i][49],
                    'nama_ayah' =>strtoupper($sheetData[$i][50]),
                    'nama_ibu' =>strtoupper($sheetData[$i][51]),
                    'alamat_orangtua' =>strtoupper($sheetData[$i][52]),
                    'kota_orangtua' =>strtoupper($sheetData[$i][53]),
                    'nama_ayah_mertua' =>strtoupper($sheetData[$i][54]),
                    'nama_ibu_mertua' =>strtoupper($sheetData[$i][55]),
                    'alamat_mertua' =>strtoupper($sheetData[$i][56]),
                    'kota_mertua' =>strtoupper($sheetData[$i][57]),
                    'jenis_jadwal' =>strtoupper($sheetData[$i][58]),
                    'kode_jadwal' =>strtoupper($sheetData[$i][59]),
                    'custom_1' =>strtoupper($sheetData[$i][60]), //kar_temp
                    'created_by' => $this->Mod_login->getSessionPersonId(),
                    'create_date' => date("Y-m-d H:i:s"),
                    'modified_by' => $this->Mod_login->getSessionPersonId(),
                    'modify_date' => date("Y-m-d H:i:s"),
                    'tgl_awal_kontrak' =>$this->fungsi->convertDate($sheetData[$i][61],'Y-m-d'),
                    'tgl_akhir_kontrak' =>$this->fungsi->convertDate($sheetData[$i][62],'Y-m-d'),
                    'id_status_kontrak' => $sheetData[$i][63] //($sheetData[$i][63]=='Y'?'1':'0')
                );
                
                $arr_ins[] = $arr_batch;
            }
        }
        if(!empty($arr_ins) && is_array($arr_ins))
        {
            $this->Mod_karyawan->insert_batch($arr_ins);

            return "Upload Berhasil";
        }

        return "Tidak Ada Data Yang Di Upload";
    }
    
    function success()
    {
        $message = '<div class="alert alert-success">'.$this->lang->line('common_save').'</div>';
        
        $this->add($message);
    }
    
    
    function save()
    {
        $this->_set_rules();
        
        if ($this->form_validation->run('karyawan') == FALSE)
        {
            $message = '';
            $this->add($message);
        }
        else
        {
            $data = $this->_set_data();
            
            $id = $this->Mod_karyawan->save($data);
            
            redirect('karyawan/success');
                        
        }
        
        
    }
    
    function update($id,$message = "")
    {
        $data['title'] = $this->titleForm;
        $data['action'] = $this->actionUrl.'/edit/'.$id;
        $data['idForm'] = "formMasterKaryawan";
        $data['button'] = "Ubah";
        $data['button_icon'] = "glyphicon-pencil";
        
        $edit_data = $this->Mod_karyawan->get_by_id_active($id)->row_array();
        $dataSet = $this->_set_data($edit_data);
        
        $data = array_merge($data,$dataSet);
//        print_r($data);
        if(!empty($message))
        {
            $data['message'] = $message;
        }
        
        $this->load->view('karyawan/form',$data);
    }
            
    function edit($id)
    {
        $this->_set_rules();
        
        if ($this->form_validation->run('karyawan') == FALSE)
        {
            $message = '';
            $this->update($id,$message);
        }
        else
        {
            $data = $this->_set_data();
            
            $update = $this->Mod_karyawan->update($id,$data);
            
            $message = '<div class="alert alert-success">'.$this->lang->line('common_edit').'</div>';
        
            $this->update($id,$message);
            
                        
        }
    }
    
    function delete($id)
    {
        $this->Mod_karyawan->delete($id);
        
        redirect('karyawan');
    }
    
    function _set_data($param="")
    {
        if(!empty($param))
        {
//            print_r($param);
            $data['txtPin'] = $param['pin'];
            $data['txtNik'] = $param['nik'];
            $data['txtKartu'] = $param['kartu'];
            $data['txtNamaKaryawan'] = $param['nama_karyawan'];
            $data['cmbJabatan'] = $param['id_jabatan'];
            $data['cmbDivisi'] = $param['id_divisi'];
            $data['cmbStatus'] = $param['id_status'];
            $data['txtTglMasuk'] = $this->fungsi->convertDate($param['tgl_masuk'],'d-m-Y');
            $data['txtNoJamsostek'] = $param['no_jamsostek'];
            $data['txtNoAsuransi'] = $param['no_asuransi'];
            $data['txtNoAkunBank'] = $param['no_bank'];
            $data['txtNoNpwp'] = $param['no_npwp'];
            $data['txtTglNpwp'] = $this->fungsi->convertDate($param['tgl_npwp'],'d-m-Y');
            $data['txtInvPerusahaan'] = $param['inv_perusahaan'];
            $data['txtJenisJadwal'] = $param['jenis_jadwal'];
            $data['txtKodeJadwal'] = $param['kode_jadwal'];
            $data['cmbStatusKontrak'] = $param['id_status_kontrak'];
            $data['txtTglAwalKontrak'] = $this->fungsi->convertDate($param['tgl_awal_kontrak'],'d-m-Y');
            $data['txtTglAkhirKontrak'] = $this->fungsi->convertDate($param['tgl_akhir_kontrak'],'d-m-Y');
            $data['cmbJenisKelamin'] = $param['id_jenkel'];
            $data['txtTempatLahir'] = $param['tempat_lahir'];
            $data['txtTglLahir'] = $this->fungsi->convertDate($param['tanggal_lahir'],'d-m-Y');
            $data['cmbPendidikan'] = $param['id_pendidikan'];
            $data['txtTahunLulus'] = $param['tahun_lulus'];
            $data['cmbAgama'] = $param['id_agama'];
            $data['txtTlp'] = $param['no_tlp'];
            $data['txtKtp'] = $param['no_ktp'];
            $data['txtTglKtp'] = $param['ktp_berlaku'];
            $data['cmbStatusMarital'] = $param['id_marital'];
            $data['cmbStatusRumah'] = $param['id_status_rumah'];
            $data['txtAlamat'] = $param['alamat'];
            $data['txtKota'] = $param['kota'];
            $data['txtKodePos'] = $param['kode_pos'];
            $data['txtAlamatKtp'] = $param['alamat_ktp'];
            $data['txtKotaKtp'] = $param['kota_ktp'];
            $data['txtKodePosKtp'] = $param['kode_pos_ktp'];
            $data['txtNamaSaudara'] = $param['nama_saudara'];
            $data['txtAlamatSaudara'] = $param['alamat_saudara'];
            $data['txtTlpSaudara'] = $param['no_tlp_saudara'];
            $data['txtNamaIstri'] = $param['nama_istri'];
            $data['txtTempatLahirIstri'] = $param['tempat_lahir_istri'];
            $data['txtTglLahirIstri'] = $this->fungsi->convertDate($param['tanggal_lahir_istri'],'d-m-Y');
            $data['txtNoAsuransiIstri'] = $param['no_asuransi_istri'];
            $data['txtNamaAnak1'] = $param['nama_anak_1'];
            $data['txtTempatLahirAnak1'] = $param['tempat_lahir_anak_1'];
            $data['txtTglLahirAnak1'] = $this->fungsi->convertDate($param['tanggal_lahir_anak_1'],'d-m-Y');
            $data['txtNoAsuransiAnak1'] = $param['no_asurasi_anak_1'];
            $data['txtNamaAnak2'] = $param['nama_anak_2'];
            $data['txtTempatLahirAnak2'] = $param['tempat_lahir_anak_2'];
            $data['txtTglLahirAnak2'] = $this->fungsi->convertDate($param['tanggal_lahir_anak_2'],'d-m-Y');
            $data['txtNoAsuransiAnak2'] = $param['no_asuransi_anak_2'];
            $data['txtNamaAnak3'] = $param['nama_anak_3'];
            $data['txtTempatLahirAnak3'] = $param['tempat_lahir_anak_3'];
            $data['txtTglLahirAnak3'] = $this->fungsi->convertDate($param['tanggal_lahir_anak_3'],'d-m-Y');
            $data['txtNoAsuransiAnak3'] = $param['no_asuransi_anak_3'];
            $data['txtNamaAyah'] = $param['nama_ayah'];
            $data['txtNamaIbu'] = $param['nama_ibu'];
            $data['txtAlamatOrangtua'] = $param['alamat_orangtua'];
            $data['txtKotaOrangtua'] = $param['kota_orangtua'];
            $data['txtNamaAyahMertua'] = $param['nama_ayah_mertua'];
            $data['txtNamaIbuMertua'] = $param['nama_ibu_mertua'];
            $data['txtAlamatMertua'] = $param['alamat_mertua'];
            $data['txtKotaMertua'] = $param['kota_mertua'];

            
            return $data;
        }
        
        $data['pin'] = $this->input->post('txtPin');
        $data['nik'] = $this->input->post('txtNik');
        $data['kartu'] = $this->input->post('txtKartu');
        $data['nama_karyawan'] = $this->input->post('txtNamaKaryawan');
        $data['id_jabatan'] = $this->input->post('cmbJabatan');
        $data['id_divisi'] = $this->input->post('cmbDivisi');
        $data['id_status'] = $this->input->post('cmbStatus');
        $data['tgl_masuk'] = $this->fungsi->convertDate($this->input->post('txtTglMasuk'),'Y-m-d');
        $data['no_jamsostek'] = $this->input->post('txtNoJamsostek');
        $data['no_asuransi'] = $this->input->post('txtNoAsuransi');
        $data['no_bank'] = $this->input->post('txtNoAkunBank');
        $data['no_npwp'] = $this->input->post('txtNoNpwp');
        $data['tgl_npwp'] = $this->fungsi->convertDate($this->input->post('txtTglNpwp'),'Y-m-d');
        $data['inv_perusahaan'] = $this->input->post('txtInvPerusahaan');
        $data['jenis_jadwal'] = $this->input->post('txtJenisJadwal');
        $data['kode_jadwal'] = $this->input->post('txtKodeJadwal');
        $data['id_status_kontrak'] = $this->input->post('cmbStatusKontrak');
        $data['tgl_awal_kontrak'] = $this->fungsi->convertDate($this->input->post('txtTglAwalKontrak'),'Y-m-d');
        $data['tgl_akhir_kontrak'] = $this->fungsi->convertDate($this->input->post('txtTglAkhirKontrak'),'Y-m-d');
        $data['id_jenkel'] = $this->input->post('cmbJenisKelamin');
        $data['tempat_lahir'] = $this->input->post('txtTempatLahir');
        $data['tanggal_lahir'] = $this->fungsi->convertDate($this->input->post('txtTglLahir'),'Y-m-d');
        $data['id_pendidikan'] = $this->input->post('cmbPendidikan');
        $data['tahun_lulus'] = $this->input->post('txtTahunLulus');
        $data['id_agama'] = $this->input->post('cmbAgama');
        $data['no_tlp'] = $this->input->post('txtTlp');
        $data['no_ktp'] = $this->input->post('txtKtp');
        $data['ktp_berlaku'] = $this->fungsi->convertDate($this->input->post('txtTglKtp'),'Y-m-d');
        $data['id_marital'] = $this->input->post('cmbStatusMarital');
        $data['id_status_rumah'] = $this->input->post('cmbStatusRumah');
        $data['alamat'] = $this->input->post('txtAlamat');
        $data['kota'] = $this->input->post('txtKota');
        $data['kode_pos'] = $this->input->post('txtKodePos');
        $data['alamat_ktp'] = $this->input->post('txtAlamatKtp');
        $data['kota_ktp'] = $this->input->post('txtKotaKtp');
        $data['kode_pos_ktp'] = $this->input->post('txtKodePosKtp');
        $data['nama_saudara'] = $this->input->post('txtNamaSaudara');
        $data['alamat_saudara'] = $this->input->post('txtAlamatSaudara');
        $data['no_tlp_saudara'] = $this->input->post('txtTlpSaudara');
        $data['nama_istri'] = $this->input->post('txtNamaIstri');
        $data['tempat_lahir_istri'] = $this->input->post('txtTempatLahirIstri');
        $data['tanggal_lahir_istri'] = $this->fungsi->convertDate($this->input->post('txtTglLahirIstri'),'Y-m-d');
        $data['no_asuransi_istri'] = $this->input->post('txtNoAsuransiIstri');
        $data['nama_anak_1'] = $this->input->post('txtNamaAnak1');
        $data['tempat_lahir_anak_1'] = $this->input->post('txtTempatLahirAnak1');
        $data['tanggal_lahir_anak_1'] = $this->fungsi->convertDate($this->input->post('txtTglLahirAnak1'),'Y-m-d');
        $data['no_asurasi_anak_1'] = $this->input->post('txtNoAsuransiAnak1');
        $data['nama_anak_2'] = $this->input->post('txtNamaAnak2');
        $data['tempat_lahir_anak_2'] = $this->input->post('txtTempatLahirAnak2');
        $data['tanggal_lahir_anak_2'] = $this->fungsi->convertDate($this->input->post('txtTglLahirAnak2'),'Y-m-d');
        $data['no_asuransi_anak_2'] = $this->input->post('txtNoAsuransiAnak2');
        $data['nama_anak_3'] = $this->input->post('txtNamaAnak3');
        $data['tempat_lahir_anak_3'] = $this->input->post('txtTempatLahirAnak3');
        $data['tanggal_lahir_anak_3'] = $this->fungsi->convertDate($this->input->post('txtTglLahirAnak3'),'Y-m-d');
        $data['no_asuransi_anak_3'] = $this->input->post('txtNoAsuransiAnak3');
        $data['nama_ayah'] = $this->input->post('txtNamaAyah');
        $data['nama_ibu'] = $this->input->post('txtNamaIbu');
        $data['alamat_orangtua'] = $this->input->post('txtAlamatOrangtua');
        $data['kota_orangtua'] = $this->input->post('txtKotaOrangtua');
        $data['nama_ayah_mertua'] = $this->input->post('txtNamaAyahMertua');
        $data['nama_ibu_mertua'] = $this->input->post('txtNamaIbuMertua');
        $data['alamat_mertua'] = $this->input->post('txtAlamatMertua');
        $data['kota_mertua'] = $this->input->post('txtKotaMertua');

        
        return $data;
    }
    
    // validation rules
    function _set_rules()
    {
        
        $this->form_validation->set_message('required', '%s Harus Diisi!!!');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }
    
    function sKaryawan()
    {
        $sKaryawan = array();
        
        if($this->input->get("q")!="")
        {
            $q = $this->input->get("q");
//            echo "(pin like '%$q%' or nama_karyawan like '%$q%')";
            
            $res = $this->Mod_karyawan->get_karyawan_list_jadwal("(pin like '%$q%' or nama_karyawan like '%$q%')")->result();
//            print_r($res);
            foreach($res as $resA)
            {
//                print_r($resA);
                $sKaryawan[] = array("id"=>$resA->person_id,"text"=>$resA->pin." - ".$resA->nama_karyawan);
            }
        }
        
        echo json_encode($sKaryawan);
        
    }
    
    function sJabatan()
    {
        $aJabatan = array();
        
        if($this->input->get("id")!="")
        {
            $q = $this->input->get("id");
            $res = $this->Mod_jabatan->get_by_id_active($q)->result();
        }
        else
        {
            $q = $this->input->get("q");
            
            $search = "kode_jabatan like '%".$q."%' or nama_jabatan like '%".$q."%'";
            
            $res = $this->Mod_jabatan->get_paged_list_active(10, 0, $search)->result();
        }
        
        
        
        foreach($res as $jabatans)
        {
            $aJabatan[] = array("id"=>$jabatans->id_jabatan,"text"=>$jabatans->kode_jabatan." - ".$jabatans->nama_jabatan);
        }
        
        echo json_encode($aJabatan);
    }
    
    function sDivisi()
    {
        $aDivisi = array();
        
        if($this->input->get("id")!="")
        {
            $q = $this->input->get("id");
            $res = $this->Mod_divisi->get_by_id_active($q)->result();
        }
        else
        {
            $q = $this->input->get("q");
            
            $search = "kode_divisi like '%".$q."%' or nama_divisi like '%".$q."%'";
            
            $res = $this->Mod_divisi->get_paged_list_active(10, 0, $search)->result();
        }
        
        foreach($res as $jabatans)
        {
            $aDivisi[] = array("id"=>$jabatans->id_divisi,"text"=>$jabatans->kode_divisi." - ".$jabatans->nama_divisi);
        }
        
        echo json_encode($aDivisi);
    }
    
    function sPendidikan()
    {
        $aRet = array();
        
        if($this->input->get("id")!="")
        {
            $q = $this->input->get("id");
            $res = $this->Mod_pendidikan->get_by_id_active($q)->result();
        }
        else
        {
            $q = $this->input->get("q");
            
            $search = "kode_pendidikan like '%".$q."%' or nama_pendidikan like '%".$q."%'";
            
            $res = $this->Mod_pendidikan->get_paged_list_active(10, 0, $search,"id_pendidikan")->result();
        }
        
        foreach($res as $ress)
        {
            $aRet[] = array("id"=>$ress->id_pendidikan,"text"=>$ress->kode_pendidikan." - ".$ress->nama_pendidikan);
        }
        
        echo json_encode($aRet);
    }
    
    function sAgama()
    {
        $aRet = array();
        
        if($this->input->get("id")!="")
        {
            $q = $this->input->get("id");
            $res = $this->Mod_agama->get_by_id_active($q)->result();
        }
        else
        {
            $q = $this->input->get("q");
            $res = $this->Mod_agama->get_paged_list_active(10, 0, $q)->result();
        }
        
        foreach($res as $ress)
        {
            $aRet[] = array("id"=>$ress->id_agama,"text"=>$ress->nama_agama);
        }
        
        echo json_encode($aRet);
    }
    
    private function statPerson($str)
    {
        if($str=="A")
            return 'A';
        else if($str=="N")
            return 'N';
        
        return 0;
    }
}

?>
