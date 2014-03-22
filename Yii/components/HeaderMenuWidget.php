<?php

/**
 * Description of MenuWidget
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package etki-tools
 * @subpackage <subpackage>
 */
class HeaderMenuWidget extends CWidget
{
    public $categories;
    public $authors;
    public $class = '';
    public function init()
    {
        $data = Yii::app()->cache->get('widgets.headerMenu.data');
        if ($data === false) {
            $data = array(
                'categories' => Category::model()->mostPopular()->findAll(),
                'authors' => User::model()->mostPopular()->findAll(),
            );
            Yii::app()->cache->set('widgets.headerMenu.data', $data, 3600);
        }
        $this->categories = $data['categories'];
        $this->authors = $data['authors'];
    }
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
                'route' => 'post/category',
                'routeOptions' => array('slug' => $category->slug)
            );
        }
        if (sizeof($this->categories) === 5) {
            array_pop($branch);
            $branch['More'] = array(
                'route' => 'post/categories',
                'more-link' => true,
            );
        }
        return $branch;
    }
    protected function generateAuthorsBranch()
    {
        $branch = array();
        foreach ($this->authors as $author) {
            $branch[$author->name] = array(
                'route' => 'post/author',
                'routeOptions' => array('id' => $author->id)
            );
            if (sizeof($this->authors === 5)) {
                array_pop($branch);
                $branch['More...'] = array(
                    'route' => 'post/authors',
                    'more-link' => true,
                );
            }
        }
        return $branch;
    }
    protected function walkTree($tree, $topLevel=false)
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
