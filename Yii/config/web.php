<?php
return array(
    'id' => 'BlogMVC/Yii 1.1.14',
    'name' => 'Just another non-wordpress blog',
    'basePath' => '/srv/http/src/blogmvc/Yii',
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
    'language' => 'ru',
    'components' => array(
        'db' => array(
            'connectionString' => 'pgsql:host=localhost;port=5432;dbname=blogmvc_yii',
            'username' => 'blogmvc',
            'password' => 'blogmvc',
        ),
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
                'admin' => 'admin/index',
                'admin/help' => 'admin/help',
                'admin/help/dev' => 'admin/devHelp',
                'admin/options' => 'admin/options',
                'admin/options/flush' => 'admin/flushCache',
                'admin/options/status' => 'admin/status',
                'admin/options/recalculate' => 'admin/recalculate',
                'admin/users' => 'user/dashboard',
                'admin/users/new' => 'user/new',
                'admin/users/<id:\d+>' => 'user/show',
                'admin/profile' => 'user/profile',
                'admin/profile/suicide' => 'user/suicide',
                'admin/profile/username' => 'user/updateUsername',
                'admin/profile/password' => 'user/updatePassword',
                'admin/posts' => 'post/dashboard',
                'admin/posts/new' => 'post/new',
                'admin/posts/check/<slug:[\w-]+>' => 'post/checkSlug',
                'admin/posts/<id:\d+>' => 'post/edit',
                'admin/posts/<id:\d+>/delete' => 'post/delete',
                'admin/category' => 'category/list/type/admin',
                'category' => 'category/list/type/public',
                'admin/category/<slug:[\w-]+>/edit' => 'category/edit',
                'admin/category/<slug:[\w-]+>/save' => 'category/save',
                'admin/category/new' => 'category/edit',
                'admin/category/save' => 'category/save',
                'category/<slug:[\w-]+>' => 'category/index',
                'author' => 'user/list',
                'author/<id:\d+>' => 'user/index',
                '<format:(html|rss|xml|json)>' => 'post/index',
                '' => 'post/index',
                '<slug:([\w-]+)>' => 'post/show',
                '<postSlug:([\w-]+)>/comment' => 'comment/add',
                '<postSlug:([\w-]+)>/<id:\d+>/delete' => 'comment/delete',
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
            'basePath' => '/srv/http/src/blogmvc/Yii/public/skins',
            'baseUrl' => '/skins',
        ),
        'assetManager' => array(
            'basePath' => '/srv/http/src/blogmvc/Yii/public/assets',
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
        'cacheHelper' => array(
            'class' => 'application.components.helpers.CacheHelper',
        ),
    ),
    'theme' => 'default',
);