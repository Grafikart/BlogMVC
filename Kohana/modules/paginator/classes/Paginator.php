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
 * @version    $Id: Paginator.php 23775 2011-03-01 17:25:24Z ralph $
 */
/**
 * @category   Zend
 * @package    Paginator
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * @category   kohana
 * @package    Paginator modified by dari88
 * @copyright  Copyright (c) dari88
 * @license    New BSD License
 */
class Paginator implements Countable, IteratorAggregate {
	/**
	 * The cache tag prefix used to namespace Paginator results in the cache
	 *
	 */

	const CACHE_TAG_PREFIX = 'Paginator_';

	/**
	 * Default scrolling style
	 *
	 * @var string
	 */
	protected static $_default_scrolling_style = 'Sliding';

	/**
	 * Default item count per page
	 *
	 * @var int
	 */
	protected static $_default_item_count_per_page = 10;

	/**
	 * Default number of local pages (i.e., the number of discretes
	 * page numbers that will be displayed, including the current
	 * page number)
	 *
	 * @var int
	 */
	protected static $_default_page_range = 10;

	/**
	 * Cache object
	 *
	 * @var Cache_Core
	 */
	protected static $_cache;

	/**
	 * Enable or disable the cache by Paginator instance
	 *
	 * @var bool
	 */
	protected $_cache_enabled = true;

	/**
	 * Adapter
	 *
	 * @var Paginator_Interface
	 */
	protected $_adapter = null;

	/**
	 * Number of items in the current page
	 *
	 * @var integer
	 */
	protected $_current_item_count = null;

	/**
	 * Current page items
	 *
	 * @var Traversable
	 */
	protected $_current_items = null;

	/**
	 * Current page number (starting from 1)
	 *
	 * @var integer
	 */
	protected $_current_page_number = 1;

	/**
	 * Number of items per page
	 *
	 * @var integer
	 */
	protected $_item_count_per_page = null;

	/**
	 * Number of pages
	 *
	 * @var integer
	 */
	protected $_page_count = null;

	/**
	 * Number of local pages (i.e., the number of discrete page numbers
	 * that will be displayed, including the current page number)
	 *
	 * @var integer
	 */
	protected $_page_range = null;

	/**
	 * Pages
	 *
	 * @var array
	 */
	protected $_pages = null;

	/**
	 * Default url, page option's name, url options.
	 *
	 * @var array
	 */
	protected $_default_url = '';
	protected $_default_page_query_name = 'page';
	protected $_default_option_query = '';

	/**
	 * url, page option's name, url options.
	 *
	 * @var array
	 */
	protected $_url = null;
	protected $_page_query_name = null;
	protected $_option_query = null;

	/**
	 * Constructor.
	 *
	 * @param Paginator_Interface|Paginator_AdapterAggregate $adapter
	 */
	public function __construct($adapter)
	{
		if ($adapter instanceof Paginator_Iterator)
		{
			$this->_adapter = $adapter;
		}
		else
		{
			throw new Exception(
					'Paginator only accepts instances of the type ' .
					'Paginator_Iterator.'
			);
		}
	}

	/**
	 * Factory.
	 *
	 * @param  mixed $data
	 * @param  string $adapter
	 * @param  array $prefixPaths
	 * @return Paginator
	 */
	public static function factory($data)
	{
		return new self(new Paginator_Iterator($data));
	}

	/**
	 * Returns the default scrolling style.
	 *
	 * @return  string
	 */
	public static function get_default_scrolling_style()
	{
		return self::$_default_scrolling_style;
	}

	/**
	 * Get the default item count per page
	 *
	 * @return int
	 */
	public static function get_default_item_count_per_page()
	{
		return self::$_default_item_count_per_page;
	}

	/**
	 * Set the default item count per page
	 *
	 * @param int $count
	 */
	public static function set_default_item_count_per_page($count)
	{
		self::$_default_item_count_per_page = (int) $count;
	}

