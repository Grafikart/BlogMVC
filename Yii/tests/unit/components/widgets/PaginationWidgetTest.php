<?php
use \Codeception\Util\Fixtures;
use \Symfony\Component\DomCrawler\Crawler;

class PaginationWidgetTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $guy;
    /**
     *
     *
     * @type Crawler
     * @since 0.1.0
     */
    protected $crawler;
    /**
     *
     *
     * @type \BaseController
     * @since 0.1.0
     */
    protected $controller;

    protected function _before()
    {
        \Yii::app()->language = 'testing';
    }

    protected function _after()
    {
        \Yii::app()->language = Fixtures::get('defaults:app:language');
    }

    protected function getCrawler($html)
    {
        if (!isset($this->crawler)) {
            $this->crawler = new Crawler;
        }
        $this->crawler->clear();
        $this->crawler->addHtmlContent($html);
        return $this->crawler;
    }

    protected function getController($totalPages)
    {
        if (!isset($this->controller)) {
            $controller = new \SiteController('site');
            $page = new \stdClass;
            $page->routeOptions = array();
            $page->totalPages = 1;
            $controller->page = $page;
            $this->controller = $controller;
        }
        $this->controller->page->totalPages = $totalPages;
        return $this->controller;
    }

    public function configProvider()
    {
        $data = array();
        for ($i = 1; $i < 9; $i++) {
            for ($j = 1; $j <= $i; $j++) {
                for ($k = 0; $k <= 6; $k++) {
                    // current page, total pages, size
                    $data[] = array($j, $i, $k);
                }
            }
        }
        return $data;
    }

    /**
     *
     *
     * @dataProvider configProvider
     *
     * @return void
     * @since 0.1.0
     */
    public function testWidget($current, $total, $size)
    {
        ob_start();
        $controller = $this->getController($total);
        $w = new \PaginationWidget($controller);
        $w->currentPage = $current;
        $w->totalPages = $total;
        $w->size = $size;
        $w->route = 'dummy/index';
        $w->init();
        $w->run();
        $out = ob_get_clean();

        $offset = ceil($size/2);
        $leftGap = $current - $offset > 2;
        $rightGap = $current + $offset < $total - 1;
        $leftDisabled = $current === 1;
        $rightDisabled = $current === $total;

        $crawler = $this->getCrawler($out);
        $elements = $crawler->filter('li');
        $totalElements = $elements->count();
        if ($total === 1) {
            $this->assertEmpty($out);
            return;
        }
        if ($leftGap) {
            $delimiter = trim($crawler->filter('li:nth-child(2)')->text());
            $this->assertEquals('pagination.delimiter', $delimiter);
        }
        if ($rightGap) {
            $number = $totalElements - 1;
            $delimiter = trim($crawler->filter('li:nth-child('.$number.')')->text());
            $this->assertEquals('pagination.delimiter', $delimiter);
        }
        if ($leftDisabled) {
            $this->assertEquals('disabled', $elements->first()->attr('class'));
        }
        if ($rightDisabled) {
            $this->assertEquals('disabled', $elements->last()->attr('class'));
        }
    }
}