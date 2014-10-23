<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog | Admin panel</title>

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
                        <li><a href="{url_logout}">Logout</a></li>
                    </ul>
                </div>

            </div><!-- /.container -->
        </div>

        <div class="container">

            <h1>Manage posts</h1>

            <p><a href="{url_admin}/post/" class="btn btn-primary">Add a new post</a></p>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Publication date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {blog_entries}
                    <tr>
                        <td>{id}</td>
                        <td>{name}</td>
                        <td>{category}</td>
                        <td>{post_date}</td>
                        <td>
                            <a href="<?php echo base_url('admin'); ?>/post/{id}" class="btn btn-primary">Edit</a>
                            <a href="<?php echo base_url('admin'); ?>/delete/{id}" class="btn btn-danger" onclick="return confirm('Are you sure ?')">Delete</a>
                        </td>
                    </tr>
                    {/blog_entries}
                </tbody>
            </table>

             <ul class="pagination">
                {pagination}
            </ul>


        </div> <!-- /container -->
    </body>
</html>