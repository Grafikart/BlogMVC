<?php
return CMap::mergeArray(
    include 'web.php',
    array(
        'components' => array(
            'request' => array(
                'baseUrl' => '',
            ),
            'fixtureManager' => array(
                'class' => 'application.components.FixtureManager',
                'basePath' => dirname(__DIR__).'/tests/_data/fixtures',
            ),
            'mysqlTestConnection' => array(
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=testing',
                'username' => 'testing',
                'password' => 'testing',
            ),
            'sqliteTestConnection' => array(
                'class' => 'CDbConnection',
                'connectionString' => 'sqlite:'.dirname(__DIR__).'/runtime/test.sqlite',
            ),
            'pgsqlTestConnection' => array(
                'class' => 'CDbConnection',
                'connectionString' => 'pgsql:dbname=testing',
                'username' => 'testing',
                'password' => 'testing',
            )
        ),
        'import' => array(
            'system.test.*',
            'application.tests._support.tests.*',
        ),
    )
);