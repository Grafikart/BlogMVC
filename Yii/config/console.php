<?php
return array(
    'id' => 'BlogMVC/Yii 1.1.14',
    'name' => 'BlogMVC console helper',
    'basePath' => dirname(dirname(__FILE__)),
    'import' => array(
        'application.components.*',
        'application.models.*',
        'application.controllers.*',
    ),
    'components' => array(
        'db' => include __DIR__.'/db.php',
    ),
    'commandMap' => array(
        'migrate' => array(
            'class' => 'system.cli.commands.MigrateCommand',
            'migrationPath' => 'application.migrations',
            'migrationTable' => 'sys_migrations',
            'connectionID' => 'db',
            //'templateFile' => 'application.migrations.template'
        ),
    ),
);