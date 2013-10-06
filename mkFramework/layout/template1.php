<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog | MyDomain.com</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <style>
            body {
                padding-top: 50px;
            }
            .sidebar{
                margin-top: 50px;
            }
        </style>
    </head>

    <body>

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo _root::getLink('default::index')?>">Blog</a>
                </div>

                <div class="collapse navbar-collapse navbar-ex1-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo _root::getLink('auth::login')?>">Admin</a></li>
                    </ul>
                </div>

            </div><!-- /.container -->
        </div>



        <div class="container">

            <div class="row">
                <div class="col-md-8">

					
                   <?php echo $this->load('main') ?>

                </div>

                <div class="col-md-4 sidebar">

					<?php echo $this->load('sidebar') ?>
                    
                </div><!-- /.sidebar -->
            </div>

        </div><!-- /.container -->

    </body>
</html>
