<?php
namespace components;

class DateFormatterTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;
    protected static $defaultLanguage;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * Initializer method, saves original application language.
     *
     * @since 0.1.0
     */
    public static function setUpBeforeClass()
    {
        static::$defaultLanguage = \Yii::app()->language;
    }

    /**
     * Dispose method, returns original application language.
     *
     * @since 0.1.0
     */
    public static function setUpAfterClass()
    {
        \Yii::app()->language = static::$defaultLanguage;
    }

    /**
     * Ugliest data provider ever!
     *
     * @return array Test data.
     * @since 0.1.0
     */
    public function dateProvider()
    {
        $dates = array(

        // 2 hours, 2 minutes ago
            array('PT2H2M', array(
                'en' => '2 hours, 2 minutes ago',
                'ru' => '2 часа, 2 минуты назад',
            )),

            // 2 hours ago
            array('PT2H', array(
                'en' => '2 hours ago',
                'ru' => '2 часа назад',
            )),
    
            // 2 hours ago, now with units stripping minutes
            array('PT2H2M', array(
                'en' => '2 hours ago',
                'ru' => '2 часа назад',
            ), 1),
    
            // 3 days, 2 hours ago
            array('P3DT2H', array(
                'en' => '3 days, 2 hours ago',
                'ru' => '3 дня, 2 часа назад',
            )),
    
            // 5 years, 2 months, 1 day, 5 hours, 2 minutes, 1 second ago
            array('P5Y2M1DT5H2M1S', array(
                'en' => '5 years, 2 months, 1 day, 5 hours, 2 minutes, 1 second ago',
                'ru' => '5 лет, 2 месяца, 1 день, 5 часов, 2 минуты, 1 секунда назад',
            ), 6),
    
            // same thing, but with stripped seconds with the help of units
            array('P5Y2M1DT5H2M1S', array(
                'en' => '5 years, 2 months, 1 day, 5 hours, 2 minutes ago',
                'ru' => '5 лет, 2 месяца, 1 день, 5 часов, 2 минуты назад',
            ), 5),
    
            // 5 лет назад
            array('P5YT1M', array(
                'en' => '5 years ago',
                'ru' => '5 лет назад',
            ), 1),
    
            // 1 год, 1 день, 1 час, 1 минута, 1 секунда назад (месяцы пропущены)
            array('P1Y1DT1H1M1S', array(
                'en' => '1 year, 1 day, 1 hour, 1 minute, 1 second ago',
                'ru' => '1 год, 1 день, 1 час, 1 минута, 1 секунда назад',
            ), 6, ),
    
            // same thing, seconds and minutes stripped
            array('P1Y1DT1H1M1S', array(
                'en' => '1 year, 1 day, 1 hour ago',
                'ru' => '1 год, 1 день, 1 час назад',
            ), 4),
    
            // 10 часов, 2 минуты назад
            array('PT10H2M', array(
                'en' => '10 hours, 2 minutes ago',
                'ru' => '10 часов, 2 минуты назад',
            ), 2),
        );
        foreach ($dates as &$date) {
            $date[0] = new \DateInterval($date[0]);
        }
        return $dates;
    }

    /**
     * Set of invalid date definitions.
     *
     * @return array
     * @since 0.1.0
     */
    public function invalidDateProvider()
    {
        return array(
            array('invalid string',),
            array(500,),
            array(13.75,),
            array(new \stdClass,),
            array(array(),),
        );
    }

    /**
     * Set of invalid unit definitions.
     *
     * @return array
     * @since 0.1.0
     */
    public function invalidUnitsProvider()
    {
        return array(
            array('invalid string',),
            array(0,),
            array(new \stdClass,),
            array(array(),),
            array(false,),
        );
    }



    // tests
    /**
     * Tests {@link \DateFormatter} reset method.
     *
     * @covers \DateFormatter::reset()
     *
     * @since 0.1.0
     */
    public function testDateReset()
    {
        \Yii::app()->language = '00';
        // touch
        /** @var \DateFormatter $f */
        $f = \Yii::app()->dateFormatter;
        usleep(1.1 * 1000 * 1000);
        $f->reset();
        $this->assertSame('timeInterval.justNow', $f->format(new \DateTime));
    }
    /**
     * Testing suite for date conversion.
     *
     * @dataProvider dateProvider
     * @covers \DateProvider::format()
     *
     * @param \DateInterval $interval
     * @param string[] $expected Expected values in [:lang => :expected_result]
     * format.
     * @param int $units
     * @since 0.1.0
     */
    public function testDateConversion(
        \DateInterval $interval,
        array $expected,
        $units=2
    ) {
        foreach ($expected as $lang => $expectedResult) {
            \Yii::app()->language = $lang;
            \Yii::app()->dateFormatter->reset();
            $date = new \DateTime;
            $date->sub($interval);
            $formatted = \Yii::app()->dateFormatter->format($date, $units);
            $this->assertSame($expectedResult, $formatted);
        }
    }

    /**
     * Tests exception throwage on invalid date.
     *
     * @dataProvider invalidDateProvider
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Invalid date provided.
     *
     * @since 0.1.0
     */
    public function testInvalidDateException($date)
    {
        \Yii::app()->dateFormatter->format($date);
    }

    /**
     * Tests exception throwage on invalid units amount.
     *
     * @dataProvider invalidUnitsProvider
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Maximum units limit has to be integer not less than one.
     *
     * @since 0.1.0
     */
    public function testInvalidUnitsException($units)
    {
        \Yii::app()->dateFormatter->format(new \DateTime, $units);
    }

}