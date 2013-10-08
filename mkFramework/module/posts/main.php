<?php 
class module_posts extends abstract_moduleembedded{
	
	public static $sModuleName='posts';
	public static $sRootModule;
	public static $tRootParams;
	
	private $category_id;
	
	public function setCategory($id){
		$this->category_id=$id;
	}
	
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
	$oModuleExamplemodule=new module_posts();
	
	//si vous souhaitez indiquer au module integrable des informations sur le module parent
	//$oModuleExamplemodule->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));
	
	//recupere la vue du module
	$oViewModule=$oModuleExamplemodule->_index();
	
	//assigner la vue retournee a votre layout
	$this->oLayout->add('main',$oViewModule);
	*/
	
	
	public function _index(){
		$sAction='_'.self::getParam('Action','list');
		return $this->$sAction();
	}
	
	public function _list(){
		
		if($this->category_id ){
			$tPosts=model_posts::getInstance()->findByCategory($this->category_id);
		}else{			
			$tPosts=model_posts::getInstance()->findAll();
		}
		
		$oModulePagination=new module_pagination;
		$oModulePagination->setModuleAction('default::index');
		$oModulePagination->setTab($tPosts);
		$oModulePagination->setLimit(5);
		$oModulePagination->setPage(_root::getParam('page'));
		$tPosts=$oModulePagination->getPageElement();
		
		
		$oView=new _view('posts::list');
		$oView->tPosts=$tPosts;

		$oView->tJoinmodel_categories=model_categories::getInstance()->getSelect();		
		$oView->tJoinmodel_users=model_users::getInstance()->getSelect();
		
		$oView->oPagination=$oModulePagination;

		return $oView;
	}
	
	
	public function _lastList(){
		
		//cache
		if(_root::getCache()->isCached('sidebar_lastpost')){
			$oView=_root::getCache()->getCached( 'sidebar_lastpost'); 
			return $oView;
		}
		
		
		$tPosts=model_posts::getInstance()->findLast();
		
		$oView=new _view('posts::smalllist');
		$oView->tPosts=$tPosts;

		$oView->tJoinmodel_categories=model_categories::getInstance()->getSelect();		
		$oView->tJoinmodel_users=model_users::getInstance()->getSelect();

		_root::getCache()->setCache('sidebar_lastpost',$oView);

		return $oView;
	}
	
	
	
	public function _show(){
		$oPosts=model_posts::getInstance()->findBySlug( module_posts::getParam('slug') );
		
		$oView=new _view('posts::show');
		$oView->oPosts=$oPosts;
		
		$oView->tJoinmodel_categories=model_categories::getInstance()->getSelect();		
		$oView->tJoinmodel_users=model_users::getInstance()->getSelect();
		
		//we instance the module 
		$oModuleComments=new module_comments;
		$oModuleComments->setPostId(module_posts::getParam('id') );
		//si vous souhaitez indiquer au module integrable des informations sur le module parent
		$oModuleComments->setRootLink('default::index',array('postsAction'=>'show','postsid'=>_root::getParam('postsid')));
		
		//form add
		$oView->oCommentsAdd=$oModuleComments->_new();
		
		//comments
		$oView->oComments=$oModuleComments->_index();
		
		return $oView;
	}

	
	
	

	

	public function processSave(){
		if(!_root::getRequest()->isPost() or _root::getParam('formmodule')!=self::$sModuleName ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$iId=module_posts::getParam('id',null);
		if($iId==null){
			$oPosts=new row_posts;	
		}else{
			$oPosts=model_posts::getInstance()->findById( module_posts::getParam('id',null) );
		}
		
		$tId=model_posts::getInstance()->getIdTab();
		$tColumn=model_posts::getInstance()->getListColumn();
		foreach($tColumn as $sColumn){
			 $oPluginUpload=new plugin_upload($sColumn);
			if($oPluginUpload->isValid()){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload->saveAs($sNewFileName);
				$oPosts->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else  if( _root::getParam($sColumn,null) === null ){ 
				continue;
			}else if( in_array($sColumn,$tId)){
				 continue;
			}
			
			$oPosts->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		if($oPosts->save()){
			//une fois enregistre on redirige (vers la page liste)
			$this->redirect('list');
		}else{
			return $oPosts->getListError();
		}
		
	}

	
	
	
	
	
}

/*variables
#select		$oView->tJoinposts=posts::getInstance()->getSelect();#fin_select
#uploadsave $oPluginUpload=new plugin_upload($sColumn);
			if($oPluginUpload->isValid()){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload->saveAs($sNewFileName);
				$oPosts->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else #fin_uploadsave


#methodNew
	public function _new(){
		$tMessage=$this->processSave();
	
		$oPosts=new row_posts;
		
		$oView=new _view('posts::new');
		$oView->oPosts=$oPosts;
		
				$oView->tJoinmodel_categories=model_categories::getInstance()->getSelect();		$oView->tJoinmodel_users=model_users::getInstance()->getSelect();
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}
methodNew#
	
#methodEdit
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oPosts=model_posts::getInstance()->findById( module_posts::getParam('id') );
		
		$oView=new _view('posts::edit');
		$oView->oPosts=$oPosts;
		$oView->tId=model_posts::getInstance()->getIdTab();
		
				$oView->tJoinmodel_categories=model_categories::getInstance()->getSelect();		$oView->tJoinmodel_users=model_users::getInstance()->getSelect();
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}
methodEdit#

#methodShow
	public function _show(){
		$oPosts=model_posts::getInstance()->findById( module_posts::getParam('id') );
		
		$oView=new _view('posts::show');
		$oView->oPosts=$oPosts;
		
				$oView->tJoinmodel_categories=model_categories::getInstance()->getSelect();		$oView->tJoinmodel_users=model_users::getInstance()->getSelect();
		return $oView;
	}
methodShow#

#methodDelete	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oPosts=model_posts::getInstance()->findById( module_posts::getParam('id') );
		
		$oView=new _view('posts::delete');
		$oView->oPosts=$oPosts;
		
				$oView->tJoinmodel_categories=model_categories::getInstance()->getSelect();		$oView->tJoinmodel_users=model_users::getInstance()->getSelect();

		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}
methodDelete#

#methodProcessDelete
	public function processDelete(){
		if(!_root::getRequest()->isPost() or _root::getParam('formmodule')!=self::$sModuleName){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$oPosts=model_posts::getInstance()->findById( module_posts::getParam('id',null) );
				
		$oPosts->delete();
		//une fois enregistre on redirige (vers la page liste)
		$this->redirect('list');
		
	}
methodProcessDelete#

			
variables*/

