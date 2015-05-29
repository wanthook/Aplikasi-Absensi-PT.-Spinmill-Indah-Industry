<?php $this->load->view("page/header"); ?>
    <div class="mainContent">
        <div class="panel panel-default">
            <div class="panel-heading">Proses Tarik Absen</div>
            <div class="panel-body"> 
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-default navbar-btn pull-right" onclick='window.open("<?php echo site_url("tarik_absen"); ?>","_self");'><span class="glyphicon glyphicon-arrow-left"></span>Kembali</button>
                       
                    </div>
                </div>
                <?php echo $table; ?>
            </div>
        </div>        
    </div>

<?php 
$this->load->view("page/footer",array('appJs'=>'')); 
?>