	/**
	 * Get the default page range
	 *
	 * @return int
	 */
	public static function get_default_page_range()
	{
		return self::$_default_page_range;
	}

	/**
	 * Set the default page range
	 *
	 * @param int $count
	 */
	public static function set_default_page_range($count)
	{
		self::$_default_page_range = (int) $count;
	}

	/**
	 * Sets a cache object
	 *
	 * @param Cache_Core $cache
	 */
	public static function set_cache(Cache_Core $cache)
	{
		self::$_cache = $cache;
	}

	/**
	 * Sets the default scrolling style.
	 *
	 * @param  string $scrolling_style
	 */
	public static function set_default_scrolling_style($scrolling_style = 'Sliding')
	{
		self::$_default_scrolling_style = $scrolling_style;
	}

	/**
	 * Enables/Disables the cache for this instance
	 *
	 * @param bool $enable
	 * @return Paginator
	 */
	public function set_cache_enabled($enable)
	{
		$this->_cache_enabled = (bool) $enable;
		return $this;
	}

	/**
	 * Returns the number of pages.
	 *
	 * @return integer
	 */
	public function count()
	{
		if ( ! $this->_page_count)
		{
			$this->_page_count = $this->_calculate_page_count();
		}

		return $this->_page_count;
	}

	/**
	 * Returns the total number of items available.
	 *
	 * @return integer
	 */
	public function get_total_item_count()
	{
		return count($this->get_adapter());
	}

	/**
	 * Clear the page item cache.
	 *
	 * @param int $page_number
	 * @return Paginator
	 */
	public function clear_page_item_cache($page_number = null)
	{
		if ( ! $this->_cache_enabled())
		{
			return $this;
		}

		if (null === $page_number)
		{
			foreach (self::$_cache->getIdsMatchingTags(array($this->_get_cache_internal_id())) as $id)
			{
				if (preg_match('|' . self::CACHE_TAG_PREFIX . "(\d+)_.*|", $id, $page))
				{
					self::$_cache->remove($this->_get_cache_id($page[1]));
				}
			}
		}
		else
		{
			$clean_id = $this->_get_cache_id($page_number);
			self::$_cache->remove($clean_id);
		}
		return $this;
	}

	/**
	 * Returns the absolute item number for the specified item.
	 *
	 * @param  integer $relative_item_number Relative item number
	 * @param  integer $page_number Page number
	 * @return integer
	 */
	public function get_absolute_item_number($relative_item_number, $page_number = null)
	{
		$relative_item_number = $this->normalize_item_number($relative_item_number);

		if ($page_number == null)
		{
			$page_number = $this->get_current_page_number();
		}

		$page_number = $this->normalize_page_number($page_number);

		return (($page_number - 1) * $this->get_item_count_per_page()) + $relative_item_number;
	}

	/**
	 * Returns the adapter.
	 *
	 * @return Paginator_Interface
	 */
	public function get_adapter()
	{
		return $this->_adapter;
	}

	/**
	 * Returns the number of items for the current page.
	 *
	 * @return integer
	 */
	public function get_current_item_count()
	{
		if ($this->_current_item_count === null)
		{
			$this->_current_item_count = $this->get_item_count($this->get_current_items());
		}

		return $this->_current_item_count;
	}

	/**
	 * Returns the items for the current page.
	 *
	 * @return Traversable
	 */
	public function get_current_items()
	{
		if ($this->_current_items === null)
		{
			$this->_current_items = $this->get_items_by_page($this->get_current_page_number());
		}

		return $this->_current_items;
	}

	/**
	 * Returns the current page number.
	 *
	 * @return integer
	 */
	public function get_current_page_number()
	{
		return $this->normalize_page_number($this->_current_page_number);
	}

	/**
	 * Sets the current page number.
	 *
	 * @param  integer $page_number Page number
	 * @return Paginator $this
	 */
	public function set_current_page_number($page_number)
	{
		$this->_current_page_number = (integer) $page_number;
		$this->_current_items = null;
		$this->_current_item_count = null;

		return $this;
	}

