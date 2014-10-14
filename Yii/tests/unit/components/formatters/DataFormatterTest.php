<?php

/**
 * Testing suite for DataFormatter class.
 *
 * @todo more coverage, please
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class DataFormatterTest extends \Codeception\TestCase\Test
{
    /**
     * Data provider for {@link testDeslugify()} method
     *
     * @return array List of examples in [:slug, :capitalize, :expected] form.
     * @since 0.1.0
     */
    public function deslugifyDataProvider()
    {
        return array(
            array('test-slug', 'test slug'),
            array('space-pilot-3000', 'space pilot 3000'),
            array(
                'push-the-little--cart------heavy',
                'Push The Little Cart — Heavy',
                true
            ),
        );
    }

    /**
     * Data provider for {@link testSlugify()} method.
     *
     * @return array Test values in [:text, :slug, :translit] form.
     * @since 0.1.0
     */
    public function slugifyDataProvider()
    {
        return array(
            array('Push The Little Cart — Heavy', 'push-the-little-cart---heavy',),
            array('    wanna Dance  ?  ', 'wanna-dance',),
            array('Test Pilot 3000', 'test-pilot-3000',),
            array(
                'Дорогая -- ты сегодня уже рзжни?',
                'дорогая---ты-сегодня-уже-рзжни',
            ),
            array('Myötähäpeä', 'myotahapea', true),
            array('space-pilot-3000', 'space-pilot-3000', true),
        );
    }

    /**
     * Tests slugification service.
     *
     * @param string  $text           Text to be slugified.
     * @param string  $expectedOutput Expected slug.
     * @param boolean $translit       If true, ASCII-transliteration is applied.
     *
     * @dataProvider slugifyDataProvider
     *
     * @return void
     * @since 0.1.0
     */
    public function testSlugify($text, $expectedOutput, $translit=false)
    {
        $this->assertSame(
            \Yii::app()->formatter->slugify($text, $translit),
            $expectedOutput
        );
    }

    /**
     * Tests conversion from slug to text.
     *
     * @param string  $slug           Slug to process,
     * @param string  $expectedOutput Expected text.
     * @param boolean $capitalize     If set to true, {@link DataFormatter} will
     * be told to capitalize every word.
     *
     * @dataProvider deslugifyDataProvider
     *
     * @return void
     * @since 0.1.0
     */
    public function testDeslugify($slug, $expectedOutput, $capitalize=false)
    {
        $this->assertSame(
            \Yii::app()->formatter->deslugify($slug, $capitalize),
            $expectedOutput
        );
    }

    /**
     * Tests array rendering.
     *
     * @return void
     * @since 0.1.0
     */
    public function testArrayRendering()
    {
        $path = \Yii::getPathOfAlias('application.config.web').'.php';
        $dummy = include $path;
        $dummy2 = 'return '.\Yii::app()->formatter->renderArray($dummy).';';
        $this->assertEquals($dummy, eval($dummy2));
    }
}