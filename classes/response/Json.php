<?php

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