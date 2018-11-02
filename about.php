<?php
	include( 'config.php' );

	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/fifa_temp.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/about.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );

	$tpl->prepare();
	$tpl->assign  ( $siteInfo );
	
	//登入前後
	$menuInfoBarTag = ( is_array( $mbInfoArr ) ) ? 'menuInfoBar_Login' : 'menuInfoBar_notLogin' ;
	$tpl->newBlock( $menuInfoBarTag );
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( $_REQUEST );
	$tpl->assign  ( $mbInfoArr );
	$tpl->gotoBlock( '_ROOT' );
	$tpl->assign('tgContact','tgContact.php');
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->printToScreen();




?>