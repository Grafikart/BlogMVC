<?php

/**
 * This class represents page on which user may delete his profile.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class SuicideBoothPage extends \GeneralPage
{
    /**
     * Page URL.
     *
     * @var string
     * @since 0.1.0
     */
    public static $url = '/admin/profile/suicide';
    /**
     * Yii controller route for suicide booth page,
     *
     * @var string
     * @since 0.1.0
     */
    public static $route = 'user/suicide';
    /**
     * Delete button selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $benderButton = 'button[role="suicide"]';
    /**
     * Bender button selector for XPath.
     *
     * @type string
     * @since 0.1.0
     */
    public static $benderButtonXPath = 'button[role=suicide]';
}