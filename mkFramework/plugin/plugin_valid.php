<?php
/*
This file is part of Mkframework.

Mkframework is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License.

Mkframework is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with Mkframework.  If not, see <http://www.gnu.org/licenses/>.

*/
/** 
* plugin_check classe pour verifier un lot de valeurs (verification de formulaire par exemple)
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_valid{

	private $bCheck;
	private $tPost;
	private $tCheck;
	
	private $oCheck;

	/**
	* constructeur
	* @access public
	* @param array tableau a verifier ($_POST,tableau de la row...)
	*/
	public function __construct($tPost){
		$this->tPost=$tPost;
		$sClass=_root::getConfigVar('check.class','plugin_check');
		$this->oCheck=new $sClass;
		$this->bCheck=true;
	}
	
	/**
	* verifie si le champ existe dans le tableau en memoire
	* @access public
	* @param string $sName nom du champ
	* @return bool retourne true/false selon
	*/
	public function exist($sName){
		if(isset($this->tPost[$sName])){
			return true;
		}
		$this->ko('exist',$sName);
		return false;
	}
	/**
	* retourne la valeur $sName du tableau en memoire
	* @access public
	* @param string $sName nom du champ
	* @return undefined retourne la valeur du champ
	*/
	public function getValue($sName){
		if(!isset($this->tPost[$sName])){
			return null;
		}
		return $this->tPost[$sName];
	}
	
	/**
	* appel magique d'une methode de l'objet utilise pour le check
	* @access public
	*/
	public function __call($sMethod,$tParam=null){
		$sField='';
		if($tParam==null){
			$bCheck=call_user_func(array($this->oCheck,$sMethod));
		}else{
			$sField=$tParam[0];
			$tParam[0]=$this->getValue($tParam[0]);
			$bCheck=call_user_func_array(array($this->oCheck,$sMethod),$tParam);
		}
		if($bCheck){
			return $this->ok(); 
		}
		$sKoMessage=$this->oCheck->getLastErrorMsg();
		
		return $this->ko($sKoMessage,$sField);
	}
	
	
	/**
	* verifie si tout est ok
	* @access public
	* @return bool retourne true/false selon
	*/
	public function isValid(){
		return $this->bCheck;
	}
	/**
	* retourne le tableau d'erreur
	* @access public
	* @return array tableau d'erreur
	*/
	public function getListError(){
		return $this->tCheck;
	}
	
	private function ko($sCheck,$sField=null){
		$this->bCheck=false;
		$this->tCheck[ $sField ][]= $sCheck;
		return false;
	}
	private function ok(){
		return true;
	}
	
	
	

}
