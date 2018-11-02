<?php
	include( 'config.php' );

	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	//$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/history.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	//$tpl->newBlock('iconBlock');
	// $icon=$_POST['icon'];
	// echo $icon;
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );



	
	$tpl->printToScreen();





?>