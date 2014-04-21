<?php
namespace WebGuy;

/**
 * This class represents common action of logged in user.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class MemberSteps extends \WebGuy\VisitorSteps
{
    /**
     * Default admin username.
     *
     * @var string
     * @since 0.1.0
     */
    public static $adminUsername = 'admin';
    /**
     * Default admin password;
     *
     * @var string
     * @since 0.1.0
     */
    public static $adminPassword = 'admin';
    /**
     * Publishes a new comment while on post page.
     *
     * @param string $text  Comment text.
     * @param string $email Optional email.
     *
     * @return void
     * @since 0.1.0
     */
    public function commentAuthenticated($text, $email=null)
    {
        $I = $this;
        $I->amGoingTo('Post a comment');
        $I->fillField(\PostPage::$commentTextArea, $text);
        if ($email !== null) {
            $I->fillField(\PostPage::$commentEmailField, $email);
        }
        $I->click(\PostPage::$commentSubmitButton);
    }

    /**
     * Logouts current user.
     *
     * @return void
     * @since 0.1.0
     */
    public function logout()
    {
        $this->amOnPage('/logout');
    }

    /**
     * Performs login with admin credentials.
     *
     * @return void
     * @since 0.1.0
     */
    public function adminLogin()
    {
        $this->login(static::$adminUsername, static::$adminPassword);
    }
}