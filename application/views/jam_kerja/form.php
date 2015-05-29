<?php $this->load->view("page/header"); 

if(!isset($txtKodeJamKerja))
{
    $txtKodeJamKerja = set_value('txtKodeJamKerja');
    $txtKodeJamKerja = set_value('txtKodeJamKerja');
    $txtJamMasuk = set_value('txtJamMasuk');
    $txtJamPulang = set_value('txtJamPulang');
    $txtLibur = set_value('txtLibur');
    $txtPendek = set_value('txtPendek');
    $txtIstirahat = set_value('txtIstirahat');
    $txtWarna = set_value('txtWarna');
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
                <div class="form-group">
                    <?php
                    echo form_label("Kode Jam Kerja", "", array('for'=>'txtKodeJamKerja','class'=>'col-sm-2 control-label'));
                    echo '<div class="col-sm-10">';
                    echo form_input(array('class'=>'form-control','name'=>'txtKodeJamKerja','id'=>'txtKodeJamKerja','value'=>$txtKodeJamKerja,'placeholder'=>'Kode Jam Kerja'));
                    echo '</div>';
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    $lbl = 'txtJamMasuk';
                    echo form_label("Jam Masuk", "", array('for'=>$lbl,'class'=>'col-sm-2 control-label'));
                    echo '<div class="col-sm-10 input-group" style="width: 200px;">';
                    echo form_input(
                                    array('class'=>'form-control',
                                          'name'=>$lbl,
                                          'id'=>$lbl,
                                          'value'=>$txtJamMasuk,
                                          'placeholder'=>'00:00:00'
                                          ));
                    echo '<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>';
                    echo '</div>';              
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    $lbl = 'txtJamPulang';
                    echo form_label("Jam Pulang", "", array('for'=>$lbl,'class'=>'col-sm-2 control-label'));
                    echo '<div class="col-sm-10 input-group" style="width: 200px;">';
                    echo form_input(
                                    array('class'=>'form-control',
                                          'name'=>$lbl,
                                          'id'=>$lbl,
                                          'value'=>$txtJamPulang,
                                          'placeholder'=>'00:00:00'
                                          ));
                    echo '<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>';
                    echo '</div>';              
                    ?>
                </div>
                
                <div class="form-group">
                    <?php echo form_label("Libur", "", array('for'=>'txtLibur','class'=>'col-sm-2 control-label'));?>
                    <div class="col-sm-10" style="width: 200px;">
                        <?php echo form_dropdown('txtLibur', array(''=>'Silakan Pilih',1=>'Y',0=>'N'),$txtLibur,'class="form-control input-sm"'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo form_label("Pendek", "", array('for'=>'txtPendek','class'=>'col-sm-2 control-label'));?>
                    <div class="col-sm-10" style="width: 200px;">
                        <?php echo form_dropdown('txtPendek', array(''=>'Silakan Pilih',1=>'Y',0=>'N'),$txtPendek,'class="form-control input-sm"'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo form_label("Kode Istirahat", "", array('for'=>'txtIstirahat','class'=>'col-sm-2 control-label'));?>
                    <div class="col-sm-10" style="width: 200px;">
                        <?php echo form_dropdown('txtIstirahat', array(''=>'Silakan Pilih',1=>'SATU',2=>'SETENGAH'),$txtIstirahat,'class="form-control input-sm"'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo form_label("Warna", "", array('for'=>'txtWarna','class'=>'col-sm-2 control-label'));?>
                    <div class="col-sm-10" style="width: 200px;">
                        <?php 
                        $lbl = 'txtWarna';
                        echo form_input(
                                array('class'=>'form-control',
                                      'name'=>$lbl,
                                      'id'=>$lbl,
                                      'value'=>$txtWarna
                                    )); ?>
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
                                    'onClick' => "window.open('".site_url("jam_kerja")."','_self')"
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
$this->load->view("page/footer",array('appJs'=>'appJamKerja')); 
?>
