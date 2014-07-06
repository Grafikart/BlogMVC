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
     * Logs out current user.
     *
     * @return void
     * @since 0.1.0
     */
    public function logout()
    {
        $this->username = null;
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
    public function writePost($title, $text, $slug=null, $category=null)
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
        $title=null,
        $text=null,
        $slug=null,
        $category=null
    ) {
        $I = $this;
        $I->amOnPage(\PostFormPage::route($id));
        $I->seeCurrentUrlEquals(\PostFormPage::route($id));
        $I->fillPostForm($title, $text, $slug, $category);
        $I->click(\PostFormPage::$submitButton);
    }
}