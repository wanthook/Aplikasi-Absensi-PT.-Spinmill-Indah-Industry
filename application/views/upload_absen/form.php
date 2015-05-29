<?php 

    $this->load->view("page/header"); 

?>

    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $title;?></div>
            <div class="panel-body"> 
                
                <?php
                    echo form_open_multipart($action, 'class="form-horizontal" method="post" id="'.$idForm.'" role="form"');
//                echo form_open( $action, 'class="form-horizontal" method="post" id="'.$idForm.'" role="form"');
//                echo form_input(array('type'=>'hidden', 'name'=>'txtId','id'=>'txtId','value'=>$txtId));
                ?>
                <!--File-->
                <div class="form-group">
                    <label for="txtFile" class="col-sm-2 control-label">File Access</label>
                    <div class="col-sm-10">
                        <input type="file" id="txtFile" name="txtFile" placeholder="Pilih File" style="width:450px">
                    </div>
                </div>
                
                <!--Periode-->
                <div class="form-group">
                    <label for="txtPeriode" class="col-sm-2 control-label">Periode</label>
                    <div class="col-sm-10">
                        <input type="text" id="txtPeriode" name="txtPeriode" class="form-control input-sm" value=""placeholder="mm-YYYY"  style="width:150px">
                    </div>
                </div>
                <div class="progress">
                    <div class="bar"></div >
                    <div class="percent">0%</div >
                </div>
                <!-- The global progress bar -->
<!--                <div id="progress" class="progress">
                    <div class="progress-bar progress-bar-success"></div>
                </div>-->
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
                                    'onClick' => "window.open('".site_url("upload_absen")."','_self')"
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
    'appJs'=>'appUploadAbsen',
    'pathJs'=>'var path="'.site_url("upload_absen").'";')); 
?>
