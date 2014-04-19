<?php
namespace components\services;

class DatabaseServiceTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    protected function _before()
    {
    }

    protected function _after()
    {
    }


    /**
     * Data provider for {@link testGetDriverByName()}
     *
     * @return array Testing data.
     * @since 0.1.0
     */
    public function driverNamesProvider()
    {
        return array(
            array('MySQL', 'mysql',),
            array('PgSQL', 'pgsql',),
            array('PostgreSQL', 'pgsql',),
            array('Postgres', 'pgsql',),
            array('SQLite', 'sqlite',),
            array('SQLite3', 'sqlite',),
            array('Oracle', 'oci',),
            array('oci', 'oci',),
            array('MSSQL', 'mssql',),
            array('SQLServer', 'mssql',),
            array('SQL Server', 'mssql',),
            array('Microsoft SQL Server', 'mssql'),
            array('Oracle Server Express Edition', 'oci'),
            array('MySQL 5.5', 'mysql'),
        );
    }

    /**
     * Data provider for {@link testGetCurDateExpression()}
     *
     * @return array Testing data.
     * @since 0.1.0
     */
    public function curDateExpressionProvider()
    {
        return array(
            array('MySQL', 'CURRENT_DATE',),
            array('PgSQL', 'CURRENT_DATE',),
            array('SQLite3', 'DATE(\'now\')',),
            array('Oracle', 'CURRENT_DATE',),
            array('MSSQL', 'CAST(GETDATE() AS DATE)',),
        );
    }

    /**
     * Data provider for {@link testGetCurTimeExpression()}
     *
     * @return array Testing data.
     * @since 0.1.0
     */
    public function curTimeExpressionProvider()
    {
        return array(
            array('mysql 5.5', 'CURRENT_TIME',),
            array('PGSQL 9.1', 'CURRENT_TIME',),
            array('sqlite', 'TIME(\'now\')',),
            array('oci', 'CURRENT_TIME',),
            array('SQL Server Compact Edition', 'CAST(GETDATE() AS TIME)',),
        );
    }

    /**
     * Data provider for {@link testGetNowExpression()}.
     *
     * @return array Testing data.
     * @since 0.1.0
     */
    public function nowExpressionProvider()
    {
        return array(
            array('mysql', 'CURRENT_TIMESTAMP',),
            array('postgres', 'CURRENT_TIMESTAMP',),
            array('sqlite server', 'DATETIME(\'now\')',),
            array('oracle', 'CURRENT_TIMESTAMP',),
            array('mssql', 'CURRENT_TIMESTAMP',),
        );
    }

    /**
     * Data provider for {@link testInvalidDriverNameException()}.
     *
     * @return array Set of testing data.
     * @since 0.1.0
     */
    public function invalidDriverNamesProvider()
    {
        $names = array(
            false,
            'false',
            17,
            0.125,
            0,
            new \stdClass,
            array('several'),
        );
        $data = array();
        foreach ($names as $name) {
            $data[] = array($name);
        }
        return $data;
    }

    // tests

    /**
     * Tests {@link \DatabaseService::getDriverByName()}.
     *
     * @param string $commonName Driver common name.
     * @param string $driverName PDO-compatible driver name.
     *
     * @dataProvider driverNamesProvider
     *
     * @return void
     * @since 0.1.0
     */
    public function testGetDriverByName($commonName, $driverName)
    {
        $this->assertSame(
            $driverName,
            \DatabaseService::getDriverByName($commonName)
        );
    }

    /**
     * Tests {@link \DatabaseService::getCurDateExpression()}.
     *
     * @param string $driver       Driver name.
     * @param string $expectedExpr Expected expression text.
     *
     * @dataProvider curDateExpressionProvider
     *
     * @return void
     * @since 0.1.0
     */
    public function testGetCurDateExpression($driver, $expectedExpr)
    {
        $expr = \DatabaseService::getCurDateExpression($driver);
        $this->assertSame($expectedExpr, $expr->expression);
    }

    /**
     * Tests {@link \DatabaseService::getCurTimeExpression()}.
     *
     * @param string $driver       Driver name.
     * @param string $expectedExpr Expected expression text.
     *
     * @dataProvider curTimeExpressionProvider
     *
     * @return void
     * @since 0.1.0
     */
    public function testGetCurTimeExpression($driver, $expectedExpr)
    {
        $expr = \DatabaseService::getCurTimeExpression($driver);
        $this->assertSame($expectedExpr, $expr->expression);
    }

    /**
     * Tests {@link \DatabaseService::getCurNowExpression()}.
     *
     * @param string $driver       Driver name.
     * @param string $expectedExpr Expected expression text.
     *
     * @dataProvider nowExpressionProvider
     *
     * @return void
     * @since 0.1.0
     */
    public function testGetNowExpression($driver, $expectedExpr)
    {
        $expr = \DatabaseService::getNowExpression($driver);
        $this->assertSame($expectedExpr, $expr->expression);
    }

    /**
     * Tests failures on incorrect driver names.
     *
     * @param string $incorrectDriver Invalid driver name.
     *
     * @dataProvider invalidDriverNamesProvider
     * @expectedException \BadMethodCallException
     *
     * @return void
     * @since 0.1.0
     */
    public function testInvalidDriverNameException($incorrectDriver)
    {
        \DatabaseService::getNowExpression($incorrectDriver);
    }
}