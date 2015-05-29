<?php $this->load->view("page/header"); ?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading">Transaksi Alasan</div>
            <div class="panel-body"> 
                <p>
                <div class="form-group">
                <?php 
                echo form_open( 'transaksi_alasan/search_table/', 'method="post" id="formSearchTransaksiAlasan" class="form-inline" role="form"');                
                ?>
                    <input type="text" name="txtSearch" id="txtSearch" placeholder="Pin, Nama" class="form-control input-sm" style="width:250px">
                    <input type="hidden" name="cmbAlasanSearch" id="cmbAlasanSearch" style="width:250px">
                    <input type="text" class="form-control input-sm" name="txtTglSearch" id="txtTglSearch" style="width:150px" placeholder="dd/mm/YYYY">
                    <button type="submit" class="btn btn-default navbar-btn input-sm"><span class="glyphicon glyphicon-search"></span>&nbsp;Cari</button>
                <?php
                
                echo '<div class="pull-right">';
                echo '&nbsp;';                
                echo anchor('transaksi_alasan/upload/','<span class="glyphicon glyphicon-upload"></span>&nbsp;Upload Transaksi Alasan',array('class'=>'btn btn-success')); 
                echo '&nbsp;';                
                echo anchor('transaksi_alasan/add/','<span class="glyphicon glyphicon-plus"></span>&nbsp;Tambah Transaksi Alasan',array('class'=>'btn btn-success')); 
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
$this->load->view("page/footer",array('appJs'=>'appTransaksiAlasan')); 
?>
