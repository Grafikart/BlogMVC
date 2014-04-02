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
    /**
     * Current page number.
     * 
     * @var int
     * @since 0.1.0
     */
    protected $pageNumber;
    /**
     * Current page title.
     * 
     * @var string
     * @since 0.1.0
     */
    protected $pageTitle;
    /**
     * Breadcrumbs in form of :url => :title array.
     * 
     * @var string[]
     * @since 0.1.0
     */
    protected $breadcrumbs = array();
    /**
     * One item length array containing information about previous page in
     * :url => :title format.
     * 
     * @var string[]
     * @since 0.1.0
     */
    protected $previousPage;
    /**
     * Validates and saves current page number.
     * 
     * @throws \HttpException HTTP error 400 is generated if invalid page
     * number is provided.
     * @param int $page Page number
     * @return int Current page number.
     * @since 0.1.0
     */
    protected function setPageNumber($page)
    {
        if (($this->page = (int) $page) < 1) {
            throw new \HttpException(400, 'badRequest.invalidPageNumber');
        }
        $this->generateBreadcrumbs();
        return $this->page;
    }
    /**
     * Page title getter.
     * 
     * @return string Current page title.
     * @since 0.1.0
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }
    /**
     * Returns breadcrumbs.
     * 
     * @return string[] Breadcrumbs.
     * @since 0.1.0
     */
    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }
    /**
     * Redefined standard method for `.md` files support.
     * 
     * @param string $_viewFile_ File to be rendered.
     * @param mixed $_data_ Data to be injected into view file.
     * @param boolean $_return_ Whether to output or return rendered view.
     * @return string|void If <var>$_return_</var> is set to true, buffered
     * output is returned, otherwise nothing is returned.
     * @since 0.1.0
     */
    public function renderInternal($_viewFile_, $_data_=null, $_return_=false)
    {
        $md = strrpos($_viewFile_, '.md') === strlen($_viewFile_) - 3;
        if(is_array($_data_)) {
            extract($_data_, EXTR_PREFIX_SAME, 'data');
        } else {
            $data = $_data_;
        }
        if ($_return_) {
            ob_start();
            ob_implicit_flush(false);
            if ($md) {
                $this->beginWidget('CMarkdown');
            }
            require($_viewFile_);
            if ($md) {
                $this->endWidget();
            }
            return ob_get_clean();
        }
        else {
            if ($md) {
                $this->beginWidget('CMarkdown');
            }
            require($_viewFile_);
            if ($md) {
                $this->endWidget();
            }
        }
    }
    /**
     * Native Yii method modification for `.md` files support.
     * 
     * @param string $viewName View file name.
     * @param string $viewPath
     * @param string $basePath
     * @param string $moduleViewPath
     * @return string|boolean View file path or false if it couldn't be found.
     * @since 0.1.0
     */
    public function resolveViewFile(
        $viewName,
        $viewPath,
        $basePath,
        $moduleViewPath=null
    ) {
        if (empty($viewName)) {
            return false;
        }

        if ($moduleViewPath===null) {
            $moduleViewPath=$basePath;
        }

        if (strrpos($viewName, '.md') === strlen($viewName) - 3) {
            $extension = '.md';
            $viewName = substr($viewName, 0, strlen($viewName) - 3);
        }
        else if (($renderer = Yii::app()->getViewRenderer()) !== null) {
            $extension = $renderer->fileExtension;
        } else {
            $extension = '.php';
        }
        if ($viewName[0] === '/') {
            if (strncmp($viewName, '//', 2) === 0) {
                $viewFile = $basePath.$viewName;
            } else {
                $viewFile = $moduleViewPath.$viewName;
            }
        }
        else if (strpos($viewName,'.')) {
            $viewFile = Yii::getPathOfAlias($viewName);
        } else {
            $viewFile = $viewPath.DIRECTORY_SEPARATOR.$viewName;
        }
        if (is_file($viewFile.$extension)) {
            return Yii::app()->findLocalizedFile($viewFile.$extension);
        }
        else if ($extension !== '.php' && is_file($viewFile.'.php')) {
            return Yii::app()->findLocalizedFile($viewFile.'.php');
        } else {
            return false;
        }
    }
    /**
     * Breadcrumbs generation method.
     * 
     * @return void
     * @since 0.1.0
     */
    protected function generateBreadcrumbs()
    {
        $segments = explode('/', trim(Yii::app()->request->requestUri, '/'));
        $url = '';
        foreach ($segments as $segment) {
            if (empty($segment)) {
                continue;
            }
            $url .= '/'.$segment;
            $this->breadcrumbs[$url] = ucfirst($segment);
        }
    }
    /**
     * Before-action callback, used to automate breadcrumbs generation.
     * 
     * @param CAction $action Action to run.
     * @return boolean Parent beforeAction() return status.
     * @since 0.1.0
     */
    public function beforeAction($action) {
        $this->generateBreadcrumbs();
        return parent::beforeAction($action);
    }
}