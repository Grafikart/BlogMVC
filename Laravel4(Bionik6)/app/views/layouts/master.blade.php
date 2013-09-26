<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ $title }} | Blog MVC Laravel4</title>
    <!-- Bootstrap core CSS -->
    {{ HTML::style("css/bootstrap.css"); }}
    {{ HTML::script("js/jquery.js"); }}
    <style>
        body {
            padding-top: 50px;
        }

        .sidebar {
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
                <a class="navbar-brand" href="{{ URL::route('home.index') }}">Blog</a>
            </div>

            <div class="collapse navbar-collapse navbar-ex1-collapse navbar-right">
                <ul class="nav navbar-nav">
                    @if ( Auth::check() )
                    <li><a href="{{ URL::route('admin.index') }}">Admin</a></li>
                    <li><a href="{{ URL::route('admin.logout') }}">Logout</a></li>
                    @else
                    <li><a href="{{ URL::route('admin.index') }}">Admin</a></li>
                    @endif
                </ul>
            </div>

        </div>
        <!-- /.container -->
    </div>
    @yield('content')
</body>
</html>
