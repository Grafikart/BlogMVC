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
    /**
     * CSS selector for statistics block.
     *
     * @type string
     * @since 0.1.0
     */
    public static $statisticsSelector = '[role="service-statistics"]';
    /**
     * CSS selector for service status block.
     *
     * @type string
     * @since 0.1.0
     */
    public static $statusSelector = '[role="server-status"]';
    /**
     * Selector for 'total users' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $totalUsersSelector
        = '[role="service-statistics"] .row-1 [role="stats-value"]';
    /**
     * Selector for 'total categories' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $totalCategoriesSelector
        = '[role="service-statistics"] .row-2 [role="stats-value"]';
    /**
     * Selector for 'total posts' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $totalPostsSelector
        = '[role="service-statistics"] .row-3 [role="stats-value"]';
    /**
     * Selector for 'posts today' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $postsTodaySelector
        = '[role="service-statistics"] .row-4 [role="stats-value"]';
    /**
     * Selector for 'total comments' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $totalCommentsSelector
        = '[role="service-statistics"] .row-5 [role="stats-value"]';
    /**
     * Selector for 'comments today' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $commentsTodaySelector
        = '[role="service-statistics"] .row-6 [role="stats-value"]';
    /**
     * Selector for 'Yii version' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $yiiVersionSelector
        = '[role="service-status"] .row-1 [role="status-value"]';
    /**
     * Selector for 'Twig version' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $twigVersionSelector
        = '[role="service-status"] .row-2 [role="status-value"]';
    /**
     * Selector for 'PHP version' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $phpVersionSelector
        = '[role="service-status"] .row-3 [role="status-value"]';
    /**
     * Selector for 'OS' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $unameSelector
        = '[role="service-status"] .row-4 [role="status-value"]';
    /**
     * Selector for 'uptime' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $uptimeSelector
        = '[role="service-status"] .row-5 [role="status-value"]';
    /**
     * Selector for 'server time' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $serverTimeSelector
        = '[role="service-status"] .row-6 [role="status-value"]';

    /**
     * Returns statistics.
     *
     * @return array
     * @since 0.1.0
     */
    public function grabStats()
    {
        $this->visit();
        return array(
            'users' => $this->grab(static::$totalUsersSelector),
            'categories' => $this->grab(static::$totalCategoriesSelector),
            'totalPosts' => $this->grab(static::$totalPostsSelector),
            'postsToday' => $this->grab(static::$postsTodaySelector),
            'totalComments' => $this->grab(static::$totalCommentsSelector),
            'commentsToday' => $this->grab(static::$commentsTodaySelector),
        );
    }

    /**
     * Returns grabbed service status.
     *
     * @return array
     * @since 0.1.0
     */
    public function grabStatus()
    {
        $this->visit();
        return array(
            'yii' => $this->grab(static::$yiiVersionSelector),
            'twig' => $this->grab(static::$twigVersionSelector),
            'php' => $this->grab(static::$phpVersionSelector),
            'uname' => $this->grab(static::$unameSelector),
            'uptime' => $this->grab(static::$uptimeSelector),
            'serverTime' => $this->grab(static::$serverTimeSelector),
        );
    }
}