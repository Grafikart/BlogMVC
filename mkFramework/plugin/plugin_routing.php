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
* plugin_rss classe gerant l'url rewriting
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_routing{
	
	private $tRoute;
	
	/** 
	* constructeur
	* @access public
	*/
	public function __construct(){
		include(_root::getConfigVar('urlrewriting.conf'));
		$this->tRoute=$tab;
	}
	
	/** 
	* retourne l'url rewrite 
	* @access public
	* @param string $sNav variable de navigation exple article::list
	* @param array $tParam tableau de parametre
	* @param bool $bAmp retourne l'url avec ou sans les &amp;
	*/
	public function getLink($sNav,$tParam=null,$bAmp=null){
		foreach($this->tRoute as $sUrl=>$tUrl){
			if($tUrl['nav']==$sNav and !isset($tUrl['tParam']) and $tParam==null){				
					return $this->convertUrl($sUrl,$tParam);//si pas de parametres des deux cotes, c est la bonne regle
			}elseif($tUrl['nav']==$sNav and is_array($tUrl['tParam']) and is_array($tParam) ){
				
				foreach($tUrl['tParam'] as $val){
					if(!isset($tParam[$val])){	
						continue 2;
					}
				}
					
				return $this->convertUrl($sUrl,$tParam);
				//si la regle demande des parametres, tous presents dans les parametres passes on choisi celle-ci
			}
		}
		return _root::getLinkString($sNav,$tParam,$bAmp);
	}
	/** 
	* parse l'url rewrite pour en extraire les parametres (nav, parametres...) 
	* @access public
	* @param string $sUrl url
	*/
	public function parseUrl($sUrl){
		$sRootScript=$_SERVER['SCRIPT_NAME'];
		$sRootScript=str_replace(_root::getConfigVar('navigation.scriptname'),'',$sRootScript);
		$sUrl=str_replace($sRootScript,'',$sUrl);
		
		/*LOG*/_root::getLog()->info('plugin_routing parseUrl('.$sUrl.')');
		if(is_array($this->tRoute)){
			foreach($this->tRoute as $sPattern => $tUrl){
				$sPattern=preg_replace('/:([^:])*:/','([^/]*)',$sPattern);
				$sPattern=preg_replace('/\//','\/',$sPattern);
				
				if(preg_match_all('/^'.$sPattern.'$/',$sUrl,$tTrouve)){
					_root::getRequest()->loadModuleAndAction($tUrl['nav']);
					if(isset($tUrl['tParam']) and is_array($tTrouve[1])){
						$j=0;
						foreach($tTrouve as $i => $found){
							if($i==0){
								continue;
							}
							$j=$i-1;
							_root::setParam($tUrl['tParam'][$j],$found[0]);
						}
					}
					return;
				}
			}
			/*LOG*/_root::getLog()->info('plugin_routing regle non trouve, 
				utilisation de 404 loadModuleAndAction('.$this->tRoute['404']['nav'].')');
			_root::getRequest()->loadModuleAndAction($this->tRoute['404']['nav']);
		}
	}
	
	private function convertUrl($sUrl,$tParam=null){
		if(is_array($tParam)){
			foreach($tParam as $sVar => $sVal){
				$sUrl=preg_replace('/:'.$sVar.':/',$sVal,$sUrl);
			}
		}
		return $sUrl;
	}



}
