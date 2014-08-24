<?php
class model_posts extends abstract_model{
	
	protected $sClassRow='row_posts';
	
	protected $sTable='posts';
	protected $sConfig='BlogMVC';
	
	protected $tId=array('id');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE id=?',$uId );
	}
	public function findBySlug($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE slug=?',$uId );
	}
	
	
	public function findAll(){
		return $this->findMany('SELECT * FROM '.$this->sTable.' ORDER BY id DESC');
	}
	public function findAllLimitBy($iStart,$iLimit){
		return $this->findMany('SELECT * FROM '.$this->sTable.' ORDER BY id DESC LIMIT '.(int)$iStart.', '.(int)$iLimit);
	}
	public function findLast(){
		return $this->findMany('SELECT * FROM '.$this->sTable.' ORDER BY id DESC LIMIT 3');
	}
	public function findByCategoryLimitBy($category_id,$iStart,$iLimit){
		return $this->findMany('SELECT * FROM '.$this->sTable.' WHERE category_id=? ORDER BY id DESC LIMIT '.(int)$iStart.', '.(int)$iLimit,$category_id);
	}
	public function findByCategory($category_id){
		return $this->findMany('SELECT * FROM '.$this->sTable.' WHERE category_id=? ORDER BY id DESC ',$category_id);
	}
	
	
	
}

class row_posts extends abstract_row{
	
	protected $sClassModel='model_posts';
	
	/*exemple jointure 
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	/*exemple test validation*/
	private function getCheck(){
		$oPluginValid=new plugin_valid($this->getTab());
		$oPluginValid->isNotEmpty('name','Le champ name ne doit pas &ecirc;tre vide');
		$oPluginValid->isNotEmpty('slug','Le champ slug ne doit pas &ecirc;tre vide');
		$oPluginValid->isNotEmpty('content','Le champ content ne doit pas &ecirc;tre vide');
		
		/* renseigner vos check ici
		$oPluginValid->isEqual('champ','valeurB','Le champ n\est pas &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isNotEqual('champ','valeurB','Le champ est &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isUpperThan('champ','valeurB','Le champ n\est pas sup&eacute; &agrave; '.$valeurB);
		$oPluginValid->isUpperOrEqualThan('champ','valeurB','Le champ n\est pas sup&eacute; ou &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isLowerThan('champ','valeurB','Le champ n\est pas inf&eacute;rieur &agrave; '.$valeurB);
		$oPluginValid->isLowerOrEqualThan('champ','valeurB','Le champ n\est pas inf&eacute;rieur ou &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isEmpty('champ','Le champ n\'est pas vide');
		$oPluginValid->isNotEmpty('champ','Le champ ne doit pas &ecirc;tre vide');
		$oPluginValid->isEmailValid('champ','L\email est invalide');
		$oPluginValid->matchExpression('champ','/[0-9]/','Le champ n\'est pas au bon format');
		$oPluginValid->notMatchExpression('champ','/[a-zA-Z]/','Le champ ne doit pas &ecirc;tre a ce format');
		*/

		return $oPluginValid;
	}

	public function isValid(){
		return $this->getCheck()->isValid();
	}
	public function getListError(){
		return $this->getCheck()->getListError();
	}
	public function save(){
		if(!$this->isValid()){
			return false;
		}
		parent::save();
		return true;
	}

}
