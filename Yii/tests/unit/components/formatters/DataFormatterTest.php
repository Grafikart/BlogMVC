<?php

/**
 * Testing suite for DataFormatter class.
 *
 * @todo more test examples for slug services
 * @todo more coverage, please
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 */
class DataFormatterTest extends \CTestCase {
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
            array('push-the-little--cart------heavy', 'Push The Little Cart — Heavy', true),
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
            array('Дорогая -- ты сегодня уже рзжни?', 'дорогая---ты-сегодня-уже-рзжни',),
            array('Myötähäpeä', 'myotahapea', true),
            array('space-pilot-3000', 'space-pilot-3000', true),
        );
    }

    /**
     * Tests slugification service.
     *
     * @dataProvider slugifyDataProvider
     *
     * @param string $text Text to be slugified.
     * @param string $expectedOutput Expected slug.
     * @param boolean $translit If true, ASCII-transliteration is applied.
     * @since 0.1.0
     */
    public function testSlugify($text, $expectedOutput, $translit=false)
    {
        $this->assertSame(
            Yii::app()->formatter->slugify($text, $translit),
            $expectedOutput
        );
    }

    /**
     * Tests conversion from slug to text.
     *
     * @dataProvider deslugifyDataProvider
     *
     * @param string $slug Slug to process,
     * @param string $expectedOutput Expected text.
     * @param boolean $capitalize If set to true, {@link DataFormatter} will
     * be told to capitalize every word.
     * @since 0.1.0
     */
    public function testDeslugify($slug, $expectedOutput, $capitalize=false)
    {
        $this->assertSame(
            Yii::app()->formatter->deslugify($slug, $capitalize),
            $expectedOutput
        );
    }
} 