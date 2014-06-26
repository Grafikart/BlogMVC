<?php

/**
 * Application model tests container.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package mvcblog
 * @subpackage Yii
 */
class ApplicationModelTest extends \Codeception\TestCase\Test
{
    /**
     * Cached model to prevent recreating it every time.
     *
     * @var ApplicationModel
     * @since 0.1.0
     */
    protected static $model;
    /**
     * Default config path alias.
     *
     * @var string
     * @since 0.1.0
     */
    protected static $defaultConfigAlias;
    /**
     * List of mock files to test application model errors in form of
     * :name => :permission_mode.
     *
     * @var int[]
     * @since 0.1.0
     */
    protected static $mockFiles = array(
        array(
            'alias' => 'application.runtime.not-writable',
            'mode' => 0444,
            'error' => ApplicationModel::CONFIG_FILE_NOT_WRITABLE,
            'createFile' => true,
            'data' => "<?php return array('components' => array());",
        ),
        array(
            'alias' => 'application.runtime.unreadable',
            'mode' => 0222,
            'error' => ApplicationModel::CONFIG_FILE_UNREADABLE,
            'createFile' => true,
        ),
        array(
            'alias' => 'application.runtime.missing-data',
            'mode' => 0777,
            'error' => ApplicationModel::CONFIG_FILE_MISSING_DATA,
            'createFile' => true,
        ),
        array(
            'alias' => 'application.runtime.missing',
            'mode' => false,
            'error' => ApplicationModel::CONFIG_FILE_MISSING,
            'createFile' => false,
        ),
    );
    protected static $mockConfigFile = 'application.runtime.mock';
    /**
     * A flag to run (or not to run) file-related tests.
     *
     * @type bool
     * @since 0.1.0
     */
    protected static $runFileTests = true;

    /**
     * Creates mock files on non-windows platforms or skips whole test on
     * windows platforms.
     *
     * @return void
     * @since 0.1.0
     */
    public static function setUpBeforeClass()
    {
        static::$model = new ApplicationModel;
        static::$defaultConfigAlias = static::$model->configFile;
        $configFile = \Yii::getPathOfAlias(static::$defaultConfigAlias).'.php';
        $mockConfigFile = \Yii::getPathOfAlias(static::$mockConfigFile).'.php';
        $data = file_get_contents($configFile);
        if (!$data || !file_put_contents($mockConfigFile, $data)) {
            static::markTestSkipped('Failed to create mock config file');
            return;
        }
        if (strpos('win', strtolower(PHP_OS))) {
            static::$runFileTests = false;
            return;
        }
        foreach (static::$mockFiles as $def) {
            if (isset($def['createFile']) && $def['createFile'] === false) {
                continue;
            }
            $path = \Yii::getPathOfAlias($def['alias']).'.php';
            if (file_exists($path) && !chmod($path, 0777)) {
                static::markTestSkipped('Failed to set permission mode on file');
                return;
            }
            if ((isset($def['data']) && !file_put_contents($path, $def['data']))
                || !touch($path)
            ) {
                static::markTestSkipped('Couldn\'t create mock file');
                return;
            }
            if (!chmod($path, $def['mode'])) {
                static::markTestSkipped('Failed to set permission mode on file');
                return;
            }
        }
    }

    /**
     * A fixer for not-called setUpBeforeClass().
     *
     * @return void
     * @since 0.1.0
     */
    public function _before()
    {
    }

    /**
     * Deletes mock files.
     *
     * @return void
     * @since 0.1.0
     */
    public static function tearDownAfterClass()
    {
        if (!static::$runFileTests) {
            return;
        }
        foreach (static::$mockFiles as $file) {
            $path = Yii::getPathOfAlias($file['alias']).'.php';
            if (file_exists($path) && chmod($path, 0777)) {
                unlink($path);
            }
        }
    }

    /**
     * Provides list of mock files and expected errors.
     *
     * @return array List of files in :alias => alias, :error => error_code
     * form.
     * @since 0.1.0
     */
    public function configFileProvider()
    {
        $files = array();
        foreach (static::$mockFiles as $file) {
            $files[] = array($file['alias'], $file['error']);
        }
        return $files;
    }

    /**
     * Data provider for language checking.
     *
     * @return array Language list in :language_code, :is_supported form.
     * @since 0.1.0
     */
    public function languageProvider()
    {
        return array(
            array('en', true,),
            array('ru', true,),
            array('nonExistentLanguage', false),
        );
    }

    /**
     * Tests erroneous behavior in case of inaccessible file.
     *
     * @param string $alias         Config file alias.
     * @param int    $expectedError Expected error code.
     *
     * @dataProvider configFileProvider
     * @return void
     * @since 0.1.0
     */
    public function testFileErrors($alias, $expectedError)
    {
        $model = new \ApplicationModel;
        if (!static::$runFileTests) {
            $msg = 'Config file erroneous reading is skipped on win platforms';
            $this->markTestSkipped($msg);
            return;
        }
        $model->configFile = $alias;
        $model->save(array('language' => 'ru'));
        $errorKey = key($model->configErrors);
        $this->assertSame($errorKey, $expectedError);
    }

    /**
     * Checks language validation.
     *
     * @param string $language       Language to be saved.
     * @param string $expectedOutput What save function should return.
     *
     * @dataProvider languageProvider
     *
     * @return void
     * @since 0.1.0
     */
    public function testLanguageSave($language, $expectedOutput)
    {
        $model = new \ApplicationModel;
        $model->configFile = static::$defaultConfigAlias;
        $model->language = $language;
        $this->assertSame(
            $expectedOutput,
            $model->save(),
            print_r($model->getErrors(), true)
        );
    }

    /**
     * Added as a temporary bugfix for not-calling `setUpBeforeClass()`
     *
     * @see https://github.com/sebastianbergmann/phpunit/issues/1295
     *
     * @return void
     * @since
     */
    public function testDummy()
    {

    }
} 