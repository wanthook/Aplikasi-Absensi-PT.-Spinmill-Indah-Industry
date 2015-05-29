<?php $this->load->view("page/header"); 

if(!isset($txtPinKerjaManual))
{
    $txtPinKerjaManual = set_value('txtPinKerjaManual');
//    $cmbSenin = set_value('cmbSenin');
//    $cmbSelasa = set_value('cmbSelasa');
//    $cmbRabu = set_value('cmbRabu');
//    $cmbKamis = set_value('cmbKamis');
//    $cmbJumat = set_value('cmbJumat');
//    $cmbSabtu = set_value('cmbSabtu');
//    $cmbMinggu = set_value('cmbMinggu');


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
                <input type="hidden" name="txtId" id="txtId" value="<?php echo $this->uri->segment(3); ?>">
                
                <!--PIN-->
                <div class="form-group">
                    <label for="txtPinKerjaManual" class="col-sm-2 control-label label-danger">PIN</label>
                    <div class="col-sm-10">
                        <input type="hidden" id="txtPinKerjaManual" name="txtPinKerjaManual" value="<?php echo $txtPinKerjaManual; ?>" style="width: 200px">
                    </div>
                </div>
                
                <fieldset class="scheduler-border">
                    <legend>Detail Jadwal Kerja Manual</legend>
                    
                    <!--Periode-->
                    <div class="form-group">
                        <label for="txtPeriode" class="col-sm-2 control-label">Periode</label>
                        <div class="col-sm-10" style="width: 200px;">
                          <input type="text" class="form-control input-sm" id="txtPeriode" name="txtPeriode" value="<?php echo date('m-Y'); ?>" placeholder="Periode">
                        </div>
                    </div>
                    
                    <!--Jadwal Kerja-->
                    <div class="form-group">
                        <label for="cmbJadwal" class="col-sm-2 control-label">Jam Kerja</label>
                        <div class="col-sm-10">
                          <input type="hidden" name="cmbJadwal" id="cmbJadwal" style="width:250px">&nbsp;&nbsp;
                          <button id="cmdHapusJamKerja" class="btn btn-default navbar-btn">Hapus Jam Kerja</button>
                        </div>
                    </div>
                    
                    <div id="tblPlace">
                        
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
                                    'onClick' => "window.open('".site_url("jadwal_kerja_manual")."','_self')"
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
    'appJs'=>'appJadwalKerjaManual',
    'pathJs'=>'var pathJ="'.site_url("jadwal_kerja_manual/").'";')); 
?>
