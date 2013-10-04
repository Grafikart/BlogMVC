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
* plugin_rss classe gerant le flux rss
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_rss{
	
	protected $news;
	protected $header;
	protected $id=0;
	protected $sAdresseRss;
	protected $sUrl;
	protected $sName='news';
	
	/** 
	* constructeur
	* @access public
	* @param string $sName nom du fichier rss
	*/
	public function __construct($sName=null){
		if($sName!=null){
			$this->setName($sName);
		}
	}
	
	/** 
	* indique le nom du fichier rss
	* @access public
	* @param string $sName nom du fichier rss
	*/
	public function setName($sName){
		$this->sName=$sName;
	}
	/** 
	* indique le titre du fichier rss (affiche dans le flux)
	* @access public
	* @param string $sTitre titre du flux rss
	*/
	public function setTitre($sTitre){
		$this->header.='<title>'.htmlentities($sTitre).'</title>';
	}
	/** 
	* indique l'url du site
	* @access public
	* @param string $sUrl url du site
	*/
	public function setUrl($sUrl){
		$this->sUrl=$sUrl;
		$this->header.='<link>'.htmlentities($sUrl).'</link>';
	}
	/** 
	* indique la description flux rss
	* @access public
	* @param string $sDesc description du flux rss
	*/
	public function setDesc($sDesc){
		$this->header.='<description><![CDATA['.$sDesc.']]></description>';
	}
	/** 
	* indique la langue flux rss
	* @access public
	* @param string $sLang langue du flux rss
	*/
	public function setLang($sLang ){
		$this->header.='<language><![CDATA['.$sLang .']]></language>';
	}
	/** 
	* indique la l'adresse flux rss
	* @access public
	* @param string $sAdresseRss adresse du flux rss
	*/
	public function setAdresseRss($sAdresseRss){
		$this->sAdresseRss=$sAdresseRss;
	}
	/** 
	* ajoute une news au flux rss
	* @access public
	* @param array $tab tableau comprenant les cles date,auteur,titre,description,link et id
	*/
	public function addNews($tab){
		
		$this->news.='<item>';
			$this->news.='<title><![CDATA['.$tab['titre'].']]></title>';
			if(isset($tab['date'])){
				$this->news.='<pubDate>'.date("r", strtotime($tab['date'])).'</pubDate>';
			}
			if(isset($tab['auteur'])){
				$this->news.='<author><![CDATA['.$tab['auteur'].']]></author>';
			}
			$this->news.='<description><![CDATA['.$tab['desc'].']]></description>';
			$this->news.='<guid>'.$this->sUrl.'#'.$tab['id'].'</guid>';
			if(isset($tab['link'])){
					$this->news.='<link>'.$tab['link'].'</link>';
			}
			
		$this->news.='</item>';
		
		
	}
	/** 
	* retoune le flux rss
	* @access public
	* @return string le flux rss genere
	*/
	public function getContent(){
	
		$head='<?xml version="1.0" encoding="ISO-8859-1" ?>'."\n";
		$head.='<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
		$foot='</rss>';
		$atom='<atom:link href="'.$this->sAdresseRss.'" rel="self" type="application/rss+xml" />';
		$sRss=$head.'<channel>'.$atom.$this->header.$this->news.'</channel>'.$foot;
		
		$oFile=new _file(_root::getConfigVar('path.data').'xml/'.$this->sName.'.rss');
		$oFile->setContent($sRss);
		$oFile->save();
		
		return $sRss;
	}
	
}
