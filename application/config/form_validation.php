<?php

$config = array(
            'jam_kerja' => array(
                                array(
                                      'field'   => 'txtKodeJamKerja', 
                                      'label'   => 'Kode Jam Kerja', 
                                      'rules'   => 'trim|required|xss_clean'
                                   ),
                                array(
                                      'field'   => 'txtJamMasuk', 
                                      'label'   => 'Jam Masuk', 
                                      'rules'   => 'trim|required|xss_clean'
                                   ),
                                array(
                                      'field'   => 'txtJamPulang', 
                                      'label'   => 'Jam Pulang', 
                                      'rules'   => 'trim|required|xss_clean'
                                   ),   
                                array(
                                      'field'   => 'txtLibur', 
                                      'label'   => 'Libur', 
                                      'rules'   => 'required|is_natural'
                                   ),
                                array(
                                      'field'   => 'txtPendek', 
                                      'label'   => 'Pendek', 
                                      'rules'   => 'required|is_natural'
                                   ),
                                array(
                                      'field'   => 'txtIstirahat', 
                                      'label'   => 'Istirahat', 
                                      'rules'   => 'required|is_natural'
                                   ),
                                array(
                                      'field'   => 'txtWarna', 
                                      'label'   => 'Warna', 
                                      'rules'   => 'required'
                                   )
                ),
            'libur' => array(
                            array(
                                  'field'   => 'txtTanggalLibur', 
                                  'label'   => 'Tanggal', 
                                  'rules'   => 'trim|required'
                               ),
                            array(
                                  'field'   => 'txtKeteranganLibur', 
                                  'label'   => 'Keterangan', 
                                  'rules'   => 'trim|required'
                               )
            ),
            'karyawan' => array
                          (
                            array(
                                  'field'   => 'txtPin', 
                                  'label'   => 'PIN', 
                                  'rules'   => 'trim|required'
                               ),
                               array(
                                  'field'   => 'txtNik', 
                                  'label'   => 'NIK', 
                                  'rules'   => 'trim|required'
                               ),
                               array(
                                  'field'   => 'txtNamaKaryawan', 
                                  'label'   => 'Nama Karyawan', 
                                  'rules'   => 'trim|required'
                               ),
                               array(
                                  'field'   => 'cmbJabatan', 
                                  'label'   => 'Jabatan', 
                                  'rules'   => 'trim|required'
                               ),
                               array(
                                  'field'   => 'cmbDivisi', 
                                  'label'   => 'Divisi', 
                                  'rules'   => 'trim|required'
                               ),
                               array(
                                  'field'   => 'cmbStatus', 
                                  'label'   => 'Status Karyawan', 
                                  'rules'   => 'trim|required'
                               ),
                               array(
                                  'field'   => 'txtTglMasuk', 
                                  'label'   => 'Tanggal Masuk', 
                                  'rules'   => 'trim|required'
                               ),
                               array(
                                  'field'   => 'txtNoJamsostek', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNoAsuransi', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNoAkunBank', 
                                  'label'   => 'No Akun Bank', 
                                  'rules'   => 'trim|required'
                               ),
                               array(
                                  'field'   => 'txtNoNpwp', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTglNpwp', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtInvPerusahaan', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtJenisJadwal', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtKodeJadwal', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'cmbStatusKontrak', 
                                  'label'   => 'Status Kontrak', 
                                  'rules'   => 'trim|required'
                               ),
                               array(
                                  'field'   => 'txtTglAwalKontrak', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTglAkhirKontrak', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'cmbJenisKelamin', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTempatLahir', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTglLahir', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'cmbPendidikan', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTahunLulus', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'cmbAgama', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTlp', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtKtp', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTglKtp', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'cmbStatusMarital', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'cmbStatusRumah', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtAlamat', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtKota', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtKodePos', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtAlamatKtp', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtKotaKtp', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtKodePosKtp', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNamaSaudara', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtAlamatSaudara', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTlpSaudara', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNamaIstri', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTempatLahirIstri', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTglLahirIstri', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNoAsuransiIstri', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNamaAnak1', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTempatLahirAnak1', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTglLahirAnak1', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNoAsuransiAnak1', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNamaAnak2', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTempatLahirAnak2', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTglLahirAnak2', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNoAsuransiAnak2', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNamaAnak3', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTempatLahirAnak3', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtTglLahirAnak3', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNoAsuransiAnak3', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNamaAyah', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNamaIbu', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtAlamatOrangtua', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtKotaOrangtua', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNamaAyahMertua', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtNamaIbuMertua', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtAlamatMertua', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               ),
                               array(
                                  'field'   => 'txtKotaMertua', 
                                  'label'   => '', 
                                  'rules'   => 'trim'
                               )
                          ),
                'jadwalKerjaNormal' => array(
                                array(
                                      'field'   => 'txtKodeJadwalKerjaNormal', 
                                      'label'   => 'Kode Jadwal', 
                                      'rules'   => 'trim|required|callback_rolekey_exists'
                                   ),
                                array(
                                      'field'   => 'txtKeteranganJadwalKerjaNormal', 
                                      'label'   => 'Keterangan Jadwal', 
                                      'rules'   => 'trim'
                                   ),
                                array(
                                    'field'   => 'cmbSenin', 
                                    'label'   => 'Jadwal Senin', 
                                    'rules'   => 'trim|required'
                                 ),
                                 array(
                                    'field'   => 'cmbSelasa', 
                                    'label'   => 'Jadwal Selasa', 
                                    'rules'   => 'trim|required'
                                 ),
                                 array(
                                    'field'   => 'cmbRabu', 
                                    'label'   => 'Jadwal Rabu', 
                                    'rules'   => 'trim|required'
                                 ),
                                 array(
                                    'field'   => 'cmbKamis', 
                                    'label'   => 'Jadwal Kamis', 
                                    'rules'   => 'trim|required'
                                 ),
                                 array(
                                    'field'   => 'cmbJumat', 
                                    'label'   => "Jadwal Jum'at", 
                                    'rules'   => 'trim|required'
                                 ),
                                 array(
                                    'field'   => 'cmbSabtu', 
                                    'label'   => 'Jadwal Sabtu', 
                                    'rules'   => 'trim|required'
                                 ),
                                 array(
                                    'field'   => 'cmbMinggu', 
                                    'label'   => 'Jadwal Minggu', 
                                    'rules'   => 'trim|required'
                                 )
                            ),
                'jadwalKerjaNormalEdit' => array(
                                array(
                                      'field'   => 'txtKodeJadwalKerjaNormal', 
                                      'label'   => 'Kode Jadwal', 
                                      'rules'   => 'trim|required'
                                   ),
                                array(
                                      'field'   => 'txtKeteranganJadwalKerjaNormal', 
                                      'label'   => 'Keterangan Jadwal', 
                                      'rules'   => 'trim'
                                   ),
                                array(
                                    'field'   => 'cmbSenin', 
                                    'label'   => 'Jadwal Senin', 
                                    'rules'   => 'trim|required'
                                 ),
                                 array(
                                    'field'   => 'cmbSelasa', 
                                    'label'   => 'Jadwal Selasa', 
                                    'rules'   => 'trim|required'
                                 ),
                                 array(
                                    'field'   => 'cmbRabu', 
                                    'label'   => 'Jadwal Rabu', 
                                    'rules'   => 'trim|required'
                                 ),
                                 array(
                                    'field'   => 'cmbKamis', 
                                    'label'   => 'Jadwal Kamis', 
                                    'rules'   => 'trim|required'
                                 ),
                                 array(
                                    'field'   => 'cmbJumat', 
                                    'label'   => "Jadwal Jum'at", 
                                    'rules'   => 'trim|required'
                                 ),
                                 array(
                                    'field'   => 'cmbSabtu', 
                                    'label'   => 'Jadwal Sabtu', 
                                    'rules'   => 'trim|required'
                                 ),
                                 array(
                                    'field'   => 'cmbMinggu', 
                                    'label'   => 'Jadwal Minggu', 
                                    'rules'   => 'trim|required'
                                 )
                            ),
                'jadwalKerjaShift' => array(
                                array(
                                      'field'   => 'txtKodeJadwalKerjaShift', 
                                      'label'   => 'Kode Jadwal', 
                                      'rules'   => 'trim|required'
                                   ),
                                array(
                                      'field'   => 'txtKeteranganJadwalKerjaShift', 
                                      'label'   => 'Keterangan Jadwal', 
                                      'rules'   => 'trim'
                                   )
                            ),
                'jadwalKerjaManual' => array(
                                array(
                                      'field'   => 'txtPinKerjaManual', 
                                      'rules'   => 'trim|required'
                                   )
                            )
);
?>
