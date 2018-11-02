<?php
	//[登出]
	//20171007建立(Gamin)
	//ob_start();//開啟output_buffering
	//session_start();includeBaseV2.php已經設置
	include( '../devInclude/includeBaseV2.php' ); //各類include檔案

	//清除cache
	$tagName	= $_SESSION['WEB2']['MemID'].'_MemberInfo';
	$rc			= new redisCache;
	$rc->delVar( $tagName );

	unset( $_SESSION['WEB2'] );
	unset( $_SESSION["Register"] );
	unset( $_SESSION );

	header( 'Location: ./' );
?>