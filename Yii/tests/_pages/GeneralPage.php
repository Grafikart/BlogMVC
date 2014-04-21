<?php

/**
 * Ancestor class for all other pages, contains all basic elements selectors.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
abstract class GeneralPage
{
    /**
     * Logout link selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $logoutLink = 'a[role="logout-link"]';
    /**
     * Login link selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $loginLink = 'a[role="login-link"]';
    /**
     * Return link selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $backLink = 'a[role="parent-page-link"]';
    /**
     * Home ("Blog") link selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $homeLink = '.navbar .navbar-header a[href="/"]';
}