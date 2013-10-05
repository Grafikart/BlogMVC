<?php
class module_auth extends abstract_module{
	
	//longueur maximum du mot de passe
	private $maxPasswordLength=100;
	
	public function before(){
		//on active l'authentification
		_root::getAuth()->enable();

		$this->oLayout=new _layout('auth');
	}

	public function _login(){
		
		$sMessage=$this->checkLoginPass();
		
		$oView=new _view('auth::login');
		$oView->sError=$sMessage;

		$this->oLayout->add('main',$oView);

	}
	private function checkLoginPass(){
		//si le formulaire n'est pas envoye on s'arrete la
		if(!_root::getRequest()->isPost() ){
			return null;
		}
		
		$sLogin=_root::getParam('login');
		$sPassword=_root::getParam('password');
		
		if(strlen($sPassword > $this->maxPasswordLength)){
			return 'Mot de passe trop long';
		}
		
		//on stoque les mots de passe hashe dans la classe model_users
		$sHashPassword=model_users::getInstance()->hashPassword($sPassword);
		$tAccount=model_users::getInstance()->getListAccount();
		
		//on va verifier que l'on trouve dans le tableau retourne par notre model
		//l'entree $tAccount[ login ][ mot de passe hashe ]
		if(!_root::getAuth()->checkLoginPass($tAccount,$sLogin,$sHashPassword)){
			return 'Mauvais login/mot de passe';
		}
		
		_root::redirect('private::index');
	}

	public function _logout(){
		_root::getAuth()->logout();
	}

	public function after(){
		$this->oLayout->show();
	}
}
