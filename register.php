<?php
	include( 'config.php' );

	$tpl=new TemplatePower( "interface/".$siteInfo['interface']."/html/register.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );


	if( isset( $_SESSION["WEB2"]['MemID'] ) )
	{
		if( $mbInfoArr['widthdrawpassword'] == 1 ) $sys->redirectUrl( './' );	//已註冊者，導向首頁
		$tpl->newBlock( 'SESSION_WEB2_MemIDBlock' );
		$tpl->assign  ( 'SESSION_WEB2_MemID', $_SESSION["WEB2"]['MemID'] );
	}
	else if( isset( $_GET['agent'] ) )
	{
		// 確認後台是否有此代理../devInclude/agent.php
		// 回覆代理id(11145), 不存在回覆(101:Confirm)
		$agentid	= getAid( $_GET['agent'] );
		$agent_us	= @explode( ':', $agentid );
		if( $agent_us[1] )
		{
			header( "Location:logout.php" );
			die();
		}

		$Arr['agentid'] = $_GET['agent'];
		$agentesult		= getUserNameList_Agent( $Arr['agentid'] );	//取得該代理帳號列表
		
		$tagName		= 'Register_'.$sys->userIP;					//記錄cache索引名稱 Register_+使用者IP / config.php已啟動$sys
		$rc->setVar( $tagName, json_encode( $agentesult ), 600 );	//Cache記錄帳號選單，執行註冊時驗證資料，十分鐘有效
		
		$tpl->newBlock('agentidBlock');
		$tpl->assign  ( 'agentid', $Arr['agentid'] );
		$tpl->newBlock( 'username_select_Block' );
		while( list( $key ) = each( $agentesult ) )
		{
			$tpl->newBlock( 'agentlistBlock' );
			$tpl->assign  ( 'username', $agentesult[$key] );//將帳號列表置於option中
		}
		

	}
	else
	{
		header("Location: index.php"); 
		die();
	}
	$questionresult=securityQuestion();//安全性問題
	$countrycode= getCountryCode(); /*新增國碼判斷，尚未上線*/
	/*新增國碼判斷，尚未上線*/
	while(list($key)=each($countrycode))
	{
		$tpl->newBlock('GETCOUNTRYCODE');
		$tpl->assign($countrycode[$key]);
	}
	while(list($q)=each($questionresult))
	{
		$tpl->newBlock('questionlistBlock');
		$tpl->assign($questionresult[$q]);//將帳號列表置於option中
	}
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );
	$tpl->printToScreen();
?>