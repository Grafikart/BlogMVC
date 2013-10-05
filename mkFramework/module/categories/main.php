<?php 
class module_categories extends abstract_moduleembedded{
	
	public static $sModuleName='categories';
	public static $sRootModule;
	public static $tRootParams;
	
	public function __construct(){
		self::setRootLink(_root::getParamNav(),null);
	}
	public static function setRootLink($sRootModule,$tRootParams=null){
		self::$sRootModule=$sRootModule;
		self::$tRootParams=$tRootParams;
	}
	public static function getLink($sAction,$tParam=null){
		return parent::_getLink(self::$sRootModule,self::$tRootParams,self::$sModuleName,$sAction,$tParam);
	}
	public static function getParam($sVar,$uDefault=null){
		return parent::_getParam(self::$sModuleName,$sVar,$uDefault);
	}
	public static function redirect($sModuleAction,$tModuleParam=null){
		return parent::_redirect(self::$sRootModule,self::$tRootParams,self::$sModuleName,$sModuleAction,$tModuleParam);
	}
	
	/*
	Pour integrer au sein d'un autre module:
	
	//instancier le module
	$oModuleCategories=new module_categories();
	
	//si vous souhaitez indiquer au module integrable des informations sur le module parent
	//$oModuleCategories->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));
	
	//recupere la vue du module
	$oViewModule=$oModuleCategories->_index();
	
	//assigner la vue retournee a votre layout
	$this->oLayout->add('main',$oViewModule);
	*/
	
	
	public function _index(){
		$sAction='_'.self::getParam('Action','list');
		return $this->$sAction();
	}
	
	public function _list(){
		//cache
		if(_root::getCache()->isCached('sidebar_categories')){
			$oView=_root::getCache()->getCached( 'sidebar_categories'); 
			return $oView;
		}
		
		$tCategories=model_categories::getInstance()->findAll();
		
		$oView=new _view('categories::list');
		$oView->tCategories=$tCategories;
		
		_root::getCache()->setCache('sidebar_categories',$oView);

		return $oView;
	}

	public function _show(){
		$oCategories=model_categories::getInstance()->findById( module_categories::getParam('id') );
		
		$oView=new _view('categories::show');
		$oView->oCategories=$oCategories;
		
		
		return $oView;
	}
	
	
}

/*variables
#select		$oView->tJoincategories=categories::getInstance()->getSelect();#fin_select
#uploadsave $oPluginUpload=new plugin_upload($sColumn);
			if($oPluginUpload->isValid()){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload->saveAs($sNewFileName);
				$oCategories->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else #fin_uploadsave
variables*/

