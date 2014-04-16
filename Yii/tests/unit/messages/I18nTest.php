<?php
namespace messages;
use Codeception\Util\Stub;

class I18nTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;
    protected static $translations = array();
    /**
     * List of existing sections in [:name => :section_keys] form.
     *
     * @var array
     * @since 0.1.0
     */
    protected static $sections = array();

    protected function _before()
    {

    }

    protected function _after()
    {

    }

    public static function setUpBeforeClass()
    {
        static::loadTranslations();
    }
    public static function tearDownAfterClass()
    {
        static::$translations = array();
    }

    protected static function loadTranslations()
    {
        $messagesPath = \Yii::app()->getMessages()->basePath;
        foreach (new \DirectoryIterator($messagesPath) as $entry) {
            if ($entry->isDot() || !$entry->isDir()) {
                continue;
            }
            $lang = $entry->getFilename();
            static::$translations[$lang] = array();
            foreach(new \DirectoryIterator($entry->getPathname()) as $file) {
                $rpos = strrpos($file->getFilename(), '.php');
                if ($rpos !== strlen($file->getFilename()) - 4) {
                    continue;
                }
                $section = substr($file->getFilename(), 0, $rpos);
                if (!isset(static::$sections[$section])) {
                    static::$sections[$section] = array();
                }
                static::$translations[$lang][$section] = include($file->getPathname());
                static::$sections[$section] = array_flip(array_merge(
                    array_flip(static::$sections[$section]),
                    static::$translations[$lang][$section]
                ));
            }
        }
    }
    public function format($messages) {
        $repr = '';
        foreach ($messages as $lang => $sections) {
            $repr .= 'language: '.$lang.PHP_EOL;
            foreach ($sections as $section => $errors) {
                if (is_string($errors)) {
                    $repr .= '  '.$section.': '.$errors.PHP_EOL;
                }
                elseif (is_array($errors)) {
                    $repr .= '  '.$section.PHP_EOL;
                    foreach ($errors as $tKey => $error) {
                        $repr .= sprintf('    %s: %s'.PHP_EOL, $tKey, $error);
                    }
                }
            }
        }
        return $repr;
    }

    // tests
    public function testTranslationsExistence()
    {
        $messages = array();
        foreach(static::$translations as $lang => $sections) {
            $errors = $this->validateLanguage($sections);
            if (sizeof($errors) > 0) {
                $messages[$lang] = $errors;
            }
        }
        if (sizeof($messages) > 0) {
            $this->fail($this->format($messages));
        }
    }
    public function validateLanguage($language)
    {
        $messages = array();
        foreach (static::$sections as $sectionName => $sectionKeys) {
            if (!isset($language[$sectionName])) {
                $messages[$sectionName] = 'Section is missing completely';
                continue;
            }
            $errors = $this->validateSection(
                $sectionName,
                $language[$sectionName]
            );
            if (sizeof($errors) > 0) {
                $messages[$sectionName] = $errors;
            }
        }
        return $messages;
    }
    public function validateSection($name, $section)
    {
        $errors = array();
        $keys = static::$sections[$name];
        foreach ($keys as $key) {
            if (!isset($section[$key])) {
                $errors[$key] = 'Translation is missing';
            }
        }
        return $errors;
    }

}