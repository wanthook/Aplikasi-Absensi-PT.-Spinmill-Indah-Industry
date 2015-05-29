<?php $this->load->view("page/header"); 

if(!isset($txtPin))
{
    
    $txtPin = set_value('txtPin');
    $txtNik = set_value('txtNik');
    $txtKartu = set_value('txtKartu');
    $txtNamaKaryawan = set_value('txtNamaKaryawan');
    $cmbJabatan = set_value('cmbJabatan');
    $cmbDivisi = set_value('cmbDivisi');
    $cmbStatus = set_value('cmbStatus');
    $txtTglMasuk = set_value('txtTglMasuk');
    $txtNoJamsostek = set_value('txtNoJamsostek');
    $txtNoAsuransi = set_value('txtNoAsuransi');
    $txtNoAkunBank = set_value('txtNoAkunBank');
    $txtNoNpwp = set_value('txtNoNpwp');
    $txtTglNpwp = set_value('txtTglNpwp');
    $txtInvPerusahaan = set_value('txtInvPerusahaan');
    $txtJenisJadwal = set_value('txtJenisJadwal');
    $txtKodeJadwal = set_value('txtKodeJadwal');
    $cmbStatusKontrak = set_value('cmbStatusKontrak');
    $txtTglAwalKontrak = set_value('txtTglAwalKontrak');
    $txtTglAkhirKontrak = set_value('txtTglAkhirKontrak');
    $cmbJenisKelamin = set_value('cmbJenisKelamin');
    $txtTempatLahir = set_value('txtTempatLahir');
    $txtTglLahir = set_value('txtTglLahir');
    $cmbPendidikan = set_value('cmbPendidikan');
    $txtTahunLulus = set_value('txtTahunLulus');
    $cmbAgama = set_value('cmbAgama');
    $txtTlp = set_value('txtTlp');
    $txtKtp = set_value('txtKtp');
    $txtTglKtp = set_value('txtTglKtp');
    $cmbStatusMarital = set_value('cmbStatusMarital');
    $cmbStatusRumah = set_value('cmbStatusRumah');
    $txtAlamat = set_value('txtAlamat');
    $txtKota = set_value('txtKota');
    $txtKodePos = set_value('txtKodePos');
    $txtAlamatKtp = set_value('txtAlamatKtp');
    $txtKotaKtp = set_value('txtKotaKtp');
    $txtKodePosKtp = set_value('txtKodePosKtp');
    $txtNamaSaudara = set_value('txtNamaSaudara');
    $txtAlamatSaudara = set_value('txtAlamatSaudara');
    $txtTlpSaudara = set_value('txtTlpSaudara');
    $txtNamaIstri = set_value('txtNamaIstri');
    $txtTempatLahirIstri = set_value('txtTempatLahirIstri');
    $txtTglLahirIstri = set_value('txtTglLahirIstri');
    $txtNoAsuransiIstri = set_value('txtNoAsuransiIstri');
    $txtNamaAnak1 = set_value('txtNamaAnak1');
    $txtTempatLahirAnak1 = set_value('txtTempatLahirAnak1');
    $txtTglLahirAnak1 = set_value('txtTglLahirAnak1');
    $txtNoAsuransiAnak1 = set_value('txtNoAsuransiAnak1');
    $txtNamaAnak2 = set_value('txtNamaAnak2');
    $txtTempatLahirAnak2 = set_value('txtTempatLahirAnak2');
    $txtTglLahirAnak2 = set_value('txtTglLahirAnak2');
    $txtNoAsuransiAnak2 = set_value('txtNoAsuransiAnak2');
    $txtNamaAnak3 = set_value('txtNamaAnak3');
    $txtTempatLahirAnak3 = set_value('txtTempatLahirAnak3');
    $txtTglLahirAnak3 = set_value('txtTglLahirAnak3');
    $txtNoAsuransiAnak3 = set_value('txtNoAsuransiAnak3');
    $txtNamaAyah = set_value('txtNamaAyah');
    $txtNamaIbu = set_value('txtNamaIbu');
    $txtAlamatOrangtua = set_value('txtAlamatOrangtua');
    $txtKotaOrangtua = set_value('txtKotaOrangtua');
    $txtNamaAyahMertua = set_value('txtNamaAyahMertua');
    $txtNamaIbuMertua = set_value('txtNamaIbuMertua');
    $txtAlamatMertua = set_value('txtAlamatMertua');
    $txtKotaMertua = set_value('txtKotaMertua');

}
?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $title;?></div>
            <div class="panel-body"> 
                
                <?php
                echo form_open( $action, 'class="form-horizontal" method="post" id="'.$idForm.'" role="form"');
