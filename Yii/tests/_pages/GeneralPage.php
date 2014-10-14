<?php

/**
 * Ancestor class for all other pages, contains all basic elements selectors.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
abstract class GeneralPage
{
    /**
     * Page heading CSS selector.
     *
     * @type string
     * @since 0.1.0
     */
    public static $pageHeaderSelector = '.page-header h1';
    /**
     * CSS selector for navigation block under page header.
     *
     * @type string
     * @since 0.1.0
     */
    public static $pageHeaderNavigationSelector
        = '.page-header .header-navigation';
    /**
     * Logout link selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $logoutLink = 'a[role="logout-link"]';
    /**
     * DOMQuery-compatible logout link selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $logoutLinkXPath = 'a[role=logout-link]';
    /**
     * Login link selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $loginLink = 'a[role="login-link"]';
    /**
     * Return link selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $backLink = 'a[role="parent-page-link"]';
    /**
     * Home ("Blog") link selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $homeLink = '.navbar .navbar-header a[href="/"]';
    /**
     * CSS selector for menu expander button.
     *
     * @type string
     * @since 0.1.0
     */
    public static $menuToggleButton = '.navbar-header .navbar-toggle';
    /**
     * Generic CSS selector for flash message.
     *
     * @type string
     * @since 0.1.0
     */
    public static $flashMessageSelector = '.alert';
    /**
     * CSS selector for error flash message.
     *
     * @type string
     * @since 0.1.0
     */
    public static $errorFlashMessageSelector = '.alert.alert-error';
    /**
     * CSS selector for notice flash message.
     *
     * @type string
     * @since 0.1.0
     */
    public static $noticeFlashMessageSelector = '.alert.alert-notice';
    /**
     * CSS selector for success flash message.
     *
     * @type string
     * @since 0.1.0
     */
    public static $successFlashMessageSelector = '.alert.alert-success';
    /**
     * Protagonist.
     *
     * @var \WebGuy
     * @since 0.1.0
     */
    protected $guy;

    /**
     * Typical constructor.
     *
     * @param \WebGuy $I Main protagonist.
     *
     * @since 0.1.0
     */
    protected function __construct(\WebGuy $I)
    {
        $this->guy = $I;
    }

    /**
     * Creates page instance driven by protagonist.
     *
     * @param \WebGuy $I Protagonist.
     *
     * @return static
     * @since 0.1.0
     */
    public static function of(\WebGuy $I)
    {
        return new static($I);
    }

    /**
     * Grabs text from provided selector with the help of webguy.
     *
     * @param string $selector Element selector (css, regexp, xpath).
     *
     * @return string Grabbed text.
     * @since 0.1.0
     */
    public function grab($selector)
    {
        return $this->guy->grabTextFrom($selector);
    }

    /**
     * Proceeds to page specified as static::$url.
     *
     * @return static Current instance for chaining methods.
     * @since 0.1.0
     */
    public function visit()
    {
        if (!isset(static::$url)) {
            throw new \BadMethodCallException('This page can\'t be visited');
        }
        $this->guy->amOnPage(static::$url);
        return $this;
    }

    /**
     * Opens responsive menu (if it was closed).
     *
     * @return bool operation success.
     * @since 0.1.0
     */
    public function openResponsiveMenu()
    {
        try {
            $this->guy->click(\GeneralPage::$menuToggleButton);
            return true;
        } catch (\Behat\Mink\Exception\ElementException $e) {
            return false;
        }
    }

    /**
     * Basic route function.
     *
     * @param string|array $needle      Searched chunk.
     * @param string|array $replacement Replacement,
     * @param int|string   $page        Page number.
     *
     * @return mixed|string Resulting url
     * @since 0.1.0
     */
    public static function route($needle, $replacement, $page = null)
    {
        $url = str_replace($needle, $replacement, static::$url);
        if ($page > 1) {
            $url .= '?page=' . $page;
        }
        return $url;
    }

    /**
     * Verifies that page has no flash messages.
     *
     * @return void
     * @since 0.1.0
     */
    public function hasNoFlashMessages()
    {
        $this->guy->dontSeeElement(static::$flashMessageSelector);
    }

    /**
     * Verifies that page has some flash messages.
     *
     * @return void
     * @since 0.1.0
     */
    public function hasFlashMessages()
    {
        $this->guy->seeElement(static::$flashMessageSelector);
    }

    /**
     * Verifies that page has no error flash messages.
     *
     * @return void
     * @since 0.1.0
     */
    public function hasNoErrorFlashMessages()
    {
        $this->guy->dontSeeElement(static::$errorFlashMessageSelector);
    }

    /**
     * Verifies that page has at least one error flash message.
     *
     * @return void
     * @since 0.1.0
     */
    public function hasErrorFlashMessages()
    {
        $this->guy->seeElement(static::$errorFlashMessageSelector);
    }

    /**
     * Verifies that page has no notice flash messages.
     *
     * @return void
     * @since 0.1.0
     */
    public function hasNoNoticeFlashMessages()
    {
        $this->guy->dontSeeElement(static::$noticeFlashMessageSelector);
    }

    /**
     * Verifies that page has at least one notice flash message.
     *
     * @return void
     * @since 0.1.0
     */
    public function hasNoticeFlashMessages()
    {
        $this->guy->seeElement(static::$noticeFlashMessageSelector);
    }

    /**
     * Verifies that page has no success flash messages.
     *
     * @return void
     * @since 0.1.0
     */
    public function hasNoSuccessFlashMessages()
    {
        $this->guy->dontSeeElement(static::$successFlashMessageSelector);
    }

    /**
     * Verifies that page has at least one success flash message.
     *
     * @return void
     * @since 0.1.0
     */
    public function hasSuccessFlashMessages()
    {
        $this->guy->seeElement(static::$successFlashMessageSelector);
    }
}