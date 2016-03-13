<?php

namespace response;

class JSON
{
	protected $object;

	public function __construct($content)
	{
		$this->object = json_decode($content);
	}

	public function isValid()
	{
		return (bool) $this->object;
	}

	public function __get($name)
	{
		switch ($name)
		{
			case 'object':
				return $this->object;
		}
	}
}