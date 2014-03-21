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
    public $pageTitle;
    public $breadcrumbs = array();
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
    public function resolveViewFile($viewName,$viewPath,$basePath,$moduleViewPath=null)
	{
		if(empty($viewName))
			return false;

		if($moduleViewPath===null)
			$moduleViewPath=$basePath;

                if (strrpos($viewName, '.md') === strlen($viewName) - 3) {
                    $extension = '.md';
                    $viewName = substr($viewName, 0, strlen($viewName) - 3);
                }
		else if(($renderer=Yii::app()->getViewRenderer())!==null)
			$extension=$renderer->fileExtension;
		else
			$extension='.php';
		if($viewName[0]==='/')
		{
			if(strncmp($viewName,'//',2)===0)
				$viewFile=$basePath.$viewName;
			else
				$viewFile=$moduleViewPath.$viewName;
		}
		elseif(strpos($viewName,'.'))
			$viewFile=Yii::getPathOfAlias($viewName);
		else
			$viewFile=$viewPath.DIRECTORY_SEPARATOR.$viewName;

		if(is_file($viewFile.$extension))
			return Yii::app()->findLocalizedFile($viewFile.$extension);
		elseif($extension!=='.php' && is_file($viewFile.'.php'))
			return Yii::app()->findLocalizedFile($viewFile.'.php');
		else
			return false;
	}
    protected function generateBreadcrumbs()
    {
        $segments = explode('/', trim(Yii::app()->request->requestUri, '/'));
        $url = '';
        foreach ($segments as $segment) {
            $url .= '/'.$segment;
            $this->breadcrumbs[$url] = ucfirst($segment);
        }
    }
    public function beforeAction($action) {
        $this->generateBreadcrumbs();
        return parent::beforeAction($action);
    }
}
