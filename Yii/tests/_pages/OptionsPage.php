<?php

/**
 * This class represents options page in admin dashboard.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class OptionsPage extends \GeneralPage
{
    /**
     * Page URL.
     *
     * @var string
     * @since 0.1.0
     */
    public static $url = '/admin/options';
    /**
     * Yii page route.
     *
     * @var string
     * @since 0.1.0
     */
    public static $route = 'admin/options';
    /**
     * Application title field name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $appTitleField = 'ApplicationModel[title]';
                                // '#ApplicationModel_title';
    /**
     * Application language list name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $siteLanguageList = 'ApplicationModel[language]';
                                   // '#ApplicationModel_language';
    /**
     * Application theme list name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $themeList = 'ApplicationModel[theme]';
    /**
     * Submit button text.
     *
     * @var string
     * @since 0.1.0
     */
    public static $formSubmit = '[role="update-options"]';
    /**
     * 'Flush cache' link text.
     *
     * @var string
     * @since 0.1.0
     */
    public static $flushCacheLink = 'a[role="flush-cache-link"]';
    /**
     * 'Recalculate counters' link text.
     *
     * @var string
     * @since 0.1.0
     */
    public static $recalculateLink = 'a[role="recalculate-counters-link"]';

    /**
     * Selects language
     *
     * @param string $lang Language to be selected, presumably 'en' or 'ru'.
     *
     * @return void
     * @since 0.1.0
     */
    public function selectLanguage($lang)
    {
        $this->guy->selectOption(static::$siteLanguageList, $lang);
    }

    /**
     * Fills application title field.
     *
     * @param string $title Application title.
     *
     * @return void
     * @since 0.1.0
     */
    public function setApplicationTitle($title)
    {
        $this->guy->fillField(static::$appTitleField, $title);
    }

    /**
     * Selects new application theme.
     *
     * @param string $theme Theme name.
     *
     * @return void
     * @since
     */
    public function selectTheme($theme)
    {
        $this->guy->selectOption(static::$themeList, $theme);
    }

    /**
     * Clicks on 'save options' button.
     *
     * @return void
     * @since 0.1.0
     */
    public function saveOptions()
    {
        $this->guy->click(static::$formSubmit);
    }

    /**
     * Updates options in single function call.
     *
     * @param null|string $title New application title. Will be ignored if set
     * to null.
     * @param null|string $lang  New application language. Will be ignored if
     * set to null.
     * @param null|string $theme New application theme. Will be ignored if set
     * to null.
     *
     * @return void
     * @since 0.1.0
     */
    public function updateOptions($title=null, $lang=null, $theme=null)
    {
        if ($title) {
            $this->setApplicationTitle($title);
        }
        if ($lang) {
            $this->selectLanguage($lang);
        }
        if ($theme) {
            $this->selectTheme($theme);
        }
        $this->saveOptions();
    }
}