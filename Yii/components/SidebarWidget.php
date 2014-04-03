<?php

/**
 * Description of SidebarWidget
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class SidebarWidget extends CWidget
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
     * Text for 'More...' links.
     * 
     * @var string
     * @since 0.1.0
     */
    public $moreLinkText;
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
    protected $cacheKey;
    /**
     * Initializer method. Checks for cached data and sets up necessary
     * properties.
     */
    public function init()
    {
        if (!($this->cached = Yii::app()->cache->get($this->cacheKey))) {
            $this->categoriesHeaderText = Yii::t('templates', 'sidebar.categories');
            $this->postsHeaderText = Yii::t('templates', 'sidebar.posts');
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
        ob_start();
        
        echo CHtml::tag('h4', array(), $this->categoriesHeaderText);
        echo CHtml::openTag('div', array('class' => 'list-group'));
        foreach ($this->categories as $category) {
            $url = $this->getController()->createUrl($this->categoryRoute, array(
                'slug' => $category->slug
            ));
            echo CHtml::openTag('a', array(
                'class' => 'list-group-item',
                'href' => $url
            ));
            echo CHtml::tag('span', array('class' => 'badge'), $category->post_count);
            echo $category->name;
            echo CHtml::closeTag('a');
        }
        echo CHtml::closeTag('div');
        echo CHtml::tag('h4', array(), $this->postsHeaderText);
        echo CHtml::openTag('div', array('class' => 'list-group'));
        foreach ($this->posts as $post) {
            $url = $this->getController()->createUrl($this->postRoute, array(
                'slug' => $post->slug
            ));
            echo CHtml::tag('a', array(
                'class' => 'list-group-item',
                'href' => $url
            ), $post->name);
        }
        echo CHtml::closeTag('div');
        
        $dep = new CGlobalStateCacheDependency('lastPost');
        Yii::app()->cache->set($this->cacheKey, ob_get_flush(), 3600, $dep);
    }
}
