<?php
$configRoot = dirname(__FILE__);
$appRoot = dirname($configRoot);
return array(
    'id' => 'BlogMVC/Yii 1.1.14',
    'name' => 'Another non-wordpress blog',
    'basePath' => $appRoot,
    'import' => array(
        'application.components.*',
        'application.components.widgets.*',
        'application.components.formatters.*',
        'application.components.exceptions.*',
        'application.components.behaviors.*',
        'application.components.layers.*',
        'application.components.services.*',
        'application.models.*',
        'application.controllers.*',
        'application.vendor.twig.extensions.lib.Twig.Extensions.Extension.Text',
    ),
    'preload' => array(
        'log',
    ),
    'sourceLanguage' => 'en',
    'language' => 'en',
    'components' => array(
        'db' => include __DIR__.'/db.php',
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                'file' => array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info',
                ),
            ),
        ),
        'messages' => array(
            'class' => 'CPhpMessageSource',
            'forceTranslation' => true,
        ),
        'cache' => array(
            'class' => 'system.caching.CFileCache',
        ),
        'cacheHelper' => array(
            'class' => 'application.components.helpers.CacheHelper',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'login' => 'site/login',
                'logout' => 'site/logout',
                'category' => 'category/list',
                'category/<slug:[\w\-]+>' => 'category/index',
                'author' => 'user/list',
                'author/<id:\d+>' => 'user/index',
                'admin' => 'admin/index',
                'admin/help' => 'admin/help',
                'admin/help/dev' => 'admin/devHelp',
                'admin/options' => 'admin/options',
                'admin/options/flush' => 'admin/flushCache',
                'admin/options/status' => 'admin/status',
                'admin/options/recalculate' => 'admin/recalculate',
                'admin/users' => 'user/dashboard',
                'admin/users/new' => 'user/new',
                'admin/profile' => 'user/profile',
                'admin/profile/suicide' => 'user/suicide',
                'admin/profile/username' => 'user/updateUsername',
                'admin/profile/password' => 'user/updatePassword',
                'admin/posts' => 'post/dashboard',
                'admin/posts/new' => 'post/new',
                'admin/posts/check/<slug:[\w\-]+>' => 'post/checkSlug',
                'admin/posts/<id:\d+>' => 'post/edit',
                'admin/posts/<id:\d+>/delete' => 'post/delete',
                'admin/category' => 'category/dashboard',
                'admin/category/<slug:[\w\-]+>/edit' => 'category/edit',
                'admin/category/<slug:[\w\-]+>/save' => 'category/save',
                'admin/category/<slug:[\w\-]+>/delete' => 'category/delete',
                'admin/category/new' => 'category/edit',
                'admin/category/save' => 'category/save',
                'admin/category/save/ajax' => 'category/ajaxSave',
                '<format:(rss|xml|json)>' => 'post/index',
                '' => 'post/index',
                '<slug:([\w\-]+)>' => 'post/show',
                '<postSlug:([\w\-]+)>/comment' => 'comment/add',
                '<postSlug:([\w\-]+)>/comment/ajax' => 'comment/ajaxAdd',
                '<postSlug:([\w\-]+)>/<id:\d+>/delete' => 'comment/delete',
            ),
        ),
        'viewRenderer' => array(
            'class' => 'application.vendor.yiiext.twig-renderer.ETwigViewRenderer',
            'twigPathAlias' => 'application.vendor.twig.twig.lib.Twig',
            'extensions' => array(
                'Twig_Extensions_Extension_Text',
            ),
        ),
        'themeManager' => array(
            'basePath' => $appRoot . '/public/skins',
            'baseUrl' => '/skins',
        ),
        'assetManager' => array(
            'basePath' => $appRoot . '/public/assets',
            'baseUrl' => '/assets',
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'applicationService' => array(
            'class' => 'application.components.services.ApplicationService',
        ),
        'user' => array(
            'class' => 'application.components.layers.WebUserLayer',
        ),
        't' => array(
            'class' => 'application.components.layers.TranslatorLayer',
        ),
        'formatter' => array(
            'class' => 'application.components.formatters.DataFormatter',
        ),
        'dateFormatter' => array(
            'class' => 'application.components.formatters.DateFormatter',
        ),
    ),
    'theme' => 'ambinight',
);
