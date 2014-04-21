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
    static $url = '/admin/users';
    /**
     * Yii page route.
     *
     * @var string
     * @since 0.1.0
     */
    static $route = 'user/index';
    /**
     * Create new user button text.
     *
     * @var string
     * @since 0.1.0
     */
    static $createNewButton = 'Create new';
    /**
     * Edit button text.
     *
     * @var string
     * @since 0.1.0
     */
    static $editLink = 'Edit';
}