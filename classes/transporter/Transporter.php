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

abstract class Transporter implements \transporter\ITransporter
{
	protected $xtoken;

	public function __construct($xtoken = null)
	{
		// @TODO find a good construct
		$this->xtoken = $xtoken;
	}
}
