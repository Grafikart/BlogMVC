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
    public static $URL = '/admin/options';
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
}