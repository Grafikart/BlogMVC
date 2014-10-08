<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog | {host}</title>

        <!-- Bootstrap core CSS -->
        <link href="{url_root}assets/css/bootstrap.css" rel="stylesheet">
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
                    <a class="navbar-brand" href="{url_root}">Blog</a>
                </div>

                <div class="collapse navbar-collapse navbar-ex1-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="{url_root}">< Back to front</a></li>
                    </ul>
                </div>

            </div><!-- /.container -->
        </div>

        <div class="container">

            <form class="form-signin" action="{url_login}" method="post">
                <h4 class="form-signin-heading">Please sign in</h4>
                <input type="text" name="username" class="form-control" placeholder="Login" autofocus>
                <input type="password" name="password" class="form-control" placeholder="Password">
                <button class="btn btn-lg btn-primary btn-block" name="post_admin_login" type="submit">Sign in</button>
            </form>

        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
    </body>
</html>
