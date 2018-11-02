<?php
	include( 'config.php' );//已開啟 $rc = new redisCache;

	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/fifa_temp.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/index.html" );
	//$tpl->assignInclude("Register","interface/".$siteInfo['interface']."/html/register_e3.html");
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );

	$tpl->prepare();
	$tpl->assign  ( $siteInfo );
	
	//登入前後
	$menuInfoBarTag = ( is_array( $mbInfoArr ) ) ? 'menuInfoBar_Login' : 'menuInfoBar_notLogin' ;
	//$menuInfoBarTag = 'menuInfoBar_notLogin' ; //0409 for test
	$tpl->newBlock( $menuInfoBarTag );
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );
	//

	$tpl->assign  ( $_REQUEST );
	$tpl->assign  ( $mbInfoArr );
	//Banner區塊
	
	$tpl->newBlock( 'indexBanner' );

	/*保本活動333 banner置換區*/
	$directory = 'interface/v2/img/pawbenbanner/'; 

	if( !is_dir( $directory ) ) die( 'NO directory:'.$directory );

	if( $dh = opendir( $directory ) )
	{
		while ( ( $file = readdir( $dh ) ) !== false ) $arr[] = $file;
		closedir($dh);
	}
	
	@sort( $arr );
	$x = 1;
	$i=0;
	while( list( $key ) = @each( $arr ) )
	{

		$file = $arr[$key];
		
		$fileStyleArr = explode( '.', $file );
		if( $x >= 2 || $fileStyleArr[0] != 'w' ||$fileStyleArr[2] <=date( 'mdHi' )) continue;
		
		if($fileStyleArr[2] >date( 'mdHi' ) )
		{
			$tpl->newBlock('li_block');
			$tpl->newBlock('banner_block');
			$tpl->assign('file',$file);
			//echo 'banner='.$banner[$key];
			//print_r($banner);
			$i+=1;
			$x++;
		}
	
	}

	if($i==0)
	{
		$tpl->assign('first','active');
	}
	/*保本活動333 banner置換區*/

	//維護P檢測模式
	if( $sys->systemStatus['errorCode'] == '900' )
	{
		$tpl->newBlock( 'maintainPopup' );
		$tpl->assign  ( $sys->systemStatus );
	}

	
	// if( isset( $_SESSION["WEB2"]['MemID'] ) )
	// {
	// 	if( $mbInfoArr['widthdrawpassword'] == 1 ) $sys->redirectUrl( './' );	//已註冊者，導向首頁
	// 	$tpl->newBlock( 'SESSION_WEB2_MemIDBlock' );
	// 	$tpl->assign  ( 'SESSION_WEB2_MemID', $_SESSION["WEB2"]['MemID'] );
	// }
	// else if( isset( $_GET['agent'] ) )
	// {
	// 	// 確認後台是否有此代理../devInclude/agent.php
	// 	// 回覆代理id(11145), 不存在回覆(101:Confirm)
	// 	$agentid	= getAid( $_GET['agent'] );
	// 	$agent_us	= @explode( ':', $agentid );
	// 	if( $agent_us[1] )
	// 	{
	// 		header( "Location:logout.php" );
	// 		die();
	// 	}
	// }	
	// $Arr['agentid'] = $_GET['agent'];
	// $tpl->newBlock('register');

	// $agentesult		= getUserNameList_Agent( $Arr['agentid'] );	//取得該代理帳號列表
	// $tagName		= 'Register_'.$sys->userIP;					//記錄cache索引名稱 Register_+使用者IP / config.php已啟動$sys
	// $rc->setVar( $tagName, json_encode( $agentesult ), 600 );	//Cache記錄帳號選單，執行註冊時驗證資料，十分鐘有效
	// $tpl->assign  ( 'agentid', $Arr['agentid'] );
	// $tpl->newBlock( 'username_select_Block' );
	// while( list( $key ) = each( $agentesult ) )
	// {
	// 	$tpl->newBlock( 'agentlistBlock' );
	// 	$tpl->assign  ( 'username', $agentesult[$key] );//將帳號列表置於option中
	// }
	
	/*热门赛事区*/
	$tpl->newBlock('HOT3');

	$data3=array();
	$result_hot3=dealtopthree();

		
	while (list($key)=each($result_hot3)) 
	{

		$top3=$result_hot3[$key];
		$tpl->assignGlobal('competition'.$key,$top3['competition']);
		$data3['day'][$key]=explode(" ", $top3['game_open_time']);
		$tpl->assign('datetime'.$key,substr($data3['day'][$key][0],5,5).' / '.substr($data3['day'][$key][1],0,5));
		$tpl->assign('marketname'.$key,$top3['marketname'].'  ');
		$tpl->assign('selection'.$key,$top3['selection']);
		//$tpl->assign('rate'.$key,'@'.$top3['current_final_profit_rate'].'%');
		if($top3['pawben_open_status']==1)
		{
			$tpl->assign('pawbenicon'.$key,'<span class="guaranteed_icon">');	
		}
		
		$tpl->assign('gamename'.$key,$top3['host_team'].'(主) vs '.$top3['guest_team']);
		$gomarket = ( is_array( $mbInfoArr ) ) ? 'tomarket'.$key : 'tologin'.$key ;
		$tpl->newBlock( $gomarket );
		$tpl->assign('ga12'.$key,$top3['ga12']);
		$tpl->assign('eventId'.$key,$top3['eventId']);
		$tpl->assign('game_team'.$key,$top3['host_team'].' v '.$top3['guest_team']);
		$tpl->assign('game_open_time'.$key,substr($top3['game_open_time'],0,-3));
		$tpl->gotoBlock('HOT3');
		$data3['deal'][]=$top3['sum_bet_dealmoney_per_selection'];
		$data3['candeal'][]=$top3['current_all_can_deal_money'];

	}
	$data3['candeal']=@implode(',',$data3['candeal']);
	$data3['deal']=@implode(',',$data3['deal']);
	$tpl->gotoBlock("_ROOT");
	$tpl->assign('hot3deal',$data3['deal']);
	$tpl->assign('hot3candeal',$data3['candeal']);
	

	/*HOTNEWS 今日頭條*/
	/*$hotnews=hotnews();
	//print_r($hotnews);
	while(list($key)=each($hotnews['news_list']))
	{
		$tpl->newBlock('HOTNEWS');
		if($key==0)
		{
			$tpl->assign('class','news_LI');
		}
		$tpl->assign($hotnews['news_list'][$key]);
		$tpl->assign('news_time',substr($hotnews['news_list'][$key]['news_time'],0,10));
	}
	*/
	$tpl->gotoBlock('_ROOT');
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );
	$tpl->printToScreen();
?>
