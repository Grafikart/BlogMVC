<?php

/**
 * This class is an ancestor to all other controllers. It adds custom
 * breadcrumbs support, proxies some calls and adds support for rendering
 * markdown files.
 *
 * @version    0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class BaseController extends \CController
{
    /**
     * Current layout. Defaults to nonexisting layout to prevent Twig double
     * rendering.
     *
     * @var string
     * @since 0.1.0
     */
    public $layout = 'none';
    /**
     * Object that contains all information about current page.
     *
     * @type \Page
     * @since 0.1.0
     */
    public $page;

    /**
     * Renders markdown file.
     *
     * @param string $view       View file name.
     * @param string $file       Markdown file alias.
     * @param array  $data       Additional data for rendering.
     * @param string $contentKey Key under which rendered markdown content will
     * be passed to template rendering engine.
     *
     * @throws \EHttpException Thrown if requested file could not be read.
     *
     * @return void
     * @since 0.1.0
     */
    public function renderMd(
        $view,
        $file,
        array $data = array(),
        $contentKey = 'content'
    ) {
        $filePath = $this->resolveMarkdownFile($file);
        if (!$filePath || ($text = file_get_contents($filePath)) === false) {
            throw new \EHttpException(500, 'internalServerError.missingFile');
        }
        $text = \Yii::app()->formatter->renderMarkdown($text);
        $data[$contentKey] = $text;
        $this->render($view, $data);
    }

    /**
     * Finds localized or general markdown file.
     *
     * @param string $alias Markdown file alias.
     *
     * @return string|boolean File path or false if path does not exist.
     * @since 0.1.0
     */
    public function resolveMarkdownFile($alias)
    {
        $lang = \Yii::app()->language;
        $lastDot = (int)strrpos($alias, '.');
        $fileName = substr($alias, $lastDot + 1);
        $directory = substr($alias, 0, $lastDot);
        $localizedFile = $directory . '.' . $lang . '.' . $fileName;
        $filePath = \Yii::getPathOfAlias($localizedFile) . '.md';
        if (file_exists($filePath)) {
            return $filePath;
        }
        $filePath = \Yii::getPathOfAlias($alias) . '.md';
        if (file_exists($filePath)) {
            return $filePath;
        }
        return false;
    }

    /**
     * Callback for initialization work such as setting breadcrumbs.
     *
     * @param \CAction $action Requested action.
     *
     * @return bool Whether the action should be ran or not.
     * @since 0.1.0
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $this->page = new Page($this);
        return true;
    }

    /**
     * Default initializer method.
     *
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
        $this->catchUnwantedRequest();
        parent::init();
        //$this->page = new Page($this->getPageTitle(), $this->route);
    }

    /**
     * This method allows to prevent `index.php?r=aaa/bbb` requests.
     *
     * @throws \EHttpException Thrown if unwanted access is found.
     *
     * @return void
     * @since 0.1.0
     */
    public function catchUnwantedRequest()
    {
        $requestUri = \Yii::app()->request->requestUri;
        $directCall = strpos($requestUri, '/index.php') === 0;
        $routeCall = \Yii::app()->request->getQuery('r') !== null;
        if ($directCall || $routeCall) {
            throw new \EHttpException(400);
        }
    }

    /**
     * This is a <b>terrible</b> or even <b>worst</b> place in the whole
     * project. I required a solid list of ancestors to every action to be able
     * to build breadcrumbs list. This could be easily done by stripping
     * segments from url and parsing it, but Yii ha no mechanism to parse
     * random url.
     *
     * @return string[] List of parent actions.
     * @since 0.1.0
     */
    public function getActionAncestors()
    {
        return array();
    }
}