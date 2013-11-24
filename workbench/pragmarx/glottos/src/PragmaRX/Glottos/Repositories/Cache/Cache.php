<?php namespace PragmaRX\Glottos\Repositories\Cache;
/**
 * Part of the Glottos package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Glottos
 * @version    1.0.0
 * @author     Antonio Carlos Ribeiro @ PragmaRX
 * @license    BSD License (3-clause)
 * @copyright  (c) 2013, PragmaRX
 * @link       http://pragmarx.com
 */

class Cache implements CacheInterface {
	
	private $memory = array();

	public function get($key)
	{
		return isset($this->memory[$key]) 
		             ? unserialize($this->memory[$key]) 
		             : null;
	}

	public function put($key, $value, $minutes = 0)
	{
		return $this->memory[$key] = serialize($value);
	}

	public function increment($key, $value = 1)
	{
		throw new \Exception("Increment operations not supported by this driver.");	
	}

	public function decrement($key, $value = 1)
	{
		throw new \Exception("Decrement operations not supported by this driver.");	
	}

	public function forever($key, $value)
	{
		$this->put($key, $value);
	}

	public function forget($key)
	{
		unset($this->memory[$key]);
	}

	public function flush()
	{
		$this->memory = array();
	}

	public function getPrefix()
	{
		return '';
	}
	
}