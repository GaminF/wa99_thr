<?php
	$online = ( $_SERVER['HTTP_HOST'] == '127.0.0.1' ) ? 0 : 1 ;
	if( $online )
	{
		include( '../devInclude/includeBaseV2.php' );	//各類include檔案
		$sysType	= 'WEB';							//選項 [ MOBILE | WEB ]
		$siteInfo	= array( "interface"=>"v2" );		//由網址取得代理與介面樣式
	}
	else//免用RedisCache + 使用測試模擬資料
	{
		session_start();
		include( 'TaoginApiNillie.php' ); 
		include("../devInclude/TemplatePower3.0.2.1/class.TemplatePower.inc.php");//各類include檔案
		$siteInfo = array( "interface"=>"v2" );//由網址取得代理與介面樣式
	}
?>