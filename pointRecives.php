<?php
	include( 'config.php' );
	//if( $sys->userAlive['errorCode'] != 'OK' ) $sys->redirectUrl( 'logout.php' );
	
	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/pointRecive.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );

	$Arr['uid']=$_SESSION["WEB2"]['id'];
	$Arr['userName'] =$_SESSION["WEB2"]['MemID'];

	$tpl->newBlock( 'widthdrawmoneyBlock');
	
		$feeresult=getReceiveFee( $Arr );
		$tpl->assign('fee',$feeresult['fee']);
		$tpl->assign('reached',$feeresult['reached']);
		$getUserBaseresult=getUserBase($Arr);//多次提領(有會員資料)
		//print_r($getUserBaseresult);

		if ($getUserBaseresult)//如果有會員資料 (多次提領)
		{
			$rc->setVar( 'UserBase'.$Arr['uid'], json_encode( $getUserBaseresult ), 600 );
			//print_r($getUserBaseresult);
			//$tpl->assign('action',$Arr['action']);
			$bankresult=$getUserBaseresult;
			while(list($key)=each($getUserBaseresult))
			{
				$tpl->assign($getUserBaseresult[$key]);
				$tpl->assign('accountName',$getUserBaseresult[$key]['aname']);
				$tpl->assign('bkid',$getUserBaseresult[$key]['bkid']);
				$tpl->assign('readonly','readonly');
			}
		}
		else
		{
			$bankresult=getBankList();//第一次提領(無會員資料)
		}

		while(list($key)=each($bankresult))
		{
			$tpl->newBlock('getBankListBlock');
			$tpl->assign($bankresult[$key]);
			
		}
			//$Arr['action']=$_GET['action'];					
			//echo "result:[".$result.']';
		//print_r($_GET);
		
		// //print_r($Arr);
		// echo '<br>';
		// //print_r($_GET);
	actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();
?>