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
* plugin_datetime classe pour gerer la date
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_datetime extends plugin_date{

	protected $iHour;
	protected $iMinute;
	protected $iSecond;

	/** 
	* constructeur
	* @access public
	* @param string $sDate on leur passe une chaine contenant la date par exemple '2007-12-25'
	* @param string $sFormat on definit leur format utilise, par exemple'Y-m-d'
	*/
	public function __construct($sDate=null,$sFormat='Y-m-d h:i:s'){
		if($sDate!=null){
			if(!$this->loadFromFormat($sDate,$sFormat)){
				return false;
			}
		}else{
			$this->reset();
		}
	}
	/**
	* @access public
	
	* @param string $sDate on leur passe une chaine contenant la date par exemple '2007-12-25'
	* @param string $sFormat on definit leur format utilise, par exemple'Y-m-d'
	*/
	public function loadFromFormat($sDate,$sFormat){
		list($sYear,$sMonth,$sDay,$sHour,$sMinute,$sSecond)=$this->convertFromFormatToTab($sDate,$sFormat);
		$this->setYear((int)$sYear);
		$this->setMonth((int)$sMonth);
		$this->setDay((int)$sDay);
		$this->setHour((int)$sHour);
		$this->setMinute((int)$sMinute);
		$this->setSecond((int)$sSecond);
		
		if(!$this->isValid() ){ 
			$this->reset();
			return false; 
		}
		
		return true;
	}
	/**
	* @access public
	*/
	public function reset(){
		$this->iAnnee=null;
		$this->iMois=null;
		$this->iJour=null;
		$this->iJoursemaine=null;
		
		$this->iHeure=null;
		$this->iMinute=null;
		$this->iSeconde=null;
	}

	/**
	* @access public	
	* @return string retourne l'heure
	*/
	public function getHour(){
		return sprintf('%02d',$this->iHour);
	}
	/**
	* @access public	
	* @return string retourne les minutes
	*/
	public function getMinute(){
		return sprintf('%02d',$this->iMinute);
	}
	/**
	* @access public	
	* @return string retourne les secondes
	*/
	public function getSecond(){
		return sprintf('%02d',$this->iSecond);
	}
	
	/**
	* @access public	
	* @param integer $iHour
	*/
	public function setHour($iHour){
		$this->iHour=(int)$iHour;
	}
	/**
	* @access public	
	* @param integer $iMinute
	*/
	public function setMinute($iMinute){
		$this->iMinute=(int)$iMinute;
	}
	/**
	* @access public	
	* @param integer $iSecond
	*/
	public function setSecond($iSecond){
		$this->iSecond=(int)$iSecond;
	}

	/**
	* @access public
	* @return string la date au format $sFormat cf format connu de la fonction php date()
	* @param string format voulu en retour (appel la fonction date() )
	*/
	public function toString($sFormat='Y-m-d H:i:s'){
		return date($sFormat,$this->getMkTime());
	}

	/**
	* @access public
	* @return string  retourne le mktime de la date
	*/
	public function getMkTime(){
		return mktime($this->iHour,$this->iMinute,$this->iSecond,$this->iMonth,$this->iDay,$this->iYear);
	}

	private function convertFromFormatToTab($sDate,$sFormat){
		
		$iHeure=0;
		$iMinute=0;
		$iSeconde=0;

		if($sFormat=='Y-m-d'){
			list($iAnnee,$iMois,$iJour)=explode('-',$sDate);
		}elseif($sFormat=='d-m-Y'){
			list($iJour,$iMois,$iAnnee)=explode('-',$sDate);
		}elseif($sFormat=='d/m/Y'){
			list($iJour,$iMois,$iAnnee)=explode('/',$sDate);
		}elseif($sFormat=='Y/m/d'){
			list($iAnnee,$iMois,$iJour)=explode('/',$sDate);
		}elseif($sFormat=='m-d-Y'){
			list($iMois,$iJour,$iAnnee)=explode('-',$sDate);
		}elseif($sFormat=='y-m-d'){
			list($iAnnee,$iMois,$iJour)=explode('-',$sDate);
			$iAnnee=2000+intval($iAnnee);
		}elseif($sFormat=='Y-m-d h:i:s'){
			$tDatetime=preg_split('/\s/',$sDate);
			list($iAnnee,$iMois,$iJour)=explode('-',$tDatetime[0]);
			list($iHeure,$iMinute,$iSeconde)=explode(':',$tDatetime[1]);
		}		
		

		return array(
				sprintf('%04d',$iAnnee),
				sprintf('%02d',$iMois),
				sprintf('%02d',$iJour),
				sprintf('%02d',$iHeure),
				sprintf('%02d',$iMinute),
				sprintf('%02d',$iSeconde),	
		);
		
	}
}
