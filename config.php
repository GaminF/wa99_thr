<?php
	/*
	header("location: maintainTime.php");
	die();
	*/
	//$sys通用檢查元件
	//siteInfo	網站通用參數Arr
	//$mbInfoArr會員基本資料參數Arr
	$online = ( $_SERVER['HTTP_HOST'] == '127.0.0.1' ) ? 0 : 1 ;
	if( $online )
	{
		include( '../devInclude/includeBaseV2.php' );	//各類include檔案

		if( $_REQUEST['debug'] ){ echo '<pre>'; print_r( $_SESSION ); }

		$sysType	= 'WEB';							//選項 [ MOBILE | WEB ]
		$siteInfo	= array( "interface"=>"v2" );		//由網址取得代理與介面樣式

		//kindArr充值使用類別
		$kindArr = array( 1=>array( "kindName"=>"网络银行"	, 'paychname'=>'' ),
						  2=>array( "kindName"=>"临柜汇款"	, 'paychname'=>'' ),
						  3=>array( "kindName"=>"支付宝"	, 'paychname'=>'alipay_scan' ),
						  4=>array( "kindName"=>"微信"		, 'paychname'=>'weixin_scan' ),
						  5=>array( "kindName"=>"QQ"		, 'paychname'=>'tenpay_scan' )
						);

		//檢驗元件
		global $sys;
		$sys = new TaoginStationEG;

		//臨時關閉
		//$sys->redirectUrl( 'maintainTime.php' );

		//版本檢驗		— WEB|MOBILE
		//if( $sys->userAgentSystem != $sysType )		$sys->redirectUrl( 'http://tg333.net' );
		
		//獲取系統檢驗項目
		$sys->systemCheck();
		
		//IP檢驗 — 區域限制8IP — 黑白名單
		if( $sys->userIpPermission != 'PASS' )		$sys->redirectUrl( 'noService.php' );
		//if( !empty( $_SESSION["WEB2"]['MemID'] ) && strtoupper( substr( $_SESSION["WEB2"]['MemID'], 0, 1 ) ) != 'P' ) $sys->redirectUrl( 'noService.php' );
		
		//網站狀態檢驗 [ 000|900|999 ] 維護公告頁
		if( ( !is_array( $sys->systemStatus ) || $sys->systemStatus['errorCode'] == '999' ) && !strpos( $_SERVER["REQUEST_URI"], "maintain.php" ) )	$sys->redirectUrl( 'maintain.php' );//API未通||系統維護狀態，顯示維護頁

		//啟用cache元件8redisCache
		$rc = new redisCache;
		
		if( empty( $_SESSION["WEB2"]['MemID'] ) )//未登入
		{
			//設定登入序號，登入驗證使用，應於login介面時產生
			$tagName = $sys->userIP;
			$rc->setVar( $tagName, time(), 300 );
		}
		else//已登入
		{
			//取得會員資料
			$mbInfoArr = getMemberInfo();
			$mbInfoArr['quotaView'] = number_format( $mbInfoArr['quota'], 2, '.', ',' );

			if( $_SESSION["WEB2"]['MemID'] && $mbInfoArr['errorCode'] != 'OK'  ) $sys->redirectUrl( 'logout.php' );
			
			//獲取使用者檢驗項目
			$sys->userCheck();
			actionLogs( 'Ready....widthdrawpassword:'.$mbInfoArr['widthdrawpassword'], 'Config Check*************' );
			if( !strpos( $_SERVER["REQUEST_URI"], "register.php" ) && !strpos( $_SERVER["REQUEST_URI"], "ac_register.php" ) )
			{
				actionLogs( 'Ready....', 'Config Check*************111111' );
				if( empty( $sys->userAlive['errorCode'] ) ) $sys->redirectUrl( 'logout.php' );		//會員登入狀況
				if( $mbInfoArr['widthdrawpassword'] == 0 )	$sys->redirectUrl( 'register.php' );	//第一次登入, 設定會員帳戶資料//
			}
			//跑馬燈-公告
			$getNoticeArr		= array( 'type'=>2, 'maxnumber'=>200, 'number'=>0 );
			$siteInfo['notice']	= getNotice( $getNoticeArr );//公告訊息
			rsort($siteInfo['notice']);
			//跑馬燈-公告。設定顯示五則
			//print_r( $siteInfo['notice'] );
			while( list( $i ) = @each( $siteInfo['notice'] ) )
			{
				//if( empty( $siteInfo['notice'][$i] ) ) continue;
				if( $siteInfo['notice'][$i]['noticshow'] != 1 ) continue;
				$marquee[] = sprintf( '「%s」%s', $siteInfo['notice'][$i]['notictitle'], $siteInfo['notice'][$i]['noticcontents'] );
			}
			$siteInfo['marquee'] = @implode( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $marquee );
		}

		$siteInfo['onlineNum'] = getOnLineUser();
		
		//網站上顯示之基準時間(Javascript)
		$siteInfo['year']	 = date( 'Y' );
		$siteInfo['mon']	 = date( 'm' );
		$siteInfo['mday']	 = date( 'd' );
		$siteInfo['hours']	 = date( 'H' );
		$siteInfo['minutes'] = date( 'i' );
		$siteInfo['seconds'] = date( 's' );
	}
	else//免用RedisCache + 使用測試模擬資料
	{
		session_start();
		include( 'TaoginApiNillie.php' ); 
		include("../devInclude/TemplatePower3.0.2.1/class.TemplatePower.inc.php");//各類include檔案
		$siteInfo = array( "interface"=>"v2" );//由網址取得代理與介面樣式
	}
	global $tpl;
?>