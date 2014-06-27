<?php

/**
 * This widget represents sidebar that resides on every feed page.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class SidebarWidget extends WidgetLayer
{
    /**
     * URL route for single category.
     * 
     * @var string
     * @since 0.1.0
     */
    public $categoryRoute = 'category/index';
    /**
     * URL route for single post.
     * 
     * @var string
     * @since 0.1.0
     */
    public $postRoute = 'post/show';
    /**
     * Maximum amount of categories to be shown.
     * 
     * @var int
     * @since 0.1.0
     */
    public $categoriesLimit = 5;
    /**
     * Maximum amount of posts to be shown.
     * 
     * @var int
     * @since 0.1.0
     */
    public $postsLimit = 5;
    /**
     * List of featured categories.
     * 
     * @var Category[]
     * @since 0.1.0
     */
    public $categories;
    /**
     * List of featured posts.
     * 
     * @var Post[]
     * @since 0.1.0
     */
    public $posts;
    /**
     * Categories header text.
     * 
     * @var string
     * @since 0.1.0
     */
    public $categoriesHeaderText;
    /**
     * Posts header text.
     * 
     * @var string
     * @since 0.1.0
     */
    public $postsHeaderText;
    /**
     * Cached HTML piece.
     * 
     * @var boolean|string
     * @since 0.1.0
     */
    public $cached;
    /**
     * Key under which data will be stored in cache.
     * 
     * @var string
     * @since 0.1.0
     */
    protected $cacheKey = 'widget.sidebar.render';
    /**
     * Initializer method. Checks for cached data and sets up necessary
     * properties.
     *
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
        // Forces global states to be updated
        /** @type CWebApplication $app */
        $app = \Yii::app();
        $app->loadGlobalState();
        if (!($this->cached = $app->cache->get($this->cacheKey))) {
            \Yii::trace('Regenerating cache for sidebar widget');
            $this->categoriesHeaderText = \Yii::t(
                'templates',
                'heading.categories'
            );
            $this->postsHeaderText = \Yii::t('templates', 'heading.lastPosts');
            $this->categories = \Category::model()->popular()->findAll();
            $this->posts = \Post::model()->paged()->findAll();
        }
    }
    /**
     * This method is responsible for real output. If cached fragment is
     * found, it is supplied as is, otherwise output is calculated and cached.
     * 
     * @return void
     * @since 0.1.0
     */
    public function run()
    {
        if ($this->cached) {
            echo $this->cached;
            return;
        }
        echo $render = $this->render('sidebar', null, true);
        $dep = new \CGlobalStateCacheDependency('lastPostUpdate');
        \Yii::app()->cache->set($this->cacheKey, $render, 3600, $dep);
    }
}
