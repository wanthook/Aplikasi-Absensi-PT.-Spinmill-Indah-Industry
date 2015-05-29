<?php $this->load->view("page/header"); ?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading">Master Karyawan</div>
            <div class="panel-body"> 
                <p>
                <div class="">
                <?php 
                echo form_open( 'karyawan/search/', 'method="post" id="formSearchJamKerja" class="form-inline" role="form"');                
                
                echo '<div class="form-group">';
                echo form_input(
                    array('name'        => 'txtSearch',
                          'id'          => 'txtSearch',
                          'placeholder' => 'PIN, NIK, NAMA KARYAWAN',
                          'class'       => 'form-control')        
                );
                echo '</div>
                     <div class="form-group">';
                ?>
                <input type="hidden" name="cmbJabatan" id="cmbJabatan" style="width:200px">
                <input type="hidden" name="cmbDivisi" id="cmbDivisi" style="width:200px">
                <?php
                echo '</div>
                     <div class="form-group">';
                echo form_button(array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-default navbar-btn'
                                ),'<span class="glyphicon glyphicon-search"></span>&nbsp;Cari');
                echo '</div>
                     <div class="pull-right">';
                echo anchor('karyawan/form_upload/','<span class="glyphicon glyphicon-upload"></span>&nbsp;Upload Karyawan',array('class'=>'btn btn-success')); 
                echo '&nbsp;';
                echo anchor('karyawan/add/','<span class="glyphicon glyphicon-plus"></span>&nbsp;Tambah Karyawan',array('class'=>'btn btn-success')); 
                echo '</div>';
                echo form_close();
                ?>
                </div>
                </p>
                <?php echo $table; ?>
                <p>
                <?php echo $pagination; ?>
                </p>
            </div>
        </div>        
    </div>

<?php 
$this->load->view("page/footer",array(
    'appJs'=>'appKaryawan',
    'pathJs'=>'var pathJabatan="'.site_url("karyawan/sJabatan").'";'.
              'var pathDivisi="'.site_url("karyawan/sDivisi").'";'.
              'var pathPendidikan="'.site_url("karyawan/sPendidikan").'";'.
              'var pathAgama="'.site_url("karyawan/sAgama").'";')); 
?>
