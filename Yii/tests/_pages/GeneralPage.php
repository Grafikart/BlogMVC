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
     * Logout link selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $logoutLink = 'a[role="logout-link"]';
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
    public static function route($needle, $replacement, $page=null)
    {
        $url = str_replace($needle, $replacement, static::$url);
        if ($page > 1) {
            $url .= '?page='.$page;
        }
        return $url;
    }
}