<?php $this->load->view("page/header"); ?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading">Jadwal Kerja Manual</div>
            <div class="panel-body"> 
                <p>
                <div class="">
                <?php 
                echo form_open( 'jadwal_kerja_manual/search/', 'method="post" id="formSearchJadwalKerjaManual" class="form-inline" role="form"');                
                
                echo '<div class="form-group">';
                echo form_input(
                    array('name'        => 'txtSearch',
                          'id'          => 'txtSearch',
                          'placeholder' => 'PIN, Nama Karyawan',
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
                echo anchor('jadwal_kerja_manual/add/','<span class="glyphicon glyphicon-plus"></span>&nbsp;Tambah Jadwal Kerja Manual',array('class'=>'btn btn-success pull-right')); 
                
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
    'appJs'=>'appJadwalKerjaManual',
    'pathJs'=>'var pathJ="'.site_url("jadwal_kerja_manual/").'";')); 
?>
