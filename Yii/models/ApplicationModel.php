<?php

/**
 * This model works with application-scope data (config) or data from all
 * application components (statistics).
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package mvcblog
 * @subpackage yii
 */
class ApplicationModel extends CModel
{
    /**
     * Application name, used as site title.
     * 
     * @var string
     * @since 0.1.0
     */
    public $name;
    /**
     * Application language. Can be either 'ru' or 'en' (until someone adds
     * another translation).
     * 
     * @var string
     * @since 0.1.0
     */
    public $language;
    protected $configFile = 'application.config.front';
    
    const CONFIG_FILE_MISSING = 1;
    const CONFIG_FILE_UNREADABLE = 2;
    const CONFIG_FILE_MISSING_DATA = 3;
    const CONFIG_FILE_NOT_WRITABLE = 4;

    public function __construct()
    {
        $this->name = Yii::app()->name;
        $this->language = Yii::app()->language;
    }
    public static function getStatistics()
    {
        $stats = array(
            'users.total' => User::model()->total(),
            'categories.total' => Category::model()->total(),
            'posts.total' => Post::model()->total(),
            'posts.today' => Post::model()->today(),
            'comments.total' => Comment::model()->total(),
            'comments.today' => Comment::model()->today(),
        );
        foreach ($stats as $key => $value) {
            unset($stats[$key]);
            $stats[Yii::t('templates', 'statistics.'.$key)] = $value;
        }
        return $stats;
    }
    public function updateConfig()
    {
        $config = $this->readConfig($this->configFile);
        $config['name'] = Yii::app()->formatter->escape($this->name);
        Yii::app()->language = $config['language'] = $this->language;
        Yii::app()->name = $this->name;
        $this->writeConfig($this->configFile, $config);
    }
    protected function readConfig($alias)
    {
        $path = Yii::getPathOfAlias($alias).'.php';
        if (!file_exists($path)) {
            return false;
        }
        return include($path);
    }
    protected function writeConfig($alias, array $config)
    {
        $path = Yii::getPathOfAlias($alias).'.php';
        if (!file_exists($path)) {
            return self::CONFIG_FILE_MISSING;
        } else if (!is_writable($path)) {
            return self::CONFIG_FILE_NOT_WRITABLE;
        }
        $template = "<?php\nreturn :config;\n";
        $config = str_replace(
            ':config',
            Yii::app()->formatter->formatArray($config, 'php'),
            $template
        );
        return file_put_contents($path, $config);
    }
    public function dumpConfig()
    {
        $config = $this->readConfig($this->configFile);
        if (!is_array($config)) {
            return $config;
        }
        return Yii::app()->formatter->formatArray($config, 'php');
    }
    public function getAvailableLanguages()
    {
        return array('en' => 'English', 'ru' => 'Русский / Russian');
    }
    public function attributeNames()
    {
        return array(
            'name',
            'language',
        );
    }
    /**
     * @todo: cache i18n
     */
    public function attributeLabels() {
        return array(
            'name' => Yii::t('forms-labels', 'application.name'),
            'language' => Yii::t('forms-labels', 'application.language'),
        );
    }
    public function rules()
    {
        return array(
            array(
                array('name', 'language'),
                'safe',
            ),
        );
    }
}
