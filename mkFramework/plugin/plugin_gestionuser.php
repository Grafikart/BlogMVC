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
* plugin_gestionuser classe de gestion user
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_gestionuser{
	
	protected $tabAllowDeny=array();
	
	public function __construct(){
		if(isset($_SESSION['gestionuser_tabAllowDeny'])){
			$this->tabAllowDeny=$_SESSION['gestionuser_tabAllowDeny'];
		}
	}
	
	private function register(){
		$_SESSION['gestionuser_tabAllowDeny']=$this->tabAllowDeny;
	}
	
	/** purge les permissions en session (appeler avant de reassigner de nouvelles permissions pour eviter la concatenation)
	* @access public
	* @return void
	*/
	public function purge(){
		$_SESSION['gestionuser_tabAllowDeny']=array();
		$this->tabAllowDeny=array();
	}
	
	/**
	* @access public
	* @return void
	 * @param string $action action qu'on autorise sur $ressource
	* @param string $ressource ressource l'action est autorise sur $ressource	
	*/
	public function allow($action,$ressource){
		if(isset($this->tabAllowDeny[$ressource][$action])){ 
			return false;
		}
		$this->tabAllowDeny[$ressource][$action]=1;
		$this->register();
	}
	/**
	* @access public
	* @return void
	 * @param string $action action qu'on n'autorise pas sur $ressource
	* @param string $ressource ressource l'action est n'autorise pas sur $ressource	
	*/
	public function deny($action,$ressource){
		if(isset($this->tabAllowDeny[$ressource][$action])){ 
			return false;
		}
		$this->tabAllowDeny[$ressource][$action]=0;
		$this->register();
	}
	/**
	* @access public
	* @return bool retourne true/false selon qu'on est autorise ou non a faire $action sur $ressource
	 * @param string $action action qu'on autorise sur $ressource
	* @param string $ressource ressource l'action est autorise sur $ressource	
	*/
	public function can($action,$ressource){
		if(!isset($this->tabAllowDeny[$ressource]) ){
			return false;
		}
		if(!isset($this->tabAllowDeny[$ressource][$action]) ){
			return false;
		}
		if($this->tabAllowDeny[$ressource][$action]==1){
			return true;
		}
		return false;
	}


}
