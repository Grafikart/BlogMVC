<?php

/**
 * This model works with application-scope data (config) or data from all
 * application components (statistics).
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
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
     * Current application theme.
     *
     * @var string
     * @since 0.1.0
     */
    public $theme;
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
    public $configFile = 'application.config.web';
    /**
     * Public skins path.
     *
     * @var string
     * @since 0.1.0
     */
    public $themesPath = 'application.public.skins';
    /**
     * Attribute labels cache.
     * 
     * @var string[]
     * @since 0.1.0
     */
    protected $attributeLabels;
    /**
     * Available themes cache.
     *
     * @var string[] List of available themes.
     * @since 0.1.0
     */
    protected $availableThemes;
    
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
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
        /** @type \CWebApplication $app */
        $app = \Yii::app();
        $this->name = $app->name;
        $this->language = $app->language;
        $this->theme = $app->theme->name;
    }
    /**
     * Returns current or cached statistics.
     * 
     * @return string[] Key-value statistics pairs.
     * @since 0.1.0
     */
    public static function getStatistics()
    {
        \Yii::beginProfile('applicationModel.getStatistics');
        if (($stats = \Yii::app()->cacheHelper->get('app.statistics')) === false) {
            \Yii::beginProfile('applicationModel.retrieveStatistics');
            $stats = array(
                'users.total' => \User::model()->count(),
                'categories.total' => \Category::model()->count(),
                'posts.total' => \Post::model()->count(),
                'posts.today' => \Post::model()->today(),
                'comments.total' => \Comment::model()->count(),
                'comments.today' => \Comment::model()->today(),
            );
            \Yii::app()->cacheHelper->setGlobalDependentCache(
                'app.statistics',
                $stats,
                3600
            );
            \Yii::endProfile('applicationModel.retrieveStatistics');
        }
        foreach ($stats as $key => $value) {
            unset($stats[$key]);
            $stats[\Yii::t('templates', 'statistics.'.$key)] = $value;
        }
        \Yii::endProfile('applicationModel.getStatistics');
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
        \Yii::beginProfile('applicationModel.save');
        if ($attributes !== null) {
            $this->setAttributes($attributes);
        }
        if (!$this->validate()) {
            return false;
        }
        $this->configErrors = array();
        $result = $this->updateConfig();
        $l10nData = array('{path}' => \Yii::getPathOfAlias($this->configFile));
        switch ($result) {
            case self::CONFIG_FILE_MISSING:
                $error = \Yii::t('validation-errors', 'app.missingConfig', $l10nData);
                $this->configErrors[$result] = $error;
                return false;
            case self::CONFIG_FILE_MISSING_DATA:
                $error = \Yii::t('validation-errors', 'app.missingConfigData', $l10nData);
                $this->configErrors[$result] = $error;
                return false;
            case self::CONFIG_FILE_NOT_WRITABLE:
                $error = \Yii::t('validation-errors', 'app.configNotWritable', $l10nData);
                $this->configErrors[$result] = $error;
                return false;
            case self::CONFIG_FILE_UNREADABLE:
                $error = \Yii::t('validation-errors', 'app.unreadableConfig', $l10nData);
                $this->configErrors[$result] = $error;
                return false;
        }
        \Yii::app()->cache->flush();
        \Yii::endProfile('applicationModel.save');
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
        \Yii::beginProfile('applicationModel.updateConfig');
        $config = $this->readConfig($this->configFile);
        if (!is_array($config)) {
            return $config;
        }
        $config['name'] = \Yii::app()->formatter->escape($this->name);
        \Yii::app()->language = $config['language'] = $this->language;
        \Yii::app()->name = $this->name;
        \Yii::app()->theme = $config['theme'] = $this->theme;
        $result = $this->writeConfig($this->configFile, $config);
        \Yii::endProfile('applicationModel.updateConfig');
        return $result;
    }
    /**
     * Reads config file using it's Yii path alias.
     * 
     * @param string $alias Yii path alias.
     *
     * @return array|int Array of data or one of self::CONFIG_FILE_* error
     * constants.
     * @since 0.1.0
     */
    protected function readConfig($alias)
    {
        \Yii::beginProfile('applicationModel.readConfig');
        $path = \Yii::getPathOfAlias($alias).'.php';
        if (!file_exists($path)) {
            return self::CONFIG_FILE_MISSING;
        }
        if (!is_readable($path)) {
            return self::CONFIG_FILE_UNREADABLE;
        }
        $data = include $path;
        if (!is_array($data) || sizeof($data) === 0) {
            return self::CONFIG_FILE_MISSING_DATA;
        }
        \Yii::endProfile('applicationModel.readConfig');
        return $data;
    }
    /**
     * Writes provided config into config file.
     * 
     * @param string $alias  Yii path alias for config file.
     * @param array  $config New config.
     *
     * @return int Number of written bytes or one of self::CONFIG_FILE_* error
     * constants. Since number of written bytes should be big (20+), error
     * codes should no intersect with it.
     * @since 0.1.0
     */
    protected function writeConfig($alias, array $config)
    {
        \Yii::beginProfile('applicationModel.writeConfig');
        $path = \Yii::getPathOfAlias($alias).'.php';
        if (!file_exists($path)) {
            return self::CONFIG_FILE_MISSING;
        } else if (!is_writable($path)) {
            return self::CONFIG_FILE_NOT_WRITABLE;
        }
        $template = "<?php\nreturn :config;\n";
        $config = str_replace(
            ':config',
            \Yii::app()->formatter->renderArray($config),
            $template
        );
        $result = file_put_contents($path, $config);
        \Yii::endProfile('applicationModel.writeConfig');
        return $result;
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
     * Returns list of available themes.
     * 
     * @return string[]
     * @since 0.1.0
     */
    public function getAvailableThemes()
    {
        if (!isset($this->availableThemes)) {
            $path = \Yii::getPathOfAlias($this->themesPath);
            // making default theme first in list.
            $this->availableThemes = array('default' => 'default');
            foreach (new DirectoryIterator($path) as $entry) {
                if (!$entry->isDot() && $entry->isDir()) {
                    $theme = $entry->getFilename();
                    $this->availableThemes[$theme] = $theme;
                }
            }
        }
        return $this->availableThemes;
    }

    /**
     * Validates that provided language is allowed.
     *
     * @param string $attribute Language attribute name.
     *
     * @return void
     * @since 0.1.0
     */
    public function validateLanguage($attribute)
    {
        $lang = $this->$attribute;
        $supported = $this->getAvailableLanguages();
        if (!in_array($lang, array_keys($supported), true)) {
            $error = \Yii::t(
                'validation-errors',
                'app.unsupportedLanguage',
                array('{lang}' => $lang)
            );
            $this->addError($attribute, $error);
        }
    }

    /**
     * Validates theme correctness.
     *
     * @param string $attribute Attribute name (probably 'theme').
     *
     * @return void
     * @since 0.1.0
     */
    public function validateTheme($attribute)
    {
        $theme = $this->$attribute;
        $supported = $this->getAvailableThemes();
        if (!in_array($theme, $supported, true)) {
            $this->addError(
                $attribute,
                \Yii::t(
                    'validation-errors',
                    'app.missingTheme',
                    array('{theme}' => $theme)
                )
            );
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
            'name' => 'application.name',
            'language' => 'application.language',
            'theme' => 'application.theme',
        );
    }
    /**
     * Returns cached attribute labels.
     * 
     * @return string[] Localized attribute labels.
     * @since 0.1.0
     */
    public function attributeLabels()
    {
        if (!isset($this->attributeLabels)) {
            $this->attributeLabels = array();
            $labels = $this->getAttributeLabels();
            foreach ($labels as $labelName => $labelTransKey) {
                $this->attributeLabels[$labelName] = \Yii::t(
                    'forms-labels',
                    $labelTransKey
                );
            }
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
                'validateLanguage',
            ),
            array(
                array('theme',),
                'validateTheme',
            )
        );
    }
}
