<?php $this->load->view("page/header"); 
//if(!isset($txtKodeAlasan) && !isset($txtKeteranganAlasan))
//{
//    $txtKodeAlasan = set_value('txtKodeAlasan');
//    $txtKeteranganAlasan = set_value('txtKeteranganAlasan');
//}

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
                    <label for="txtTgl" class="col-sm-2 control-label">Tanggal Transaksi <font style="color: red;">*</font></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm" id="txtTgl" name="txtTgl" placeholder="dd-mm-YYYY" value="<?php echo  (isset($value)?$value["tanggal_transaksi"]:""); ?>" style="width:200px">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cmbAlasan" class="col-sm-2 control-label">Alasan <font style="color: red;">*</font></label>
                    <div class="col-sm-10">
                      <input type="text" id="cmbAlasan" name="cmbAlasan" style="width:400px" value="<?php echo  (isset($value)?$value["id_alasan"]:""); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cmbKaryawan" class="col-sm-2 control-label">Karyawan <font style="color: red;">*</font></label>
                    <div class="col-sm-10">
                      <input type="text" id="cmbKaryawan" name="cmbKaryawan" style="width:500px" value="<?php echo  (isset($value)?$value["person_id"]:""); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="txtWaktu" class="col-sm-2 control-label">Waktu <font style="color: red;">*</font></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm" id="txtWaktu" name="txtWaktu" style="width:100px" placeholder="00.00">
                    </div>
                </div>
                <div class="form-group">
                    <label for="txtKeterangan" class="col-sm-2 control-label">Keterangan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm" id="txtKeterangan" name="txtKeterangan" style="width:500px" value="<?php echo  (isset($value)?$value["keterangan"]:""); ?>">
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
                                    'onClick' => "window.open('".site_url("transaksi_alasan")."','_self')"
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
$this->load->view("page/footer",array('appJs'=>'appTransaksiAlasan')); 
?>
