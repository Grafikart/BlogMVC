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
     * Selector for 'total users' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $totalUsersContainer = '.row-1 [role="stats-value"]';
    /**
     * Selector for 'total categories' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $totalCategoriesContainer = '.row-2 [role="stats-value"]';
    /**
     * Selector for 'total posts' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $totalPostsContainer = '.row-3 [role="stats-value"]';
    /**
     * Selector for 'posts today' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $postsTodayContainer = '.row-4 [role="stats-value"]';
    /**
     * Selector for 'total comments' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $totalCommentsContainer = '.row-5 [role="stats-value"]';
    /**
     * Selector for 'comments today' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $commentsTodayContainer = '.row-6 [role="stats-value"]';
    /**
     * Selector for 'Yii version' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $yiiVersionContainer = '.row-1 [role="status-value"]';
    /**
     * Selector for 'Twig version' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $twigVersionContainer = '.row-2 [role="status-value"]';
    /**
     * Selector for 'PHP version' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $phpVersionContainer = '.row-3 [role="status-value"]';
    /**
     * Selector for 'OS' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $unameContainer = '.row-4 [role="status-value"]';
    /**
     * Selector for 'uptime' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $uptimeContainer = '.row-5 [role="status-value"]';
    /**
     * Selector for 'server time' element.
     *
     * @var string
     * @since 0.1.0
     */
    public static $serverTimeContainer = '.row-6 [role="status-value"]';

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
            'users' => $this->grab(static::$totalUsersContainer),
            'categories' => $this->grab(static::$totalCategoriesContainer),
            'totalPosts' => $this->grab(static::$totalPostsContainer),
            'postsToday' => $this->grab(static::$postsTodayContainer),
            'totalComments' => $this->grab(static::$totalCommentsContainer),
            'commentsToday' => $this->grab(static::$commentsTodayContainer),
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
            'yii' => $this->grab(static::$yiiVersionContainer),
            'twig' => $this->grab(static::$twigVersionContainer),
            'php' => $this->grab(static::$phpVersionContainer),
            'uname' => $this->grab(static::$unameContainer),
            'uptime' => $this->grab(static::$uptimeContainer),
            'serverTime' => $this->grab(static::$serverTimeContainer),
        );
    }
}