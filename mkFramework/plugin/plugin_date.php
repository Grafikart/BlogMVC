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
* plugin_date classe pour gerer la date
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_date{

	protected $iYear;
	protected $iMonth;
	protected $iDay;
	
	/** 
	* constructeur
	* @access public
	* @param string $sDate on leur passe une chaine contenant la date par exemple '2007-12-25'
	* @param string $sFormat on definit leur format utilise, par exemple'Y-m-d'
	*/
	public function __construct($sDate=null,$sFormat='Y-m-d'){
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
		list($sYear,$sMonth,$sDay)=$this->convertFromFormatToTab($sDate,$sFormat);
		$this->setYear((int)$sYear);
		$this->setMonth((int)$sMonth);
		$this->setDay((int)$sDay);
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
		$this->iYear=null;
		$this->iMonth=null;
		$this->iDay=null;

		$this->iHour=null;
		$this->iMinute=null;
		$this->iSecond=null;
	}
	/**
	* @access public
	* @param integer $iYear
	*/
	public function setYear($iYear){
		$this->iYear=intval($iYear);
	}
	/**
	* @access public
	* @param integer $iMonth
	*/
	public function setMonth($iMonth){
		$this->iMonth=intval($iMonth);
	}
	/**
	* @access public
	* @param integer $iDay
	*/
	public function setDay($iDay){
		$this->iDay=intval($iDay);
	}
	
	/**
	* @access public
	* @return string  Retourne l'annee selon le format $sFormat
	* @param string $sFormat definit le format a utiliser pour le retour (YYYY par defaut ou YY)
	*/
	public function getYear($sFormat='YYYY'){
		if($this->iYear==null){ return null;}
		if($sFormat=='YY'){
			return substr($this->iYear,-2);
		}else if($sFormat=='YYYY'){
			return $this->iYear;
		}else{
			throw new Exception('Wrong format for plugin_date::getYear()');
		}
	}
	/**
	* @access public
	* @return string  Retourne le mois selon le format $sFormat
	* @param string $sFormat definit le format a utiliser pour le retour (MM par defaut, ou M)
	*/
	public function getMonth($sFormat='MM'){
		if($this->iMonth==null){ return null;}
		if($sFormat=='M'){
			return $this->iMonth;
		}else if($sFormat=='MM'){
			return sprintf('%02d',$this->iMonth);
		}else{
			throw new Exception('Wrong format for plugin_date::getMonth()');
		}
	}
	/**
	* @access public
	* @return string  Retourne le mois au format texte
	*/
	public function getStringMonth($sFormat='MM'){
		if($this->iMonth==null){ return null;}
		_root::loadLangueDate();
		$tLangueDate=_root::getConfigVar('tLangueDate');

		if($sFormat=='MM'){
			return $tLangueDate['tMoisLong'][(int)$this->getMonth('M')];
		}else if($sFormat=='M'){
			return $tLangueDate['tMoisCourt'][(int)$this->getMonth('M')];
		}else{
			throw new Exception('Wrong format for plugin_date::getStringMonth()');
		}
	}
	/**
	* @access public
	* @return string  Retourne le jour au format texte
	*/
	public function getStringDay($sFormat='DD'){
		if($this->iMonth==null){ return null;}
		_root::loadLangueDate();
		$tLangueDate=_root::getConfigVar('tLangueDate');

		if($sFormat=='DD'){
			return $tLangueDate['tJourLong'][(int)$this->getWeekDay('D')];
		}else if($sFormat=='D'){
			return $tLangueDate['tJourCourt'][(int)$this->getWeekDay('D')];
		}else{
			throw new Exception('Wrong format for plugin_date::getStringDay()');
		}
	}

	/**
	* @access public
	* @return string  Retourne le jour selon le format $sFormat
	* @param string $sFormat definit le format a utiliser pour le retour (DD par defaut, ou D)
	*/
	public function getDay($sFormat='DD'){
		if($this->iDay==null){ return null;}
		if($sFormat=='D'){
			return $this->iDay;
		}else if($sFormat=='DD'){
			return sprintf('%02d',$this->iDay);
		}else{
			throw new Exception('Wrong format for plugin_date::getDay()');
		}
	}
	/**
	* @access public
	* @return string  Retourne le jour de la semaine 
	*/
	public function getWeekDay(){
		return date('w',$this->getMkTime() ) ;
	}
	/**
	* @access public
	* @return string  Retourne le numero de la semaine
	*/
	public function getNumberWeek(){
		return date('W',$this->getMkTime() );
	}

	

	/** 
	* calcul date j+
	* @access public
	* @param int $iNb calcul date + $iNb jour
	*/
	public function addDay($iNb){
		$newDate=mktime(0,0,0,$this->iMonth,$this->iDay+$iNb,$this->iYear);
		
		$this->loadFromFormat(date('Y-m-d',$newDate), 'Y-m-d' );
	}
	/** 
	* calcul date m+
	* @access public
	* @param int $iNb calcul date + $iNb mois
	*/
	public function addMonth($iNb){
		$newDate=mktime(0,0,0,$this->iMonth+$iNb,$this->iDay,$this->iYear);
		
		$this->loadFromFormat(date('Y-m-d',$newDate), 'Y-m-d' );
	}
	/** 
	* calcul date a+
	* @access public
	* @param int $iNb calcul date + $iNb a
	*/
	public function addYear($iNb){
		$newDate=mktime(0,0,0,$this->iMonth,$this->iDay,$this->iYear+$iNb);
		
		$this->loadFromFormat(date('Y-m-d',$newDate), 'Y-m-d' );
	}
	
	/** 
	* calcul date j-
	* @access public	
	* @param int $iNb calcul date - $iNb jour
	*/
	public function removeDay($iNb){
		$newDate=mktime(0,0,0,$this->iMonth,$this->iDay-$iNb,$this->iYear);
		
		$this->loadFromFormat(date('Y-m-d',$newDate), 'Y-m-d' );
	}
	/** 
	* calcul date m-
	* @access public	
	* @param int $iNb calcul date - $iNb mois
	*/
	public function removeMonth($iNb){
		$newDate=mktime(0,0,0,$this->iMonth-$iNb,$this->iDay,$this->iYear);
		
		$this->loadFromFormat(date('Y-m-d',$newDate), 'Y-m-d' );
	}
	/** 
	* calcul date a-
	* @access public
	* @param int $iNb calcul date - $iNb a
	*/
	public function removeYear($iNb){
		$newDate=mktime(0,0,0,$this->iMonth,$this->iDay,$this->iYear-$iNb);
		
		$this->loadFromFormat(date('Y-m-d',$newDate), 'Y-m-d' );
	}

	/**
	* @access public
	* @return string  retourne le mktime de la date
	*/
	public function getMkTime(){
		return mktime(0,0,0,$this->iMonth,$this->iDay,$this->iYear);
	}
	
	/**
	* @access public
	* @return bool  retourne true/false selon que la journee soit ferie
	*  (noel,jour de l'an,jeudi de l'ascension, dimanche de paque,samedi,dimanche,lundi de paques, 1er mai, 8 mai)
	*/
	public function isBank(){
		
		$iAnnee=$this->iYear;
		$iMois=$this->iMonth;
		$iJour=$this->iDay;
		
		$iJourNewDate=$this->getWeekDay();
		
		//calcul dimanche de paque et jeudi ascension seulement si mois d'avril ou mai
		if(intVal($iMois)==3 or intVal($iMois)==4 or intVal($iMois)==5){
			//calcul Paques
			$sDimanchePaques=date('d-m-Y',easter_date($iAnnee));
			$tDimanchePaquesTab=explode('-',$sDimanchePaques);
		
			$iJourDimanchePaques=$tDimanchePaquesTab[0];
			$iMoisDimanchePaques=$tDimanchePaquesTab[1];
		
			$sLundiPaques=date('d-m-Y',mktime(0,0,0,$iMoisDimanchePaques,$iJourDimanchePaques+1,$iAnnee));
			$tLundiPaquesTab=explode('-',$sLundiPaques);
		
			$iJourLundiPaques=intVal($tLundiPaquesTab[0]);
			$iMoisLundiPaques=intVal($tLundiPaquesTab[1]);
		
			//calcul jeudi ascension = dimanche paques + 39 jour
			$sJeudiAscension=date('d-m-Y',mktime(0,0,0,$iMoisDimanchePaques,$iJourDimanchePaques+39,$iAnnee));
			$tJeudiAscensionTab=explode('-',$sJeudiAscension);
		
			$iJourJeudiAsc=intVal($tJeudiAscensionTab[0]);
			$iMoisJeudiAsc=intVal($tJeudiAscensionTab[1]);
		}
			
		if($iJourNewDate==6 or $iJourNewDate==0){
			//samedi ou dimanche
			return true;
		}
		else if($iMois==12 and $iJour==25){
			//noel
			return true;
		}
		else if($iMois==1 and $iJour==1){
			//jour de l'an
			return true;
		}
		else if($iMois==5 and ($iJour==1 or $iJour==8)){
			//1er et 8 mai
			return true;
		}
		else if($iMois==11 and ($iJour==1 or $iJour==11)){
			//1er et 11 novembre
			return true;
		}
		else if($iMois==7 and $iJour==14){
			//14 juillet
			return true;
		}
		else if($iMois==8 and $iJour==15){
			//15 aout
			return true;
		}
		else if($iMois==$iMoisLundiPaques and $iJour==$iJourLundiPaques){
			//Paques
			return true;
		}
		else if($iMois==$iMoisJeudiAsc and $iJour==$iJourJeudiAsc){
			//Ascension
			return true;
		}
		return false;
		
	}
	/**
	* @access public
	* @return bool  retourne true/false selon que la date est ou non valide
	*/
	public function isValid(){
	
		if($this->iYear==null or $this->iMonth==null or $this->iDay==null ){
			return false;
		}
		if( $this->iYear < 1900 ){
			return false;
		}
		if( $this->iMonth < 1 or $this->iMonth > 12 ){
			return false;
		}
		if( $this->iDay < 1 or $this->iDay > 31 ){
			return false;
		}
		
		return true;
	}

	/**
	* @access public
	* @return string la date au format $sFormat cf format connu de la fonction php date()
	* @param string format voulu en retour (appel la fonction date() )
	*/
	public function toString($sFormat='Y-m-d'){
		return date($sFormat,$this->getMkTime());
	}

	/**
	* @access public
	* @return bool  retourne true/false selon que la date soit aujourd'hui
	*/
	public function isToday(){
		if($this->getFormat('Y-m-d')==date('Y-m-d')){
			return true;
		}
		return false;
	}
	
	
	private function convertFromFormatToTab($sDate,$sFormat){
		
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
		}		

		return array(
				sprintf('%04d',$iAnnee),
				sprintf('%02d',$iMois),
				sprintf('%02d',$iJour),	
		);
		
	}
	
}
