<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Panel</title>
        <!-- Bootstrap -->
        <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="/css/admin.css" type="text/css" rel="stylesheet">
        <link href="/css/jquery-ui.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="/css/main.css" />
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-timepicker-addon.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/admin/">Ting Ting</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (!empty($_SESSION['ADMIN_ID'])) { ?>  
                            <li><a href="/admin/doc/">API Doc</a></li>
                            <li><a href="/admin/members/">Members</a></li>
                            <li><a href="/admin/posts/">Posts</a></li>
                            <li class="dropdown">
                                <a href="/admin/setup/" class="dropdown-toggle" data-toggle="dropdown">Setup <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">                                    
                                    <li><a href="/admin/countries/">Countries</a></li>
                                </ul>
                            </li>
                            <li><a href="/admin/profile/">My Profile</a></li>
                            <li><a href="/admin/logout/">Logout</a></li>
                        <?php } else { ?>
                            <li><a href="/admin/login/">Login</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>            
        </nav>