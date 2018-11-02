<?php
	include("config.php");
	//if( $sys->userAlive['errorCode'] != 'OK' ) $sys->redirectUrl( 'logout.php' );

	//取得賽事列表 $gArr(全部賽事), $dateArr(日期賽事), $cpArr(聯盟賽事)
	//include( 'getGameList.php' );
	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/fifa_tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/fifa_statistics.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );

	$tpl->prepare();
	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );

	actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();
?>