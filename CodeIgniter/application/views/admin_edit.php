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
                    </ul>
                </div>

            </div><!-- /.container -->
        </div>

        <div class="container">

            <h1>Edit post</h1>

            <p><a href="{url_admin}">< Back to posts</a></p>

            <form action="{form_action}" id="PostAdminEditForm" method="post" accept-charset="utf-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group required">
                            <label for="PostName">Name :</label>
                            <input name="data[Post][name]" class="form-control" maxlength="255" type="text" value="{post_name}" id="PostName" required="required">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group required">
                            <label for="PostSlug">Slug :</label>
                            <input name="data[Post][slug]" class="form-control" maxlength="255" type="text" value="{post_slug}" id="PostSlug" required="required">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="PostCategoryId">Category :</label>
                            <select name="data[Post][category_id]" class="form-control" id="PostCategoryId">
                                {categories}
                                <option value="{id}" {selected}>{name}</option>
                                {/categories}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="PostUserId">Author :</label>
                            <select name="data[Post][user_id]" class="form-control" id="PostUserId">
                                {authors}
                                <option value="{id}" {selected}>{username}</option>
                                {/authors}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="PostContent">Content :</label>
                    <textarea name="data[Post][content]" class="form-control" cols="30" rows="6" id="PostContent" required="required">{post_content}</textarea>
                </div>
                <div class="submit">
                    <input class="btn btn-primary" type="submit" value="{label_action}">
                </div>
            </form>


        </div> <!-- /container -->
    </body>
</html>