<?php

/**
 * This widget creates top site menu, populating it woth popular categories
 * and authors. Menu is recreated during every request, but data is cached, so
 * menu may take up to one hour to renew.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class HeaderMenuWidget extends CWidget
{
    /**
     * List of popular categories.
     * 
     * @var string[]
     * @since 0.1.0
     */
    public $categories;
    /**
     * List of popular authors.
     * 
     * @var string[]
     * @since 0.1.0
     */
    public $authors;
    /**
     * URL route for page with list of all categories.
     * 
     * @var string
     * @since 0.1.0
     */
    public $categoryListingRoute = 'category/index';
    /**
     * URL route for page with category posts.
     * 
     * @var string
     * @since 0.1.0
     */
    public $categoryDisplayRoute = 'category/show';
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
     * Initializing method. Retrieves and caches data.
     * 
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
        $data = Yii::app()->cache->get('widgets.headerMenu.data');
        if ($data === false) {
            $data = array(
                'categories' => Category::model()->popular()->findAll(),
                'authors' => User::model()->popular()->findAll(),
            );
            Yii::app()->cache->set('widgets.headerMenu.data', $data, 3600);
        }
        $this->categories = $data['categories'];
        $this->authors = $data['authors'];
        if (!isset($this->moreText)) {
            $this->moreText = Yii::t('templates', 'links.more');
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
            Yii::app()->name => array('route' => 'post/index'),
        );
        if (sizeof($this->authors) > 1) {
            $tree['Authors'] = array(
                'route' => 'post/authors',
                'tree' => $this->generateAuthorsBranch(),
            );
        }
        if (sizeof($this->categories) > 0) {
            $tree['Categories'] = array(
                'route' => 'post/categories',
                'tree' => $this->generateCategoriesBranch(),
            );
        }
        echo $this->walkTree($tree, true);
    }
    protected function generateCategoriesBranch()
    {
        $branch = array();
        foreach ($this->categories as $category) {
            $branch[$category->name] = array(
                'route' => $this->categoryDisplayRoute,
                'routeOptions' => array('slug' => $category->slug)
            );
        }
        if (sizeof($this->categories) === 5) {
            array_pop($branch);
            $branch[$this->moreText] = array(
                'route' => $this->categoryListingRoute,
                'more-link' => true,
            );
        }
        return $branch;
    }
    /**
     * 
     * @return string
     * @since 0.1.0
     */
    protected function generateAuthorsBranch()
    {
        $branch = array();
        foreach ($this->authors as $author) {
            $branch[$author->name] = array(
                'route' => $this->authorDisplayRoute,
                'routeOptions' => array('id' => $author->id)
            );
            if (sizeof($this->authors === 5)) {
                array_pop($branch);
                $branch[$this->moreText] = array(
                    'route' => $this->authorListingRoute,
                    'more-link' => true,
                );
            }
        }
        return $branch;
    }
    /**
     * Recursively walks provided tree and build nested HTML unordered list.
     * 
     * @param array $tree Menu tree taht has to be converted to HTML list.
     * @param boolean $topLevel Defines whether currently passed tree is a
     * tree itself (top level node) or one of subnodes.
     * @return string Formatted HTML.
     * @since 0.1.0
     */
    protected function walkTree(array $tree, $topLevel=false)
    {
        $n = "\n";
        $items = array();
        $listOpts = ($topLevel)?array('class' => $this->class):array();
        foreach ($tree as $title => $node) {
            $htmlOpts = array();
            if (isset($node['more-link'])) {
                $htmlOpts['class'] = 'more-link';
            }
            if (!isset($node['routeOptions'])) {
                $node['routeOptions'] = array();
            }
            $content = CHtml::link($title, $this->controller->createUrl(
                $node['route'], $node['routeOptions']
            ));
            if (isset($node['tree'])) {
                $content .= $n.$this->walkTree($node['tree']).$n;
            }
            $items[] = CHtml::tag('li', $htmlOpts, $content);
        }
        return CHtml::tag('ul', $listOpts, $n.implode("\n", $items).$n);
    }
}
