<?php $this->load->view("page/header"); ?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading">Master Divisi</div>
            <div class="panel-body"> 
                <p>
                <div class="form-group">
                <?php 
                echo form_open( 'divisi/search/', 'method="post" id="formSearchDivisi" class="form-inline" role="form"');                
                
                echo form_input(
                    array('name'        => 'txtSearch',
                          'id'          => 'txtSearch',
                          'placeholder' => 'Cari...',
                          'class'       => 'form-control',
                          'style'       => 'width:200px')        
                );
                echo form_button(array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-default navbar-btn'
                                ),'<span class="glyphicon glyphicon-search"></span>&nbsp;Cari');
                echo '&nbsp;';
                echo anchor('divisi/add/','<span class="glyphicon glyphicon-plus"></span>&nbsp;Tambah Divisi',array('class'=>'btn btn-success pull-right')); 
                
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
$this->load->view("page/footer",array('appJs'=>'appDivisi')); 
?>
