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
* plugin_log classe pour loguer
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_log{
	
	private $bInfo;
	private $bWarning;
	private $bError;
	private $bAppli;

	/**
	* constructeur
	* @access public
	*/
	public function __construct(){
		$this->setApplication(true);
		$this->setInformation(true);
		$this->setWarning(true);
		$this->setError(true);
		
	}
	/**
	* active/desactive le log applicatif
	* @access public
	* @param bool $bActive true/false selon
	*/
	public function setApplication($bActif){
		$this->bAppli=$bActif;
	}
	/**
	* active/desactive le log informatif (framework)
	* @access public
	* @param bool $bActive true/false selon
	*/
	public function setInformation($bActif){
		$this->bInfo=$bActif;
	}
	/**
	* active/desactive le log warning
	* @access public
	* @param bool $bActive true/false selon
	*/
	public function setWarning($bActif){
		$this->bWarning=$bActif;
	}
	/**
	* active/desactive le log erreur
	* @access public
	* @param bool $bActive true/false selon
	*/
	public function setError($bActif){
		$this->bError=$bActif;
	}
	
	/**
	* vous permet dans votre application de loguer
	* @access public
	* @param string $sMessage message a loguer
	*/
	public function log($sMessage){
		if(!$this->bAppli){ return null;}
		$this->writefile('log;'.$sMessage);
		return true;
	}
	/**
	* vous permet dans votre application de loguer en tant qu'erreur
	* @access public
	* @param string $sMessage message a loguer
	*/
	public function error($sMessage){
		if(!$this->bError){ return null;}
		$this->writefile('ERROR;'.$sMessage);
		return true;
	}
	/**
	* vous permet dans votre application de loguer en tant que warning
	* @access public
	* @param string $sMessage message a loguer
	*/
	public function warning($sMessage){
		if(!$this->bWarning){ return null;}
		$this->writefile('Warning;'.$sMessage);
		return true;
	}
	/**
	* utiliser principalement par le framework pour indiquer tout ce qui se passe (a desactiver en production)
	* @access public
	* @param string $sMessage message a loguer
	*/
	public function info($sMessage){
		if(!$this->bInfo){ return null;}
		$this->writefile('info;'.$sMessage);
		return true;
	}

	private function writefile($sMessage){
		
		$oFileLog=new _file(_root::getConfigVar('path.log','data/log/').date('Y-m-d').'_log.csv');
		if($oFileLog->exist()){ $oFileLog->load();}
		
		$oFileLog->addContent(date('Y-m-d').';'.date('h:i:s').';'.$sMessage."\n");
		
		try{
		  $oFileLog->save();
		}catch(Exception $e){
		  throw new Exception (
		  		'Probleme lors de l\'ecriture du log'."\n"
		  		.'note:verifier les droits du repertoire '._root::getConfigVar('path.log','data/log')."\n"
		  		.'Exception: '.$e->getMessage());
		}
		
		$oFileLog->clean();
	}

}
