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
    public $postsCacheToken = 'posts';
    /**
     * Token for comments cache dependency.
     *
     * @type string
     * @since 0.1.0
     */
    public $commentsCacheToken = 'comments';
    /**
     * Token for global cache dependency.
     *
     * @type string
     * @since 0.1.0
     */
    public $globalCacheToken = 'global';
    /**
     * Prefix to be used in conjunction with token name.
     *
     * @type string
     * @since 0.1.0
     */
    public $tokenPrefix = 'cache.tokens.';

    /**
     * Typical initializer. Forces Yii to load global state.
     *
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
        \Yii::app()->loadGlobalState();
    }
    /**
     * Retrieves stored data.
     *
     * @param string $key     Cache key.
     * @param mixed  $default Default value to be returned if cache has been
     *                        invalidated.
     *
     * @return mixed Cached data or default value.
     * @since 0.1.0
     */
    public function get($key, $default=null)
    {
        return \Yii::app()->cache->get($key, $default);
    }

    /**
     * Just a {@link CCache::set()} wrapper to maintain consistency.
     *
     * @param string            $key        Key under which data will be stored.
     * @param mixed             $data       Data that requires to be stored.
     * @param int               $lifespan   Cache lifespan
     * @param \ICacheDependency $dependency Cache dependency that allows
     *                                      automatic cache invalidation.
     *
     * @return boolean True on successful data save, false otherwise.
     * @since 0.1.0
     */
    public function set($key, $data, $lifespan=0, $dependency=null)
    {
        return \Yii::app()->cache->set($key, $data, $lifespan, $dependency);
    }
    /**
     * Returns current posts cache token value.
     *
     * @return string
     * @since 0.1.0
     */
    public function getPostsCacheTokenValue()
    {
        return \Yii::app()->getGlobalState(
            $this->tokenPrefix.$this->postsCacheToken
        );
    }

    /**
     * Returns current comments cache token value.
     *
     * @return string
     * @since 0.1.0
     */
    public function getCommentsCacheTokenValue()
    {
        return \Yii::app()->getGlobalState(
            $this->tokenPrefix.$this->commentsCacheToken
        );
    }

    /**
     * Returns current global cache token value.
     *
     * @return string
     * @since 0.1.0
     */
    public function getGlobalCacheTokenValue()
    {
        return \Yii::app()->getGlobalState(
            $this->tokenPrefix.$this->globalCacheToken
        );
    }

    /**
     * Invalidates posts-dependent cache. Also invalidates global cache.
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidatePostsCache()
    {
        $this->invalidateCache($this->postsCacheToken);
        $this->invalidateGlobalCache();
    }

    /**
     * Invalidates comments-dependent cache. Also invalidates global cache.
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidateCommentsCache()
    {
        $this->invalidateCache($this->commentsCacheToken);
        $this->invalidateGlobalCache();
    }

    /**
     * Invalidates global cache.
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidateGlobalCache()
    {
        $this->invalidateCache($this->globalCacheToken);
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
    public function setGlobalDependentCache($key, $data, $time=30)
    {
        $this->setDependentData($this->globalCacheToken, $key, $data, $time);
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
    public function setPostsDependentCache($key, $data, $time=30)
    {
        $this->setDependentData($this->postsCacheToken, $key, $data, $time);
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
    public function setCommentsDependentData($key, $data, $time=30)
    {
        $this->setDependentData($this->commentsCacheToken, $key, $data, $time);
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
    protected function setDependentData($token, $key, $data, $time)
    {
        $token = $this->tokenPrefix.$token;
        $dependency = new \CGlobalStateCacheDependency($token);
        \Yii::app()->cache->set($key, $data, $time, $dependency);
        $message = 'Cached data dependent on %s using %s key fot %d seconds';
        \Yii::log(sprintf($message, $token, $key, $time));
    }

    /**
     * Generates unique string. Guaranteed to deliver different value every
     * microsecond
     *
     * @return string
     * @since 0.1.0
     */
    public function generateSign()
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
    protected function invalidateCache($token)
    {
        /** @type \CWebApplication $app */
        $app = \Yii::app();
        $sign = $this->generateSign();
        $token = $this->tokenPrefix.$token;
        $app->setGlobalState($token, $sign);
        $app->saveGlobalState();
        $message = 'Invalidated cache for %s token, updated global state using %s';
        \Yii::log(sprintf($message, $token, $sign));
    }
}
