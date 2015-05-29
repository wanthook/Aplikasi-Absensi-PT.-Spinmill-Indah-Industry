<?php $this->load->view("page/header"); ?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading">List Upload Access</div>
            <div class="panel-body"> 
                <p>
                <div class="">
                <?php 
                echo form_open( 'set_jadwal_kerja/search/', 'method="post" id="formSearchSetJadwalKerjaNormal" class="form-inline" role="form"');                
                
                echo '<div class="form-group">';
                echo form_input(
                    array('name'        => 'txtSearch',
                          'id'          => 'txtSearch',
                          'placeholder' => 'Kode, Keterangan',
                          'class'       => 'form-control')        
                );
                echo '</div>';
//                     <div class="form-group">';
                ?>
<!--                <input type="hidden" name="cmbJabatan" id="cmbJabatan" style="width:200px">
                <input type="hidden" name="cmbDivisi" id="cmbDivisi" style="width:200px">-->
                <?php
//                echo '</div>&nbsp;';
                echo form_button(array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-default navbar-btn'
                                ),'<span class="glyphicon glyphicon-search"></span>&nbsp;Cari');
                echo '&nbsp;';
                echo anchor('upload_absen/add/','<span class="glyphicon glyphicon-upload"></span>&nbsp;Upload Data Absen',array('class'=>'btn btn-success pull-right')); 
                
                echo form_close();
                ?>
                </div>
                </p>
                <div class="table-responsive">
                <?php echo $table; ?>
                </div>
                <p>
                <?php echo $pagination; ?>
                </p>
            </div>
        </div>        
    </div>

<?php 
$this->load->view("page/footer",array(
    'appJs'=>'appUploadAbsen',
    'pathJs'=>'var pathJadwal="'.site_url("set_jadwal_kerja/sJadwal").'";')); 
?>
