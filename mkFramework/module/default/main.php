<?php 
class module_default extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		//instancier le module
		$oModuleCategories=new module_categories;

		//recupere la vue du module
		$oView=$oModuleCategories->_index();

		//assigner la vue retournee a votre layout
		$this->oLayout->add('sidebar',$oView);
		
		//posts (main)
		$oModuleExamplemodule=new module_posts();
		
		//recupere la vue du module
		$oViewModule=$oModuleExamplemodule->_lastList();
		
		//assigner la vue retournee a votre layout
		$this->oLayout->add('sidebar',$oViewModule);
	}
	
	public function _index(){
	   
		//posts (main)
		$oModulePosts=new module_posts();
		
		//recupere la vue du module
		$oViewModule=$oModulePosts->_index();
		
		//assigner la vue retournee a votre layout
		$this->oLayout->add('main',$oViewModule);
		
	}
	public function _category(){
	    $oView=new _view('default::index');
		
		$this->oLayout->add('main',$oView);
		
		//posts (main)
		$oModuleExamplemodule=new module_posts();
		
		$oModuleExamplemodule->setCategory(_root::getParam('id'));
		
		//si vous souhaitez indiquer au module integrable des informations sur le module parent
		$oModuleExamplemodule->setRootLink('default::categoryDetail',array('id'=>_root::getParam('id')));
		
		//recupere la vue du module
		$oViewModule=$oModuleExamplemodule->_index();
		
		//assigner la vue retournee a votre layout
		$this->oLayout->add('main',$oViewModule);
		
	}
	public function _categoryDetail(){
		$this->_category();
	}
	
	
	public function after(){
		$this->oLayout->show();
	}
}
