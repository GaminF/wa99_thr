<?php
	include( 'config.php' );
	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/helpcenter.html" );
	//$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign( $siteInfo );
	
	//登入前後
	/*$menuInfoBarTag = ( is_array( $mbInfoArr ) ) ? 'menuInfoBar_Login' : 'menuInfoBar_notLogin' ;
	$tpl->newBlock( $menuInfoBarTag );
	$tpl->assign  ( $_REQUEST );
	$tpl->assign  ( $mbInfoArr );*/

	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->printToScreen();



?>