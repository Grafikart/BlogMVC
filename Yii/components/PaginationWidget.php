<?php

/**
 * This is a simple widget for creating pagination on post/category/admin
 * pages.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.1
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
     * Text for first page button.
     *
     * @var string
     * @since 0.1.1
     */
    public $firstPageText = '&laquo;';
    /**
     * Text for last page button.
     *
     * @var string
     * @since 0.1.1
     */
    public $lastPageText = '&raquo';
    /**
     * Amount of page links to be shown (excluding side links).
     *
     * @var int
     * @since 0.1.1
     */
    public $size = 5;
    
    /**
     * Preparational method. Gets and stores variables for latter output.
     *
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
        if ($this->totalPages === 0) {
            return;
        }
        if ($this->title !== false) {
            echo CHtml::tag('div', array(), $this->title);
        }
        $start = max(1, $this->currentPage - floor($this->size/2));
        $end = min($this->totalPages, $this->currentPage + ceil($this->size/2));

        echo $this->getSideLink(true, $start === 1);
        for ($i = $start; $i <= $end; $i++) {
            echo $this->getLink($i, null, $i === $this->currentPage);
        }
        echo $this->getSideLink(false, $end === $this->totalPages);
    }
    /**
     * Returns HTML link tag pointing to page with provided number.
     * 
     * @param int $page Page number.
     * @param string $text Link text.
     * @param boolean $current True if processed page is requested page.
     * @param boolean $disabled True if link should be disabled.
     * @return string HTML tag.
     * @since 0.1.0
     */
    protected function getLink($page, $text=null, $current=false, $disabled=false)
    {
        if ($text === null) {
            $text = (string)$page;
        }
        $htmlOpts = array();
        if ($disabled) {
            $htmlOpts = array('class' => 'disabled');
            $content = CHtml::tag('span', array(), $text);
        } else {
            if ($current) {
                $htmlOpts = array('class' => 'active');
            }
            $opts = array_merge($this->routeOptions, array('page' => $page));
            $link = $this->controller->createUrl($this->route, $opts);
            $content = CHtml::link($text, $link);
        }
        return CHtml::tag('li', $htmlOpts, $content);
    }

    /**
     * Returns side link (« or ») to first or last page.
     *
     * @param bool $first Tells if link for first page should be returned.
     * @param bool $disabled Tells if link should be disabled.
     * @return string Link text.
     * @since 0.1.0
     */
    protected function getSideLink($first=true, $disabled=false)
    {
        if ($first)
            return $this->getLink(1, $this->firstPageText, false, $disabled);
        return $this->getLink($this->totalPages, $this->lastPageText, false, $disabled);
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
