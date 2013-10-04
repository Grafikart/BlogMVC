<?php 
class module_default extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		//instancier le module
		$oModuleCategories=new module_categories;

		//si vous souhaitez indiquer au module integrable des informations sur le module parent
		//$oModuleExamplemodule->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));

		//recupere la vue du module
		$oView=$oModuleCategories->_index();

		//assigner la vue retournee a votre layout
		$this->oLayout->add('sidebar',$oView);
		
		//posts (main)
		$oModuleExamplemodule=new module_posts();
		
		//si vous souhaitez indiquer au module integrable des informations sur le module parent
		//$oModuleExamplemodule->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));
		
		//recupere la vue du module
		$oViewModule=$oModuleExamplemodule->_lastList();
		
		//assigner la vue retournee a votre layout
		$this->oLayout->add('sidebar',$oViewModule);
	}
	
	public function _index(){
	    $oView=new _view('default::index');
		
		$this->oLayout->add('main',$oView);
		
		//posts (main)
		$oModuleExamplemodule=new module_posts();
		
		//si vous souhaitez indiquer au module integrable des informations sur le module parent
		//$oModuleExamplemodule->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));
		
		//recupere la vue du module
		$oViewModule=$oModuleExamplemodule->_index();
		
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
		$oModuleExamplemodule->setRootLink('default::category',array('id'=>_root::getParam('id')));
		
		//recupere la vue du module
		$oViewModule=$oModuleExamplemodule->_index();
		
		//assigner la vue retournee a votre layout
		$this->oLayout->add('main',$oViewModule);
		
	}
	
	
	public function after(){
		$this->oLayout->show();
	}
}
