<?php

/**
 * Profile page.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class ProfilePage extends \GeneralPage
{
    /**
     * Profile page url.
     *
     * @var string
     * @since 0.1.0
     */
    public static $url = '/admin/profile';
    /**
     * Yii controller route for profile page.
     *
     * @var string
     * @since 0.1.0
     */
    public static $route = 'user/profile';
    /**
     * `Username` field name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $usernameField = 'User[username]';
    /**
     * `Update username` button selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $usernameUpdateButton = '[role="update-username"]';
    /**
     * `Current password` field name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $currentPasswordField = 'User[password]';
    /**
     * `New password` field name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $newPasswordField = 'User[newPassword]';
    /**
     * `Repeat new password` field name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $repeatNewPasswordField = 'User[newPasswordRepeat]';
    /**
     * `Update password` button selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $passwordUpdateButton = '[role="update-password"]';
    /**
     * Selector for link to first Futurama episode.
     *
     * @var string
     * @since 0.1.0
     */
    public static $suicideBoothLink = 'a[role="suicide-booth-link"]';
}