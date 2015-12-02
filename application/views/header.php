<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Ting Ting</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/css/main.css" />
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
    </head>
    <body>
        <header class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Ting Ting</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="/home/signup/">Signup</a></li>
                    </ul> 
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (!empty($_SESSION['MEMBER_ID'])) { ?> 
                            <li><a href="/member/look_out/">Look Out</a></li>
                            <li><a href="/member/create_post/">Create Post</a></li>
                            <li><a href="/member/myposts/">My Posts</a></li>
                            <li><a href="/member/profile/">My Profile</a></li>
                            <li><a href="/member/logout/">Logout</a></li>
                        <?php } else { ?>
                            <li><a href="/login/">Login</a></li>
                        <?php } ?>
                    </ul>
                </div>               
            </div> 
        </header>
        <div class="container master-container">
            <!--ul class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active">Examples</li>
            </ul-->
            <?php getMessage(); ?>

