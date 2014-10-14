<?php

/**
 * This widget creates top site menu, populating it with popular categories
 * and authors. Menu is recreated during every request, but data is cached, so
 * menu may take up to one hour to renew.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class HeaderMenuWidget extends \WidgetLayer
{
    /**
     * List of popular categories.
     * 
     * @var Category[]
     * @since 0.1.0
     */
    public $categories;
    /**
     * List of most active authors.
     * 
     * @var User[]
     * @since 0.1.0
     */
    public $authors;
    /**
     * URL route for page with list of all categories.
     * 
     * @var string
     * @since 0.1.0
     */
    public $categoryListingRoute = 'category/list';
    /**
     * URL route for page with category posts.
     * 
     * @var string
     * @since 0.1.0
     */
    public $categoryDisplayRoute = 'category/index';
    /**
     * URL route for page with list of all authors.
     * 
     * @var string
     * @since 0.1.0
     */
    public $authorListingRoute = 'user/list';
    /**
     * URL route for page with author posts.
     * 
     * @var string
     * @since 0.1.0
     */
    public $authorDisplayRoute = 'user/posts';
    /**
     * Text for 'More...' links. If won't set, will be autopopulated with
     * `links.more` translation.
     * 
     * @var string
     * @since 0.1.0
     */
    public $moreText;
    /**
     * Menu CSS class.
     * 
     * @var string
     * @since 0.1.0
     */
    public $class = '';
    /**
     * Cache lifetime (in seconds).
     *
     * @var int
     * @since 0.1.0
     */
    public $cacheLifetime = 3600;

    /**
     * Initializing method. Retrieves and caches data.
     * 
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
        $data = \Yii::app()->cache->get('widgets.headerMenu.data');
        if ($data === false) {
            $data = array(
                'categories' => \Category::model()->popular()->findAll(),
                'authors' => \User::model()->mostActive()->findAll(),
            );
            \Yii::app()->cache->set(
                'widgets.headerMenu.data',
                $data,
                $this->cacheLifetime
            );
        }
        $this->categories = $data['categories'];
        $this->authors = $data['authors'];
        if (!isset($this->moreText)) {
            $this->moreText = \Yii::t('templates', 'links.more');
        }
    }
    /**
     * This is the method that calculates widget tree and produces widget
     * output.
     * 
     * @return void
     * @since 0.1.0
     */
    public function run()
    {
        $tree = array(
            \Yii::app()->name => array('route' => 'post/index'),
        );
        if (sizeof($this->authors) > 1) {
            $tree['Authors'] = array(
                'route' => 'post/authors',
                'tree' => $this->generateAuthorsBranch(),
            );
        }
        if (sizeof($this->categories) > 0) {
            $tree[Yii::t('templates', 'link.categories')] = array(
                'route' => 'post/categories',
                'tree' => $this->generateCategoriesBranch(),
            );
        }
        echo $this->render('headerMenu', array('tree' => $tree));
        //echo $this->walkTree($tree, true);
    }

    /**
     * Generates categories branch of menu tree.
     *
     * @return array
     * @since 0.1.0
     */
    protected function generateCategoriesBranch()
    {
        $branch = array();
        $controller = $this->getController();
        foreach ($this->categories as $category) {
            $branch[] = array(
                'href' => $controller->createUrl(
                    $this->categoryDisplayRoute,
                    array('slug' => $category->slug)
                ),
                'title' => $category->name,
            );
        }
        if (sizeof($this->categories) === 5) {
            array_pop($branch);
            $branch[] = array(
                'href' => $controller->createUrl($this->categoryListingRoute),
                'title' => $this->moreText,
                'more-link' => true,
            );
        }
        return $branch;
    }
    /**
     * Generates authors branch of menu tree.
     *
     * @return string
     * @since 0.1.0
     */
    protected function generateAuthorsBranch()
    {
        $branch = array();
        $controller = $this->getController();
        foreach ($this->authors as $author) {
            $branch[] = array(
                'href' => $controller->createUrl(
                    $this->authorDisplayRoute,
                    array('id' => $author->id)
                ),
                'title' => $author->name,
            );
            if (sizeof($this->authors === 5)) {
                array_pop($branch);
                $branch[] = array(
                    'href' => $controller->createUrl($this->authorListingRoute),
                    'title' => $this->moreText,
                    'more-link' => true,
                );
            }
        }
        return $branch;
    }
    /**
     * Recursively walks provided tree and build nested HTML unordered list.
     * 
     * @param array $tree  Menu tree that has to be converted to HTML list.
     * @param int   $level Current tree level, defines indent
     *
     * @return string Formatted HTML.
     * @since 0.1.0
     */
    protected function walkTree(array $tree, $level = 0)
    {
        $listOpts = ($level===0)?array('class' => $this->class):array();
        $this->openTag('ul', $listOpts, $level * 4);
        foreach ($tree as $title => $node) {
            $htmlOpts = array();
            if (isset($node['more-link'])) {
                $htmlOpts['class'] = 'more-link';
            }
            $this->openTag('li', $htmlOpts);
            $this->tag('a', array('href' => $node['href']), $title);
            if (isset($node['tree'])) {
                $this->walkTree($node['tree'], $level + 1);
            }
            $this->closeTag('li');
        }
        $this->closeTag('ul');
    }
}