	/**
	 * Returns an item from a page.  The current page is used if there's no
	 * page sepcified.
	 *
	 * @param  integer $item_number Item number (1 to item_count_per_page)
	 * @param  integer $page_number
	 * @return mixed
	 */
	public function get_item($item_number, $page_number = null)
	{
		if ($page_number == null)
		{
			$page_number = $this->get_current_page_number();
		}
		else if ($page_number < 0)
		{
			$page_number = ($this->count() + 1) + $page_number;
		}

		$page = $this->get_items_by_page($page_number);
		$item_count = $this->get_item_count($page);

		if ($item_count == 0)
		{
			throw new Exception('Page ' . $page_number . ' does not exist');
		}

		if ($item_number < 0)
		{
			$item_number = ($item_count + 1) + $item_number;
		}

		$item_number = $this->normalize_item_number($item_number);

		if ($item_number > $item_count)
		{
			throw new Exception('Page ' . $page_number . ' does not'
					. ' contain item number ' . $item_number);
		}

		return $page[$item_number - 1];
	}

	/**
	 * Returns the number of items per page.
	 *
	 * @return integer
	 */
	public function get_item_count_per_page()
	{
		if (empty($this->_item_count_per_page))
		{
			$this->_item_count_per_page = self::get_default_item_count_per_page();
		}

		return $this->_item_count_per_page;
	}

	/**
	 * Sets the number of items per page.
	 *
	 * @param  integer $item_count_per_page
	 * @return Paginator $this
	 */
	public function set_item_count_per_page($item_count_per_page = -1)
	{
		$this->_item_count_per_page = (integer) $item_count_per_page;
		if ($this->_item_count_per_page < 1)
		{
			$this->_item_count_per_page = $this->get_total_item_count();
		}
		$this->_page_count = $this->_calculate_page_count();
		$this->_current_items = null;
		$this->_current_item_count = null;

		return $this;
	}

	/**
	 * Returns the number of items in a collection.
	 *
	 * @param  mixed $items Items
	 * @return integer
	 */
	public function get_item_count($items)
	{
		$item_count = 0;

		if (is_array($items) || $items instanceof Countable)
		{
			$item_count = count($items);
		}
		else
		{ // $items is something like LimitIterator
			$item_count = iterator_count($items);
		}

		return $item_count;
	}

	/**
	 * Returns the items for a given page.
	 *
	 * @return Traversable
	 */
	public function get_items_by_page($page_number)
	{
		$page_number = $this->normalize_page_number($page_number);

		if ($this->_cache_enabled())
		{
			$data = self::$_cache->load($this->_get_cache_id($page_number));
			if ($data !== false)
			{
				return $data;
			}
		}

		$offset = ($page_number - 1) * $this->get_item_count_per_page();

		$items = $this->_adapter->get_items($offset, $this->get_item_count_per_page());

		if ( ! $items instanceof Traversable)
		{
			$items = new ArrayIterator($items);
		}

		if ($this->_cache_enabled())
		{
			self::$_cache->save($items, $this->_get_cache_id($page_number), array($this->_get_cache_internal_id()));
		}

		return $items;
	}

	/**
	 * Returns a foreach-compatible iterator.
	 *
	 * @return Traversable
	 */
	public function getIterator()
	{
		return $this->get_current_items();
	}

	/**
	 * Returns the page range (see property declaration above).
	 *
	 * @return integer
	 */
	public function get_page_range()
	{
		if (null === $this->_page_range)
		{
			$this->_page_range = self::get_default_page_range();
		}

		return $this->_page_range;
	}

	/**
	 * Sets the page range (see property declaration above).
	 *
	 * @param  integer $page_range
	 * @return Paginator $this
	 */
	public function set_page_range($page_range)
	{
		$this->_page_range = (integer) $page_range;

		return $this;
	}

