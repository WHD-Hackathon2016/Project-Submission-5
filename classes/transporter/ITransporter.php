<?php
/**
 * @package    1&1 Server monitoring
 *
 * @author     Francisco Aramayo Martinez <faramayo@arsys.es>
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-software.de>
 *
 * @license    GNU General Public License version 3 or later; see LICENSE
 */

namespace transporter;

interface ITransporter
{
	public function __construct($credentials = null);

	public function get($url);

	public function post($url,$data);
}
