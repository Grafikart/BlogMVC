<?php

/**
 * This is a simple widget for creating pagination on post/category/admin
 * pages.
 *
 * I seriously didn't know about CPager and ended up with that.
 *
 * @version    Release: 0.1.1
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class PaginationWidget extends WidgetLayer
{
    /**
     * Current page number
     * 
     * @type int
     * @since 0.1.0
     */
    public $currentPage;
    /**
     * Amount of pages in total.
     * 
     * @type int
     * @since 0.1.0
     */
    public $totalPages;
    /**
     * Yii `controller/action` for link generation.
     * 
     * @type string
     * @since 0.1.0
     */
    public $route;
    /**
     * Optional list of data required to generate link from route.
     * 
     * @type array
     * @since 0.1.0
     */
    public $routeOptions = array();
    /**
     * Text for the delimiter between last/first page link and near-current
     * page links (if they are separated).
     * 
     * @type string
     * @since 0.1.0
     */
    public $delimiterText;
    /**
     * Text for first page button.
     *
     * @type string
     * @since 0.1.1
     */
    public $firstPageText = '&laquo;';
    /**
     * Text for last page button.
     *
     * @type string
     * @since 0.1.1
     */
    public $lastPageText = '&raquo';
    /**
     * Amount of page links to be shown (excluding side links).
     *
     * @type int
     * @since 0.1.1
     */
    public $size = 5;
    /**
     * Flag that prevents widget from generating output. Set to true if not
     * enough information is available.
     *
     * @type bool
     * @since 0.1.0
     */
    protected $halt = false;
    
    /**
     * Preparational method. Gets and stores variables for latter output or
     * halts future processing.
     *
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
        /** @type \BaseController $controller */
        $controller = $this->getController();
        if (!isset($this->currentPage)) {
            $this->currentPage = $controller->page->pageNumber;
        }
        if (!isset($this->totalPages) || $this->totalPages < 2) {
            $this->totalPages = $controller->page->totalPages;
        }
        if (!isset($this->route)) {
            $this->route = $controller->page->route;
        }
        if (empty($this->routeOptions)) {
            $this->routeOptions = $controller->page->routeOptions;
        }
        if (!isset($this->totalPages, $this->route, $this->currentPage)
            || $this->totalPages < 2
        ) {
            $this->halt = true;
        }
        if (!isset($this->delimiterText)) {
            $this->delimiterText = \Yii::t('templates', 'pagination.delimiter');
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
        if ($this->halt) {
            return;
        }
        $this->render('pagination');
    }
}
