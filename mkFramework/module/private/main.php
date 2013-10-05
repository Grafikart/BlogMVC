<?php 
class module_private extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('private');
		
		_root::getAuth()->enable();
		
		//$this->oLayout->addModule('menu','menu::index');
	}
	/* #debutaction#
	public function _exampleaction(){
	
		$oView=new _view('examplemodule::exampleaction');
		
		$this->oLayout->add('main',$oView);
	}
	#finaction# */
	
	
	public function _index(){
		$oModulePostsadmin=new module_postsadmin;

		//si vous souhaitez indiquer au module integrable des informations sur le module parent
		//$oModuleExamplemodule->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));

		//recupere la vue du module
		$oView=$oModulePostsadmin->_index();

		//assigner la vue retournee a votre layout
		$this->oLayout->add('main',$oView);
	}
	
	
	public function after(){
		$this->oLayout->show();
	}
	
	
}
