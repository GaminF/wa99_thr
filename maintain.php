<?php
	include( 'config.php' );

	if( $sys->systemStatus['errorCode'] == '000' || $sys->systemStatus['errorCode'] == '900' )
	{
		header( "Location:logout.php" );
		die();
	}

	$tpl=new TemplatePower( "interface/".$siteInfo['interface']."/html/maintain.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign( $siteInfo );
	$tpl->assign( $mbInfoArr );

	$result		 = $sys->systemStatus;
	$servicetime = date( 'Y-m-d H:i:s' );//gmdate("Y-m-d H:i:s", mktime($H));	

	if( $result['time']=='' || !isset( $result['time'] ) || $result['time'] < $servicetime )
	{
		$setTime = date( "Y-m-d 14:30:00" ); //手動設定
		$endtime = ( $setTime > $servicetime ) ? $setTime : date("Y-m-d 23:59:59");

		//後端無法連線，由前端控制台控制時間
		include( '/var/www/html/devInclude/class_serverCtrl.php' );
		$sc			= new serverCtrl();
		$setArr		= $sc->getMaintainInfo();
		$endtime	= ( !empty( $setArr['setTime'] ) ) ? $setArr['setTime'] : $endtime ;
		if( $_REQUEST['debug'] ) echo 'endtime:'.$endtime;
	}
	else
	{
		$endtime = $result['time'];
	}
	$lefttime = ( strtotime( $endtime ) - strtotime( $servicetime ) );
	if( $_REQUEST['debug'] ) echo '<p>endtime:'.strtotime( $endtime ).' / servicetime:'.strtotime( $servicetime ).' / lefttime:'.$lefttime;
	$tpl->assign( 'lefttime', $lefttime );
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );
	$tpl->printToScreen();
?>
