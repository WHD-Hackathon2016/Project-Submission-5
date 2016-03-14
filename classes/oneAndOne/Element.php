<?php
/**
 * @package    1&1 Server monitoring
 *
 * @author     Francisco Aramayo Martinez <faramayo@arsys.es>
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-software.de>
 *
 * @license    GNU General Public License version 3 or later; see LICENSE
 */

namespace oneAndOne;
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 13/03/2016
 * Time: 13:53
 */
abstract class Element implements IElement
{
	protected $data;

    static $segment;

	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * @param null $id
	 * @return $this
	 * @throws \Exception
	 */
    public static function get($id = null)
    {
        $curl = new \transporter\Curl(\AppConfig::getData('API')['token']);
        $url= \AppConfig::getData('API')['url']. static::$segment.'/'.$id;
        $result = $curl->get($url);

		return static::createObject($result);
	}

	protected static function createObject($result)
	{
		// @TODO: check if $result is valid
		$content = $result->content;

		$return = null;

		if (is_array($content))
		{
			$return = array();

			foreach ($content as $data)
			{
				$return[] = new static($data);
			}
		}
		else
		{
			$return = new static($content);
		}

		return $return;
	}

	public function __get($name)
	{
		if (isset($this->data->$name))
		{
			return $this->data->$name;
		}

		return null;
	}
}
