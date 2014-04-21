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
     * Publishes a new comment while on post page.
     *
     * @param string $text  Comment text.
     * @param string $email Optional email.
     *
     * @return void
     * @since 0.1.0
     */
    public function comment($text, $email=null)
    {
        $I = $this;
        $I->fillField(\PostPage::$commentTextArea, $text);
        if ($email !== null) {
            $I->fillField(\PostPage::$commentEmailField, $email);
        }
        $I->click(\PostPage::$commentSubmitButton);
    }
}