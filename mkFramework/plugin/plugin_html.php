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
* plugin_html classe pour generer de l'html
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_html{
	
	
	/** 
	* retourne le code html d'une image
	* @access public
	* @param string $sSrc path de l'image, par defaut utilisera le path.img configure dans conf/site.php
	* @param string $sAlt texte alternatif
	* @param array $tOption tableau contenant autant d'options a ajouter 
	* 						array('style'=>'border:1px')  >> <img style="border:1px"...
	* @return string retourne le code html de l'image
	*/
	public function getImg($sSrc,$sAlt=null,$tOption=null){
		if($sAlt==null){ $sAlt=$sSrc; }
		$sOptions=$this->getOptionFromTab($tOption);
		return '<img src="'._root::getConfigVar('path.img').$sSrc.'" title="'.$sAlt.'" '.$sOptions.'/>';
	}
	/** 
	* retourne le code html d'une div
	* @access public
	* @param string $sContenu contenu de la div
	* @param array $tOption tableau contenant autant d'options a ajouter 
	* 						array('style'=>'border:1px')  >> <div style="border:1px"...
	* @return string retourne le code html de la div
	*/
	public function getDiv($sContenu,$tOption=null){
		return '<div'.$this->getOptionFromTab($tOption).'>'.$sContenu.'</div>';
	}
	/** 
	* retourne le code html d'un input
	* @access public
	* @param string $sName nom du champ input
	* @param string $sValue valeur du champ input
	* @param array $tOption tableau contenant autant d'options a ajouter 
	* 						array('style'=>'border:1px')  >> <input style="border:1px"...
	* @return string retourne le code html de l'input
	*/
	public function getInput($sName,$sValue=null,$tOption=null){
		if(!isset($tOption['class'])){ $tOption['class']='input'; }
		return '<input type="input" name="'.$sName.'" value="'.$sValue.'"'.$this->getOptionFromTab($tOption).'/>';
	}
	/** 
	* retourne le code html d'un input radio
	* @access public
	* @param string $sName nom du champ input
	* @param string $sValue valeur du champ input
	* @param bool $bChecked coche ou non
	* @param array $tOption tableau contenant autant d'options a ajouter 
	* 						array('style'=>'border:1px')  >> <input style="border:1px"...
	* @return string retourne le code html de l'input radio
	*/
	public function getInputRadio($sName,$sValue=null,$bChecked=false,$tOption=null){
		if(!isset($tOption['class'])){ $tOption['class']='input'; }
		$sChecked='';
		if($bChecked){ $sChecked='checked="checked"';}
		$sOptions=$this->getOptionFromTab($tOption);
		return '<input type="radio" name="'.$sName.'" value="'.$sValue.'" '.$sChecked.' '.$sOptions.'/>';
	}
	/** 
	* retourne le code html d'un input checkbox
	* @access public
	* @param string $sName nom du champ input
	* @param string $sValue valeur du champ input
	* @param bool $bChecked coche ou non
	* @param array $tOption tableau contenant autant d'options a ajouter 
	* 						array('style'=>'border:1px')  >> <input style="border:1px"...
	* @return string retourne le code html de l'input checkbox
	*/
	public function getInputCheckbox($sName,$sValue=null,$bChecked=false,$tOption=null){
		if(!isset($tOption['class'])){ $tOption['class']='input'; }
		$sChecked='';
		if($bChecked){ $sChecked='checked="checked"';}
		$sOptions=$this->getOptionFromTab($tOption);
		return '<input type="checkbox" name="'.$sName.'" value="'.$sValue.'" '.$sChecked.' '.$sOptions.'/>';
	}
	/** 
	* retourne le code html d'un select
	* @access public
	* @param string $sName nom du champ select
	* @param array $tSelect tableau key/valeur du select (options)
	* @param string $sValue valeur du champ select
	* @param array $tOption tableau contenant autant d'options a ajouter 
	* 					array('style'=>'border:1px')  >> <input style="border:1px"...
	* @return string retourne le code html de l'input
	*/
	public function getSelect($sName,$tSelect,$sValue=null,$tOption=null){
		if(!isset($tOption['class'])){ $tOption['class']='select'; }
		$sHtml='<select name="'.$sName.'"'.$this->getOptionFromTab($tOption).'>';
		if($tSelect){
			foreach($tSelect as $sKey => $sVal){
				$sHtml.='<option '; 
				if($sKey==$sValue){ 
					$sHtml.='selected="selected"';
				} 
				$sHtml.=' value="'.$sKey.'">'.$sVal.'</option>';
			}
		}
		$sHtml.='</select>';
		return $sHtml;
	}
	/** 
	* retourne le code html d'un select multiple
	* @access public
	* @param string $sName nom du champ select
	* @param array $tSelect tableau key/valeur du select (options)
	* @param string $tValue valeur du champ select (tableau)
	* @param array $tOption tableau contenant autant d'options a ajouter 
	* 					array('style'=>'border:1px')  >> <input style="border:1px"...
	* @return string retourne le code html de l'input
	*/
	public function getSelectMultiple($sName,$tSelect,$tValue=null,$tOption=null){
		if(!isset($tOption['class'])){ $tOption['class']='select'; }
		$sHtml='<select multiple="multiple" name="'.$sName.'[]"'.$this->getOptionFromTab($tOption).'>';
		if($tSelect){
			foreach($tSelect as $sKey => $sVal){
				$sHtml.='<option '; 
				if(is_array($tValue) and in_array($sKey,$tValue)){ 
					$sHtml.='selected="selected"';
				}
				$sHtml.=' value="'.$sKey.'">'.$sVal.'</option>';
			}
		}
		$sHtml.='</select>';
		return $sHtml;
	}
	/** 
	* retourne le code html d'un textarea
	* @access public
	* @param string $sName nom du champ textarea
	* @param string $sValue valeur du champ textarea
	* @param array $tOption tableau contenant autant d'options a ajouter 
	* 					array('style'=>'border:1px')  >> <textarea style="border:1px"...
	* @return string retourne le code html de l'input
	*/
	public function getTextarea($sName,$sValue=null,$tOption=null){
		if(!isset($tOption['class'])){ $tOption['class']='textarea'; }
		return '<textarea name="'.$sName.'"'.$this->getOptionFromTab($tOption).'>'.$sValue.'</textarea>';
	}
	/** 
	* retourne le code html d'un champ date (en 3 champs)
	* @access public
	* @param string $sName nom du champ date
	* @param string $sValue valeur du champ date au format y-m-d
	* @param array $tOption tableau contenant autant d'options a ajouter 
	* 					array('style'=>'border:1px')  >> <input style="border:1px"...
	* @return string retourne le code html de l'input date
	*/
	public function getInputDate($sName,$sValue=null,$tOption=null){
		$sValueAnnee=$sValueMois=$sValueJour='';
		if($sValue!=null and preg_match('/-/',$sValue)){
			list($sValueAnnee,$sValueMois,$sValueJour)=preg_split('/-/',$sValue);
			$sValueAnnee=sprintf('%04d',$sValueAnnee);
			$sValueMois=sprintf('%02d',$sValueMois);
			$sValueJour=sprintf('%02d',$sValueJour);
		}
		$sHtml='';
		$tOption2['class']='inputDateJour';
		$sHtml.= '<input type="input" name="'.$sName.'_jour" value="'.$sValueJour.'"'.$this->getOptionFromTab($tOption2).'/>';
		$sHtml.= ' / ';
		$tOption2['class']='inputDateMois';
		$sHtml.= '<input type="input" name="'.$sName.'_mois" value="'.$sValueMois.'"'.$this->getOptionFromTab($tOption2).'/>';
		$sHtml.= ' / ';
		$tOption2['class']='inputDateAnnee';
		$sHtml.= '<input type="input" name="'.$sName.'_annee" value="'.$sValueAnnee.'"'.$this->getOptionFromTab($tOption2).'/>';
		if(!isset($tOption['class'])){ $tOption['class']='inputDate'; }
		return $this->getDiv($sHtml,$tOption);
	}
	/** 
	* retourne la date au format YYYY-MM-DD a partir d'un champ inputDate (du meme plugin)
	* @access public
	* @param array $tPost tableau ou chercher ($_POST,$_GET)
	* @param string $sName nom du champ date
	* @return string retourne la date au format YYYY-MM-DD 
	*/
	public function getDateFromInput($tPost,$sName){
		if(!isset($tPost[$sName.'_annee']) or !isset($tPost[$sName.'_mois']) or !isset($tPost[$sName.'_jour']) 
		or $tPost[$sName.'_annee']=='' or $tPost[$sName.'_mois']=='' or $tPost[$sName.'_jour']==''
		){
			return null;
		}
		return (int)$tPost[$sName.'_annee'].'-'.(int)$tPost[$sName.'_mois'].'-'.(int)$tPost[$sName.'_jour'];
	}
	
	private function getOptionFromTab($tOption){
		if($tOption==null){ return null;}
		$sOption='';
		foreach($tOption as $sVar => $sVal){
			$sOption.=' '.$sVar.'='.'"'.preg_replace("/'/",'\'',$sVal).'"';
		}
		return $sOption;
	}
	
}
