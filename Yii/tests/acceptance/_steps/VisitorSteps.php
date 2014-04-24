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
     * Leaves a comment from unauthorized user while on post page.
     *
     * @param string $comment  Comment text.
     * @param string $username User's name.
     * @param string $email    User's email.
     *
     * @return void
     * @since 0.1.0
     */
    public function commentUnauthenticated($comment, $username, $email=null)
    {
        $I = $this;
        $I->fillField(\PostPage::$commentUsernameField, $username);
        $I->fillField(\PostPage::$commentTextArea, $comment);
        if ($email !== null) {
            $I->fillField(\PostPage::$commentEmailField, $email);
        }
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
}