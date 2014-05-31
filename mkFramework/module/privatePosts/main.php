<?php 
class module_privatePosts extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('private');
		
		//$this->oLayout->addModule('menu','menu::index');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	
	public function _list(){
		
		$tPosts=model_posts::getInstance()->findAll();
		
		$oModulePagination=new module_pagination;
		$oModulePagination->setModuleAction('privatePosts::list');
		$oModulePagination->setTab($tPosts);
		$oModulePagination->setLimit(2);
		$oModulePagination->setPage(_root::getParam('page'));
		$tPosts=$oModulePagination->getPageElement();
		
		$oView=new _view('privatePosts::list');
		$oView->tPosts=$tPosts;
		
		$oView->tJoinmodel_categories=model_categories::getInstance()->getSelect();		
		$oView->tJoinmodel_users=model_users::getInstance()->getSelect();
		
		$oView->oPagination=$oModulePagination;
		
		$this->oLayout->add('main',$oView); 
	}

	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oPosts=new row_posts;
		$oPosts=$this->fillRow($oPosts);
		
		$oView=new _view('privatePosts::new');
		$oView->oPosts=$oPosts;
		
		$oView->tJoinmodel_categories=model_categories::getInstance()->getSelect();		
		$oView->tJoinmodel_users=model_users::getInstance()->getSelect();
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oPosts=model_posts::getInstance()->findById( _root::getParam('id') );
		$oPosts=$this->fillRow($oPosts);
		
		$oView=new _view('privatePosts::edit');
		$oView->oPosts=$oPosts;
		$oView->tId=model_posts::getInstance()->getIdTab();
		
		$oView->tJoinmodel_users=model_users::getInstance()->getSelect();
		$oView->tJoinmodel_categories=model_categories::getInstance()->getSelect();	
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
	
	public function _delete(){
		$tMessage=$this->processDelete();

		
	}

	
	
	private function fillRow($oPosts){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return $oPosts;
		}
		
		$tId=model_posts::getInstance()->getIdTab();
		$tColumn=model_posts::getInstance()->getListColumn();
		foreach($tColumn as $sColumn){
			if( _root::getParam($sColumn,null) === null ){ 
				continue;
			}else if( in_array($sColumn,$tId)){
				 continue;
			}
			
			$oPosts->$sColumn=_root::getParam($sColumn,null) ;
		}
		return $oPosts;
	}

	private function processSave(){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$iId=_root::getParam('id',null);
		if($iId==null){
			$oPosts=new row_posts;	
		}else{
			$oPosts=model_posts::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tColumn=array('category_id','user_id','name','slug','content');
		foreach($tColumn as $sColumn){
			$oPosts->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		
		if($oPosts->save()){
			if(_root::getCache()->isCached('sidebar_lastpost')){
				_root::getCache()->clearCache( 'sidebar_lastpost');
			}
			if(_root::getCache()->isCached('sidebar_categories')){
				_root::getCache()->clearCache( 'sidebar_categories');
			}
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('privatePosts::list');
		}else{
			return $oPosts->getListError();
		}
		
	}
	
	
	public function processDelete(){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$oPosts=model_posts::getInstance()->findById( _root::getParam('id',null) );
				
		$oPosts->delete();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('privatePosts::list');
		
	}


	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

