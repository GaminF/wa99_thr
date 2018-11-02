<?php
	$cType	= array( 'member', 'c2_game', 'acc', 'newmember' );

	$ac = ( $_GET['ac'] ) ? 1 : 0 ;
	
	$cUrl[1]	= array( 1=>'http://119.81.168.34/iapi/post.php',							//賽事列表|登入|登入檢查.....
					 9=>'http://119.81.168.34/cgi-bin/communication/historyGame.py',	//對戰記錄
					10=>'http://119.81.168.34/api_center/finance/findex.php',			//會員資料－出入帳。會員帳戶 / Gamin
					11=>'http://119.81.168.34/api_center/payway/',						//第三方支付-智付寶 / Gamin
					12=>'http://104.199.182.140/paysys/paywayEG2.php',
					13=>'http://104.199.182.140/apiCenter/sms/smsCode.php'
					);
	$cUrl[0]	= array( 1=>'http://35.197.97.179/bb/iapi/post.php',							//賽事列表|登入|登入檢查.....
					 9=>'http://35.197.97.179/bb/cgi-bin/communication/historyGame.py',	//對戰記錄
					10=>'http://35.197.97.179/bb/api_center/finance/findex.php',			//會員資料－出入帳。會員帳戶 / Gamin
					11=>'http://35.197.97.179/bb/api_center/payway/',						//第三方支付-智付寶 / Gamin
					12=>'http://104.199.182.140/paysys/paywayEG2.php',
					13=>'http://104.199.182.140/apiCenter/sms/smsCode.php'
					);

	global $ApiArr;

	$ApiArr	= Array( 'subscribeeasylist'		=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'subscribeeasylist' ) ),
					 'gameHistoryDetail'		=>array( 'url'=>$cUrl[$ac][1], 'cache'=>'openDate','cacheTime'=>60,'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[2], 'function_name' => 'gameHistoryDetail' ) ),
					 'c2gameslist'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>1,		'cacheTime'=>30,	'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'c2gameslist' ) ),
					 'c2gselectlist4'			=>array( 'url'=>$cUrl[$ac][1], 'cache'=>'gameid','cacheTime'=>20,	'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'c2gselectlist4' ) ),
					 'C2GameSetBet'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'C2GameSetBet' ) ),
					 'c2gameselectname'			=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'c2gameselectname' ) ),
					 'c2gamecategoryarray'		=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'c2gamecategoryarray' ) ),
					 'c2subscribebetlist'		=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'c2subscribebetlist' ) ),
					 'c2historysubscribebetlist'=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'c2historysubscribebetlist' ) ),
					 'subscribeeasyNew'			=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'subscribeeasyNew' ) ),
					 'c2subscribebetupdate'		=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'c2subscribebetupdate' ) ),
					 'c2GetSubscribeBetInfo'	=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'c2GetSubscribeBetInfo' ) ),
					 'c2subscribebet'			=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'c2subscribebet' ) ),
					 'c2GetNoticeInfo'			=>array( 'url'=>$cUrl[$ac][1], 'cache'=>1,		'cacheTime'=>120,	'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'c2GetNoticeInfo' ) ),
					 'userHistoryDetail'		=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[2], 'function_name' => 'userHistoryDetail' ) ),
					 'userHistoryAmount'		=>array( 'url'=>$cUrl[$ac][1], 'cache'=>2,		'cacheTime'=>60,	'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[2], 'function_name' => 'userHistoryAmount' ) ),
					 'listMoneySave'			=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'listMoneySave' ) ),
					 'saveMoney'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'saveMoney' ) ),
					 'c2GetMatchBetInfo'		=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'c2GetMatchBetInfo' ) ),
					 'KeepAlive'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>0, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'KeepAlive' ) ),
					 'MemberInfo'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>2,		'cacheTime'=>60,	'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'MemberInfo' ) ),
					 'quotaupdate'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'quotaupdate' ) ),
					 'memberlogin'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>0, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'memberlogin' ) ),
					 'onlinenumber'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>1,		'cacheTime'=>30,	'ckSession'=>0, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'onlinenumber' ) ),
					 'marketnumber'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[1], 'function_name' => 'marketnumber' ) ),
					 'securityQuestion'			=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'securityQuestion' ) ),
					 'usernamelist'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'usernamelist' ) ),
					 'memberadd'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>0, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'memberadd' ) ),
					 'usernamelist_agent'		=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>0, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'usernamelist' ) ),
					 'updategetuser'			=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[3], 'function_name' => 'updategetuser' ) ),
					 'userpickup'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[3], 'function_name' => 'userpickup' ) ),
					 'updateUserBetsize'		=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'updateUserBetsize' ) ),
					 'siteStatus'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>1,		'cacheTime'=>20,	'ckSession'=>0, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'siteStatus' ) ),
					 'mobilecheck'				=>array( 'url'=>$cUrl[$ac][1], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>0, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'mobilecheck' ) ),
					 'getReceiveFee'			=>array( 'url'=>$cUrl[$ac][10], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>0, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'getReceiveFee' ) ),
					 'getUserBase'				=>array( 'url'=>$cUrl[$ac][10], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'getUserBase' ) ),
					 'getBankList'				=>array( 'url'=>$cUrl[$ac][10], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'getBankList' ) ),
					 'bankInfo'					=>array( 'url'=>$cUrl[$ac][10], 'cache'=>1,		'cacheTime'=>2,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'bankInfo' ) ),
					 'SetUserBase'				=>array( 'url'=>$cUrl[$ac][10], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>0, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'SetUserBase' ) ),
					 'addUserBank'				=>array( 'url'=>$cUrl[$ac][10], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'addUserBank' ) ),
					 'ckReceivePwd'				=>array( 'url'=>$cUrl[$ac][10], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'ckReceivePwd' ) ),
					 'delUserFinance'			=>array( 'url'=>$cUrl[$ac][10], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'delUserFinance' ) ),
					 'getUserAccountName'		=>array( 'url'=>$cUrl[$ac][10], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'getUserAccountName' ) ),
					 'ckIsUserName'				=>array( 'url'=>$cUrl[$ac][10], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'ckIsUserName' ) ),
					 'financeC2C'				=>array( 'url'=>$cUrl[$ac][10], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'financeC2C' ) ),
					 'ckIsRecive8C2C'			=>array( 'url'=>$cUrl[$ac][10], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'ckIsRecive8C2C' ) ),
					 'payOrder'					=>array( 'url'=>$cUrl[$ac][11], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'payOrder' ) ),
					 'notifyOrder'				=>array( 'url'=>$cUrl[$ac][11], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'class_name' => $cType[0], 'function_name' => 'notifyOrder' ) ),
					 'pkRecord'					=>array( 'url'=>$cUrl[$ac][9], 'cache'=>'event',	'cacheTime'=>60,	'ckSession'=>0, 'postArr'=>array( 'function_name' => 'pkRecord' ) ),
					 'smsCode'					=>array( 'url'=>$cUrl[$ac][13], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'function_name' => 'smsCode' ) ),
					 'pay3Way'					=>array( 'url'=>$cUrl[$ac][12], 'cache'=>0,		'cacheTime'=>0,		'ckSession'=>1, 'postArr'=>array( 'function_name' => 'pay3Way' ) )
	);

	function getCacheX( $arr )
	{
		$rc = new redisCache;
		$tagName = getCacheTagName( $arr );//選定類別組合標籤
		if( $_REQUEST['debug'] ) echo 'CacheName['.$tagName.']<br>';
		$rcStatus = $rc->getVar( $tagName );
		if( $rcStatus == 'setData' ) return false;
		if( $rcStatus == 'waitData' )//進行等待動作
		{
			$x = 0;
			do{
				$x++;
			}while( $x <= 20000000 );
		}
		return $rc->getVar( $tagName );
	}
	
	//設定cache
	//val空值時Redis無法設定Cache
	function setCache( $arr )
	{
		if( empty( $arr['tagName'] ) || empty( $arr['val'] ) ) return false;
		$rc = new redisCache;
		$rc->setVar( $arr['tagName'], $arr['val'], $arr['time'] );
		return true;
	}

	//設定cache類別組合標籤
	//cache依照不同代碼，進行不同cacheTagName設置
	//1=function_name(共用資料), 2=username_function_name, 其他類-例:day>gameHistoryDetail_2017-11-11
	function getCacheTagName( $arr )
	{
		if( $arr['postArr']['function_name'] == 'c2GetNoticeInfo' )
		{
			$tagName = ( $arr['postArr']['type'] != 3 ) ? $arr['postArr']['function_name'] : $_SESSION['WEB2']['MemID'].'_'.$arr['postArr']['function_name'] ;
		}
		elseif( $arr['cache'] == 1 )
		{
			$tagName = $arr['postArr']['function_name'] ;
		}
		elseif( $arr['cache'] == 2 )//PJ888_userHistoryAmount
		{
			$tagName = $arr['postArr']['username'].'_'.$arr['postArr']['function_name'] ;
		}
		elseif( $arr['cache'] == 3 )
		{
			$tagName = $arr['postArr']['id'].'_'.$arr['postArr']['function_name'] ;
		}
		else
		{
			$tagName = $arr['postArr']['function_name'].'_'.$arr['postArr'][$arr['cache']];
		}
		return $tagName;
	}
	
	function getCurlResult( $DataArr )
	{
		$onServer = ( $_SERVER['HTTP_HOST'] == '127.0.0.1' ) ? 0 : 1 ;//是否為線上機，用於能否使用Redis機制
		if( $_GET['debug'] ) { echo '<pre>'; print_r( $DataArr ); }
		actionLogs( array2Str( $DataArr['postArr'] ), 'REQUEST' );
//必要登入身分if( !$_SESSION["WEB2"]['MemID'] && $DataArr['ckSession'] ) return '';

		$dataSource = 'CACHE';
		//使用&取得cache記錄 cache有設定 && 且不為開發本機 && 未設不使用cache(有值則不使用cache)
		if( $DataArr['cache'] && $onServer && empty( $_REQUEST['noCache'] ) ) $ResultArr = getCacheX( $DataArr );
		
		//無cache，進行API取得資料
		if( !$ResultArr )
		{
			$dataSource = 'API';
			//特例API使用無wa99標示，只有pkRecord，待建議合併入wa99行列
			$curlArr	= ( $DataArr['postArr']['function_name'] == 'pkRecord' ) ? $DataArr['postArr'] : array( "wa99" => json_encode( $DataArr['postArr'] ) ) ;
			if( $_GET['debug'] ) { print_r( $curlArr ); }
			$ResultArr	= curlResult( $DataArr['url'], $curlArr );
			if( $_GET['debug'] ){ echo $ResultArr; }
			//設定cache
			if( $DataArr['cache'] ) 
			{
				$arr['tagName'] = getCacheTagName( $DataArr );
				$arr['val']		= $ResultArr;
				$arr['time']	= ( $DataArr['cacheTime'] ) ? $DataArr['cacheTime'] : 10 ;
				if( $onServer ) setCache( $arr );
			}
		}
		if( $DataArr['postArr']['function_name'] != 'c2GetNoticeInfo' ) actionLogs( $dataSource.'|'.$ResultArr, 'RESPONSE' );//減少檔案量
		if( $DataArr['postArr']['function_name'] == 'c2gselectlist4' ) $ResultArr = str_replace( "expired", "", $ResultArr );
		if( $_GET['debug'] )echo 'result json:'.$ResultArr;
		$result = json_decode(urldecode($ResultArr), true);
		if( $_GET['debug'] ){ echo 'dataSource:'.$dataSource.'<p>'; print_r( $result ); }
		return $result;
	}

	function testCurl( $DataArr )
	{
		$onServer = ( $_SERVER['HTTP_HOST'] == '127.0.0.1' ) ? 0 : 1 ;//是否為線上機，用於能否使用Redis機制
		echo '<pre>';
		print_r( $DataArr );
		$ResultArr	= curlResult( $DataArr['url'], $DataArr['postArr'] );
		echo '<br>RESULT:'.$ResultArr.'<br>';
		return json_decode( urldecode( $ResultArr ), true );
	}
	
	function curlResult( $cUrl, $data )
	{
		$ch = curl_init( $cUrl );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST		, "POST" );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER	, true );
		curl_setopt( $ch, CURLOPT_TIMEOUT			, 10 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER	, false );
		curl_setopt( $ch, CURLOPT_POSTFIELDS		, array( 'wa99'=>json_encode( $data ) ) );
		curl_setopt( $ch, CURLOPT_ENCODING			, "gzip");
		$result = curl_exec( $ch );
		curl_close( $ch );
		return $result;
	}

	/* 網站狀態 [000]開啟 [900]P測試模式 [999]維護中 */
	function siteStatus()
	{
		global $ApiArr;
		return testCurl( $ApiArr['siteStatus'] );
	}
	function getLogin( $Arr='' )
	{
		global $ApiArr;
		$StepTag = 'memberlogin';
		$ApiArr[$StepTag]['postArr']['username'] = 'PJ888';
		$ApiArr[$StepTag]['postArr']['password'] = 'a111111';
		$ApiArr[$StepTag]['postArr']['UserIP']	 = '127.0.0.1';
		$ApiArr[$StepTag]['postArr']['ServerIP'] = $_SERVER['HTTP_HOST'];
		return testCurl( $ApiArr[$StepTag] );
	}
	/* 會員資訊 */
	function getMemberInfo( $Arr='' )
	{
		global $ApiArr;
		$StepTag = 'MemberInfo';
		$ApiArr[$StepTag]['postArr']['id']		 = $Arr['id'];
		$ApiArr[$StepTag]['postArr']['username'] = $Arr['username'];
		return testCurl( $ApiArr[$StepTag] );
	}
	
	echo 'TEST:'.curlResult( 'http://119.81.168.34/iapi/testJson.php', array( 'pp'=>'1234' ) );
	echo '<p>';
	
	siteStatus();
	$result = getLogin();
	echo '---------------<p>';
	print_r( $result );
	getMemberInfo($result);
?>