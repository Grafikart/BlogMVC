
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog | MyDomain.com</title>

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
                    <a class="navbar-brand" href="{url_root}">Blog</a>
                </div>

                <div class="collapse navbar-collapse navbar-ex1-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="{url_admin}">Admin</a></li>
                    </ul>
                </div>

            </div><!-- /.container -->
        </div>



        <div class="container">

            <div class="row">
                <div class="col-md-8">

                    {article}
                    <div class="page-header">
                        <h1>{name}</h1>
                        <p><small>
                            Category : <a href="{category_url}">{category}</a>,
                            by <a href="{author_url}">{author}</a> on <em>{post_date}</em>
                        </small></p>
                    </div>

                    <article>
                       {content}
                    </article>
                    {/article}

                    <hr>

                    <section class="comments">

                        <h3>Comment this post</h3>

                        <div class="alert alert-danger"><strong>Oh snap !</strong> you did some errors</div>

                        <form role="form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Your email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-error">
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Your username">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Your comment"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>

                        <h3>2 Commentaires</h3>

                        <div class="row">
                            <div class="col-md-2">
                                <img src="http://lorempicsum.com/futurama/100/100/4" width="100%">
                            </div>
                            <div class="col-md-10">
                                <p><strong>Username</strong> 10 hours ago</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, laudantium voluptatibus quae doloribus dolorem earum dicta quasi. Fugit, eligendi, voluptatibus corporis deleniti perferendis accusantium totam harum dolor ab veniam laudantium!</p>
                            </div>
                        </div>
                        <div class="row">
                            <hr>
                            <div class="col-md-2">
                                <img src="http://lorempicsum.com/futurama/100/100/5" width="100%">
                            </div>
                            <div class="col-md-10">
                                <p><strong>Username</strong> 11 days ago</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, laudantium voluptatibus quae doloribus dolorem earum dicta quasi. Fugit, eligendi, voluptatibus corporis deleniti perferendis accusantium totam harum dolor ab veniam laudantium!</p>
                            </div>
                        </div>
                    </section>



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
