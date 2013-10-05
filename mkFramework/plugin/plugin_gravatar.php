<?php
class plugin_gravatar{
	
	public static function get($email){
		$size = 10;
		$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "&s=" . $size;
		

		return $grav_url;
	}
}
