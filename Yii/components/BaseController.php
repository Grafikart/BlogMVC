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
     * A simple wrapper around standard Yii {@link \CController::render()}
     * method that allows easy data formatting.
     *
     * @param string     $view    View name.
     * @param array|null $data    Data that is used to render a template.
     * @param mixed      $rawData Raw data that should be formatted using
     *                            {@link \DataFormatter}
     * @param bool       $return  Whether to return data or output it directly.
     *
     * @throws \EHttpException Thrown if non-html format is used, but no
     * `$rawData` is received.
     *
     * @return string|void Output as string or nothing (depending on `$return`
     *                     argument).
     * @since 0.1.0
     */
    public function render($view, $data=null, $rawData=null, $return=false)
    {
        header($this->page->generateFormatHeader());
        if ($this->page->format === 'html') {
            return parent::render($view, $data, $return);
        } else {
            if (empty($rawData)) {
                throw new \EHttpException(400, 'badRequest.invalidFormat');
            }
            $formatter = \Yii::app()->formatter;
            if (is_array($rawData)) {
                $render = $formatter->formatModels($rawData, $this->page->format);
            } else if ($rawData instanceof \CModel) {
                $render = $formatter->formatModel($rawData, $this->page->format);
            } else {
                \Yii::log(
                    'Unexpected data type: '.gettype($rawData),
                    CLogger::LEVEL_ERROR
                );
                throw new \EHttpException(
                    500,
                    'internalServerError.unexpectedDataType'
                );
            }
            if ($return) {
                return $render;
            }
            echo $render;
        }
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

    /**
     * Another terrible solution to setup links for navigation menu outside of
     * actions. It's quite unclear where they should be defined, though.
     *
     * @return array List of navigation links in [actionId => [actions]] form,
     *               e.g. [index => [post/index, user/index]]
     * @since
     */
    public function navigationLinks()
    {
        return array();
    }
}
