<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="">

    <title>Aplikasi Absen Spinmill</title>
    
    <link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico">
    
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/bootstrap-theme.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/jquery.dataTables.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--<link href="<?php echo base_url();?>css/login.css" rel="stylesheet">-->
    <style>
        body 
        {
             background: url(<?php echo base_url(); ?>images/color-splash.jpg) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
            background-size: cover;
            padding-top: 20%;
            padding-bottom: 40px;
        }
    </style>
  </head>

  <body>  
    <div class="container">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigator">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="<?php echo base_url();?>images/Spinmill.png"></img></a>
            </div>             
        </nav> 
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line("login_welcome_message"); ?></h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post">
                        <fieldset>
                            <div class="form-group">
                                <img src="<?php echo base_url(); ?>images/logo.jpg" class="img-responsive center-block"></img>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="<?php echo $this->lang->line('login_username'); ?>" name="txtUsername" id="txtUsername" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="<?php echo $this->lang->line('login_password'); ?>" name="txtPassword" id="txtPassword" type="password" value="">
                            </div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Masuk">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php validation_errors(); ?>
    <div class="container">
        <nav class="navbar navbar-default navbar-fixed-bottom">
            <div class="footer">
                <p class="navbar-text">Copyright &copy; <?php echo date("Y"); ?> PT. Spinmill Indah Industry</p>
            </div>
        </nav>
    </div><!-- /container -->  
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>js/jquery-1.9.1.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>js/jquery.dataTables.js"></script>
  </body>
</html>
