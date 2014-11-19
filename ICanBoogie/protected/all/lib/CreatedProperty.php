<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlogMVC;

use ICanBoogie\ActiveRecord\DateTimePropertySupport;

/**
 * Implements a `created` property.
 *
 * @see DateTimeProperty
 */
trait CreatedProperty
{
	/**
	 * The date and time at which the record was created.
	 *
	 * @var string
	 */
	private $created;

	/**
	 * Returns the date and time at which the record was created.
	 *
	 * @return \ICanBoogie\DateTime
	 */
	protected function get_created()
	{
		return DateTimePropertySupport::get($this->created);
	}

	/**
	 * Sets the date and time at which the record was created.
	 *
	 * @param mixed $value
	 */
	protected function set_created($datetime)
	{
		DateTimePropertySupport::set($this->created, $datetime);
	}
}
