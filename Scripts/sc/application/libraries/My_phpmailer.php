<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_phpmailer
{
	public function __construct()
	{
		require_once(APPPATH.'/third_party/PHPMailer/class.phpmailer.php');
	}
}