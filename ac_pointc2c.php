<?php
	//20180612調整cache時效300>180 Gamin
	include( '../devInclude/includeBaseV2.php' );	//各類include檔案

	$step=(!isset($_POST['step']))?1:$_POST['step'];
	$userinfo = getUserUpdate();

	//未登入，不可進行程序181017Gamin
	if( !empty( $userinfo[0]['changeMessage'] ) )
	{
		//清除cache
		$tagName	= $_SESSION['WEB2']['MemID'].'_MemberInfo';
		$rc			= new redisCache;
		$rc->delVar( $tagName );

		unset( $_SESSION['WEB2'] );
		unset( $_SESSION["Register"] );
		unset( $_SESSION );

		$result['reCode']='111';
		$result['reMsg'] ='请重新登入';
		echo json_encode($result);
		die();
	}
	
	$um = @explode( '-', $userinfo[0]['mobile'] );
	$rc		 = new redisCache;
	switch ($step) {
		case 1://确认简讯
			$testMobile = array( '886-0976798808', '886-0928909967111' );
			$ckSMS = $rc->getVar('smscode4'.$_SESSION["WEB2"]['userid']);
			if( $ckSMS != 'setData' && $ckSMS != 'waitData' )
			{
				$result = 'C2C01:验证码已发送，请稍后再试';
				actionLogs( $result, 'RESULT' );
				echo $result;
				break;
			}
			
			if( empty( $um[1] ) )
			{
				$userMobile['phone'] = $um[0];
			}
			else
			{
				$userMobile['phone'] = $um[1];
				$userMobile['countryCode'] = $um[0];
			}
			$Arr['phone']	= $_POST['area'].'-'.$userMobile['phone'];
			$rc->setVar('countrycode'.$_SESSION["WEB2"]['userid'],$_POST['area'],180);
			actionLogs( $Arr['phone'], 'sendSMSCode' );
			$sms = ( in_array( $Arr['phone'], $testMobile ) ) ? '000:5678' : sendSMSCode( $Arr ) ;
			$smscode		= explode(':', $sms);
			$rc->setVar('smscode4'.$_SESSION["WEB2"]['userid'],$smscode[1],180);
			echo $sms;
			actionLogs( $sms, 'RESULT' );
			break;
		case 2://确认账号
			$Arr['ckUserName']=$_POST['ckUserName'];
			$Arr['smscode']=$_POST['smscode'];
			$code=$rc->getVar('smscode4'.$_SESSION["WEB2"]['userid']);
			if($Arr['smscode']!=$code)
			{
				$result = '验证码错误';//$Arr['smscode'].'+'.$code.'/'.$_SESSION["WEB2"]['userid'];
				actionLogs( $result, 'RESULT' );
				echo $result;
				break;
			}
			$ckusername=ckIsUserName($Arr);
			if($ckusername['reCode']=='0000')
			{
				echo $ckusername['reCode'];
				$rc->setVar( 'incomeUid'.$_SESSION["WEB2"]['userid'], $ckusername['incomeUid'], 180 );
			}
			else
			{
				echo $ckusername['reMsg'];
			}
			
			break;
		case 3://执行互转
			$ssTag = 'quota'.$_SESSION["WEB2"]['id'];
			$quota = $rc->getVar( $ssTag );
			actionLogs( 'ssTag:'.$ssTag.', ssVar:'.$quota, 'GET CACHE C2C' );
			if( $quota == 'setData' || $quota == 'waitData' )
			{
				$result['reCode']='004';
				$result['reMsg'] ='操作逾时，请至交易明细确认结果';
				actionLogs( array2Str( $result ), 'RESULT' );
				echo json_encode($result);
				break;
			}
			$rc->delVar( $ssTag );//181013避免重複執行Gamin
			
			$Arr['incomeUid']=$rc->getVar('incomeUid'.$_SESSION["WEB2"]['userid'] );
			$Arr['incomeUserName']=$_POST['ckUserName'];
			$Arr['amount']=$_POST['amount'];
			$Arr['withdrawpassword']=$_POST['wdpw'];
			$Arr['receivePwd']=$_POST['wdpw'];
			$pwdresult=ckReceivePwd( $Arr );
			if($quota-$_POST['amount']<0)
			{
				$result['reCode']='003';
				$result['reMsg'] ='转出金额超过帐户余额';
			}
			else if($pwdresult!='000')
			{
				$result['reCode']='002';
				$result['reMsg'] ='交易密码错误';
			}
			else
			{
				$result = financeC2C($Arr);
			}
			actionLogs( array2Str( $result ), 'RESULT' );
			echo json_encode($result);
			if($result['reCode']='0000' && empty($um[1]))
			{
				$Arr['countryCode']=$rc->getVar('countrycode'.$_SESSION["WEB2"]['userid']);
				$Arr['mobile']=$um[0];
				//print_r($Arr);
				$save_countrycode=storeMobile($Arr);
				//echo 'save_countrycode='.$save_countrycode;
			}
			$rc->delVar('smscode4'.$_SESSION["WEB2"]['userid']);
			$rc->delVar('incomeUid'.$_SESSION["WEB2"]['userid'] );
			$rc->delVar('countrycode'.$_SESSION["WEB2"]['userid']);
			break;
		default:
			echo '1';
			break;
	}
?>