	/**
	 * Returns the page collection.
	 *
	 * @param  string $scrolling_style Scrolling style
	 * @return array
	 */
	public function get_pages($scrolling_style = null)
	{
		if ($this->_pages === null)
		{
			$this->_pages = $this->_create_pages($scrolling_style);
		}

		return $this->_pages;
	}

	/**
	 * Returns a subset of pages within a given range.
	 *
	 * @param  integer $lower_bound Lower bound of the range
	 * @param  integer $upper_bound Upper bound of the range
	 * @return array
	 */
	public function get_pages_in_range($lower_bound, $upper_bound)
	{
		$lower_bound = $this->normalize_page_number($lower_bound);
		$upper_bound = $this->normalize_page_number($upper_bound);

		$pages = array();

		for ($page_number = $lower_bound; $page_number <= $upper_bound; $page_number ++ )
		{
			$pages[$page_number] = $page_number;
		}

		return $pages;
	}

	/**
	 * Returns the page item cache.
	 *
	 * @return array
	 */
	public function get_page_item_cache()
	{
		$data = array();
		if ($this->_cache_enabled())
		{
			foreach (self::$_cache->getIdsMatchingTags(array($this->_get_cache_internal_id())) as $id)
			{
				if (preg_match('|' . self::CACHE_TAG_PREFIX . "(\d+)_.*|", $id, $page))
				{
					$data[$page[1]] = self::$_cache->load($this->_get_cache_id($page[1]));
				}
			}
		}
		return $data;
	}

	/**
	 * Brings the item number in range of the page.
	 *
	 * @param  integer $item_number
	 * @return integer
	 */
	public function normalize_item_number($item_number)
	{
		$item_number = (integer) $item_number;

		if ($item_number < 1)
		{
			$item_number = 1;
		}

		if ($item_number > $this->get_item_count_per_page())
		{
			$item_number = $this->get_item_count_per_page();
		}

		return $item_number;
	}

	/**
	 * Brings the page number in range of the paginator.
	 *
	 * @param  integer $page_number
	 * @return integer
	 */
	public function normalize_page_number($page_number)
	{
		$page_number = (integer) $page_number;

		if ($page_number < 1)
		{
			$page_number = 1;
		}

		$page_count = $this->count();

		if ($page_count > 0 && $page_number > $page_count)
		{
			$page_number = $page_count;
		}

		return $page_number;
	}

	/**
	 * Tells if there is an active cache object
	 * and if the cache has not been desabled
	 *
	 * @return bool
	 */
	protected function _cache_enabled()
	{
		return ((self::$_cache !== null) && $this->_cache_enabled);
	}

	/**
	 * Makes an Id for the cache
	 * Depends on the adapter object and the page number
	 *
	 * Used to store item in cache from that Paginator instance
	 *  and that current page
	 *
	 * @param int $page
	 * @return string
	 */
	protected function _get_cache_id($page = null)
	{
		if ($page === null)
		{
			$page = $this->get_current_page_number();
		}
		return self::CACHE_TAG_PREFIX . $page . '_' . $this->_get_cache_internal_id();
	}

	/**
	 * Get the internal cache id
	 * Depends on the adapter and the item count per page
	 *
	 * Used to tag that unique Paginator instance in cache
	 *
	 * @return string
	 */
	protected function _get_cache_internal_id()
	{
		return md5(serialize(array(
							$this->get_adapter(),
							$this->get_item_count_per_page()
						)));
	}

	/**
	 * Calculates the page count.
	 *
	 * @return integer
	 */
	protected function _calculate_page_count()
	{
		return (integer) ceil($this->get_adapter()->count() / $this->get_item_count_per_page());
	}

