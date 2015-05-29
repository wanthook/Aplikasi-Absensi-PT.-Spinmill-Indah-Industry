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
    <!--<link href="<?php echo base_url();?>css/bootstrap-theme.css" rel="stylesheet">-->
    <link href="<?php echo base_url();?>css/colorpicker.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/magicsuggest-1.3.1.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/datepicker.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/select2.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/jquery.fileupload.css" rel="stylesheet">
    
    <!--<link href="<?php echo base_url();?>css/jquery-ui-1.10.3.custom.css" rel="stylesheet">-->
    
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>css/terry.css" rel="stylesheet">
    
    <style>
        .navbar-default {
  background-color: #5aa383;
  border-color: #429461;
}
.navbar-default .navbar-brand {
  color: #ecf0f1;
}
.navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
  color: #047250;
}
.navbar-default .navbar-text {
  color: #ecf0f1;
}
.navbar-default .navbar-nav > li > a {
  color: #ecf0f1;
}
.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
  color: #047250;
}
.navbar-default .navbar-nav > li > .dropdown-menu {
  background-color: #5aa383;
}
.navbar-default .navbar-nav > li > .dropdown-menu > li > a {
  color: #ecf0f1;
}
.navbar-default .navbar-nav > li > .dropdown-menu > li > a:hover,
.navbar-default .navbar-nav > li > .dropdown-menu > li > a:focus {
  color: #047250;
  background-color: #429461;
}
.navbar-default .navbar-nav > li > .dropdown-menu > li > .divider {
  background-color: #5aa383;
}
.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
  color: #047250;
  background-color: #429461;
}
.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
  color: #047250;
  background-color: #429461;
}
.navbar-default .navbar-toggle {
  border-color: #429461;
}
.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
  background-color: #429461;
}
.navbar-default .navbar-toggle .icon-bar {
  background-color: #ecf0f1;
}
.navbar-default .navbar-collapse,
.navbar-default .navbar-form {
  border-color: #ecf0f1;
}
.navbar-default .navbar-link {
  color: #ecf0f1;
}
.navbar-default .navbar-link:hover {
  color: #047250;
}

@media (max-width: 767px) {
  .navbar-default .navbar-nav .open .dropdown-menu > li > a {
    color: #ecf0f1;
  }
  .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
    color: #047250;
  }
  .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
    color: #047250;
    background-color: #429461;
  }
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
                <a class="navbar-brand" href="<?php echo site_url("home"); ?>"><img src="<?php echo base_url();?>images/Spinmill.png"></img><!--&nbsp;&nbsp;<?php echo $this->lang->line('common_app_name'); ?>--></a>
            </div>   
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a class="navbar-brand" href="<?php echo site_url("home"); ?>"><span class="glyphicon glyphicon-home"></span>&nbsp;<?php echo $this->lang->line('common_home')?></a>        
                    </li>  
                    <?php
        
                        $modul = $this->Mod_modul->getAllowedModules($user_info->user_id);
                        $menus = $this->Mod_modul->createParentChild($modul);

                        foreach($menus as $menu)
                        {
                            $icon = "";
                            if(!empty($menu['icon']))
                                $icon = '<span class="glyphicon '.$menu['icon'].'"></span>&nbsp;';
                        ?>
                    <li class="dropdown">
                        <a href="<?php echo site_url($menu['route']); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $icon.$menu['name']; ?> <b class="caret"></b></a>    
                        <?php
                            if($menu['child']!=null)
                            {                    
                            ?>

                            <ul class="dropdown-menu">

                            <?php
                            foreach ($menu['child'] as $child)
                            {
                                $iconChild = "";
                                if(!empty($child['icon']))
                                    $iconChild = '<span class="glyphicon '.$child['icon'].'"></span>&nbsp;&nbsp;';
                                
                                ?>
                                <li>
                                    <a href="<?php echo site_url($child['route']); ?>"><?php echo $iconChild.$child['name']; ?></a>        
                                </li>
                                <?php
                            }
                            ?>

                            </ul>

                            <?php                
                            }
                        ?>
                    </li>            
                        <?php
                        }

                    ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <p class="navbar-text"></p>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo $this->lang->line('common_welcome') ?>, <b><?php echo $user_info->nama ?></b> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><span class="glyphicon glyphicon-cog"></span>&nbsp;<?php echo $this->lang->line('common_change_password') ?></a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url("home/logout"); ?>"><span class="glyphicon glyphicon-log-out"></span>&nbsp;<?php echo $this->lang->line('common_logout') ?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav> 
    </div>