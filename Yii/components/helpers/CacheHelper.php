<?php

/**
 * A little helper to encapsulate common cache tasks.
 *
 * "Global cache dependency" is used to describe cache dependency that
 * invalidates dependent cache on any other cache invalidation; in other words,
 * posts or comments cache invalidation triggers 'global' cache invalidation.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class CacheHelper extends \CComponent
{
    /**
     * Token for posts cache dependency.
     *
     * @type string
     * @since 0.1.0
     */
    public static $postsCacheToken = 'postsCacheToken';
    /**
     * Token for comments cache dependency.
     *
     * @type string
     * @since 0.1.0
     */
    public static $commentsCacheToken = 'commentsCacheToken';
    /**
     * Token for global cache dependency.
     *
     * @type string
     * @since 0.1.0
     */
    public static $globalCacheToken = 'globalCacheToken';


    /**
     * Returns current posts cache token value.
     *
     * @return string
     * @since 0.1.0
     */
    public static function getPostsCacheTokenValue()
    {
        return \Yii::app()->getGlobalState(static::$postsCacheToken);
    }

    /**
     * Returns current comments cache token value.
     *
     * @return string
     * @since 0.1.0
     */
    public static function getCommentsCacheTokenValue()
    {
        return \Yii::app()->getGlobalState(static::$commentsCacheToken);
    }

    /**
     * Returns current global cache token value.
     *
     * @return string
     * @since 0.1.0
     */
    public static function getGlobalCacheTokenValue()
    {
        return \Yii::app()->getGlobalState(static::$globalCacheToken);
    }

    /**
     * Invalidates posts-dependent cache. Also invalidates global cache.
     *
     * @return void
     * @since 0.1.0
     */
    public static function invalidatePostsCache()
    {
        static::invalidateCache(static::$postsCacheToken);
        static::invalidateGlobalCache();
    }

    /**
     * Invalidates comments-dependent cache. Also invalidates global cache.
     *
     * @return void
     * @since 0.1.0
     */
    public static function invalidateCommentsCache()
    {
        static::invalidateCache(static::$commentsCacheToken);
        static::invalidateGlobalCache();
    }

    /**
     * Invalidates global cache.
     *
     * @return void
     * @since 0.1.0
     */
    public static function invalidateGlobalCache()
    {
        static::invalidateCache(static::$globalCacheToken);
    }

    /**
     * Caches data with global dependency.
     *
     * @param string $key  Cache key.
     * @param mixed  $data Data to be cached.
     * @param int    $time Cache lifespan in seconds.
     *
     * @return void
     * @since 0.1.0
     */
    public static function setGlobalDependentCache($key, $data, $time=30)
    {
        static::setDependentData(
            static::$globalCacheToken,
            $key,
            $data,
            $time
        );
    }

    /**
     * Sets posts-dependent cache.
     *
     * @param string $key  Cache key.
     * @param mixed  $data Data to cache.
     * @param int    $time Cache lifespan in seconds.
     *
     * @return void
     * @since 0.1.0
     */
    public static function setPostsDependentCache($key, $data, $time=30)
    {
        static::setDependentData(
            static::$postsCacheToken,
            $key,
            $data,
            $time
        );
    }

    /**
     * Saves comments-dependent cache.
     *
     * @param string $key  Cache key.
     * @param mixed  $data Data to be cached.
     * @param int    $time Cache lifespan in seconds.
     *
     * @return void
     * @since 0.1.0
     */
    public static function setCommentsDependentData($key, $data, $time=30)
    {
        static::setDependentData(
            static::$commentsCacheToken,
            $key,
            $data,
            $time
        );
    }

    /**
     * Caches provided data using provided token to establish dependency.
     *
     * @param string $token Cache token which defines cache dependency.
     * @param string $key   Cache key.
     * @param mixed  $data  Data to be cached.
     * @param int    $time  Time in seconds.
     *
     * @return void
     * @since 0.1.0
     */
    protected static function setDependentData($token, $key, $data, $time)
    {
        \Yii::app()->cache->set(
            $key,
            $data,
            $time,
            new \CGlobalStateCacheDependency($token)
        );
    }

    /**
     * Generates unique string. Guaranteed to deliver different value every
     * microsecond
     *
     * @return string
     * @since 0.1.0
     */
    public static function generateSign()
    {
        return microtime();
        //return microtime().uniqid();
    }

    /**
     * Invalidates cache for selected token by setting new value to global state
     * variable.
     *
     * @param string $token Cache token.
     *
     * @return void
     * @since 0.1.0
     */
    protected static function invalidateCache($token)
    {
        /** @type \CWebApplication $app */
        $app = \Yii::app();
        $sign = static::generateSign();
        $token = 'cache.tokens.'.$token;
        $app->setGlobalState($token, $sign);
        $app->saveGlobalState();
        $m = sprintf(
            'Invalidated cache for %s token, updated global state using %s',
            $token,
            $sign
        );
        \Yii::log($m);
    }
}
 