<?php

/**
 * Users dashboard page, allows to review current users and create new.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class UsersDashboardPage extends GeneralPage
{
    /**
     * Page URL.
     *
     * @var string
     * @since 0.1.0
     */
    public static $url = '/admin/users';
    /**
     * Yii page route.
     *
     * @var string
     * @since 0.1.0
     */
    public static $route = 'user/index';
    /**
     * Create new user button text.
     *
     * @var string
     * @since 0.1.0
     */
    public static $createNewButtonSelector = '[role="create-user-link"]';
    /**
     * Edit button CSS selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $editLinkSelector = '[role="edit-profile-link"]';
    /**
     * CSS selector for table row containing new user's data.
     *
     * @type string
     * @since 0.1.0
     */
    public static $createdUserRowSelector = 'tr.success';
}