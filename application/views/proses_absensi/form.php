<?php $this->load->view("page/header"); 

?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $title;?></div>
            <div class="panel-body"> 
                
                <?php
                echo form_open( $action, 'class="form-horizontal" method="post" id="'.$idForm.'" role="form"');
//                echo form_input(array('type'=>'hidden', 'name'=>'txtId','id'=>'txtId','value'=>$id));
                ?>
                <div class="form-group">
                    <label for="txtPeriode" class="col-sm-2 control-label">Periode <font style="color: red;">*</font></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm" id="txtPeriode" name="txtPeriode" placeholder="mm-YYYY" style="width:200px" required="">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="cmbKaryawan" class="col-sm-2 control-label">Karyawan</label>
                    <div class="col-sm-10">
                      <input type="text" id="cmbKaryawan" name="cmbKaryawan" placeholder="Pilih Karyawan" style="width:500px">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="cmbDivisi" class="col-sm-2 control-label">Divisi</label>
                    <div class="col-sm-10">
                      <input type="text" id="cmbDivisi" name="cmbDivisi" placeholder="Pilih Divisi" style="width:500px">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="asdf" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                        <small><em>- Kosongkan karyawan untuk memproses semua karyawan.<br>- Kosongkan Divisi untuk memproses semua divisi.</em></small>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php
//                        echo form_button(array(
//                                    'type' => 'submit',
//                                    'name' => 'cmdDownload',
//                                    'value' => 'pdf',
//                                    'class' => 'btn btn-default navbar-btn'
//                                ),'<span class="glyphicon '.$button_icon.'"></span>&nbsp;'.$button);
//                        echo '&nbsp;&nbsp;';
                        echo form_button(array(
                                    'type' => 'submit',
                                    'name' => 'cmdProses',
                                    'value' => 'xls',
                                    'class' => 'btn btn-default navbar-btn'
                                ),'<span class="glyphicon '.$button_icon.'"></span>&nbsp;'.$button);
                        echo '&nbsp;&nbsp;';
                        echo form_button(array(
                                    'type' => 'button',
                                    'class' => 'btn btn-default navbar-btn',
                                    'onClick' => "window.open('".site_url("home")."','_self')"
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
$this->load->view("page/footer",array('appJs'=>'appProsesAbsensi')); 
?>
