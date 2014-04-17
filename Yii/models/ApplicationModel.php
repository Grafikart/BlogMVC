<?php

/**
 * This model works with application-scope data (config) or data from all
 * application components (statistics).
 *
 * @todo Add profiling
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
    /**
     * List of errors related to config editing.
     *
     * @var string[]
     * @since 0.1.0
     */
    public $configErrors = array();
    /**
     * Yii path alias pointing to config file.
     * 
     * @var string
     * @since 0.1.0
     */
    public $configFile = 'application.config.front';
    /**
     * Attribute labels cache.
     * 
     * @var string[]
     * @since 0.1.0
     */
    protected $attributeLabels;
    
    /**
     * Error code for missing config file.
     * 
     * @var int
     * @since 0.1.0
     */
    const CONFIG_FILE_MISSING = 1;
    /**
     * Error code for unreadable config file.
     * 
     * @var int
     * @since 0.1.0
     */
    const CONFIG_FILE_UNREADABLE = 2;
    /**
     * Error code for missing config data.
     * 
     * @var int
     * @since 0.1.0
     */
    const CONFIG_FILE_MISSING_DATA = 3;
    /**
     * Error code for unwritable config file.
     * 
     * @var int
     * @since 0.1.0
     */
    const CONFIG_FILE_NOT_WRITABLE = 4;

    /**
     * Main constructor. Separated with {@link init()} to support logic
     * consistency.
     *
     * @since 0.1.0
     */
    public function __construct()
    {
        $this->init();
    }
    /**
     * Main initializer method.
     *
     * @since 0.1.0
     */
    public function init()
    {
        $this->name = \Yii::app()->name;
        $this->language = \Yii::app()->language;
    }
    /**
     * Returns current or cached statistics.
     * 
     * @return string[] Key-value statistics pairs.
     * @since 0.1.0
     */
    public static function getStatistics()
    {
        if (($stats = \Yii::app()->cache->get('app.statistics')) === false) {
            $stats = array(
                'users.total' => User::model()->count(),
                'categories.total' => Category::model()->count(),
                'posts.total' => Post::model()->count(),
                'posts.today' => Post::model()->today(),
                'comments.total' => Comment::model()->count(),
                'comments.today' => Comment::model()->today(),
            );
            foreach ($stats as $key => $value) {
                unset($stats[$key]);
                $stats[Yii::t('templates', 'statistics.'.$key)] = $value;
            }
            $dep = new CGlobalStateCacheDependency('lastPost');
            Yii::app()->cache->set('app.statistics', $stats, 3600, $dep);
        }
        return $stats;
    }

    /**
     * Saves current model config.
     *
     * @param string[] $attributes Attributes to be saved.
     *
     * @return bool True on success, false otherwise.
     * @since 0.1.0
     */
    public function save(array $attributes=null)
    {
        if ($attributes !== null) {
            $this->setAttributes($attributes);
        }
        if (!$this->validate()) {
            return false;
        }
        $this->configErrors = array();
        $result = $this->updateConfig();
        $l10nData = array('{path}' => Yii::getPathOfAlias($this->configFile));
        switch ($result) {
            case self::CONFIG_FILE_MISSING:
                $error = Yii::t('validation-errors', 'app.missingConfig', $l10nData);
                $this->configErrors[$result] = $error;
                return false;
            case self::CONFIG_FILE_MISSING_DATA:
                $error = Yii::t('validation-errors', 'app.missingConfigData', $l10nData);
                $this->configErrors[$result] = $error;
                return false;
            case self::CONFIG_FILE_NOT_WRITABLE:
                $error = Yii::t('validation-errors', 'app.configNotWritable', $l10nData);
                $this->configErrors[$result] = $error;
                return false;
            case self::CONFIG_FILE_UNREADABLE:
                $error = Yii::t('validation-errors', 'app.unreadableConfig', $l10nData);
                $this->configErrors[$result] = $error;
                return false;
        }
        return true;
    }
    /**
     * Updates current config.
     * 
     * @return int {@link writeConfig()} return value.
     * @since 0.1.0
     */
    public function updateConfig()
    {
        $config = $this->readConfig($this->configFile);
        if (!is_array($config)) {
            return $config;
        }
        $config['name'] = Yii::app()->formatter->escape($this->name);
        Yii::app()->language = $config['language'] = $this->language;
        Yii::app()->name = $this->name;
        return $this->writeConfig($this->configFile, $config);
    }
    /**
     * Reads config file using it's Yii path alias.
     * 
     * @param string $alias Yii path alias.
     * @return array|int Array of data or one of self::CONFIG_FILE_* error
     * constants.
     * @since 0.1.0
     */
    protected function readConfig($alias)
    {
        $path = Yii::getPathOfAlias($alias).'.php';
        if (!file_exists($path)) {
            return self::CONFIG_FILE_MISSING;
        }
        if (!is_readable($path)) {
            return self::CONFIG_FILE_UNREADABLE;
        }
        $data = include($path);
        if (!is_array($data) || sizeof($data) === 0) {
            return self::CONFIG_FILE_MISSING_DATA;
        }
        return $data;
    }
    /**
     * Writes provided config into config file.
     * 
     * @param string $alias Yii path alias for config file.
     * @param array $config New config.
     * @return int Number of written bytes or one of self::CONFIG_FILE_* error
     * constants. Since number of written bytes should be big (20+), error
     * codes should no intersect with it.
     * @since 0.1.0
     */
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
            Yii::app()->formatter->renderArray($config),
            $template
        );
        return file_put_contents($path, $config);
    }
    /**
     * Returns list of available languages.
     * 
     * @return string[] List of available languages.
     * @since 0.1.0
     */
    public function getAvailableLanguages()
    {
        return array('en' => 'English', 'ru' => 'Русский / Russian');
    }

    /**
     * Validates that provided language is allowed.
     *
     * @param $attribute string Language attribute name.
     * @since 0.1.0
     */
    public function validateLanguage($attribute)
    {
        $lang = $this->$attribute;
        $supported = $this->getAvailableLanguages();
        if (!in_array($lang, array_keys($supported), true)) {
            $error = Yii::t(
                'validation-errors',
                'app.unsupportedLanguage',
                array('{lang}' => $lang)
            );
            $this->addError($attribute, $error);
        }
    }
    /**
     * Standard Yii method for returning set of attribute names.
     * 
     * @return string[] List of attribute names.
     * @since 0.1.0
     */
    public function attributeNames()
    {
        return array(
            'name',
            'language',
        );
    }
    /**
     * Returns localized attribute labels.
     * 
     * @return string[] Localized attribute labels.
     * @since 0.1.0
     */
    protected function getAttributeLabels()
    {
        return array(
            'name' => Yii::t('forms-labels', 'application.name'),
            'language' => Yii::t('forms-labels', 'application.language'),
        );
    }
    /**
     * Returns cached attribute labels.
     * 
     * @return string[] Localized attribute labels.
     * @since 0.1.0
     */
    public function attributeLabels() {
        if (!isset($this->attributeLabels)) {
            $this->attributeLabels = $this->getAttributeLabels();
        }
        return $this->attributeLabels;
    }
    /**
     * Method defining validation rules.
     * 
     * @return array Validation rules.
     * @since 0.1.0
     */
    public function rules()
    {
        return array(
            array(
                array('name',),
                'safe',
            ),
            array(
                array('language',),
                'validateLanguage'
            )
        );
    }
}
