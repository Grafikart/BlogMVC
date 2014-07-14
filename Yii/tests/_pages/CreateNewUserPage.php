<?php

/**
 * This page contains required information for work with 'new user' page.
 *
 * @version    0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class CreateNewUserPage extends \GeneralPage
{
    /**
     * Page url.
     *
     * @type string
     * @since 0.1.0
     */
    public static $url = '/admin/users/new';
    /**
     * Internal Yii route for `new user` page.
     *
     * @type string
     * @since 0.1.0
     */
    public static $route = 'user/new';
    /**
     * CSS selector for form element.
     *
     * @type string
     * @since 0.1.0
     */
    public static $formSelector = 'form[role="new-user-form"]';
    /**
     * CSS selector for `username` field.
     *
     * @type string
     * @since 0.1.0
     */
    public static $usernameFieldSelector
        = 'form[role="new-user-form"] [name="User[username]"]';
    /**
     * CSS selector for `new password` field.
     *
     * @type string
     * @since 0.1.0
     */
    public static $passwordFieldSelector
        = 'form[role="new-user-form"] [name="User[newPassword]"]';
    /**
     * CSS selector for `repeat new password` field.
     *
     * @type string
     * @since 0.1.0
     */
    public static $repeatPasswordFieldSelector
        = 'form[role="new-user-form"] [name="User[newPasswordRepeat]"]';
    /**
     * CSS selector for submit button
     *
     * @type string
     * @since 0.1.0
     */
    public static $submitButtonSelector
        = 'form[role="new-user-form"] [role="create-user"]';
}
 