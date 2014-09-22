<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog | {host}</title>

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
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
                    <a class="navbar-brand" href="/">Blog</a>
                </div>

                <div class="collapse navbar-collapse navbar-ex1-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="login/">Admin</a></li>
                    </ul>
                </div>

            </div><!-- /.container -->
        </div>

        <div class="container">

            <div class="row">
                <div class="col-md-8">

                    <div class="page-header">
                        <h1>Blog</h1>
                        <p class="lead">Welcome on my blog</p>
                    </div>

					{blog_entries}
                    <article>
                        <h2><a href="{post_url}">{name}</a></h2>
                        <p><small>
                            Category : <a href="{category_url}">{category}</a>,
                            by <a href="{author_url}">{author}</a> on <em>{post_date}</em>
                        </small></p>
                        <p>{post_preview}...</p>
                        <p class="text-right"><a href="{post_url}" class="btn btn-primary">Read more...</a></p>
                    </article>

                    <hr>
					
					{/blog_entries}

                    <ul class="pagination">
                        <li><a href="index.html">&laquo;</a></li>
                        <li><a href="index.html">1</a></li>
                        <li><a href="index.html">2</a></li>
                        <li><a href="index.html">3</a></li>
                        <li><a href="index.html">4</a></li>
                        <li><a href="index.html">5</a></li>
                        <li><a href="index.html">&raquo;</a></li>
                    </ul>
                </div>

                <div class="col-md-4 sidebar">

                    <h4>Categories</h4>
                    <div class="list-group">
                        <a href="category.html" class="list-group-item">
                            <span class="badge">14</span>
                            Category #1
                        </a>
                        <a href="category.html" class="list-group-item">
                            <span class="badge">5</span>
                            Category #2
                        </a>
                        <a href="category.html" class="list-group-item">
                            <span class="badge">1</span>
                            Category #3
                        </a>
                        <a href="category.html" class="list-group-item">
                            <span class="badge">7</span>
                            Category #4
                        </a>
                    </div>

                    <h4>Last posts</h4>
                    <div class="list-group">
                        <a href="post.html" class="list-group-item">
                            The Route of All Evil
                        </a>
                        <a href="post.html" class="list-group-item">
                            Good news everyone !
                        </a>
                    </div>
                </div><!-- /.sidebar -->
            </div>

        </div><!-- /.container -->

    </body>
</html>
