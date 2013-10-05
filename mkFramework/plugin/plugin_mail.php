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
* plugin_auth classe pour gerer l'authentification
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_mail{

	private $sFrom;
	private $sFromLibelle;
	private $tTo;
	private $tCC;
	private $sBCC;
	private $sTitle;
	private $sBody;
	private $sBodyHtml;
	private $sAttached;
	
	private $sErrors;
	
	private $sWall;

	public function __construct(){
		$this->sWall='afdsfdsfsqhghregregftervgqrdgregregfdgdfd';
	}


	public function setFrom($sFromLibelle,$sFrom){
		$this->sFrom=$sFrom;
		$this->sFromLibelle=$sFromLibelle;
	}	
	public function addTo($sTo){
		$this->tTo[$sTo]=$sTo;
	}
	public function setBcc($sBCC){
		$this->sBCC=$sBCC;
	}
	
	public function setTitle($sTitle){
		$this->sTitle=$sTitle;
	}
	public function setSubject($sTitle){
		$this->sTitle=$sTitle;
	}
	public function setBody($sBody){
		$this->sBody=$sBody;
	}
	public function setBodyHtml($sBody){
		$this->sBodyHtml=$sBody;
	}
	
	public function attachFile($sFile){
		$this->sAttached=$sFile;
	}
	
	private function checkEmail($sEmail){
		return preg_match('/^([a-zA-Z0-9\-\_\.]*)@([a-zA-Z0-9\-\_\.]*)\.([a-zA-Z]*)$/',$sEmail);
	}
	private function isValid(){
		$ok=1;
		
		$tErrors=array();
		if($this->sFrom == ''){
			$ok=0;
			$tErrors[]="Pas d'email from";
		}elseif(!$this->checkEmail($this->sFrom)){
			$ok=0;
			$tErrors[]="Mauvais format pour l'email from (".$this->sFrom.")";
		}
		
		if( count($this->tTo) == 0){
			$ok=0;
			$tErrors[]="Pas d'email to";
		}else{
			foreach($this->tTo as $sTo){
				if(!$this->checkEmail($sTo)){
					$ok=0;
					$tErrors[]="Mauvais format pour l'email to (".$sTo.")";
				}
			}
		}
		
		if($this->sTitle == ''){
			$ok=0;
			$tErrors[]="Pas de sujet";
		}
		
		
		if(!$ok){
			$this->sErrors="Erreur plugin_mail lors de l envoi de l'email \n";
			$this->sErrors.=implode("\n",$tErrors);
		}
		
		return $ok;
	}
	
	public function send(){
		
		if(!$this->isValid()){
			throw new Exception($this->sErrors);
		}

		$n0="\n";
		$r0="\r";
		$n=$n0;
		$nn=$n0.$n0 ;
		$rn=$r0.$n0 ;
		$rnn=$r0.$n0.$n0 ;
		
		$sHeader = 'From: "'.$this->sFromLibelle.'" <'.$this->sFrom.'>'.$n;
		if($this->sBCC!=''){
			$sHeader .= 'Bcc: '.$this->sBCC."\r\n";
		}
		$sHeader .= 'Return-Path: <'.$this->sFrom.'>'.$n;
		$sHeader .= 'MIME-Version: 1.0'.$n;
		$sHeader .= 'Content-Type: multipart/mixed; boundary="'.$this->sWall.'"'.$rn; 
		
		$sMsg = '';
		
		if($this->sBody != ''){
		$sMsg .= '--'.$this->sWall.$n;
		$sMsg .= 'Content-Type: text/plain; charset="iso-8859-1"'.$nn;
		$sMsg .= $this->sBody.$nn; 
		}
		
		if($this->sBodyHtml != ''){
		$sMsg .= '--'.$this->sWall.$n;
		$sMsg .= 'Content-Type: text/html; charset="iso-8859-1"'.$nn;
		$sMsg .= $this->sBodyHtml.$nn;	
		}
		
		if($this->sAttached != ''){
		$sMsg .= '--'.$this->sWall.''.$n; 
		$sMsg .= 'Content-Type: text/csv; name="'.$this->sAttached.'"'.$n;
		$sMsg .= 'Content-Transfer-Encoding: base64'.$n;
		$sMsg .= 'Content-Disposition:attachement; filename="'.$this->sAttached.'"'.$nn;
		$sMsg .= chunk_split(base64_encode(file_get_contents($this->sAttached)))."\n";
		}
		
		if( mail( implode(',',$this->tTo),$this->sTitle,$sMsg,$sHeader)){
			return true;
		}else{
			return false;
		} 
	}


}