//                echo form_input(array('type'=>'hidden', 'name'=>'txtId','id'=>'txtId','value'=>$id));
                ?>
                <ul class="nav nav-tabs" id="tabMasterKaryawan">
                    <li class="active"><a href="#dataperusahaan" data-toggle="tab">Data Perusahaan</a></li>
                    <li class="dropdown">
                        <a href="#datapribadi" class="dropdown-toggle" data-toggle="dropdown">Data Pribadi <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#pribadi" tabindex="-1" data-toggle="tab">Pribadi</a></li>  
                            <li><a href="#keluarga" tabindex="-1" data-toggle="tab">Keluarga</a></li>
                            <li><a href="#orangtua" tabindex="-1" data-toggle="tab">Orang Tua</a></li>
                        </ul>
                    </li>
                </ul>
                
                <div class="tab-content">                    
                    <!--Tab content form master data perusahaan-->
                    <div class="tab-pane active" id="dataperusahaan">
                        <br>
                        <fieldset class="scheduler-border">
                            <legend>Data Perusahaan</legend>
                            
                            <!--pin-->
                            <div class="form-group">
                                <label for="txtPin" class="col-sm-2 control-label label-danger">PIN</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtPin" name="txtPin" value="<?php echo $txtPin; ?>" placeholder="PIN" style="width:200px">
                                </div>
                            </div>

                            <!--nik-->
                            <div class="form-group">
                                <label for="txtNik" class="col-sm-2 control-label label-danger">NIK</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtNik" name="txtNik" value="<?php echo $txtNik; ?>" placeholder="NIK" style="width:200px">
                                </div>
                            </div>
                            
                            <!--kartu-->
                            <div class="form-group">
                                <label for="txtKartu" class="col-sm-2 control-label label-danger">Kartu</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtKartu" name="txtKartu" value="<?php echo $txtKartu; ?>" placeholder="KARTU" style="width:200px">
                                </div>
                            </div>
                            
                            <!--nama karyawan-->
                            <div class="form-group">
                                <label for="txtNamaKaryawan" class="col-sm-2 control-label label-danger">Nama Karyawan</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtNamaKaryawan" name="txtNamaKaryawan" value="<?php echo $txtNamaKaryawan; ?>" placeholder="NamaKaryawan">
                                </div>
                            </div>

                            <!--jabatan-->
                            <div class="form-group">
                                <label for="cmbJabatan" class="col-sm-2 control-label label-danger">Jabatan</label>
                                <div class="col-sm-10">
                                  <input type="hidden" name="cmbJabatan" id="cmbJabatan" value="<?php echo $cmbJabatan; ?>" style="width:250px">
                                </div>
                            </div>

                            <!--divisi-->
                            <div class="form-group">
                                <label for="cmbDivisi" class="col-sm-2 control-label label-danger">Divisi</label>
                                <div class="col-sm-10">
                                  <input type="hidden" name="cmbDivisi" id="cmbDivisi" value="<?php echo $cmbDivisi; ?>" style="width:250px">
                                </div>
                            </div>

                            <!--status karyawan-->
                            <div class="form-group">
                                <label for="cmbStatus" class="col-sm-2 control-label label-danger">Status Karyawan</label>
                                <div class="col-sm-10">
                                  <input type="hidden" name="cmbStatus" id="cmbStatus" value="<?php echo $cmbStatus; ?>" style="width:250px">
                                </div>
                            </div>

                            <!--tanggal masuk-->
                            <div class="form-group">
                                <label for="txtTglMasuk" class="col-sm-2 control-label label-danger">Tanggal Masuk</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTglMasuk" id="txtTglMasuk" value="<?php echo $txtTglMasuk; ?>" style="width:150px" placeholder="dd/mm/YYYY">
                                </div>
                            </div>

                            <!--no jamsostek-->
                            <div class="form-group">
                                <label for="txtNoJamsostek" class="col-sm-2 control-label">Nomor Jamsostek</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtNoJamsostek" id="txtNoJamsostek" value="<?php echo $txtNoJamsostek; ?>" style="width:250px" placeholder="No. Jamsostek">
                                </div>
                            </div>

                            <!--no asuransi-->
                            <div class="form-group">
                                <label for="txtNoAsuransi" class="col-sm-2 control-label">Nomor Asuransi</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtNoAsuransi" id="txtNoAsuransi" value="<?php echo $txtNoAsuransi; ?>" style="width:250px" placeholder="No. Asuransi">
                                </div>
                            </div>

                            <!--no akun bank-->
                            <div class="form-group">
                                <label for="txtNoAkunBank" class="col-sm-2 control-label label-danger">Nomor Akun Bank</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtNoAkunBank" id="txtNoAkunBank" value="<?php echo $txtNoAkunBank; ?>" style="width:250px" placeholder="No. Akun Bank">
                                </div>
                            </div>

                            <!--no npwp-->
                            <div class="form-group">
                                <label for="txtNoNpwp" class="col-sm-2 control-label">Nomor NPWP</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtNoNpwp" id="txtNoNpwp" value="<?php echo $txtNoNpwp; ?>" style="width:250px" placeholder="No. NPWP">
                                </div>
                            </div>

                            <!--tgl npwp-->
                            <div class="form-group">
                                <label for="txtTglNpwp" class="col-sm-2 control-label">TMT NPWP</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTglNpwp" id="txtTglNpwp" value="<?php echo $txtTglNpwp; ?>" style="width:150px" placeholder="dd/mm/YYYY">
                                </div>
                            </div>

                            <!--inventaris perusahaan-->
                            <div class="form-group">
                                <label for="txtInvPerusahaan" class="col-sm-2 control-label">Inventaris Perusahaan</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control input-sm" name="txtInvPerusahaan" id="txtInvPerusahaan" value="<?php echo $txtInvPerusahaan; ?>" style="width:350px" placeholder="Inventaris Perusahaan" rows="3"></textarea>
                                </div>
                            </div>
                        </fieldset>
                        
                        <fieldset class="scheduler-border">
                            <legend>Keterangan Jadwal</legend>
                            
                            <!--Jenis Jadwal-->
                            <div class="form-group">
                                <label for="txtJenisJadwal" class="col-sm-2 control-label">Jenis Jadwal</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtJenisJadwal" id="txtJenisJadwal" value="<?php echo $txtJenisJadwal; ?>" style="width:250px" readonly>
                                </div>
                            </div>
                            
                            <!--Kode Jadwal-->
                            <div class="form-group">
                                <label for="txtKodeJadwal" class="col-sm-2 control-label">Kode Jadwal</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtKodeJadwal" id="txtKodeJadwal" value="<?php echo $txtKodeJadwal; ?>" style="width:250px" readonly>
                                </div>
                            </div>
                            
                        </fieldset>
                        
                        <fieldset class="scheduler-border">
                            <legend>Kontrak</legend>
                            
                            <!--status kontrak-->
                            <div class="form-group">
                                <label for="cmbStatusKontrak" class="col-sm-2 control-label label-danger">Status Kontrak</label>
                                <div class="col-sm-10">
                                  <input type="hidden" name="cmbStatusKontrak" id="cmbStatusKontrak" value="<?php echo $cmbStatusKontrak; ?>" style="width:250px">
                                </div>
                            </div>
                            
                            <!--tgl awal kontrak-->
                            <div class="form-group">
                                <label for="txtTglAwalKontrak" class="col-sm-2 control-label">Tanggal Awal Kontrak</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTglAwalKontrak" id="txtTglAwalKontrak" value="<?php echo $txtTglAwalKontrak; ?>" style="width:150px" placeholder="dd/mm/YYYY">
                                </div>
                            </div>
                            
                            <!--tgl akhir kontrak-->
                            <div class="form-group">
                                <label for="txtTglAkhirKontrak" class="col-sm-2 control-label">Tanggal Akhir Kontrak</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTglAkhirKontrak" id="txtTglAkhirKontrak" value="<?php echo $txtTglAkhirKontrak; ?>" style="width:150px" placeholder="dd/mm/YYYY">
                                </div>
                            </div>
                            
                        </fieldset>
                        
                    </div>
                    <!--end-->
                    
                    <div class="tab-pane" id="pribadi">
                        
                        <fieldset class="scheduler-border">
                            <legend>Identitas Pribadi</legend>
                            
                            <!--Jenis Kelamin-->
                            <div class="form-group">
                                <label for="cmbJenisKelamin" class="col-sm-2 control-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                  <input type="hidden" name="cmbJenisKelamin" id="cmbJenisKelamin" value="<?php echo $cmbJenisKelamin; ?>" style="width:200px">
                                </div>
                            </div>
                            
                            <!--tempat lahir-->
                            <div class="form-group">
                                <label for="txtTempatLahir" class="col-sm-2 control-label">Tempat Lahir</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTempatLahir" id="txtTempatLahir" value="<?php echo $txtTempatLahir; ?>" style="width:250px" placeholder="Tempat Lahir">
                                </div>
                            </div>
                            
                            <!--tgl lahir-->
                            <div class="form-group">
                                <label for="txtTglLahir" class="col-sm-2 control-label">Tanggal Lahir</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTglLahir" id="txtTglLahir" value="<?php echo $txtTglLahir; ?>" style="width:150px" placeholder="dd/mm/YYYY">
                                </div>
                            </div>
                            
                            <!--Pendidikan-->
                            <div class="form-group">
                                <label for="cmbPendidikan" class="col-sm-2 control-label">Pendidikan</label>
                                <div class="col-sm-10">
                                  <input type="hidden" name="cmbPendidikan" id="cmbPendidikan" value="<?php echo $cmbPendidikan; ?>" style="width:250px">
                                </div>
                            </div>
                            
                            <!--tahun lulus-->
                            <div class="form-group">
                                <label for="txtTahunLulus" class="col-sm-2 control-label">Tahun Lulus</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTahunLulus" id="txtTahunLulus" value="<?php echo $txtTahunLulus; ?>" style="width:150px" placeholder="YYYY">
                                </div>
                            </div>
                            
                            <!--agama-->
                            <div class="form-group">
                                <label for="cmbAgama" class="col-sm-2 control-label">Agama</label>
                                <div class="col-sm-10">
                                  <input type="hidden" name="cmbAgama" id="cmbAgama" value="<?php echo $cmbAgama; ?>" style="width:250px">
                                </div>
                            </div>
                            
                            <!--no tlp/hp-->
                            <div class="form-group">
                                <label for="txtTlp" class="col-sm-2 control-label">Nomor Telepon/HP</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTlp" id="txtTlp" value="<?php echo $txtTlp; ?>" style="width:250px" placeholder="No Tlp/HP">
                                </div>
                            </div>
                            
                            <!--no ktp-->
                            <div class="form-group">
                                <label for="txtKtp" class="col-sm-2 control-label">Nomor KTP</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtKtp" id="txtKtp" value="<?php echo $txtKtp; ?>" style="width:250px" placeholder="No KTP">
                                </div>
                            </div>
                            
                            <!--ktp berlaku-->
                            <div class="form-group">
                                <label for="txtTglKtp" class="col-sm-2 control-label">KTP Berlaku s/d</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTglKtp" id="txtTglKtp" value="<?php echo $txtTglKtp; ?>" style="width:150px" placeholder="dd/mm/YYYY">
                                </div>
                            </div>
                            
                            <!--status marital-->
                            <div class="form-group">
                                <label for="cmbStatusMarital" class="col-sm-2 control-label">Status Karyawan</label>
                                <div class="col-sm-10">
                                  <input type="hidden" name="cmbStatusMarital" id="cmbStatusMarital" value="<?php echo $cmbStatusMarital; ?>" style="width:250px">
                                </div>
                            </div>
                            
                            <!--status rumah-->
                            <div class="form-group">
                                <label for="cmbStatusRumah" class="col-sm-2 control-label">Status Rumah</label>
                                <div class="col-sm-10">
                                  <input type="hidden" name="cmbStatusRumah" id="cmbStatusRumah" value="<?php echo $cmbStatusRumah; ?>" style="width:250px">
                                </div>
                            </div>
                            
                        </fieldset>
                        
                        <fieldset class="scheduler-border">
                            <legend>Tempat Tinggal Sekarang</legend>
                            
                            <!--alamat-->
                            <div class="form-group">
                                <label for="txtAlamat" class="col-sm-2 control-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control input-sm" name="txtAlamat" id="txtAlamat" value="<?php echo $txtAlamat; ?>" style="width:350px" placeholder="Alamat" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <!--Kota-->
                            <div class="form-group">
                                <label for="txtKota" class="col-sm-2 control-label">Kota</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtKota" id="txtKota" value="<?php echo $txtKota; ?>" style="width:250px" placeholder="Kota">
                                </div>
                            </div>
                            
                            <!--Kode Pos-->
                            <div class="form-group">
                                <label for="txtKodePos" class="col-sm-2 control-label">Kode Pos</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtKodePos" id="txtKodePos" value="<?php echo $txtKodePos; ?>" style="width:250px" placeholder="Kode Pos">
                                </div>
                            </div>
                        </fieldset>
                        
                        <fieldset class="scheduler-border">
                            <legend>Tempat Tinggal Sesuai KTP</legend>
                            
                            <!--alamat-->
                            <div class="form-group">
                                <label for="txtAlamatKtp" class="col-sm-2 control-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control input-sm" name="txtAlamatKtp" id="txtAlamatKtp" value="<?php echo $txtAlamatKtp; ?>" style="width:350px" placeholder="Alamat KTP" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <!--Kota-->
                            <div class="form-group">
                                <label for="txtKotaKtp" class="col-sm-2 control-label">Kota</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtKotaKtp" id="txtKotaKtp" value="<?php echo $txtKotaKtp; ?>" style="width:250px" placeholder="Kota KTP">
                                </div>
                            </div>
                            
                            <!--Kode Pos-->
                            <div class="form-group">
                                <label for="txtKodePosKtp" class="col-sm-2 control-label">Kode Pos</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtKodePosKtp" id="txtKodePosKtp" value="<?php echo $txtKodePosKtp; ?>" style="width:250px" placeholder="Kode Pos Ktp">
                                </div>
                            </div>
                        </fieldset>
                        
                        <fieldset class="scheduler-border">
                            <legend>Saudara yang bisa dihubungi saat darurat</legend>
                            
                            <!--nama saudara-->
                            <div class="form-group">
                                <label for="txtNamaSaudara" class="col-sm-2 control-label">Nama</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtNamaSaudara" name="txtNamaSaudara" value="<?php echo $txtNamaSaudara; ?>" placeholder="Nama Saudara">
                                </div>
                            </div>
                            
                            <!--alamat saudara-->
                            <div class="form-group">
                                <label for="txtAlamatSaudara" class="col-sm-2 control-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control input-sm" name="txtAlamatSaudara" id="txtAlamatSaudara" value="<?php echo $txtAlamatSaudara; ?>" style="width:350px" placeholder="Alamat Saudara" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <!--no tlp/hp saudara-->
                            <div class="form-group">
                                <label for="txtTlpSaudara" class="col-sm-2 control-label">Nomor Telepon/HP</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTlpSaudara" id="txtTlpSaudara" value="<?php echo $txtTlpSaudara; ?>" style="width:250px" placeholder="No Tlp/HP Saudara">
                                </div>
                            </div>
                            
                        </fieldset>
                        
                    </div>

                    <div class="tab-pane" id="keluarga">
                        <fieldset class="scheduler-border">
                            <legend>Data Istri</legend>
                                                 
                            <!--nama istri-->
                            <div class="form-group">
                                <label for="txtNamaIstri" class="col-sm-2 control-label">Nama Istri</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtNamaIstri" name="txtNamaIstri" value="<?php echo $txtNamaIstri; ?>" placeholder="Nama Istri">
                                </div>
                            </div>
                            
                            <!--Tempat Lahir Istri-->
                            <div class="form-group">
                                <label for="txtTempatLahirIstri" class="col-sm-2 control-label">Tempat Lahir Istri</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTempatLahirIstri" id="txtTempatLahirIstri" value="<?php echo $txtTempatLahirIstri; ?>" style="width:250px" placeholder="Tempat Lahir Istri">
                                </div>
                            </div>
                            
                            <!--Tanggal Lahir Istri-->
                            <div class="form-group">
                                <label for="txtTglLahirIstri" class="col-sm-2 control-label">Tanggal Lahir Istri</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTglLahirIstri" id="txtTglLahirIstri" value="<?php echo $txtTglLahirIstri; ?>" style="width:150px" placeholder="dd/mm/YYYY">
                                </div>
                            </div>
                            
                            <!--No. Kartu Asuransi Istri-->
                            <div class="form-group">
                                <label for="txtNoAsuransiIstri" class="col-sm-2 control-label">No. Asuransi Istri</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtNoAsuransiIstri" id="txtNoAsuransiIstri" value="<?php echo $txtNoAsuransiIstri; ?>" style="width:250px" placeholder="No Asuransi Istri">
                                </div>
                            </div>
                        </fieldset>
                        
                        <fieldset class="scheduler-border">
                            <legend>Data Anak ke-1</legend>
                                                 
                            <!--nama anak ke-1-->
                            <div class="form-group">
                                <label for="txtNamaAnak1" class="col-sm-2 control-label">Nama Anak ke-1</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtNamaAnak1" name="txtNamaAnak1" value="<?php echo $txtNamaAnak1; ?>" placeholder="Nama Anak Ke-1">
                                </div>
                            </div>
                            
                            <!--Tempat Lahir Anak ke-1-->
                            <div class="form-group">
                                <label for="txtTempatLahirAnak1" class="col-sm-2 control-label">Tempat Lahir Anak ke-1</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTempatLahirAnak1" id="txtTempatLahirAnak1" value="<?php echo $txtTempatLahirAnak1; ?>" style="width:250px" placeholder="Tempat Lahir Anak ke-1">
                                </div>
                            </div>
                            
                            <!--Tanggal Lahir Anak ke-1-->
                            <div class="form-group">
                                <label for="txtTglLahirAnak1" class="col-sm-2 control-label">Tanggal Lahir Anak ke-1</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTglLahirAnak1" id="txtTglLahirAnak1" value="<?php echo $txtTglLahirAnak1; ?>" style="width:150px" placeholder="dd/mm/YYYY">
                                </div>
                            </div>
                            
                            <!--No. Kartu Asuransi Anak ke-1-->
                            <div class="form-group">
                                <label for="txtNoAsuransiAnak1" class="col-sm-2 control-label">No. Asuransi Anak ke-1</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtNoAsuransiAnak1" id="txtNoAsuransiAnak1" value="<?php echo $txtNoAsuransiAnak1; ?>" style="width:250px" placeholder="No Asuransi Anak ke-1">
                                </div>
                            </div>
                        </fieldset>
                        
                        <fieldset class="scheduler-border">
                            <legend>Data Anak ke-2</legend>
                                                 
                            <!--nama anak ke-1-->
                            <div class="form-group">
                                <label for="txtNamaAnak2" class="col-sm-2 control-label">Nama Anak ke-2</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtNamaAnak2" name="txtNamaAnak2" value="<?php echo $txtNamaAnak2; ?>" placeholder="Nama Anak Ke-2">
                                </div>
                            </div>
                            
                            <!--Tempat Lahir Anak ke-2-->
                            <div class="form-group">
                                <label for="txtTempatLahirAnak2" class="col-sm-2 control-label">Tempat Lahir Anak ke-2</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTempatLahirAnak2" id="txtTempatLahirAnak2" value="<?php echo $txtTempatLahirAnak2; ?>" style="width:250px" placeholder="Tempat Lahir Anak ke-2">
                                </div>
                            </div>
                            
                            <!--Tanggal Lahir Anak ke-2-->
                            <div class="form-group">
                                <label for="txtTglLahirAnak2" class="col-sm-2 control-label">Tanggal Lahir Anak ke-2</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTglLahirAnak2" id="txtTglLahirAnak2" value="<?php echo $txtTglLahirAnak2; ?>" style="width:150px" placeholder="dd/mm/YYYY">
                                </div>
                            </div>
                            
                            <!--No. Kartu Asuransi Anak ke-2-->
                            <div class="form-group">
                                <label for="txtNoAsuransiAnak2" class="col-sm-2 control-label">No. Asuransi Anak ke-2</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtNoAsuransiAnak2" id="txtNoAsuransiAnak2" value="<?php echo $txtNoAsuransiAnak2; ?>" style="width:250px" placeholder="No Asuransi Anak ke-2">
                                </div>
                            </div>
                        </fieldset>
                        
                        <fieldset class="scheduler-border">
                            <legend>Data Anak ke-3</legend>
                                                 
                            <!--nama anak ke-3-->
                            <div class="form-group">
                                <label for="txtNamaAnak3" class="col-sm-2 control-label">Nama Anak ke-3</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtNamaAnak3" name="txtNamaAnak3" value="<?php echo $txtNamaAnak3; ?>" placeholder="Nama Anak Ke-3">
                                </div>
                            </div>
                            
                            <!--Tempat Lahir Anak ke-3-->
                            <div class="form-group">
                                <label for="txtTempatLahirAnak3" class="col-sm-2 control-label">Tempat Lahir Anak ke-3</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTempatLahirAnak3" id="txtTempatLahirAnak3" value="<?php echo $txtTempatLahirAnak3; ?>" style="width:250px" placeholder="Tempat Lahir Anak ke-3">
                                </div>
                            </div>
                            
                            <!--Tanggal Lahir Anak ke-3-->
                            <div class="form-group">
                                <label for="txtTglLahirAnak3" class="col-sm-2 control-label">Tanggal Lahir Anak ke-3</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtTglLahirAnak3" id="txtTglLahirAnak3" value="<?php echo $txtTglLahirAnak3; ?>" style="width:150px" placeholder="dd/mm/YYYY">
                                </div>
                            </div>
                            
                            <!--No. Kartu Asuransi Anak ke-3-->
                            <div class="form-group">
                                <label for="txtNoAsuransiAnak3" class="col-sm-2 control-label">No. Asuransi Anak ke-3</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtNoAsuransiAnak3" id="txtNoAsuransiAnak3" value="<?php echo $txtNoAsuransiAnak3; ?>" style="width:250px" placeholder="No Asuransi Anak ke-3">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    
                    <div class="tab-pane" id="orangtua">
                        <fieldset class="scheduler-border">
                            <legend>Orang Tua</legend>
                                                 
                            <!--nama ayah-->
                            <div class="form-group">
                                <label for="txtNamaAyah" class="col-sm-2 control-label">Nama Ayah</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtNamaAyah" name="txtNamaAyah" value="<?php echo $txtNamaAyah; ?>" placeholder="Nama Ayah">
                                </div>
                            </div>
                            
                            <!--nama ibu-->
                            <div class="form-group">
                                <label for="txtNamaIbu" class="col-sm-2 control-label">Nama Ibu</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtNamaIbu" name="txtNamaIbu" value="<?php echo $txtNamaIbu; ?>" placeholder="Nama Ibu">
                                </div>
                            </div>
                            
                            <!--alamat ortu-->
                            <div class="form-group">
                                <label for="txtAlamatOrangtua" class="col-sm-2 control-label">Alamat Orangtua</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control input-sm" name="txtAlamatOrangtua" id="txtAlamatOrangtua" value="<?php echo $txtAlamatOrangtua; ?>" style="width:350px" placeholder="Alamat Orangtua" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <!--Kota / Kabupaten Orangtua-->
                            <div class="form-group">
                                <label for="txtKotaOrangtua" class="col-sm-2 control-label">Kota / Kabupaten Orangtua</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtKotaOrangtua" id="txtKotaOrangtua" value="<?php echo $txtKotaOrangtua; ?>" style="width:250px" placeholder="Kota / Kabupaten Orangtua">
                                </div>
                            </div>
                        </fieldset>
                        
                        <fieldset class="scheduler-border">
                            <legend>Mertua</legend>
                                                 
                            <!--nama ayah mertua-->
                            <div class="form-group">
                                <label for="txtNamaAyahMertua" class="col-sm-2 control-label">Nama Ayah Mertua</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtNamaAyahMertua" name="txtNamaAyahMertua" value="<?php echo $txtNamaAyahMertua; ?>" placeholder="Nama Ayah Mertua">
                                </div>
                            </div>
                            
                            <!--nama ibu mertua-->
                            <div class="form-group">
                                <label for="txtNamaIbuMertua" class="col-sm-2 control-label">Nama Ibu Mertua</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtNamaIbuMertua" name="txtNamaIbuMertua" value="<?php echo $txtNamaIbuMertua; ?>" placeholder="Nama Ibu Mertua">
                                </div>
                            </div>
                            
                            <!--alamat mertua-->
                            <div class="form-group">
                                <label for="txtAlamatMertua" class="col-sm-2 control-label">Alamat Mertua</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control input-sm" name="txtAlamatMertua" id="txtAlamatMertua" value="<?php echo $txtAlamatMertua; ?>" style="width:350px" placeholder="Alamat Mertua" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <!--Kota / Kabupaten Mertua-->
                            <div class="form-group">
                                <label for="txtKotaMertua" class="col-sm-2 control-label">Kota / Kabupaten Mertua</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" name="txtKotaMertua" id="txtKotaMertua" value="<?php echo $txtKotaMertua; ?>" style="width:250px" placeholder="Kota / Kabupaten Mertua">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                
                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php
                        echo form_button(array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-default navbar-btn'
                                ),'<span class="glyphicon '.$button_icon.'"></span>&nbsp;'.$button);
                        echo '&nbsp;&nbsp;';
                        echo form_button(array(
                                    'type' => 'button',
                                    'class' => 'btn btn-default navbar-btn',
                                    'onClick' => "window.open('".site_url("karyawan")."','_self')"
                                ),'<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Kembali');
                        ?>
                    </div>
                </div>
                <?php
                echo form_close();
                echo validation_errors();
                ?>                
            </div>
        </div>
        <?php
        if(isset($message))
        {
            echo $message;
        }
        ?>
    </div>
<?php 
$this->load->view("page/footer",array(
    'appJs'=>'appKaryawan',
    'pathJs'=>'var pathJabatan="'.site_url("karyawan/sJabatan").'";'.
              'var pathDivisi="'.site_url("karyawan/sDivisi").'";'.
              'var pathPendidikan="'.site_url("karyawan/sPendidikan").'";'.
              'var pathAgama="'.site_url("karyawan/sAgama").'";')); 
?>
