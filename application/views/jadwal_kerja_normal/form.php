<?php $this->load->view("page/header"); 

if(!isset($txtKodeJadwalKerjaNormal))
{
    $txtKodeJadwalKerjaNormal = set_value('txtKodeJadwalKerjaNormal');
    $txtKeteranganJadwalKerjaNormal = set_value('txtKeteranganJadwalKerjaNormal');
    $cmbSenin = set_value('cmbSenin');
    $cmbSelasa = set_value('cmbSelasa');
    $cmbRabu = set_value('cmbRabu');
    $cmbKamis = set_value('cmbKamis');
    $cmbJumat = set_value('cmbJumat');
    $cmbSabtu = set_value('cmbSabtu');
    $cmbMinggu = set_value('cmbMinggu');


}
?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $title;?></div>
            <div class="panel-body"> 
                
<!--                <ul class="nav nav-tabs" id="tabJadwalNormal">
                    <li class="active"><a href="#kodejadwalnormal" data-toggle="tab">Kode Jadwal Normal</a></li>
                    <li><a href="#jadwalnormal" data-toggle="tab">List Karyawan Jadwal Normal</a></li>
                </ul>-->
                
                <div class="tab-content">   
                    
                    <!--Tab content form master data perusahaan-->
                    <div class="tab-pane active" id="kodejadwalnormal">
                        <br>
                        <fieldset class="scheduler-border">
                            <legend>Kode Jadwal Normal</legend>
                <?php
                echo form_open( $action, 'class="form-horizontal" method="post" id="'.$idForm.'" role="form"');
//                echo form_input(array('type'=>'hidden', 'name'=>'txtId','id'=>'txtId','value'=>$id));
                ?>
                
                            <!--Kode Jadwal-->
                            <div class="form-group">
                                <label for="txtKodeJadwalKerjaNormal" class="col-sm-2 control-label label-danger">Kode Jadwal</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtKodeJadwalKerjaNormal" name="txtKodeJadwalKerjaNormal" value="<?php echo $txtKodeJadwalKerjaNormal; ?>" placeholder="Kode Jadwal" style="width:200px">
                                </div>
                            </div>

                            <!--Keterangan Jadwal-->
                            <div class="form-group">
                                <label for="txtKeteranganJadwalKerjaNormal" class="col-sm-2 control-label">Keterangan Jadwal</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control input-sm" id="txtKeteranganJadwalKerjaNormal" name="txtKeteranganJadwalKerjaNormal" value="<?php echo $txtKeteranganJadwalKerjaNormal; ?>" placeholder="Keterangan Jadwal">
                                </div>
                            </div>

                            <fieldset class="scheduler-border">
                                <legend>Detail Jadwal Kerja Normal</legend>

                                <!--Senin-->
                                <div class="form-group">
                                    <label for="cmbSenin" class="col-sm-2 control-label label-danger">Senin</label>
                                    <div class="col-sm-10">
                                      <input type="hidden" name="cmbSenin" id="cmbSenin" value="<?php echo $cmbSenin; ?>" style="width:250px">
                                    </div>
                                </div>

                                <!--Selasa-->
                                <div class="form-group">
                                    <label for="cmbSelasa" class="col-sm-2 control-label label-danger">Selasa</label>
                                    <div class="col-sm-10">
                                      <input type="hidden" name="cmbSelasa" id="cmbSelasa" value="<?php echo $cmbSelasa; ?>" style="width:250px">
                                    </div>
                                </div>

                                <!--Rabu-->
                                <div class="form-group">
                                    <label for="cmbRabu" class="col-sm-2 control-label label-danger">Rabu</label>
                                    <div class="col-sm-10">
                                      <input type="hidden" name="cmbRabu" id="cmbRabu" value="<?php echo $cmbRabu; ?>" style="width:250px">
                                    </div>
                                </div>

                                <!--Kamis-->
                                <div class="form-group">
                                    <label for="cmbKamis" class="col-sm-2 control-label label-danger">Kamis</label>
                                    <div class="col-sm-10">
                                      <input type="hidden" name="cmbKamis" id="cmbKamis" value="<?php echo $cmbKamis; ?>" style="width:250px">
                                    </div>
                                </div>

                                <!--Jumat-->
                                <div class="form-group">
                                    <label for="cmbJumat" class="col-sm-2 control-label label-danger">Jum'at</label>
                                    <div class="col-sm-10">
                                      <input type="hidden" name="cmbJumat" id="cmbJumat" value="<?php echo $cmbJumat; ?>" style="width:250px">
                                    </div>
                                </div>

                                <!--Sabtu-->
                                <div class="form-group">
                                    <label for="cmbSabtu" class="col-sm-2 control-label label-danger">Sabtu</label>
                                    <div class="col-sm-10">
                                      <input type="hidden" name="cmbSabtu" id="cmbSabtu" value="<?php echo $cmbSabtu; ?>" style="width:250px">
                                    </div>
                                </div>

                                <!--Minggu-->
                                <div class="form-group">
                                    <label for="cmbMinggu" class="col-sm-2 control-label label-danger">Minggu</label>
                                    <div class="col-sm-10">
                                      <input type="hidden" name="cmbMinggu" id="cmbMinggu" value="<?php echo $cmbMinggu; ?>" style="width:250px">
                                    </div>
                                </div>
                            </fieldset>    
                            
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
                                                'onClick' => "window.open('".site_url("jadwal_kerja_normal")."','_self')"
                                            ),'<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Kembali');
                                    ?>
                                </div>
                            </div> 
                        </fieldset>
                <?php
                echo form_close();
                echo validation_errors();
                ?>                
                    </div>
                
<!--                    <div class="tab-pane" id="jadwalnormal">
                        <br>
                        <fieldset class="scheduler-border">
                            <legend>List Karyawan Jadwal Normal</legend>

                            <?php
                            echo "<p>";
                            echo anchor('#','<span class="glyphicon glyphicon-plus"></span>&nbsp;Tambah Karyawan',array('class'=>'btn btn-success pull-right', 'id'=>'cmdAddKaryawan')); 
                            echo "</p>";
                            echo $table_kar;
                            ?>

                        </fieldset>
                    </div>-->
                
                </div>
            </div>
        <?php
        if(isset($message))
        {
            echo $message;
        }
        ?>
        </div>
    </div>
<?php 
$this->load->view("page/footer",array(
    'appJs'=>'appJadwalKerjaNormal',
    'pathJs'=>'var pathJadwal="'.site_url("jadwal_kerja_normal/sJadwal").'";')); 
?>
