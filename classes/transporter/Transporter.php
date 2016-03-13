<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
