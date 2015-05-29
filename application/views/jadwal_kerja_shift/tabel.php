<?php $this->load->view("page/header"); ?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading">Kode Jadwal Kerja</div>
            <div class="panel-body"> 
                <p>
                <div class="">
                <?php 
                echo form_open( 'jadwal_kerja_shift/search/', 'method="post" id="formSearchJadwalKerjaShift" class="form-inline" role="form"');                
                
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
                echo anchor('jadwal_kerja_shift/add/','<span class="glyphicon glyphicon-plus"></span>&nbsp;Tambah Kode Jadwal Kerja Shift',array('class'=>'btn btn-success pull-right')); 
                
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
    'appJs'=>'appJadwalKerjaShift',
    'pathJs'=>'var pathJadwal="'.site_url("jadwal_kerja_shift/sJadwal").'";'.
              'var pathTblJad="'.site_url("jadwal_kerja_shift/load_stable").'";'.
              'var pathAddTblJad="'.site_url("jadwal_kerja_shift/add_stable_temp").'";'.
              'var pathDelTblJad="'.site_url("jadwal_kerja_shift/delete_stable_temp").'";')); 
?>
