<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Array Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/array_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('blog_post_resume'))
{
	// http://j-reaux.developpez.com/tutoriel/php/fonctions-troncature-texte/
	function blog_post_resume($texte, $nbreCar)
	{
		$texte = trim(strip_tags($texte));
		if(is_numeric($nbreCar))
		{
			$PointSuspension = '...';
			$texte .= ' ';
			$LongueurAvant = strlen($texte);
			if ($LongueurAvant > $nbreCar) {
				$texte = substr($texte, 0, strpos($texte, ' ', $nbreCar));
				if ($PointSuspension!='') {
					$texte .= $PointSuspension;
				}
			}
		}
		return $texte;
	};
}

/* End of file blog_helper.php */
/* Location: ./application/helpers/blog_helper.php */