<?php
namespace components;


class ConfigFormatterTest extends \Codeception\TestCase\Test
{
    /**
     * @var \CodeGuy
     */
    protected $guy;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function configProvider()
    {
        return array(
            array(1, array('z' => 14),),
            array(2, array('a' => 'What\'s up?')),
            array(
                3,
                array(
                    'theme' => 'ambinight',
                    'name' => 'testName',
                    'language' => 'ru',
                )),
        );
    }
    public function valueProvider()
    {
        return array(
            array(1, 1,),
            array('supper', "'supper'",),
            array('supper\'', "'supper\''",),
            array('supper\\', "'supper\\'",),
            array(true, 'true',),
            array(false, 'false',),
            array(null, 'null',),
        );
    }

    /**
     * Escape function test.
     *
     * @param mixed $value          Value to be escaped
     * @param mixed $expectedOutput Expected result.
     *
     * @dataProvider valueProvider
     *
     * @return void
     * @since 0.1.0
     */
    public function testEscaping($value, $expectedOutput)
    {
        $editor = new \ConfigEditor;
        $this->assertSame($expectedOutput, $editor->escapeValue($value));
    }

    /**
     *
     *
     * @param $index
     * @param array $data
     *
     * @dataProvider configProvider
     *
     * @return void
     * @since
     */
    public function testRewrite($index, array $data)
    {
        $basePath = \Yii::getPathOfAlias('application.tests._data.config');
        $rawFilePath = sprintf('%s/raw.%s.php', $basePath, $index);
        $rewrittenFilePath = sprintf('%s/rewritten.%s.php', $basePath, $index);
        $dumpPath = sprintf(
            \Yii::getPathOfAlias('application.runtime.rewritten-config') .
            '.%d.php',
            $index
        );
        $rawFileContent = file_get_contents($rawFilePath);
        // $rawFileData = require $rawFilePath;
        $rewrittenFileContent = file_get_contents($rewrittenFilePath);
        $rewrittenFileData = require $rewrittenFilePath;
        $hambda = new \ConfigEditor;
        $newConfig = $hambda->rewriteConfig($rawFileContent, $data);
        file_put_contents($dumpPath, $newConfig);
        $this->assertSame($rewrittenFileContent, $newConfig);
        // it won't be same because of __FILE__ and __DIR__ usage. Text
        // comparison is quite an ok way to test.
        //$this->assertSame($rewrittenFileData, include $dumpPath);
    }
}