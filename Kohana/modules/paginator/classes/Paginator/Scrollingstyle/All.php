<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Paginator
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: All.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * A scrolling style that returns every page in the collection.
 * Useful when it is necessary to make every page available at
 * once--for example, when using a dropdown menu pagination control.
 *
 * @category   Zend
 * @package    Paginator
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Paginator_Scrollingstyle_All implements Paginator_Scrollingstyle_Interface {

	/**
	 * Returns an array of all pages given a page number and range.
	 *
	 * @param  Paginator $paginator
	 * @param  integer $page_range Unused
	 * @return array
	 */
	public function get_pages(Paginator $paginator, $page_range = null)
	{
		return $paginator->get_pages_in_range(1, $paginator->count());
	}

}