<?php

namespace oneAndOne;
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 13/03/2016
 * Time: 13:53
 */
abstract class Element implements IElement
{
    protected $id;
    protected $name;
    protected $date;

    protected $segment;

    public function get($id)
    {
        $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);
        $url= \AppConfig::getData('API')['url'].$this->segment.'/'.$id;
        $result = $curl->get($url);

		return $result;
	}

	public function post($url, $postparams)
	{
        $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);
        $result = $curl->post($url, $postparams);
	}

	public function __get($name)
	{
		switch ($name)
		{
			case 'id':
				return $this->$name;
		}
	}
}