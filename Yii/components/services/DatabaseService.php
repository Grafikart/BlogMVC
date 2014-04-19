<?php
/**
 * This class serves as a single-interface factory for different DB engines
 * expressions.
 * All interactions are made statically so there's no need to call this class
 * as Yii component.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class DatabaseService extends CComponent
{
    /**
     * Default driver name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $driver;

    /**
     * Yii standard initializer.
     *
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
    }

    /**
     * Returns default driver name.
     *
     * @return string
     * @since 0.1.0
     */
    protected static function getDefaultDriver()
    {
        if (self::$driver === null) {
            self::$driver = \Yii::app()->db->getDriverName();
        }
        return self::$driver;
    }

    /**
     * Returns driver by it's name.
     *
     * @param string $driver Driver name. If set to null (or omitted),
     * default one will be used.
     *
     * @throws BadMethodCallException Thrown if unknown driver name is provided.
     *
     * @return string Driver name.
     * @since 0.1.0
     */
    protected static function getDriver($driver)
    {
        if ($driver === null) {
            return self::getDefaultDriver();
        }
        if (is_string($driver)) {
            $driver = self::getDriverByName($driver);
        }
        if (!is_string($driver)) {
            throw new \BadMethodCallException('Invalid driver provided');
        }
        return $driver;
    }

    /**
     * Returns Yii/PDO-compatible driver name based on passed one.
     *
     * @param string $driver Driver name.
     *
     * @return string|null Name if found, null otherwise.
     * @since 0.1.0
     */
    public static function getDriverByName($driver)
    {
        $driver = strtolower($driver);
        $drivers = array(
            'mysql' => 'mysql',
            'pgsql' => 'pgsql',
            'postgres' => 'pgsql',
            //'postgresql' => 'pgsql', // satisified by `postgres`
            'sqlite' => 'sqlite',
            //'sqlite3' => 'sqlite', // satisfied by `sqlite`
            'oci' => 'oci',
            'oracle' => 'oci',
            'mssql' => 'mssql',
            'sqlserver' => 'mssql',
            'sql server' => 'mssql',
        );
        if (in_array($driver, array_keys($drivers), true)) {
            return $drivers[$driver];
        }
        foreach ($drivers as $commonName => $driverName) {
            if (strpos($driver, $commonName) !== false) {
                return $driverName;
            }
        }
        return null;
    }

    /**
     * Return CDbExpression equivalent of MySQL CURDATE() function.
     *
     * @param null|string $driver Driver name. If set to null (or omitted),
     * default one will be used.
     *
     * @return CDbExpression
     * @since 0.1.0
     */
    public static function getCurDateExpression($driver=null)
    {
        $driver = self::getDriver($driver);
        switch ($driver) {
            case 'mysql':
            case 'pgsql':
            case 'oci':
                $expr = 'CURRENT_DATE';
                break;
            case 'sqlite':
                $expr = 'DATE(\'now\')';
                break;
            case 'mssql':
                $expr = 'CAST(GETDATE() AS DATE)';
                break;
        }
        return new \CDbExpression($expr);
    }

    /**
     * Returns CDbExpression equivalent of MySQL `NOW()` function.
     *
     * @param null|string $driver Driver name. If set to null (or omitted),
     * default one will be used.
     *
     * @return \CDbExpression
     * @since 0.1.0
     */
    public static function getNowExpression($driver=null)
    {
        $driver = self::getDriver($driver);
        if ($driver === 'sqlite') {
            return new \CDbExpression('DATETIME(\'now\')');
        }
        return new \CDbExpression('CURRENT_TIMESTAMP');
    }

    /**
     * Returns CDbExpression equivalent of MySQL `CURTIME()` function.
     *
     * @param null|string $driver Driver name. If set to null (or omitted),
     * default one will be used.
     *
     * @throws BadMethodCallException
     *
     * @return CDbExpression
     * @since 0.1.0
     */
    public static function getCurTimeExpression($driver=null)
    {
        $driver = self::getDriver($driver);
        switch ($driver) {
            case 'mysql':
            case 'pgsql':
            case 'oci':
                $expr = 'CURRENT_TIME';
                break;
            case 'mssql':
                $expr = 'CAST(GETDATE() AS TIME)';
                break;
            case 'sqlite':
                $expr = 'TIME(\'now\')';
                break;
        }
        return new \CDbExpression($expr);
    }
}
 