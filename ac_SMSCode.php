<?php
	//發送手機驗證碼
	//使用Redis元件/devInclude/class_redisCache.php
	//使用共用函式 /devInclude/netFunctionV2.php
	
	//20171008建立(Gamin)
	//帶入phone參數886-0911234567
	//取得設定—重複限制記錄	$Redis->getVar( $_REQUEST['phone'] )		=> $Redis->getVar( '886-0911234567' )
	//取得設定—確認驗證碼	$Redis->getVar( 'SMS'+$_REQUEST['phone'] )	=> $Redis->getVar( 'SMS886-0911234567' )

	include( '../devInclude/class_redisCache.php' );
	include( '../devInclude/netFunctionV2.php' );//xml_to_array()

	smsLog( '', 'start' );
	if( empty( $_REQUEST['phone'] ) ) die( '101:None' );

	$inPhone = $_REQUEST['phone'];
	$ar		 = explode( '-', $inPhone );
	if( count( $ar ) < 2 ) die( '102:Fail' );//不符合規格
	
	$rc		= new redisCache;
	//連續請求限制
	$status = $rc->getVar( $inPhone );
	if( $status == 'waitData' || $status != 'setData' ) die( '103:Retry' );
	$rc->setVar( $inPhone, '-', 60 ); //設定請求重複限制
	//已發送限制
	$status = $rc->getVar( 'SMS'.$inPhone );
	if( $status == 'waitData' ) die( '107:Wait' );
	if( $status != 'setData' )	die( '104:你已经重覆发送，于5分钟后再发送！' );

	if( $ar[0] == '86' )
	{
		$phone = $ar[1];
		$ph = $phone;
	}
	else
	{
		$gg = substr( $ar[1], 1, strlen( $ar[1] ) );
		$phone = $ar[0].' '.$gg;
		
		$inArr = array( '853', '81', '60', '84', '62', '66', '61', '65', '63', '971', '855' );
		if( $ar[0]=='886' || $ar[0]=='852' )
		{
			$ph = '0'.$gg;
		}
		else if( in_array( $ar[0], $inArr ) )
		{
			$ph = $ar[0].$ar[1];
		}
	}

	$pass = random_mun();

	$sms = ( substr( $phone, 0, 1 ) == '1' ) ? sms_get_china_two( $pass, trim( $phone ) ) : sms_get_two( $pass, trim( $phone ) ) ;
	
	if( $sms['error_code'] == '000' || $sms['SubmitResult']['code']=='2' )
	{
		$rc->setVar( 'SMS'.$inPhone, $pass, 300 );//設定驗證碼
		die( '000:SUCCESS' );
	}
	
	if( empty( $ph ) ) die( '105:None' );
	$sec = json_decode( sms_get( $pass, $ph ) );
	if( $sec->error_code == '000' )
	{
		$rc->setVar( 'SMS'.$inPhone, $pass, 300 );//設定驗證碼
		die( '000:SUCCESS' );
	}
	echo '106:Fail' ;

	//產生驗證碼
	function random_mun( $length=4 )
	{
		$randomString = substr( str_shuffle( "0123456789" ), 0, $length );
		return $randomString;
	}
	//簡訊
	function sms_get( $msg, $phone )
	{
		$arr['url']	 = 'http://sms-get.com/api_send.php';
		$arr['data'] = array( "username" => 'linbowei', "password" => 'lin8888', "method" => '1', "sms_msg" => urlencode( $msg ), "phone" => $phone );
		smsLog( json_encode( $arr ), 'SMS-REQUEST' );
		$ch = curl_init( $curl_url_sms );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );//把$result轉成values
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER , false );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $arr['data'] );
		$result = curl_exec($ch);
		curl_close($ch);
		smsLog( $result, 'SMS-RESPONSE' );
		return $result;
	}
	//簡訊2
	function sms_get_two( $msg, $phone )
	{
		$pwd		 = '63a0bfea99b98a5096dd928ffa5cb6a9';//nation
		$arr['data'] = "account=cf_taogin8888&password=".$pwd."&mobile=".$phone."&content=".rawurlencode( "Your verification code is ".$msg );
		$arr['url']  = "http://api.isms.ihuyi.cn/webservice/isms.php?method=Submit";
		$result		 = smsCurl( $arr );
		return xml_to_array( $result );
	}
	//簡訊
	function sms_get_china_two( $msg, $phone )
	{
		$pwd		 = '676315c5b2a83418b6702e356f116d29';	//nation
		$arr['data'] = "account=cf_taogin8888&password=".$pwd."&mobile=".$phone."&content=".rawurlencode( "您的验证码是：".$msg."。请不要把验证码泄露给其他人。" );
		$arr['url']  = "https://106.ihuyi.com/webservice/sms.php?method=Submit";
		$result		 = smsCurl( $arr );
		return xml_to_array( $result );
	}
	function smsCurl( $arr )
	{
		smsLog( json_encode( $arr ), 'SMS-REQUEST' );
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $arr['url'] );
		curl_setopt( $curl, CURLOPT_HEADER, false );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_NOBODY, true );
		curl_setopt( $curl, CURLOPT_POST, true );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $arr['data'] );
		$result = curl_exec( $curl );
		curl_close($curl);
		smsLog( $result, 'SMS-RESPONSE' );
		return $result;
	}
	function smsLog( $info='', $type='start', $kind='sms' )
	{
		$logPath = '/var/www/wa99logs/'.$kind.'/';
		$logFile = $logPath.'/'.date( 'Ymd' ).'.log';
		
		if( !is_dir( $logPath ) )
		{
			$oldumask = umask(0);
			mkdir( $logPath, 0777, true );
			umask( $oldumask );
		}

		if( $type == 'start' )
		{
			file_put_contents( $logFile, "\r\n", FILE_APPEND );
			file_put_contents( $logFile, "---------------------------------------------------------------------", FILE_APPEND );
			file_put_contents( $logFile, "\r\n", FILE_APPEND );
			file_put_contents( $logFile, 'START|'.$_SERVER['HTTP_HOST']."|".date( 'Y-m-d H:i:s' )."|".$_SERVER["REMOTE_ADDR"]."|".$_SERVER["HTTP_REFERER"]."|".$_SERVER["REQUEST_URI"]."|".array2Str( $_REQUEST ), FILE_APPEND );
			file_put_contents( $logFile, "\r\n", FILE_APPEND );
		}
		else
		{
			file_put_contents( $logFile, $type."|".date( 'Y-m-d H:i:s' )."|".trim( $info ), FILE_APPEND );
			file_put_contents( $logFile, "\r\n", FILE_APPEND );
		}
	}
?>