<?php 
    $this->load->view("page/header");
?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $title;?></div>
            <div class="panel-body"> 
                
                <?php
                echo form_open_multipart($action);
//                echo form_input(array('type'=>'hidden', 'name'=>'txtId','id'=>'txtId','value'=>$id));
                ?>
                <!--upload file-->
                <div class="form-group">
                    <label for="txtUploadFile" class="col-sm-2 control-label">Upload file</label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control input-sm" id="txtUploadFile" name="txtUploadFile" placeholder="Upload File" style="width:500px">
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
//$this->load->view("page/footer",array(
//    'appJs'=>'appJadwalKerjaNormal',
//    'pathJs'=>'var pathJadwal="'.site_url("jadwal_kerja_normal/sJadwal").'";')); 
?>
