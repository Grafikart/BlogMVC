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
* plugin_upload classe gerant l'upload de fichier
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_upload{

	private $tFile;
	private $sOriginFileName;
	private $sTmpFileName;
	private $sNewPath;
	private $sExtension;
	private $bValid;

	/** 
	* constructeur
	* @access public
	* @param string nomDuChamp
	*/
	public function __construct($sColumn){
		if(isset($_FILES[$sColumn]) && $_FILES[$sColumn]['size'] > 0){
			$this->bValid=true;
			$this->tFile=$_FILES[$sColumn];
			$this->sOriginFileName=basename($_FILES[$sColumn]['name']);
			$this->sTmpFileName=$_FILES[$sColumn]['tmp_name'];
			$this->loadExtension();
		}else{
			$this->bValid=false;
		}
	}

	/** 
	* indique l'adresse ou sauvegarder le fichier
	* @access public
	* @param string $sNewFileName adresse complete de destination (data/upload/fichier.jpg)
	* @return bool true/false selon que l'upload a bien fonctionne
	*/
	public function saveAs($sNewFileName){
		$this->sNewPath=$sNewFileName.'.'.$this->sExtension;

		if(move_uploaded_file($this->sTmpFileName, $this->sNewPath)){
			return true;
		}
		else{
			return false;
		}
	}
	/** 
	* retourne l'adresse complete du fichier uploade
	* @access public
	* @return string l'adresse complete du fichier uploade
	*/
	public function getPath(){
		return $this->sNewPath;
	}
	/** 
	* retourne l'adresse complete du fichier uploade
	* @access public
	* @return bool true/false selon que le fichier a bien ete uploade ou non
	*/
	public function isValid(){
		return $this->bValid;
	}

	private function loadExtension(){
		$tFileName=preg_split('/\./',$this->sOriginFileName);
		$this->sExtension= end($tFileName);
	}

}
