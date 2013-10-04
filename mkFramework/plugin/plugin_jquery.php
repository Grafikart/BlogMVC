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
* plugin_jquery classe pour generer du code jquery
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_jquery{

	private $sJs;
	private $sName;
	private $tParam;
	
	/** 
	* constructeur
	* @access public
	* @param string $sName nom de la fonction a creer
	* @param array tableau de parametre attendu exple: array('id')
	*/
	public function __construct($sName,$tParam=null){
		$this->sName=$sName;
		if($tParam==null){
			$tParam=array();
		}
		$this->tParam=$tParam;
	
	}
	
	private function parseUrl($sUrl){
		$sUrl=preg_replace('/&amp;/','&',$sUrl); 
		
		foreach($this->tParam as $sParam){
			$sUrl=preg_replace( '/\$'.$sParam.'/',"'+$sParam+'",$sUrl);
		}
		
		return $sUrl;
	}
	
	/** 
	* ajouter un appel ajax innerHtml
	* @access public
	* @param string $sUrl adresse a appeler
	* @param string $sCible de l'element a modifier
	*/
	public function addLinkUpdateElement($sUrl,$sCible){
		
		$sUrl=$this->parseUrl($sUrl);
		
		$this->sJs.='
			$.ajax({
		 	url: \''.$sUrl.'\',
		 	success: function(response) {
		     	// update status element
		     	$(\'#'.$sCible.'\').html(response);
		 	}
	     		});
     		';
		
	}
	/** 
	* ajouter un appel ajax envoyant sa reponse au une fonction javascript
	* @access public
	* @param string $sUrl adresse a appeler
	* @param string $sFunction function a appeler
	*/
	public function addLinkCallFunction($sUrl,$sFunction){
		$sUrl=$this->parseUrl($sUrl);
		
		$this->sJs.='
			$.ajax({
		 	url: \''.$sUrl.'\',
		 	success: function(response) {
		     	// call function
		     	'.$sFunction.'(response);
		 	}
	     		});
     		';
	}
	/** 
	* ajouter un appel ajax modifiant un element html
	* @access public
	* @param string $sCible id de l'element html a modifier
	* @param string $sAction action jquery a appeler
	* @param string $sParam parametres a utiliser dans l'appel
	*/
	public function addModifyElement($sCible,$sAction,$sParam=null){
		$this->sJs.=' $(\'#'.$sCible.'\').'.$sAction.'('.$sParam.');';
		 
	}
	/** 
	* ajouter du code javascript dans la fonction 
	* @access public
	* @param string $sTxt code javascript a ajouter dans la fonction
	 
	*/
	public function addJs($sTxt){
		$this->sJs.=$sTxt;
	}
	/** 
	* recupere le code javascript de la fonction encadre des balises scripts
	* @access public
	 
	 
	*/
	public function getJs(){
		$sParams=implode($this->tParam,',');
		return '<script language="Javascript">function '.$this->sName.'('.$sParams.'){'.$this->sJs.'}</script>';
	}
	



}
