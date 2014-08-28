<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>@yield('title') | MyDomain.com</title>

        <!-- Bootstrap core CSS -->
        {{ HTML::style('css/bootstrap.css')}}
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
                    <a class="navbar-brand" href="{{ URL::to('/') }}">Blog</a>
                </div>

                <div class="collapse navbar-collapse navbar-ex1-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li>{{ HTML::link('/admin', 'Admin') }}</li>
                    </ul>
                </div>

            </div><!-- /.container -->
        </div>



        <div class="container">

            @yield('content', $content)

        </div><!-- /.container -->

    </body>
</html>
