<?php
	//[登入] 檢驗 & SESSION記錄
	//REQUEST	參數account, pwd
	//RESPONSE	字串[登入訊息代碼:登入訊息:登入失敗次數:是否註冊代碼:???]
	//
	//20171007建立(Gamin)
	//session_start();
	//ini_set('date.timezone','Asia/Shanghai');
	include( '../devInclude/includeBaseV2.php' ); //各類include檔案

	/*
	//預防系統外程式進入
	//登入需於登入頁取得登入權限-用戶IP為cache標示, 時間為cache內容, 限時120秒
	$sys		= new TaoginStationEG;
	$cacheName	= $sys->userIP;
	$rc			= new redisCache;
	$rcStatus	= $rc->getVar( $cacheName );
	if( $rcStatus == 'setData' || $rcStatus == 'waitData' ) die( '111:none' );
	
	$rc->delVar( $cacheName );
	*/

	if( empty( $_REQUEST['account'] ) || empty( $_REQUEST['pwd'] ) ) die( '13:请确认登入帐号、密码:::' );

	$acrc		= new redisCache();
	$uCountTag	= 'countAction'.$_REQUEST['account'];
	$uCount		= $acrc->getVar( $uCountTag );
	$uCountArr	= json_decode( $uCount, true );

	if( !is_array( $uCountArr ) ) $uCountArr['counts'] = 0;
	$uCountArr['counts']++;
	$acrc->setVar( $uCountTag, json_encode( $uCountArr ), 60 );
	if( $uCountArr['counts'] > 6 )
	{
		echo sprintf( '%s:%s:%s:%s:%s', 60, '您登入次数过于频繁，请于60秒钟后再尝试', $uCountArr['counts'], 0, $uCount );
	}
	else
	{
		$resultArr = getLogin( $_REQUEST );

		if( $resultArr['type'] == 1 ) $_SESSION["WEB2"] = array( 'id' => $resultArr['id'], 'MemID' => $resultArr["username"], 'userid' => $resultArr['userid'], 'rgAccount' => $resultArr["username"], 'rgPwd' => $_REQUEST['pwd'] );
		
		echo sprintf( '%s:%s:%s:%s:%s', $resultArr['type'], $resultArr['message'], $resultArr['errorcount'], $resultArr['firstLogin'], json_encode( $resultArr ) );
	}
?>