<?php $this->load->view("page/header"); 

//if(!isset($txtKodeJadwalKerjaNormal))
//{
//    $txtKodeJadwalKerjaNormal = set_value('txtKodeJadwalKerjaNormal');
//    $txtKeteranganJadwalKerjaNormal = set_value('txtKeteranganJadwalKerjaNormal');
//    $txtId = set_value('txtId');
//    $cmbSenin = set_value('cmbSenin');
//    $cmbSelasa = set_value('cmbSelasa');
//    $cmbRabu = set_value('cmbRabu');
//    $cmbKamis = set_value('cmbKamis');
//    $cmbJumat = set_value('cmbJumat');
//    $cmbSabtu = set_value('cmbSabtu');
//    $cmbMinggu = set_value('cmbMinggu');
//
//
//}
?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $title;?></div>
            <div class="panel-body"> 
                
                <?php
                echo form_open( $action, 'class="form-horizontal" method="post" id="'.$idForm.'" role="form"');
                echo form_input(array('type'=>'hidden', 'name'=>'txtId','id'=>'txtId','value'=>(isset($txtId)?$txtId:"")));
                ?>
                <!--Karyawan-->
                <div class="form-group">
                    <label for="txtKaryawan" class="col-sm-2 control-label">Karyawan</label>
                    <div class="col-sm-10">
                        <input type="text" id="txtKaryawan" name="txtKaryawan" value="<?php if(isset($txtKaryawan)){echo $txtKaryawan;} ?>" placeholder="Pilih Karyawan" style="width:450px">
                    </div>
                </div>
                
                <!--Jenis Jadwal-->
                <div class="form-group">
                    <label for="txtJenisJadwal" class="col-sm-2 control-label">Jenis Jadwal</label>
                    <div class="col-sm-10">
                        <input type="text" id="txtJenisJadwal" name="txtJenisJadwal" value="<?php if(isset($txtJenisJadwal)){echo $txtJenisJadwal;} ?>" style="width:150px">
                    </div>
                </div>
                
                <!--Jadwal-->
                <div class="form-group">
                    <label for="txtJadwal" class="col-sm-2 control-label">Jadwal</label>
                    <div class="col-sm-10">
                        <input type="text" id="txtJadwal" name="txtJadwal" value="<?php if(isset($txtJadwal)){echo $txtJadwal;} ?>" placeholder="Pilih Jadwal" style="width:450px">
                    </div>
                </div>
                
                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php
                        echo form_button(array(
                                    'type' => 'submit',
                                    'id' => 'cmdOk',
                                    'class' => 'btn btn-default navbar-btn'
                                ),'<span class="glyphicon '.$button_icon.'"></span>&nbsp;'.$button);
                        echo '&nbsp;&nbsp;';
                        echo form_button(array(
                                    'type' => 'button',
                                    'class' => 'btn btn-default navbar-btn',
                                    'onClick' => "window.open('".site_url("set_jadwal_kerja")."','_self')"
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
    'appJs'=>'appSetJadwalKerja',
    'pathJs'=>'var pathJadwal="'.site_url("jadwal_kerja_normal/sJadwal").'";'
              . ' var pathKar="'.site_url("karyawan").'";'
              . ' var pathJad="'.site_url("set_jadwal_kerja").'";')); 
?>
