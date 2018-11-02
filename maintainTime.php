<?php
	include( '../devInclude/includeBaseV2.php' );	//各類include檔案
	$siteInfo = array( "interface"=>"v2" );		//由網址取得代理與介面樣式
	$tpl=new TemplatePower( "interface/".$siteInfo['interface']."/html/maintain.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();

	$servicetime = date( 'Y-m-d H:i:s' );//gmdate("Y-m-d H:i:s", mktime($H));	

	$setTime = date( '2018-07-15 00:00:00' ); //手動設定
	$endtime = ( $setTime > $servicetime ) ? $setTime : date("Y-m-d 23:59:59");

	$lefttime = ( strtotime( $endtime ) - strtotime( $servicetime ) );
	$tpl->assign( 'lefttime', $lefttime );

	if( $lefttime <=0 ) { header("location: index.php"); die(); }
	
	$tpl->printToScreen();
?>
