<?php $this->load->view("page/header"); ?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading">Tarik Absen</div>
            <div class="panel-body">
                <?php
                echo form_open( 'tarik_absen/do_import', 'class="form-horizontal" method="post" id="frmTarikAbsen" role="form"');
                ?>
                <h4>Form Tarik Data</h4>
                <hr>
                <div class="form-group">
                    <label for="asdf" class="col-sm-2 control-label">Tanggal </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" readonly="readonly" style="width:200px" value="<?php echo date("d-m-Y H:i:s"); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="asdf1" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-default">Proses</button>
                    </div>
                </div>
                <?php
                echo form_close();
                echo $msg;
                ?>
                <h4>History Tarik Data</h4>
                <hr>
                <?php echo $table; ?>
                <p>
                <?php echo $pagination; ?>
                </p>
            </div>
        </div>        
    </div>

<?php 
$this->load->view("page/footer",array('appJs'=>'')); 
?>
