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
                        <li>{{ HTML::link('/', '< Back to front')}}</li>
                        <li>{{ HTML::linkAction('UsersController@logout', 'Logout')}}</li>
                    </ul>
                </div>

            </div><!-- /.container -->
        </div>



        <div class="container">

            @if(Session::has('error'))
                <div class="alert alert-danger">
                    <strong>{{ Session::get('error') }}</strong>
                </div>
            @endif

            @if(Session::has('success'))
                <div class="alert alert-success">
                    <strong>{{ Session::get('success') }}</strong>
                </div>
            @endif

            @yield('content', $content)

        </div><!-- /.container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>
        (function($){

            $('[data-method]').append(function(){
                return "\n"+
                "<form action='"+$(this).attr('href')+"' method='POST' style='display:none'>\n"+
                "   <input type='hidden' name='_method' value='"+$(this).attr('data-method')+"'>\n"+
                "   <input type='hidden' name='_token' value='{{ Session::get('_token') }}'>\n"+
                "</form>\n"
            }).removeAttr('href').attr('style','cursor:pointer;').click(function(e){
                e.preventDefault();
                if (confirm('Voulez vous vraiment effectuer cette action ?')){
                    $(this).find("form").submit();
                }
            });

        })(jQuery);
        </script>

    </body>
</html>
