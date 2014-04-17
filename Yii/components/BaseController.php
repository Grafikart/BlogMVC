<?php

/**
 * Description of BaseController
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class BaseController extends CController
{
    public $layout = 'none';
    /**
     * Current page number.
     *
     * @var int
     * @since 0.1.0
     */
    public $pageNumber;
    /**
     * Breadcrumbs in form of :url => :title array.
     *
     * @var string[]
     * @since 0.1.0
     */
    public $breadcrumbs = array();
    /**
     * Array of replacement rules [[:needle], [:replacement]].
     *
     * @var array
     * @since 0.1.0
     */
    public $breadcrumbsReplacements = array(array(), array());

    /**
     * Validates and saves current page number.
     *
     * @throws \HttpException HTTP error 400 is generated if invalid page
     * number is provided.
     * @param int $page Page number
     * @return int Current page number.
     * @since 0.1.0
     */
    public function setPageNumber($page)
    {
        if (($this->pageNumber = (int)$page) < 1) {
            throw new \HttpException(400, 'badRequest.invalidPage');
        }
        $this->generateBreadcrumbs();
        return $this->pageNumber;
    }

    /**
     * Sets page title.
     *
     * @param string $pageTitle Page title to be set
     * @since 0.1.0
     */
    public function setPageTitle($pageTitle)
    {
        $l = sizeof($this->breadcrumbs);
        if ($l > 0) {
            $this->breadcrumbs[$l - 1]['title'] = $pageTitle;
        }
        parent::setPageTitle($pageTitle);
    }

    /**
     * Sets page title and number.
     *
     * @param int $pageNumber Current page number.
     * @param string $pageTitle Current page name.
     * @since 0.1.0
     */
    public function setPage($pageNumber = null, $pageTitle = null)
    {
        if ($pageNumber !== null) {
            $this->setPageNumber($pageNumber);
        }
        $this->generateBreadcrumbs();
        if ($pageTitle !== null) {
            $this->setPageTitle($pageTitle);
        }
    }

    /**
     * Adds new breadcrumbs replacement token.
     *
     * @param string $needle
     * @param string $replacement
     * @since 0.1.0
     */
    public function addBreadcrumbsReplacement($needle, $replacement)
    {
        $this->breadcrumbsReplacements[0] = $needle;
        $this->breadcrumbsReplacements[1] = $replacement;
    }

    /**
     * Returns information about parent page: false if there's no parent page,
     * [:url => :title] otherwise.
     *
     * @return array|bool False if there's no parent page, [:url => :title]
     * otherwise.
     * @since 0.1.0
     */
    public function getParentPage()
    {
        $l = sizeof($this->breadcrumbs);
        if ($l < 2) {
            return false;
        }
        return array($this->breadcrumbs[$l - 2]);
    }

    /**
     * Renders markdown file.
     *
     * @throws HttpException Thrown if requested file could not be read.
     *
     * @param string $view View file name.
     * @param string $file Markdown file alias.
     * @param array $data Additional data for rendering.
     * @param string $contentKey Key under which rendered markdown content will
     * be passed to template rendering engine.
     * @since 0.1.0
     */
    public function renderMd(
        $view,
        $file,
        array $data=array(),
        $contentKey='content'
    ) {
        $filePath = $this->resolveMarkdownFile($file);
        if (!$filePath || ($text = file_get_contents($filePath)) === false) {
            throw new \HttpException(500, 'internalServerError.missingFile');
        }
        $text = \Yii::app()->formatter->formatText($text, 'markdown');
        $data[$contentKey] = $text;
        $this->render($view, $data);
    }

    /**
     * Finds localized or general markdown file.
     *
     * @param string $alias Markdown file alias.
     * @return string|boolean File path or false if path does not exist.
     * @since 0.1.0
     */
    public function resolveMarkdownFile($alias)
    {
        $lang = \Yii::app()->language;
        $lastDot = (int) strrpos($alias, '.');
        $localizedFile = substr($alias, 0, $lastDot).'.'.$lang.substr($alias, $lastDot);
        $filePath = \Yii::getPathOfAlias($localizedFile).'.md';
        if (file_exists($filePath)) {
            return $filePath;
        }
        $filePath = \Yii::getPathOfAlias($alias).'.md';
        if (file_exists($filePath)) {
            return $filePath;
        }
        return false;
    }

    /**
     * Breadcrumbs generation method. Does virtually nothing if breadcrumbs are
     * already set and <var>$force</var> is set to false.
     *
     * @param boolean $setPageTitle Whether to autogenerate page title or not.
     * @param boolean $force Whether to force regeneration if breadcrumbs are
     * generated or not.
     * @return void
     * @since 0.1.0
     */
    protected function generateBreadcrumbs($setPageTitle=true, $force=false)
    {
        if (sizeof($this->breadcrumbs) > 0 && !$force) {
            return;
        }
        $uri = trim(Yii::app()->request->requestUri, '/');
        $this->breadcrumbs = array();
        if (($pos = strpos($uri, '?')) !== false) {
            $lastPage = substr($uri, $pos + 1);
            $uri = substr($uri, 0, $pos);
        }
        $segments = explode('/', $uri);
        $url = '';
        foreach ($segments as $segment) {
            if (in_array($segment, array_keys($this->breadcrumbsReplacements), true)) {
                $this->breadcrumbs[] = array(
                    'url' => $url .= '/' . $segment,
                    'title' => $this->breadcrumbsReplacements[$segment],
                );
            } else {
                $this->breadcrumbs[] = array(
                    'url' => $url .= '/' . $segment,
                    'title' => ucfirst(Yii::app()->formatter->deslugify($segment)),
                );
            }
        }
        if (isset($lastPage) && strlen($lastPage) > 0) {
            $this->addParamsBreadcrumb($lastPage);
        }
        if ($setPageTitle) {
            $lastBreadcrumb = $this->getLastBreadcrumb();
            $this->setPageTitle($lastBreadcrumb['title']);
        }
    }

    /**
     * Generates additional breadcrumb element based on query string.
     *
     * @param string $paramString Query string.
     * @since 0.1.0
     */
    protected function addParamsBreadcrumb($paramString)
    {
        $params = explode('&', $paramString);
        $parts = array();
        foreach ($params as $param) {
            $pos = strpos($param, '=');
            if ($pos === false || $pos === strlen($param) - 1) {
                $parts[] = ucfirst($param);
            } else {
                $parts[] = ucfirst(urldecode(substr($param, 0, $pos))) . ' ' .
                           ucfirst(urldecode(substr($param, $pos + 1)));
            }
        }
        $last = $this->getLastBreadcrumb();
        $url = $last['url'];
        $this->breadcrumbs[] = array(
            'url' => $url.'?'.$paramString,
            'title' => implode(', ', $parts),
        );
    }

    /**
     * Returns last breadcrumb.
     *
     * @return string[]|boolean Last breadcrumb or false if it doesn't exist.
     * @since 0.1.0
     */
    public function getLastBreadcrumb()
    {
        $l = sizeof($this->breadcrumbs);
        if ($l < 1) {
            return false;
        }
        return $this->breadcrumbs[$l - 1];
    }

    /**
     * Returns penultimate breadcrumb.
     *
     * @return string[]|boolean Penultimate breadcrumb or false if it doesn't
     * exist.
     * @since 0.1.0
     */
    public function getPenultimateBreadcrumb()
    {
        $l = sizeof($this->breadcrumbs);
        if ($l < 2) {
            return false;
        }
        return $this->breadcrumbs[$l - 2];
    }

    /**
     * Callback for initialization work such as setting breadcrumbs.
     *
     * @param CAction $action Requested action.
     * @return bool Whether the action should be ran or not.
     * @since 0.1.0
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $this->generateBreadcrumbs();
        return true;
    }
}