<?php

/**
 * Description of InstallCommand
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blog-mvc
 * @subpackage yii
 */
class InstallCommand extends CConsoleCommand
{
    public $driverMap = array(
        'pgsql' => array('psql', 'postgres', 'postgresql',),
        'mysql' => array(),
        'sqlite' => array('sqlite3'),
        'mssql' => array('sql server', 'sqlserver',),
        'oci' => array('oracle',),
    );
    public function run()
    {
        // enter app name
        // enter app id (optional)
        // get composer -- in other threaded
        // run composer install -- in other threaded
        // get db connection
        // run migrations (ask for dummy data)
        // setup cache
        // ask for admin password and create/update user
    }
    protected function _testComposer()
    {
        
    }
    protected function _installComposer()
    {
        
    }
    protected function _createDbConnection(
        $driver,
        $host,
        $user,
        $password,
        $port=null
    ) {
        
    }
    protected function _runMigrations()
    {
        
    }
}
