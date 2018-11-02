<?php
	require_once('../../../psec/modules/allmodules.php');//public,session module
	require_once('../../../psec/modules/newsecane.php');//下注module
	require_once('../../../psec/function/netfunction.php');//函式

	/*啟動session*/
	$session->init();
	$siteStatus = $session->weberrorcode();

	$dnow = date('Y-m-d H:i:s');

	$dresult = $siteStatus['time'];   //日期天数相加函数

	if(strlen((int)((strtotime($dresult) - strtotime($dnow)) / (24 * 3600))) < 2)
	{
		$da = (int)((strtotime($dresult) - strtotime($dnow)) / (24 * 3600));
	}
	else
	{
		$da = (int)((strtotime($dresult) - strtotime($dnow)) / (24 * 3600));
	}

	if(strlen((int)((strtotime($dresult) - strtotime($dnow)) % (24*3600)/3600)) < 2)
	{
		$hu = (int)((strtotime($dresult) - strtotime($dnow)) % (24*3600)/3600);
	}
	else
	{
		$hu = (int)((strtotime($dresult) - strtotime($dnow)) % (24*3600)/3600);
	}

	if(strlen((int)((strtotime($dresult) - strtotime($dnow)) % (3600)/60)) < 2)
	{
		$mi = (int)((strtotime($dresult) - strtotime($dnow)) % (3600)/60);
	}
	else
	{
		$mi = (int)((strtotime($dresult) - strtotime($dnow)) % (3600)/60);
	}

	if(strlen((int)((strtotime($dresult) - strtotime($dnow)) % 60)) < 2)
	{
		$sec = (int)((strtotime($dresult) - strtotime($dnow)) % 60);
	}
	else
	{
		$sec = (int)((strtotime($dresult) - strtotime($dnow)) % 60);
	}

	if($siteStatus['time']=='')
	{
		$setTime = date( '2018-04-27 02:30:00' );
		$servicetime = date('Y-m-d H:i:s');
		$endtime = ( $setTime > $servicetime ) ? $setTime : date("Y-m-d 23:59:59");
		$das = (int)((strtotime($endtime) - strtotime($servicetime)) % (24*3600)/3600);
		$mis = (int)((strtotime($endtime) - strtotime($servicetime)) % (3600)/60);
		$secs = (int)((strtotime($endtime) - strtotime($servicetime)) % 60);

		echo '000,'.$das.','.$mis.','.$secs.'';	
	}
	else
	{
		echo $da.','.$hu.','.$mi.','.$sec.','.$siteStatus['errorCode'];
	}

	function checkcount()
	{
		$gg = date("l", strtotime("Tuesday"));
		$ff1 = strtotime(date('Y-m-d 14:30:30'));
		$ff2 = strtotime(date('Y-m-d 16:30:30'));
		$ff3 = strtotime(date('Y-m-d 18:30:30'));
		$now = strtotime(date('Y-m-d H:i:s'));
		if($now < $ff1)
		{
			$info = strtotime(date('Y-m-d 14:30:30'));
		}   
		if($now > $ff1)
		{
			$info = strtotime(date('Y-m-d 16:30:30'));
		}
		if($now > $ff2)
		{
			$info = strtotime(date('Y-m-d 18:30:30'));
		}

		if($gg=='Tuesday')
		{
			return $info;
		}
		else
		{
			return date('Y-m-d 23:59:59');
		}
	}
?>