<div class="container">
        <nav class="navbar navbar-default navbar-fixed-bottom">
            <div class="footer">
                <p class="navbar-text">Copyright &copy; <?php echo date('Y')?> <?php echo $this->lang->line('common_company_name'); ?></p>
            </div>
        </nav>
    </div><!-- /container -->  
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script src="<?php echo base_url();?>js/jquery-1.9.1.js"></script>
    <script src="<?php echo base_url();?>js/jquery-ui-1.10.3.custom.js"></script>
    <script src="<?php echo base_url();?>js/jquery.blockUI.js"></script>
    <script src="<?php echo base_url();?>js/jquery.tablesorter.min.js"></script>     
    <script src="<?php echo base_url();?>js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-colorpicker.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url();?>js/bootstrapValidator.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery.mask.js"></script>
    <script src="<?php echo base_url();?>js/magicsuggest-1.3.1.js"></script>
    <script src="<?php echo base_url();?>js/select2.js"></script> 
    <script src="<?php echo base_url();?>js/jquery.form.js"></script> 
    <script src="<?php echo base_url();?>js/jquery-cookie/src/jquery.cookie.js"></script> 
    <script language="javascript"> var siteUrl="<?php echo site_url();  ?>"</script>
    <?php
    if(isset($pathJs))
    {
        ?>
    <script>
    <?php echo $pathJs; ?>
    </script>
        <?php
    }
    ?>
    
    <?php
    if(isset($appJs))
    {
        ?>
    <script src="<?php echo base_url();?>js/app/<?php echo $appJs?>.js"></script>        
        <?php
    }
    ?>
    
  </body>
</html>