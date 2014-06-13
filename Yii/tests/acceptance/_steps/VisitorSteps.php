<?php
namespace WebGuy;

/**
 * This class represents and implements typical visitor actions.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class VisitorSteps extends \WebGuy
{
    /**
     * Page currently visited,
     *
     * @var \GeneralPage
     * @since 0.1.0
     */
    public $currentPage;
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
        if ($login !== null) {
            $I->fillField(\LoginPage::$loginField, $login);
        }
        if ($password !== null) {
            $I->fillField(\LoginPage::$passwordField, $password);
        }
        $I->click(\LoginPage::$submitButton);
    }

    /**
     * Fills comment form.
     *
     * @param null|string $comment  User comment. Leave as null to prevent
     * filling.
     * @param null|string $username Username. Leave as null to prevent filling.
     * @param null|string $email    User email. Leave as null to prevent
     * filling.
     *
     * @return void
     * @since 0.1.0
     */
    public function fillCommentForm($comment=null, $username=null, $email=null)
    {
        $I = $this;
        if (is_string($comment)) {
            $I->fillField(\PostPage::$commentTextArea, $comment);
        }
        if (is_string($username)) {
            $I->fillField(\PostPage::$commentUsernameField, $username);
        }
        if (is_string($email)) {
            $I->fillField(\PostPage::$commentEmailField, $email);
        }
    }

    /**
     * Fills and submits comment form.
     *
     * @param null|string $comment  User comment. Leave as null to prevent
     * filling.
     * @param null|string $username Username. Leave as null to prevent filling.
     * @param null|string $email    User email. Leave as null to prevent
     * filling.
     *
     * @return void
     * @since 0.1.0
     */
    public function submitCommentForm(
        $comment=null,
        $username=null,
        $email=null
    ) {
        $I = $this;
        $I->fillCommentForm($comment, $username, $email);
        $I->click(\PostPage::$commentSubmitButton);
    }

    /**
     * Sets current page guy is visiting.
     *
     * @param string $pageClass Page class.
     *
     * @return \GeneralPage
     * @since 0.1.0
     */
    public function setCurrentPage($pageClass)
    {
        return $this->currentPage = $pageClass::of($this);
    }

    /**
     * Dwindles current window to something like old smartphone.
     *
     * @return void
     * @since 0.1.0
     */
    public function dwindleWindow()
    {
        $this->resizeWindow(400, 600);
    }

    /**
     * Resizes window to common desktop resolution.
     *
     * @return void
     * @since 0.1.0
     */
    public function enlargeWindow()
    {
        $this->resizeWindow(1024, 768);
    }
}