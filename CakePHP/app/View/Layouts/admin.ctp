<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <?= $this->fetch('meta'); ?>

        <title><?= $title_for_layout; ?> | Admin panel</title>

        <!-- Bootstrap core CSS -->
        <?= $this->Html->css('bootstrap'); ?>
        <?= $this->fetch('css'); ?>
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
                    <a class="navbar-brand" href="<?= $this->Html->url('/'); ?>">Blog</a>
                </div>

                <div class="collapse navbar-collapse navbar-ex1-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li><?= $this->Html->link('< Back to front', '/'); ?></li>
                        <li><?= $this->Html->link('Logout', '/users/logout'); ?></li>
                    </ul>
                </div>

            </div><!-- /.container -->
        </div>



        <div class="container">

            <?= $this->Session->flash(); ?>

            <?= $this->fetch('content'); ?>

        </div><!-- /.container -->

        <?= $this->fetch('script'); ?>

    </body>
</html>
