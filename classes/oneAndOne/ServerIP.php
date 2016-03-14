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


class ServerIP extends Element
{
    static $segment = "/public_ips";

    public function getServerId($ipId)
    {
		$ip = parent::get($ipId);

        if (isset($ip->content->assigned_to->id) )
        {
            return $ip->content->assigned_to->id;
        }

        throw new \Exception("Ip has not server assigned");
    }
}