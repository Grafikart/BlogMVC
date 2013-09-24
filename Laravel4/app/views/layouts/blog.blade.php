<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog | Laravel 4</title>

        <!-- Bootstrap core CSS -->
        <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
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
					{{ HTML::linkRoute('home', 'Blog', array(), array('class' => 'navbar-brand')) }}
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse navbar-right">
                    <ul class="nav navbar-nav">
						@if (Request::is('admin') || Request::is('admin/*') || Request::is('login'))
                        <li>{{ HTML::linkRoute('home', '< Back to front') }}</li>
						@else
                        <li>{{ HTML::linkRoute('admin', 'Admin') }}</li>
						@endif
                    </ul>
                </div>
            </div><!-- /.container -->
        </div>

        <div class="container">
            <div class="row">
				@yield('content')
            </div>
        </div><!-- /.container -->

    </body>
</html>
