<?php
	include( 'config.php' );

	$Arr=$_POST;
	$inspection=$_POST['inspection'];

	actionLogs( '', 'start', 'register' );
	
	switch ($inspection)
	{
		case 'ckCode'://驗證碼確認
			
			if( empty( $_POST['mobile'] ) || empty( $_REQUEST['ckCode'] ) ) die( '{"reCode":"101","reMsg":"数据有误"}' );
			$inPhone = $_POST['mobile'];
			$rc		 = new redisCache;
			$smsCode = $rc->getVar( 'SMSCode'.$inPhone );
			if( $smsCode == 'waitData' || $smsCode == 'setData' )	die( '{"reCode":"102","reMsg":"验证码失效，请重新发送！"}' );
			if( $smsCode != $_REQUEST['ckCode'] )					die( '{"reCode":"103","reMsg":"验证码错误，请重新确认或发送！"}' );
			$rc->setVar( 'registerSMS'.$_POST['mobile'], 'PASS', 300 );
			$rc->delVar( 'SMSCode'.$inPhone );
			die( '{"reCode":"000","reMsg":"验证完成"}' );
		break;
		case '1'://先檢查手機號碼
			actionLogs( '', 'ckMobile&SMSCode REQUEST', 'register' );

			// $mArr				= explode( '-', $_POST['mobile'] );
			// $Arr['mobile']		= $mArr[1];
			$sendArr['phone']	= $_POST['mobile'];
			
			$cked = $rc->getVar( 'SMSCode'.$_POST['mobile'] );
			if( $cked != 'waitData' && $cked != 'setData' ) die( '{"reCode":"104","reMsg":"重复发送，未收到请稍候五分钟再重发"}' );//$mobileresult );
			
			$mobileresult		= getCheckRegisterMobile( $Arr );
			actionLogs( 'mobileresult:'.$mobileresult, 'ckMobile&SMSCode RESPONSE', 'register' );
			if( $mobileresult != 'ok' ) die( '{"reCode":"666","reMsg":"「'.$sendArr['phone'].'」此手机号已绑定"}' );//$mobileresult );
			//20180823 test
			$result = sendSMSCode( $sendArr ); //測完要開
			//$result = '000:1234';//測試使用 測完要關
			$reArr	= explode( ':', $result );
			actionLogs( $result, 'ckMobile&SMSCode RESPONSE', 'register' );
			if( $reArr[0] == '000' && !empty( $reArr[1] ) )
			{
				$rc->setVar( 'SMSCode'.$_POST['mobile'], $reArr[1], 300 );
				die( sprintf( '{"reCode":"%s","reMsg":"%s"}', $reArr[0], '验证码已发送至您的手机号' ) );
			}
			die( sprintf( '{"reCode":"%s","reMsg":"%s"}', $reArr[0], $reArr[1] ) );
		break;
		case  '2'://在檢查會員資料
			actionLogs( 'Step Start', 'addMember', 'register' );
			
			$mobileCK = $rc->getVar( 'registerSMS'.$_POST['mobile'] );
			if( $mobileCK != 'PASS' ) die( '102:手机号认证失效' );
			
			//$mArr			= explode( '-', $_POST['mobile'] );
			//$Arr['mobile']	= $mArr[1];
			$Arr['mobile']	= $_POST['mobile'];
			/*20180822 add by nillie 需記錄國碼為註冊會員新參數，尚未正式上線*/
			//$Arr['countryCode']	= $mArr[0];
			if( empty( $_SESSION["WEB2"]['MemID'] ) )//新帳號檢查選單列表
			{
				$tagName = 'Register_'.$sys->userIP;	//記錄cache索引名稱 Register_+使用者IP / config.php已啟動$sys
				$acCache = $rc->getVar( $tagName );		//取得Cache帳號選單，驗證資料，十分鐘有效
				if( $acCache == 'setData' || $acCache == 'waitData' ) die( '101:操作逾时或错误，请重新整理页面后再尝试' );
				$rc->delVar( $tagName );				//讀取後，刪除Cache記錄，防止重發狀況
				
				//檢驗發送帳號&Cache選單是否符合
				$acCheck	= 0;
				$acArr		= json_decode( $acCache, true );
				while( list( $i ) = @each( $acArr ) )
				{
					if( $_POST['userName'] == $acArr[$i] ) $acCheck = 1;
				}
				if( !$acCheck ) die( '103:数据错误，请重新整理页面后再尝试' );
				$Arr['userName'] = $_POST['userName'];
				$memberesult = ( $Arr['mobile'] == '0976798808' ) ? 'success' : addMember( $Arr ) ;//20180823 test 電話記得改回來
				actionLogs( json_encode( $memberesult ), 'Register Member() RESPONSE', 'register' );
				if( $memberesult['error_code'] == 'null' || empty( $memberesult['error_code'] ) )	die( '111:注册申请已送出，请进行登入' ); 
				elseif( $memberesult['error_code'] == '1' ) die( $memberesult['error_code'] ); 
				echo $memberesult['error_code'].':注册会员失败，请重新整理页面后再尝试';
			}
			else
			{
				$Arr['userName'] = $_SESSION["WEB2"]['MemID'];
				$SetUserBaseresult	= SetUserBase( $Arr );
				actionLogs( $SetUserBaseresult, 'Register SetUserBase() RESPONSE', 'register' );
				echo 1;
			}
		break;
		default:
		
		echo 'none';
		break;
	}
?>