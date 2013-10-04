<?php

include('../vendor/Michelf/Markdown.php');


class plugin_markdown{
	
	
	public static function tr($text){
		
		return Michelf\Markdown::defaultTransform($text);
	}
	
}
