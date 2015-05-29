<?php $this->load->view("page/header"); ?>
<style>
.table th
{
   text-align: center;   
}
.table td
{
   text-align: center;   
}

td.nwrap
{
    white-space: nowrap;
}
</style>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading">Absen Manual</div>
            <div class="panel-body"> 
                <?php 
                echo form_open( 'absen_manual/search/', 'method="post" id="formSearchAbsenManual" class="form-inline" role="form"');                
                ?>
                <div class="form-group">
                <?php
                echo form_input(
                    array('name'        => 'txtSearch',
                          'id'          => 'txtSearch',
                          'placeholder' => 'PIN atau NAMA',
                          'class'       => 'form-control input-sm',
                          'style'       => 'width:200px')        
                );
                ?>
                </div>
                <div class="form-group">
                <?php
                echo form_input(
                    array('name'        => 'startDate',
                          'id'          => 'startDate',
                          'placeholder' => 'Tanggal Awal',
                          'class'       => 'form-control input-sm',
                          'style'       => 'width:200px')        
                );
                ?>
                </div>
                &dash;
                <div class="form-group">   
                <?php                
                echo form_input(
                    array('name'        => 'endDate',
                          'id'          => 'endDate',
                          'placeholder' => 'Tanggal Akhir',
                          'class'       => 'form-control input-sm',
                          'style'       => 'width:200px')        
                );
                ?>
                </div>
                <div class="form-group">   
                <?php 
                echo form_button(array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-default navbar-btn input-sm'
                                ),'<span class="glyphicon glyphicon-search"></span>&nbsp;Cari');
                ?>
                </div>
                <div class="form-group  pull-right">   
                <?php 
                echo anchor('absen_manual/add/','<span class="glyphicon glyphicon-plus"></span>&nbsp;Tambah Absen Manual',array('class'=>'btn btn-success input-sm')); 
                
                ?>
                </div>
                <?php echo form_close(); ?>
                </p>
                <?php echo $table; ?>
                <p>
                <?php echo $pagination; ?>
                </p>
            </div>
        </div>        
    </div>

<?php 
$this->load->view("page/footer",array('appJs'=>'appAbsenManual')); 
?>
