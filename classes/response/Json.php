<?php
/**
 * @package    1&1 Server monitoring
 *
 * @author     Francisco Aramayo Martinez <faramayo@arsys.es>
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-software.de>
 *
 * @license    GNU General Public License version 3 or later; see LICENSE
 */

namespace response;

class JSON
{
	protected $content;

	public function __construct($content)
	{
		$this->content = json_decode($content);
	}

	public function isValid()
	{
		return (bool) $this->content;
	}

	public function __get($name)
	{
		switch ($name)
		{
			case 'content':
				return $this->content;
		}
	}
}