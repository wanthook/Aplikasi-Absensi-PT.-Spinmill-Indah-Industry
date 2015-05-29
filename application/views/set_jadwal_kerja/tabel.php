<?php $this->load->view("page/header"); ?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading">Set Jadwal Kerja</div>
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
//                     <div class="form-group">';
                ?>
<!--                <input type="hidden" name="cmbJabatan" id="cmbJabatan" style="width:200px">
                <input type="hidden" name="cmbDivisi" id="cmbDivisi" style="width:200px">-->
                <?php
                 echo '</div>
                     <div class="form-group">';
                echo form_button(array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-default navbar-btn'
                                ),'<span class="glyphicon glyphicon-search"></span>&nbsp;Cari');
                echo '</div>
                     <div class="pull-right">';
                echo anchor('set_jadwal_kerja/form_upload/','<span class="glyphicon glyphicon-upload"></span>&nbsp;Upload Set Jadwal',array('class'=>'btn btn-success')); 
                echo '&nbsp;';
                echo anchor('set_jadwal_kerja/add/','<span class="glyphicon glyphicon-plus"></span>&nbsp;Tambah Jadwal Kerja',array('class'=>'btn btn-success pull-right')); 
                echo '</div>';
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
    'appJs'=>'appSetJadwalKerja',
    'pathJs'=>'var pathJadwal="'.site_url("set_jadwal_kerja/sJadwal").'";')); 
