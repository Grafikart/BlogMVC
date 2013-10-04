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
* plugin_tpl classe d'aide de template
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_tpl{
	
	static protected $tAlternate;
	
	
	/** retourne en alternance une valeur du tableau $tab, 
	 * un deuxieme argument (optionnel) permet d'avoir plusieurs lots d'alternance
	* @access public
	* @param array $tab tableau contenant les valeurs a alterner
	* @param string $uRef
	*/
	public static function alternate($tab,$uRef=0){
		if(!isset(self::$tAlternate[$uRef])){
			self::$tAlternate[$uRef]=0;
		}else{
			self::$tAlternate[$uRef]+=1;
		}
		if(self::$tAlternate[$uRef] >= count($tab)){
			self::$tAlternate[$uRef]=0;
		}
		return $tab[self::$tAlternate[$uRef] ];
	}
	

}
