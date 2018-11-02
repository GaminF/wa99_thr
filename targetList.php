<?php
	include("config.php");
	//if( $sys->userAlive['errorCode'] != 'OK' ) $sys->redirectUrl( 'logout.php' );

	//取得賽事列表 $gArr(全部賽事), $dateArr(日期賽事), $cpArr(聯盟賽事)
	include( 'getGameList.php' );
	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/targetList.html" );
	//$tpl->assignInclude("dealchart","interface/".$siteInfo['interface']."/html/ac_dealchart.html");
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );


	$tpl->prepare();
	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( 'countNumAll'	, sprintf( '%02d', count( $typeArr['All']['list'] ) ) );
	$tpl->assign  ( 'countNumCP'	, sprintf( '%02d', count( $typeArr['CP'] ) ) );

	//會員自設快捷金額
	$addAmountArr = @explode( ',', $mbInfoArr['betsize'] );
	if( !is_array( $addAmountArr ) ) $addAmountArr = array( 1000, 5000, 12000 );
	while( list( $i ) = @each( $addAmountArr ) ) $tpl->assign( 'fastAmount'.$i, $addAmountArr[$i] );
	@reset( $addAmountArr );
	while( list( $i ) = @each( $addAmountArr ) )
	{
		$tpl->newBlock( 'gameAddOrderAmount' );
		$tpl->assign  ( 'addAmount', $addAmountArr[$i] );
	}
/*
	@reset( $typeArr['Day'] );
	//左選單
	while( list( $iDate ) = @each( $typeArr['Day'] ) )
	{
		$tpl->newBlock( 'gameDayItem' );
		$tpl->assign  ( 'listTag', $iDate );
		$tpl->assign  ( 'countNum', sprintf( '%02d', count( $typeArr['Day'][$iDate] ) ) );
	}
	*/
	$x = 1;
	@krsort( $typeArr );
	@reset( $typeArr );
	while( list( $key ) = @each( $typeArr ) )//選單類別
	{
		if( $key == 'CP' ) continue;
		$groupArr = $typeArr[$key];
		while( list( $tag ) = @each( $groupArr ) )//類別區塊
		{
			$tpl->newBlock( 'gameMainItem' );
			$tpl->assign  ( 'listTag', ( $tag == 'list' ) ? '全部赛事' : $tag );
			$tpl->assign  ( 'switchTag', ( $tag == 'list' ) ? ' open' : '' );
			$tpl->assign  ( 'iNum', $x );
			$tpl->newBlock( 'gameList' );
			if( $tag == 'list' ) $tpl->assign  ( 'switchStatus', 'block' );
			$listArr = $groupArr[$tag];
			while( list( $i ) = @each( $listArr ) )//類別資料列表
			{
				$tpl->newBlock( 'gameListItem' );
				$tpl->assign  ( $listArr[$i] );
				$tpl->assign  ( 'gametime', substr( $listArr[$i]['gametime'], 0, 16 ) );
				$tpl->assign  ( 'dateStr', substr( $listArr[$i]['gametime'], 5, 5 ) );
				$tpl->assign  ( 'timeStr', substr( $listArr[$i]['gametime'], 11, 5 ) );
				//0613 nillie test ok
				if($listArr[$i]['status_id']==1)
				{
					$tpl->assign('pawben','<span class="guaranteed_list">保本</span>');
				}
				//if($_GET['eventId']==$listArr[$i]['gameid']) $tpl->assign( 'marketGameActive', 'market_game_active' );

				//if( $tag == 'list' && $i == 0 ) $tpl->assign( 'marketGameActive', 'market_game_active' );

				/*20180716 nillie test start*/
				if($_GET['eventId']==$listArr[$i]['gameid']) 
				{
					$tpl->assign( 'marketGameActive', 'market_game_active' );
				}

				if( $tag == 'list' && $i == 0 && empty( $_GET['eventId'] ) ) $tpl->assign( 'marketGameActive', 'market_game_active' );

				/*20180716 nillie test end*/

				if( empty( $getBaseData ) )//進入時顯示第一筆賽事資料
				{

					$tpl->gotoBlock( '_ROOT' );
					$tpl->newBlock( 'javascriptRun' );
					if(!empty($_GET['eventId']) && !empty($_GET['ga12']))
					{
						$tpl->assign  ( 'scriptStr', sprintf( "marketTab( '%s', '%s', '%s', '%s', '%s' );", $_GET['eventId'], $_GET['ga12'], $_GET['time'],$_GET['competition'], $_GET['team'] ));
					}
					else
					{
						$tpl->assign  ( 'scriptStr', sprintf( "marketTab( '%s', '%s', '%s', '%s', '%s' );", $listArr[$i]['gameid'], $listArr[$i]['ga12'], substr( $listArr[$i]['gametime'], 0, 16 ), $listArr[$i]['competitionname'], $listArr[$i]['gamename'] ) );
					}
					$getBaseData = 1;
				}
			}
			$x++;
		}
	}
	actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();
?>