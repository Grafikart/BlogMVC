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
                // whatever you do, make sure this name doesn't intersect with
                // the one in db-test.php
                'connectionString' => 'sqlite:'.dirname(__DIR__).'/runtime/dummy.db',
                'tablePrefix' => 'test_conn_',
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