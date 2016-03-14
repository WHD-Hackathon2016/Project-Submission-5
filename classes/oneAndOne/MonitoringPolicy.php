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


class MonitoringPolicy extends \oneAndOne\Element
{
	private $criticalCpu;
	private $criticalRam;
	private $criticalDisk;
	private $warningCpu;
	private $warningRam;
	private $warningDisk;

	static $segment = '/monitoring_policies';
}