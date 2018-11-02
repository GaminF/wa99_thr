<?php
	include( 'config.php' );
	if( $sys->userAlive['errorCode'] != 'OK' ) $sys->redirectUrl( 'logout.php' );
	
	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/pointRecive.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );
	$rc->setVar('quota'.$_SESSION["WEB2"]['id'],$mbInfoArr['quota'],300);
	$Arr['uid']=$_SESSION["WEB2"]['userid'];
	$Arr['userName'] =$_SESSION["WEB2"]['MemID'];
	/* 會員互轉開放限制
	$date=date("His");
	if($date>"210000" || $date<"020000")
	{
		$tpl->assign('status','0');//close
	}
	else
	{
		$tpl->assign('status','1');//open
	}
	*/
	if($mbInfoArr['withdrawmoneyblocked']==1)
	{
		$tpl->newBlock( 'widthdrawlockBlock');
	}
	else
	{
		$tpl->newBlock( 'widthdrawmoneyBlock');
		$feeresult=getReceiveFee( $Arr );
		$tpl->assign('fee',$feeresult['fee']);
		$tpl->assign('reached',$feeresult['reached']);
		$getUserBaseresult=getUserBase($Arr);//多次提領(有會員資料)
		$reservice=ckIsRecive8C2C($Arr);//檢查24HR內會員互轉是否有保留餘額
		if ($getUserBaseresult)//如果有會員資料 (多次提領)
		{
			$bankresult=$getUserBaseresult;
			while(list($key)=each($getUserBaseresult))
			{
				$tpl->assign($getUserBaseresult[$key]);
				$tpl->assign('accountName',$getUserBaseresult[$key]['aname']);
				$tpl->assign('bkid',$getUserBaseresult[$key]['bkid']);
				$tpl->assign('readonly','readonly');
			}
			while(list($key)=each($bankresult))
			{
				$tpl->newBlock('getBankListBlock');
				$tpl->assign( $bankresult[$key] );
			}
			$getUserBaseresult['times']		= 1;
			$getUserBaseresult['quota']		= $mbInfoArr['quota'];
			$getUserBaseresult['stayPoint'] = $reservice['stayPoint'];
			$rc->setVar( 'UserBase'.$Arr['uid'], json_encode( $getUserBaseresult ), 600 );
		}
		else
		{
			$actArr = getAccountName();
			$tpl->assign( 'accountName', $actArr['AccountName'] );
			
			$cacheArr['times'] = 0;
			$cacheArr['aname'] = $actArr['AccountName'];
			$cacheArr['quota'] = $mbInfoArr['quota'];
			$cacheArr['stayPoint'] = $reservice['stayPoint'];
			$rc->setVar( 'UserBase'.$Arr['uid'], json_encode( $cacheArr ), 600 );
			
			$bankresult=getBankList();//第一次提領(無會員資料)
			while(list($key)=each($bankresult))
			{
				$tpl->newBlock('getBankListBlock');
				$tpl->assign( $bankresult[$key] );
				$tpl->assign( 'bkid', $bankresult[$key]['id'] );
			}
		}

		if($reservice['stayPoint']>0)
		{
			$tpl->newBlock('reservicemoneyBlock');
			$tpl->assignGlobal('savenotice',$reservice['stayPoint']);
			$rc->setVar('savemoney'.$_SESSION["WEB2"]['userid'],$reservice['stayPoint'],300);
		}
	}

	actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();
?>