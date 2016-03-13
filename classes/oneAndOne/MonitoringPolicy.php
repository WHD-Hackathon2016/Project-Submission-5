<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 13/03/2016
 * Time: 14:33
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