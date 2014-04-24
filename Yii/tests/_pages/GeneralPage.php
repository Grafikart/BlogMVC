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
}