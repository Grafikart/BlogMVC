<?php 
class module_comments extends abstract_moduleembedded{
	
	public static $sModuleName='comments';
	public static $sRootModule;
	public static $tRootParams;
	
	public $post_id;
	
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
	
	public function setPostId($id){
		$this->post_id=$id;
	}
	
	/*
	Pour integrer au sein d'un autre module:
	
	//instancier le module
	$oModuleExamplemodule=new module_comments();
	
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
		
		$tComments=model_comments::getInstance()->findAllByPost($this->post_id);
		
		$oView=new _view('comments::list');
		$oView->tComments=$tComments;
		
		

		return $oView;
	}
	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oComments=new row_comments;
		
		$oView=new _view('comments::new');
		$oView->oComments=$oComments;
		
		
		
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
	
		$iId=module_comments::getParam('id',null);
		if($iId==null){
			$oComments=new row_comments;	
		}else{
			$oComments=model_comments::getInstance()->findById( module_comments::getParam('id',null) );
		}
		
		$tId=model_comments::getInstance()->getIdTab();
		$tColumn=model_comments::getInstance()->getListColumn();
		foreach($tColumn as $sColumn){
			 $oPluginUpload=new plugin_upload($sColumn);
			if($oPluginUpload->isValid()){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload->saveAs($sNewFileName);
				$oComments->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else  if( _root::getParam($sColumn,null) === null ){ 
				continue;
			}else if( in_array($sColumn,$tId)){
				 continue;
			}
			
			$oComments->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		$oComments->post_id=$this->post_id;
		
		if($oComments->save()){
			//une fois enregistre on redirige (vers la page liste)
			$this->redirect('list');
		}else{
			return $oComments->getListError();
		}
		
	}

	
	
	
	
	
}

/*variables
#select		$oView->tJoincomments=comments::getInstance()->getSelect();#fin_select
#uploadsave $oPluginUpload=new plugin_upload($sColumn);
			if($oPluginUpload->isValid()){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload->saveAs($sNewFileName);
				$oComments->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else #fin_uploadsave


#methodNew
	public function _new(){
		$tMessage=$this->processSave();
	
		$oComments=new row_comments;
		
		$oView=new _view('comments::new');
		$oView->oComments=$oComments;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}
methodNew#
	
#methodEdit
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oComments=model_comments::getInstance()->findById( module_comments::getParam('id') );
		
		$oView=new _view('comments::edit');
		$oView->oComments=$oComments;
		$oView->tId=model_comments::getInstance()->getIdTab();
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}
methodEdit#

#methodShow
	public function _show(){
		$oComments=model_comments::getInstance()->findById( module_comments::getParam('id') );
		
		$oView=new _view('comments::show');
		$oView->oComments=$oComments;
		
		
		return $oView;
	}
methodShow#

#methodDelete	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oComments=model_comments::getInstance()->findById( module_comments::getParam('id') );
		
		$oView=new _view('comments::delete');
		$oView->oComments=$oComments;
		
		

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
	
		$oComments=model_comments::getInstance()->findById( module_comments::getParam('id',null) );
				
		$oComments->delete();
		//une fois enregistre on redirige (vers la page liste)
		$this->redirect('list');
		
	}
methodProcessDelete#

			
variables*/

