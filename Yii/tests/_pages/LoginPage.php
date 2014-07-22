<?php

/**
 * Login page representation.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class LoginPage extends \GeneralPage
{
    /**
     * Login page url.
     *
     * @var string
     * @since 0.1.0
     */
    public static $url = '/login';
    /**
     * Username field name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $loginField = 'User[username]'; // '#User_username';
    /**
     * Password field name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $passwordField = 'User[password]'; // '#User_password';
    /**
     * Submit input selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $submitButton = '[role="sign-in-button"]'; // 'Sign in';
    /**
     * Submit form selector.
     *
     * @type string
     * @since 0.1.0
     */
    public static $formSelector = 'form[role="login-form"]';
}