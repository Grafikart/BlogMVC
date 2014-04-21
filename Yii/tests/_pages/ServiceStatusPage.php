<?php

/**
 * This page displays some service variables such as uptime, number of comments,
 * etc.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class ServiceStatusPage extends \GeneralPage
{
    /**
     * Status page url.
     *
     * @var string
     * @since 0.1.0
     */
    public static $url = '/admin/status';
    /**
     * Yii controller route for status page.
     *
     * @var string
     * @since 0.1.0
     */
    public static $route = 'admin/status';
    /**
     * `Flush cache` link selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $flushCacheLink = '[role="flush-cache-link"]';
}