<?php
/**
 * 
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
        $driver = strtolower($driver);
        $drivers = array(
            'mysql' => 'mysql',
            'pgsql' => 'pgsql',
            'postgresql' => 'pgsql',
            'sqlite' => 'sqlite',
            'oci' => 'oci',
            'oracle' => 'oci',
            'mssql' => 'mssql',
            'sqlserver' => 'mssql'
        );
        if (in_array($driver, array_keys($drivers), true)) {
            return $drivers[$driver];
        }
        throw new \BadMethodCallException('Invalid driver provided');
    }

    /**
     * Return CDbExpression equivalent of MySQL CURDATE() function.
     *
     * @param null|string $driver Driver name. If set to null (or omitted),
     * default one will be used.
     *
     * @return CDbExpression
     * @since
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
                $expr = 'CAST(GET_DATE() AS DATE)';
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
}
 