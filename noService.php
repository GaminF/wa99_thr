<?php
	include( '../devInclude/includeBaseV2.php' );
	$siteInfo['interface'] = 'v2';
	$tpl=new TemplatePower( "interface/".$siteInfo['interface']."/html/noService.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign  ( $siteInfo );
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->printToScreen();

?>