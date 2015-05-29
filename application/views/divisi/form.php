<?php $this->load->view("page/header"); 

if(!isset($txtKodeDivisi) && !isset($txtKeteranganDivisi))
{
    $txtKodeDivisi = set_value('txtKodeDivisi');
    $txtKeteranganDivisi = set_value('txtKeteranganDivisi');
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
                    echo form_label("Kode Divisi", "", array('for'=>'txtKodeDivisi','class'=>'col-sm-2 control-label'));
                    echo '<div class="col-sm-10">';
                    echo form_input(array('class'=>'form-control','name'=>'txtKodeDivisi','id'=>'txtKodeDivisi','value'=>$txtKodeDivisi,'placeholder'=>'Kode Divisi'));
                    echo '</div>';
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo form_label("Keterangan Divisi", "", array('for'=>'txtKeteranganDivisi','class'=>'col-sm-2 control-label'));
                    echo '<div class="col-sm-10">';
                    echo form_input(array('class'=>'form-control','name'=>'txtKeteranganDivisi','id'=>'txtKeteranganDivisi','value'=>$txtKeteranganDivisi,'placeholder'=>'Keterangan Divisi'));
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
                                    'onClick' => "window.open('".site_url("divisi")."','_self')"
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
$this->load->view("page/footer",array('appJs'=>'appDivisi')); 
?>
