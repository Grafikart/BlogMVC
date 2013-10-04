<?php 
class module_postsadmin extends abstract_moduleembedded{
	
	public static $sModuleName='postsadmin';
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
	$oModuleExamplemodule=new module_postsadmin();
	
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
		
		$tPosts=model_posts::getInstance()->findAll();
		
		$oModulePagination=new module_pagination;
		$oModulePagination->setModuleAction('private::index');
		$oModulePagination->setTab($tPosts);
		$oModulePagination->setLimit(2);
		$oModulePagination->setPage(_root::getParam('page'));
		$tPosts=$oModulePagination->getPageElement();
		
		$oView=new _view('postsadmin::list');
		$oView->tPosts=$tPosts;
		
		$oView->tJoinmodel_categories=model_categories::getInstance()->getSelect();		
		$oView->tJoinmodel_users=model_users::getInstance()->getSelect();
		
		$oView->oPagination=$oModulePagination;

		return $oView;
	}
	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oPosts=new row_posts;
		
		$oView=new _view('postsadmin::new');
		$oView->oPosts=$oPosts;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}

	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oPosts=model_posts::getInstance()->findById( module_postsadmin::getParam('id') );
		
		$oView=new _view('postsadmin::edit');
		$oView->oPosts=$oPosts;
		$oView->tId=model_posts::getInstance()->getIdTab();
		
		$oView->tJoinmodel_categories=model_categories::getInstance()->getSelect();		
		$oView->tJoinmodel_users=model_users::getInstance()->getSelect();
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}

	
	
	public function _show(){
		$oPosts=model_posts::getInstance()->findById( module_postsadmin::getParam('id') );
		
		$oView=new _view('postsadmin::show');
		$oView->oPosts=$oPosts;
		
		
		return $oView;
	}

	
		
	public function _delete(){
		$tMessage=$this->processDelete();

		$oPosts=model_posts::getInstance()->findById( module_postsadmin::getParam('id') );
		
		$oView=new _view('postsadmin::delete');
		$oView->oPosts=$oPosts;
		
		

		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
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
	
		$iId=module_postsadmin::getParam('id',null);
		if($iId==null){
			$oPosts=new row_posts;	
		}else{
			$oPosts=model_posts::getInstance()->findById( module_postsadmin::getParam('id',null) );
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

	
	
	public function processDelete(){
		if(!_root::getRequest()->isPost() or _root::getParam('formmodule')!=self::$sModuleName){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$oPosts=model_posts::getInstance()->findById( module_postsadmin::getParam('id',null) );
				
		$oPosts->delete();
		//une fois enregistre on redirige (vers la page liste)
		$this->redirect('list');
		
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
		
		$oView=new _view('postsadmin::new');
		$oView->oPosts=$oPosts;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}
methodNew#
	
#methodEdit
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oPosts=model_posts::getInstance()->findById( module_postsadmin::getParam('id') );
		
		$oView=new _view('postsadmin::edit');
		$oView->oPosts=$oPosts;
		$oView->tId=model_posts::getInstance()->getIdTab();
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}
methodEdit#

#methodShow
	public function _show(){
		$oPosts=model_posts::getInstance()->findById( module_postsadmin::getParam('id') );
		
		$oView=new _view('postsadmin::show');
		$oView->oPosts=$oPosts;
		
		
		return $oView;
	}
methodShow#

#methodDelete	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oPosts=model_posts::getInstance()->findById( module_postsadmin::getParam('id') );
		
		$oView=new _view('postsadmin::delete');
		$oView->oPosts=$oPosts;
		
		

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
	
		$oPosts=model_posts::getInstance()->findById( module_postsadmin::getParam('id',null) );
				
		$oPosts->delete();
		//une fois enregistre on redirige (vers la page liste)
		$this->redirect('list');
		
	}
methodProcessDelete#

			
variables*/

