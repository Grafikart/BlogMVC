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
class plugin_xsrf{
	
	private $sSalt;
	private $iLifetime;
	private $sMsg;
	private $bUseSession;
	
	private $sSessionVar;
	
	/** 
	* constructeur
	* @access public
	* @param string $sToken
	*/
	public function __construct(){
		$this->sSalt='fdsfA34T679hjfdsAfef';
		$this->iLifetime= _root::getConfigVar('security.xsrf.timeout.lifetime');
		$this->bUseSession=_root::getConfigVar('security.xsrf.session.enabled',0);
		
		$this->sSessionVar='xsrfTokenArray';
	}
	
	/**
	* active l'utilisation de la session pour les token xrf (plus securise: permet une utilisation unique du jeton)
	* @access public
	*/
	public function enableSession(){
		$this->bUseSession=1;
	}
	/**
	* desactive l'utilisation de la session pour les token xrf (moins securise)
	* @access public
	*/
	public function disableSession(){
		$this->bUseSession=0;
	}
	
	private function genToken($iTime){
		return sha1($this->sSalt.$iTime);
	}
	
	
	/**
	* recupere le message d'erreur
	* @access public
	* @return string retourne le token
	*/
	public function getMessage(){
		return $this->sMsg;
	}
	/**
	* recupere le token (a inclure dans le formulaire en hidden)
	* @access public
	* @return string retourne le token
	*/
	public function getToken(){
		$iTime=time();
		$sToken=$iTime.'####'.$this->genToken( $iTime );
		
		if($this->bUseSession){
			$this->saveToken($iTime.'####'.$this->genToken( $iTime ));
		}
	
		return $sToken;
	}
	
	private function saveToken($InputToken){
		if(!isset($_SESSION[$this->sSessionVar])){
			$_SESSION[$this->sSessionVar]=array();
		}
		
		$_SESSION[$this->sSessionVar]=$InputToken;
	}
	
	private function isTokenSaved($sToken){
		if($_SESSION[$this->sSessionVar]==$sToken){
			return true;
		}
	}
	
	private function unsaveToken(){
		$_SESSION[$this->sSessionVar]=null;
	}
	
	/**
	* verifie si le token est valide
	* @access public
	* @param string $sInputToken
	* @return bool retourne true/false selon
	*/
	public function checkToken($sInputToken){
		$tToken=preg_split('/####/',$sInputToken);
		$iTime=$tToken[0];
		$sToken=$tToken[1];
		if( (time()-$iTime) >= $this->iLifetime ){ //verifie si la token est valide
			$this->sMsg='msg_tokenInvalidTimeout';
			return false;
		}
		if($sToken!=$this->genToken($iTime)){ //verifie si ce n'est pas un faux token
			$this->sMsg='msg_tokenInvalidCorrupt';
			return false;
		}
		if($this->bUseSession){
			if(!$this->isTokenSaved($sInputToken)){
				$this->sMsg='msg_tokenUnknown';
				return false;
			}else{
				$this->unsaveToken($sInputToken);
			}
		}
		return true;
	}
	
	
}

