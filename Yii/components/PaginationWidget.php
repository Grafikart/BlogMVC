<?php

/**
 * This is a simple widget for creating pagination on post/category/admin
 * pages.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class PaginationWidget extends CWidget
{
    /**
     * Current page number
     * 
     * @var int
     * @since 0.1.0
     */
    public $currentPage = 1;
    /**
     * Amount of pages in total.
     * 
     * @var int
     * @since 0.1.0
     */
    public $totalPages;
    /**
     * Yii `controller/action` for link generation.
     * 
     * @var string
     * @since 0.1.0
     */
    public $route;
    /**
     * Optional list of data required to generate link from route.
     * 
     * @var array
     * @since 0.1.0
     */
    public $routeOptions = array();
    /**
     * Pagination block title. If set to false, will be omitted.
     * 
     * @var string
     * @since 0.1.0
     */
    public $title;
    /**
     * Text for the delimiter between last/first page link and near-current
     * page links (if they are separated).
     * 
     * @var string
     * @since 0.1.0
     */
    public $delimiterText;
    
    /**
     * Preparational method. Gets and stores variables for latter output.
     * 
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
        if (!isset($this->route)) {
            $message = 'URL route is required to generate links';
            throw new \BadMethodCallException($message);
        }
        if (!isset($this->totalPages)) {
            $message = 'Total pages amount is required to generate pagination';
            throw new \BadMethodCallException($message);
        }
        if (!isset($this->delimiterText)) {
            $this->delimiterText = Yii::t('templates', 'pagination.delimiter');
        }
        if (!isset($this->title)) {
            $this->title = Yii::t('templates', 'pagination.title');
        }
    }
    /**
     * The actual processing method. Takes all the data and outputs
     * pagination block.
     * 
     * @return void
     * @since 0.1.0
     */
    public function run()
    {
        if ($this->title !== false) {
            echo CHtml::tag('div', array(), $this->title);
        }
        $start = max(2, $this->currentPage - 2);
        $end = min($this->totalPages - 1, $this->currentPage + 2);
        echo $this->getLink(1, 1 === $this->currentPage);
        if ($start > 2) {
            echo $this->getDelimiter();
        }
        for ($i = $start; $i <= $end; $i++) {
            echo $this->getLink($i, $i === $this->currentPage);
        }
        if ($end < $this->totalPages - 1) {
            echo $this->getDelimiter();
        }
        if ($this->totalPages > 1) {
            $current = $this->totalPages === $this->currentPage;
            echo $this->getLink($this->totalPages, $current);
        }
    }
    /**
     * Returns HTML link tag pointing to page with provided number.
     * 
     * @param int $page Page number.
     * @param boolean $current True if processed page is requested page.
     * @return string HTML tag.
     * @since 0.1.0
     */
    protected function getLink($page, $current=false)
    {
        $opts = array_merge($this->routeOptions, array('page' => $page));
        $link = $this->controller->createUrl($this->route, $opts);
        $htmlOpts = array('class' => 'pagination-link');
        if ($current) {
            $htmlOpts['class'] .= ' current-page';
        }
        return CHtml::link($page, $link, $htmlOpts);
    }
    /**
     * Returns HTML tag that serves
     * 
     * @return string Delimiter tag.
     * @since 0.1.0
     */
    protected function getDelimiter()
    {
        return CHtml::tag('span', array(
            'class' => 'pagination-delimiter'
        ), $this->delimiterText);
    }
}
