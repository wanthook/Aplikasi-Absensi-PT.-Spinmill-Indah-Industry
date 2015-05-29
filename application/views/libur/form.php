<?php $this->load->view("page/header"); 

if(!isset($txtTanggalLibur))
{
    $txtTanggalLibur = set_value('txtTanggalLibur');
    $txtKeteranganLibur = set_value('txtKeteranganLibur');
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
                    $lbl = 'txtTanggalLibur';
                    echo form_label("Tanggal Libur", "", array('for'=>$lbl,'class'=>'col-sm-2 control-label'));
                    echo '<div class="col-sm-10 input-group" style="width: 200px;">';
                    echo form_input(
                                    array('class'=>'form-control',
                                          'name'=>$lbl,
                                          'id'=>$lbl,
                                          'value'=>$txtTanggalLibur,
                                          'placeholder'=>'dd-mm-yyyy'
                                          ));
                    echo '<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>';
                    echo '</div>';              
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo form_label("Keterangan Libur", "", array('for'=>'txtKeteranganLibur','class'=>'col-sm-2 control-label'));
                    echo '<div class="col-sm-10">';
                    echo form_input(array('class'=>'form-control','name'=>'txtKeteranganLibur','id'=>'txtKeteranganLibur','value'=>$txtKeteranganLibur,'placeholder'=>'Keterangan Libur'));
                    echo '</div>';
                    ?>
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
                                    'onClick' => "window.open('".site_url("libur")."','_self')"
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
$this->load->view("page/footer",array('appJs'=>'appLibur')); 
?>
