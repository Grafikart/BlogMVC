<?php

/**
 * This is an abstract base class for all migrations tests. Since it is nearly
 * impossible to have all DB ready for tests, it implements a skeleton for
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 */
abstract class BaseMigrationTest extends CTestCase
{
    /**
     * Connection to the testing DB.
     * 
     * @var CDbConnection
     * @since 0.1.0
     */
    protected static $db;
    /**
     * List of migrations.
     * 
     * @var CDbMigration[]
     * @since 0.1.0
     */
    protected static $migrations = array();
    /**
     * Output buffering flag. If set to true, output buffering is started.
     * 
     * @var boolean
     * @since 0.1.0
     */
    protected static $buffering = false;
    /**
     * Verbosity flag. If set to true, test will output all include all log
     * data on fail.
     * 
     * @var boolean
     * @since 0.1.0
     */
    protected static $verbose = false;
    /**
     * A mandatory function that returns testing DB service name.
     * 
     * @return string DB provider name.
     * @since 0.1.0
     */
    public static function getDbProviderName()
    {
        if (!property_exists(get_called_class(), 'provider')) {
            $message = 'Derived migration test class doesn\'t specify it\'s '.
                'provider';
            throw new \RuntimeException($message);
        }
        return static::$provider;
    }
    /**
     * Typical one-run setup method. Truncates test database, 
     * 
     * @return void
     * @since 0.1.0
     */
    public static function setUpBeforeClass()
    {
        Yii::import('application.migrations');
        $provider = static::getDbProviderName().'TestConnection';
        /** @type CWebApplication $app */
        $app = \Yii::app();
        if ($app->hasComponent($provider)) {
            static::$db = $app->$provider;
            static::truncateDatabase();
            static::setMigrations();
        } else {
            $message = 'Application database provider "'.$provider.'" '.
                       'doesn\'t exist.';
            static::markTestSkipped($message);
        }
    }
    /**
     * Frees up memory taken by migrations after test.
     * I seriously don't know for how long test is kept in memory so better be
     * safe than fatty.
     * 
     * @return void
     * @since 0.1.0
     */
    public static function tearDownAfterClass()
    {
        static::$migrations = array();
    }
    /**
     * Sets up list of migrations.
     * 
     * @return void
     * @since 0.1.0
     */
    public function setMigrations()
    {
        $path = Yii::getPathOfAlias('application.migrations');
        Yii::import('application.migrations.*');
        $files = scandir($path);
        foreach ($files as $file) {
            if (preg_match('#^m\d{6}_\d{6}[\w_]*\.php$#', $file)) {
                $migrationName = substr($file, 0, strlen($file) - 4);
                /**
                 * @var $migration CDbMigration
                 */
                $migration = new $migrationName;
                $migration->setDbConnection(static::$db);
                static::$migrations[] = $migration;
            }
        }
    }
    /**
     * Starts internal buffering.
     * 
     * @return void
     * @since 0.1.0
     */
    public static function startBuffering()
    {
        if (!static::$buffering) {
            ob_start();
            static::$buffering = true;
        }
    }
    /**
     * Ends internal buffering and returns output.
     * 
     * @return boolean|string False if buffering hasn't been started, buffer
     * content otherwise.
     * @since 0.1.0
     */
    public static function endBuffering()
    {
        if (static::$buffering) {
            static::$buffering = false;
            return ob_get_clean();
        }
        return false;
    }
    /**
     * Extension to the original {@link fail()} method which will add all data
     * in the buffer to the fail text.
     * 
     * @param string $text
     * @since 0.1.0
     */
    public static function fail($text)
    {
        $data = static::endBuffering();
        if ($data) {
            $text .= PHP_EOL.PHP_EOL.$data;
        }
        parent::fail($text);
    }
    /**
     * Tests migrations one by one.
     * 
     * @return void
     * @since 0.1.0
     */
    public function testMigrations()
    {
        static::startBuffering();
        foreach (static::$migrations as $migration) {
            try {
                if ($migration->up() === false) {
                    $this->fail('Migration has returned "failed" status');
                }
            } catch (CDbException $e) {
                $this->fail('CDbException: '.$e->getMessage());
            }
        }
        static::$migrations = array_reverse(static::$migrations);
        foreach (static::$migrations as $migration) {
            try {
                if ($migration->down() === false) {
                    $this->fail('Migration has returned "failed" status');
                }
            } catch (CDbException $e) {
                $this->fail('CDbException: '.$e->getMessage());
            }
        }
        static::endBuffering();
    }
    /**
     * Deletes all tables from database. Since it is unknown from here which
     * tables will be created, the only safe way is to destroy everything
     * what is possible. 
     * 
     * @return void
     * @since 0.1.0
     */
    protected static function truncateDatabase()
    {
        $db = static::$db;
        $tables = $db->schema->getTables();
        $count = 0;
        while ($count != sizeof($tables)) {
            $count = sizeof($tables);
            foreach ($tables as $key => $table) {
                try {
                    $db->createCommand()->dropTable($table->name);
                    unset($tables[$key]);
                } catch (Exception $ex) {
                    // since some tables are bound by foreign keys (that not
                    // always could be dropped), it's most likely there will be
                    // some exceptions, so they are just ignored until there is
                    // cyclic reference or all tables are dropped.
                }
            }
        }
        if ($count > 0) {
            $tableNames = array();
            foreach ($tables as $table) {
                $tableNames[] = $table->name;
            }
            $message = sprintf(
                '%s: Could not clear up database, following tables refused to '.
                'drop: [%s]',
                get_called_class(),
                implode(', ', $tableNames)
            );
            static::fail($message);
        }
    }
}
