<?php
namespace WebGuy;

use Codeception\Util\Fixtures;

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
     * Currently used login.
     *
     * @type string
     * @since 0.1.0
     */
    public $username;
    /**
     * Currently used password.
     *
     * @type string
     * @since 0.1.0
     */
    public $password;
    /**
     * Flag that represents current authentication state.
     *
     * @type bool
     * @since 0.1.0
     */
    protected $isAuthenticated = false;

    /**
     * Publishes a new comment while on post page.
     *
     * @param string $text  Comment text.
     * @param string $email Optional email.
     *
     * @return void
     * @since 0.1.0
     */
    public function commentAuthenticated($text, $email = null)
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
     * Logs out current user.
     *
     * @return void
     * @since 0.1.0
     */
    public function logout()
    {
        $this->username = $this->password = null;
        $this->isAuthenticated = false;
        $this->amOnPage('/logout');
    }

    /**
     * Performs login with admin credentials.
     *
     * @return void
     * @since 0.1.0
     */
    public function autoLogin()
    {
        $this->username = Fixtures::get('data:users[0]:login');
        $password = Fixtures::get('data:users[0]:password');
        $this->login($this->username, $password);
    }

    /**
     * Performs login.
     *
     * @param string $login    User login.
     * @param string $password User password.
     *
     * @return void
     * @since 0.1.0
     */
    public function login($login, $password)
    {
        $I = $this;
        $I->amOnPage(\LoginPage::$url);
        $currentUrl = $I->grabFromCurrentUrl();
        if ($currentUrl === \LoginPage::$url) {
            if ($login !== null) {
                $I->fillField(\LoginPage::$loginField, $login);
            }
            if ($password !== null) {
                $I->fillField(\LoginPage::$passwordField, $password);
            }
            $I->click(\LoginPage::$submitButton);
        }
        $url = $I->grabFromCurrentUrl();
        if ($url !== \LoginPage::$url) {
            $this->isAuthenticated = true;
            $this->username = $login;
            $this->password = $password;
        } else {
            $this->isAuthenticated = false;
            $this->username = null;
            $this->password = null;
        }
    }

    /**
     * Publishes new post.
     *
     * @param string      $title    Post title.
     * @param string      $text     Post content.
     * @param string|null $slug     Post slug (optional).
     * @param string|null $category Post category.
     *
     * @return void
     * @since 0.1.0
     */
    public function writePost($title, $text, $slug = null, $category = null)
    {
        $I = $this;
        $I->amOnPage(\PostFormPage::$newPostUrl);
        $I->seeCurrentUrlEquals(\PostFormPage::$newPostUrl);;
        $I->fillPostForm($title, $text, $slug, $category);
        $I->click(\PostFormPage::$submitButton);
    }

    /**
     * Fills post form.
     *
     * @param string|null $title    Post title.
     * @param string|null $text     Post content
     * @param string|null $slug     Post slug.
     * @param string|null $category Post category.
     *
     * @return void
     * @since 0.1.0
     */
    public function fillPostForm(
        $title=null,
        $text=null,
        $slug=null,
        $category=null
    ) {
        $I = $this;
        if (is_string($title)) {
            $I->fillField(\PostFormPage::$titleField, $title);
        }
        if (is_string($text)) {
            $I->fillField(\PostFormPage::$textArea, $text);
        }
        if (is_string($slug)) {
            $I->fillField(\PostFormPage::$slugField, $slug);
        }
        if (is_string($category)) {
            $I->selectOption(\PostFormPage::$categoryList, $category);
        }
    }

    /**
     * Updates existing post.
     *
     * @param int         $id       Post id.
     * @param string|null $title    Post title.
     * @param string|null $text     Post text.
     * @param string|null $slug     Post slug.
     * @param string|null $category Post category.
     *
     * @return void
     * @since 0.1.0
     */
    public function editPost(
        $id,
        $title = null,
        $text = null,
        $slug = null,
        $category = null
    )
    {
        $I = $this;
        $I->amOnPage(\PostFormPage::route($id));
        $I->seeCurrentUrlEquals(\PostFormPage::route($id));
        $I->fillPostForm($title, $text, $slug, $category);
        $I->click(\PostFormPage::$submitButton);
    }

    /**
     * Performs 'flush cache' action.
     *
     * @return void
     * @since 0.1.0
     */
    public function flushCache()
    {
        $I = $this;
        $I->amOnPage(\OptionsPage::$url);
        $I->click('control.flushCache');
    }

    /**
     * Performs 'recalculate category counters' action.
     *
     * @return void
     * @since 0.1.0
     */
    public function recalculateCategoryCounters()
    {
        $I = $this;
        $I->amOnPage(\OptionsPage::$url);
        $I->click('control.recalculateCounters');
    }

    /**
     * Updates username from wev interface.
     *
     * @param string $username New username.
     *
     * @return void
     * @since 0.1.0
     */
    public function switchUsername($username)
    {
        $I = $this;
        $I->amOnPage(\ProfilePage::$url);
        $I->fillField(\ProfilePage::$usernameField, $username);
        $I->click(\ProfilePage::$usernameUpdateButton);
        $I->username = $username;
    }

    /**
     * Updates current user password.
     *
     * @param string $newPassword New password.
     *
     * @return void
     * @since 0.1.0
     */
    public function updatePassword($newPassword)
    {
        if (!$this->isAuthenticated) {
            throw new \BadMethodCallException('Please authenticate first');
        }
        $I = $this;
        $I->amOnPage(\ProfilePage::$url);
        $I->fillField(\ProfilePage::$currentPasswordField, $this->password);
        $I->fillField(\ProfilePage::$newPasswordField, $newPassword);
        $I->fillField(\ProfilePage::$repeatNewPasswordField, $newPassword);
        $I->click(\ProfilePage::$passwordUpdateButton);
        $this->password = $newPassword;
    }
}