	/**
	 * Creates the page collection.
	 *
	 * @param  string $scrolling_style Scrolling style
	 * @return stdClass
	 */
	protected function _create_pages($scrolling_style = null)
	{
		$page_count = $this->count();
		$current_page_number = $this->get_current_page_number();

		$pages = new stdClass;
		$pages->page_count = $page_count;
		$pages->item_count_per_page = $this->get_item_count_per_page();
		$pages->first = 1;
		$pages->current = $current_page_number;
		$pages->last = $page_count;

		// Previous and next
		if ($current_page_number - 1 > 0)
		{
			$pages->previous = $current_page_number - 1;
		}

		if ($current_page_number + 1 <= $page_count)
		{
			$pages->next = $current_page_number + 1;
		}

		// Pages in range
		$scrolling_style = $this->_load_scrolling_style($scrolling_style);
		$pages->pages_in_range = $scrolling_style->get_pages($this);
		$pages->first_page_in_range = min($pages->pages_in_range);
		$pages->last_page_in_range = max($pages->pages_in_range);

		// Item numbers
		if ($this->get_current_items() !== null)
		{
			$pages->current_item_count = $this->get_current_item_count();
			$pages->item_count_per_page = $this->get_item_count_per_page();
			$pages->total_item_count = $this->get_total_item_count();
			$pages->first_item_number = (($current_page_number - 1) * $this->get_item_count_per_page()) + 1;
			$pages->last_item_number = $pages->first_item_number + $pages->current_item_count - 1;
		}

		return $pages;
	}

	/**
	 * Loads a scrolling style.
	 *
	 * @param string $scrolling_style
	 * @return Paginator_Scrollingstyle_Interface
	 */
	protected function _load_scrolling_style($scrolling_style = null)
	{
		if ($scrolling_style === null)
		{
			$scrolling_style = self::$_default_scrolling_style;
		}

		switch (strtolower($scrolling_style))
		{
			case 'all':
			case 'elastic':
			case 'jumping':
			case 'sliding':
				$className = 'Paginator_Scrollingstyle_' . ucfirst($scrolling_style);
				return new $className;

			case 'null':
			default:
				throw new Exception('Scrolling style must be a class ' .
						'name or object implementing Paginator_Scrollingstyle_Interface');
		}
	}

	/**
	 * Set URL and options
	 * Default Page Query Name = 'page'
	 * @param string $url
	 * @param string $page_query_name
	 * @param string $option_query
	 * @return boolean true
	 */
	public function set_option_queries($url = null, $page_query_name = null, $option_query = null)
	{
		$this->_url = $url ? $url : $this->_default_url;
		$this->_page_query_name = $page_query_name ? $page_query_name : $this->_default_page_query_name;
		$this->_option_query = $option_query ? $option_query : $this->_default_option_query;
		return true;
	}

	/**
	 * Render the pagination.
	 * Scrolling style: Sliding(default), Elastic, Jumping, All
	 * @param  string $scrolling_style = null
	 * @return rendered_View
	 */
	public function render($scrolling_style = null)
	{
		if ($this->_page_query_name == null)
		{
			$this->set_option_queries();
		}

		$pages = $this->get_pages($scrolling_style);
		if ($pages->page_count > 0)
		{
			$url1 = $this->_url . '?' . $this->_page_query_name . '=';
			$url2 = $this->_option_query ? '&' . $this->_option_query : '';
			$first = ($pages->first == $pages->current) ? '' : $url1 . $pages->first . $url2;
			$previous = ($pages->first == $pages->current) ? '' : $url1 . $pages->previous . $url2;
			$next = ($pages->last == $pages->current) ? '' : $url1 . $pages->next . $url2;
			$last = ($pages->last == $pages->current) ? '' : $url1 . $pages->last . $url2;
			foreach ($pages->pages_in_range as $key => $value)
			{
				$pages_in_range[$value] = ($value == $pages->current) ? '' : $url1 . $value . $url2;
			}
		}
		else
		{
			$first = $previous = $pages_in_range[1] = $next = $last = '';
		}

		$view = View::factory('paginator/pagination');
		$view->first = $first;
		$view->previous = $previous;
		$view->pages_in_range = $pages_in_range;
		$view->next = $next;
		$view->last = $last;

		return $view->render();
	}

}
