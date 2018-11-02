<?php
//待加入安全判斷SESSION
	include( '../devInclude/includeBaseV2.php' );	//各類include檔案
	$siteInfo = array( "interface"=>"v2" );
	
	if( !$_SESSION["WEB2"]['MemID'] ) die();
	//市場項目-ID&項目名稱
	$selectID = array( 0=>'&nbsp;', 1=>'0 - 0', 2=>'1 - 0', 3=>'1 - 1', 4=>'0 - 1', 5=>'2 - 0', 6=>'2 - 1', 7=>'2 - 2', 8=>'1 - 2', 9=>'0 - 2', 10=>'3 - 0',11=>'3 - 1', 12=>'3 - 2', 13=>'3 - 3', 14=>'2 - 3', 15=>'1 - 3', 16=>'0 - 3', 9063255=>'客队赢　进球四球以上', 9063256=>'平手　进球四球以上', 9063254=>'主队赢　进球四球以上', 4506345=>'其他', 285469=>'1球以上', 285470=>'2球以上', 285471=>'3球以上', 285472=>'4球以上', 285473=>'5球以上', 285474=>'6球以上', 285475=>'7球以上', 69843=>'0 - 10 分钟', 69844=>'11 - 20 分钟', 69845=>'21 - 30 分钟', 69846=>'31 - 40 分钟', 69847=>'41 - 50 分钟', 69848=>'51 - 60 分钟', 69849=>'61 - 70 分钟', 69850=>'71 - 80 分钟', 69851=>'81 - 终场', 69852=>'终场没进球' );

	//市場項目-項目表。因應後台API資料有誤，特以此表比對與顯示
	$selectArr = array(	1=>array( 'marketname'=>'波胆',			'pos'=>'table_left',	'icon'=>'head_icon1-1',	'cell'=>'cell_39', 'marketItem'=>array( 1,4,9,16,2,3,8,15,5,6,7,14,10,11,12,13,9063255,9063254 ) ),
						2=>array( 'marketname'=>'半场波胆',		'pos'=>'table_right',	'icon'=>'head_icon1-2', 'cell'=>'cell_46', 'marketItem'=>array( 1,4,9,2,3,8,5,6,7,4506345,0,0,0,0,0,0,0,0 ) ),
						3=>array( 'marketname'=>'总得分',		'pos'=>'table_left',	'icon'=>'head_icon1-3', 'cell'=>'cell_47', 'marketItem'=>array( 285469,285470,285471,285472,285473,285474,285475,0,0,0 ) ),
						0=>array( 'marketname'=>'首入球时间',	'pos'=>'table_right',	'icon'=>'head_icon1-4', 'cell'=>'cell_48', 'marketItem'=>array( 69843, 69844, 69845, 69846, 69847, 69848, 69849, 69850, 69851, 69852 ) )
						);
					
	switch( $_POST['ac'] )
	{
		//取得交易號碼，記錄基礎賽事資料，供最後執行注單用資訊
		case 'getOrderNo':
			//INPUT Val gameid, a12, effectivetime, competition, event, marketid, selectid, profit, systemrate, price
			$rc = new redisCache;
			//設定登入序號，登入驗證使用，應於login介面時產生
			$user = $_SESSION["WEB2"]['MemID'];
			if( empty( $user ) ) die( '{"errorcode":"101","msg":"请重新登入操作"}' );
			$orderNo = $user.'_OrderNo'.time();
			$rc->setVar( $orderNo, json_encode( $_POST ), 300 );//設定五分鐘
			die( '{"errorcode":"000","msg":"'.$orderNo.'"}' );
		break;
		case 'actionOrder'://執行注單
			//需預防重複下單問題

			if( !$_POST['size'] ) die( '{"errorcode":"100","msg":"金额有误，请重新操作"}' );
			$nowTime = date( 'Y-m-d H:i:s' );
			$rc = new redisCache;
			//記錄Log CacheOrder Data
			$CacheOrder = $rc->getVar( $_REQUEST['OrderNo'] );
			$orderArr = json_decode( $CacheOrder, true );
			if( !is_array( $orderArr ) ) die( '{"errorcode":"101","msg":"[重复下单]请变更下单金额或稍后再试！"}' );
			$rc->delVar( $_REQUEST['OrderNo'] );//清除Cache訂單記錄，防重複發送
			
			actionLogs( $CacheOrder, 'CacheOrder Info' );

			$orderArr['size'] = $_POST['size'];
			$CacheOrder = json_encode( $orderArr );

			$orderCache180Tag = $_SESSION["WEB2"]['MemID'].'_order180';
			$OrderCache180Str = $rc->getVar( $orderCache180Tag );
			$OrderCache180Arr = json_decode( $OrderCache180Str, true );
			if( is_array( $OrderCache180Arr ) && $OrderCache180Str == $CacheOrder ) die( '{"errorcode":"1011","msg":"[重复下单]请变更下单金额或稍后再试！"}' );
		
			$mbInfoArr = getMemberInfo();
			if( $_POST['size'] > $mbInfoArr['quota'] || $mbInfoArr['quota'] <= 0 ) die( '{"errorcode":"102","msg":"余额不足"}' );
			
			$error		= 0;
			$ckGLTag	= array( 'gameid'=>'eventId', 'gametime'=>'gametime', 'competitionname'=>'competition', 'gamename'=>'event', 'ga12'=>'ga12' );

			$gArr		= getGameList();
			while( list( $key ) = @each( $gArr ) )
			{
				if( $gArr[$key]['gameid'] != $orderArr['gameid'] || is_array( $Arr ) ) continue;//比對賽事列表場次
				while( list( $gTag ) = @each( $ckGLTag ) )
				{
					if( $gArr[$key][$gTag] == $orderArr[$gTag] ) $Arr[$ckGLTag[$gTag]] = $orderArr[$gTag];//比對Cache訂單資料 & API資料設置
					else $error[] = $gTag;
				}
			}
			if( is_array( $error ) )			die( '{"errorcode":"103","msg":"参数错误：'.implode( ',', $error ).'"}' );
			if( $nowTime > $Arr['gametime'] )	die( '{"errorcode":"104","msg":"暂不开放"}' );
			
			$Arr['ga12'] = $orderArr['ga12'];
			$mArr = getGameItemList( $Arr['eventId'], $Arr['ga12'], $Arr['gametime'] );

			while( list( $be14 ) = @each( $selectArr ) )
			{
				if( $mArr[$be14]['marketid'] != $orderArr['marketid'] ) continue;//比對Cache訂單資料-市場
				while( list( $i ) = @each( $mArr[$be14]['selectid'] ) )
				{
					if( $mArr[$be14]['selectid'][$i] != $orderArr['selectid'] ) continue;
					$ikey = $i;//資料索引值
				}
				$Arr['price']		= $mArr[$be14]['selectrateL1'][$ikey];	//系統價
				$Arr['systemrate']	= $mArr[$be14]['selectrateL1o'][$ikey];	//BF價
				$Arr['profit']		= $orderArr['profit'];					//獲利%
				$Arr['size']		= $_POST['size'];						//下注金額
				$Arr['market']		= $mArr[$be14]['marketname'];//波胆
				$Arr['selection']	= $mArr[$be14]['selectname'][$ikey];	//1-3
				$Arr['marketId']	= $orderArr['marketid'];				//市場id
				$Arr['selectionId']	= $orderArr['selectid'];				//項目id
				$Arr['be14']		= $be14;								//類別代碼1波胆,2上半場波胆,3总得分,0首入球
			}
			if( empty( $Arr['marketId'] ) ) die( '{"errorcode":"105","msg":"参数错误"}' );
			$result = getOrderResult( $Arr );
			
			#20181026 add by nillie for api no respone with timeout
			if( $result['errorcode'] == '' || !is_array($result) ) die( '{"errorcode":"999","msg":"您的单已送出，请至交易明细确认结果。"}' );
			if( $result['errorcode'] != '000' ) die( '{"errorcode":"'.$result['errorcode'].'","msg":"'.$result['message'].'"}' );

			$result['gameselect']	= str_replace ( "進", "进", $result['gameselect'] );//进。特別處理項目
			//180605修正無條件四捨五入BY GAMIN
			//$result['conversion'] = number_format( $orderArr['profit'] * $result['dealmoney'] * ( 1 - $orderArr['fee'] ), 2 );
			$result['conversion']	= floor( $result['dealmoney'] * $orderArr['profit'] * ( 1 - $orderArr['fee'] ) * 100 ) / 100;
			$result['dealmoney']	= number_format( $result['dealmoney'], 2 );
			$result['profit']		= ( $orderArr['profit']*100 ).'%';
			$result['gametime']		= $orderArr['gametime'];
			$result['gamemarket']	= ( $result['gamemarket'] == '上半場波胆' ) ? $selectArr[2]['marketname'] : $result['gamemarket'] ;
			echo json_encode( $result );
			$rc->setVar( $orderCache180Tag, $CacheOrder, 90 );//設定3分鐘同樣內容，不可重複下單(因應原系統防重複下單之規則)
			$rc->delVar( $_SESSION["WEB2"]['MemID'].'_memberInfo' );//強制清除用戶資訊(餘額),因API回應過久,餘額無更新180913
		break;
		default:
			$acrc = new redisCache;
			$cku = $_SESSION["WEB2"]['MemID'];
			$uCount = $acrc->getVar( 'cku'.$cku );
			//testLogs( $ipCount, 'SET1', 'debug' );
			$uCountArr = json_decode( $uCount, true );
			if( !is_array( $uCountArr ) ) $uCountArr['counts'] = 0;
			$uCountArr['counts']++;
			if( $uCountArr['counts'] > 5 )
			{
				$acrc->setVar( 'cku'.$cku, json_encode( $uCountArr ), 60 );
				die();
			}
			$acrc->setVar( 'cku'.$cku, json_encode( $uCountArr ), 1 );
			// 市場項目表 INPUT: $POST['gameid']; $POST['ga12']; $POST['gametime'];
			$apiData = getGameItemList( $_POST['gameid'], $_POST['ga12'], $_POST['gametime'] );
			$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/ac_targetList.html" );
			$tpl->prepare();
			//賽事時間已過、賽事關閉，便不再提供資料
			if( !empty( $apiData["gametime"] ) && ( date( 'Y-m-d H:i:s' ) >= $apiData["gametime"] || $apiData['msg'] == '比赛已經关闭' ) )
			{
				if( !$apiData['msg'] ) $apiData['msg'] = '比赛已经开始了！';
				$tpl->newBlock( 'GameMarketMsg' );
				$tpl->assign  ( $apiData );
				$tpl->printToScreen();
				die();
			}

			$r = 0;							//因應html分為兩表為一列之分隔
			$tpl->newBlock( 'GameMarket' ); //市場項目總表
			while( list( $key ) = @each( $selectArr ) )
			{
				if( ( $r % 2 ) == 0 ) $tpl->newBlock( 'MarketTableRow' );	//因應html分為兩表為一列之分隔
				$tpl->newBlock( 'MarketTable' );							//單一表單
				$tpl->assign  ( $selectArr[$key] );
				$tpl->assign  ( $apiData[$key] );
				$tpl->assign  ( 'marketname', $selectArr[$key]['marketname'] );
				$tpl->assign  ( 'marketid', $selectArr[$key]['marketid'] );
				$tpl->assign  ( 'chartid', $key );
				$tpl->assignGlobal('gameid',$_POST['gameid']);
				$tpl->assignGlobal('ga12',$_POST['ga12']);
				$tpl->assign  ( 'totaldealmoney', ( !empty( $apiData[$key]['totaldealmoney'] ) ) ? number_format( $apiData[$key]['totaldealmoney'], 2, '.', ',' ) : 0 );
				$idData = $apiData[$key]['selectid'];						//api資料id列表
				$listNum = 1;												//判斷未筆html
				$recordCount = count( $selectArr[$key]['marketItem'] );		//判斷未筆html
				while( list( $i ) = @each( $selectArr[$key]['marketItem'] ) )
				{
					$subTag = ( $listNum == $recordCount ) ? 'Last' : '' ;	//判斷未筆html
					$tpl->newBlock( 'MarketSelectList'.$subTag );			//表單列表
					$tpl->assign  ( 'selectItem', $selectID[$selectArr[$key]['marketItem'][$i]] );
					
					@reset( $idData );
					while( list( $ck ) = @each( $idData ) )					//避免API項目資料少塞於固定列表
					{
						if( $idData[$ck] != $selectArr[$key]['marketItem'][$i] ) continue;//比對介面ID與API ID是否配對吻合
						$tpl->assign  ( 'profit'		,	( $apiData[$key]['profitL1'][$ck] > 0 )		? ( $apiData[$key]['profitL1'][$ck]*100 ).'%' : '' );
						$tpl->assign  ( 'tradingVolView',	( $apiData[$key]['tradingVolL1'][$ck] > 0 )	? '&yen;'.number_format( $apiData[$key]['tradingVolL1'][$ck], 2, '.', ',' ) : '' );
						/*0613 nillie location test OK*/
						if($apiData[$key]['pawben'][$ck]==1 && $apiData[$key]['profitL1'][$ck] > 0)
						{
							$tpl->assign('pawbenicon','<span class="guaranteed_content">保本</span>');
						}
						if( $apiData[$key]['tradingVolL1'][$ck] > 0 )//可交易量大於0才可下單
						{
							$tpl->newBlock( 'MarketSelectListButton'.$subTag );
							$tpl->assign  ( $apiData );
							$tpl->assign  ( $apiData[$key] );
							$tpl->assign  ( 'selectid'	, $apiData[$key]['selectid'][$ck] );
							$tpl->assign  ( 'selectname', $selectID[$selectArr[$key]['marketItem'][$i]] );
							$tpl->assign  ( 'marketname', $selectArr[$key]['marketname'] );
							$tpl->assign  ( 'tradingVol', $apiData[$key]['tradingVolL1'][$ck] );
							$tpl->assign  ( 'profit'	, $apiData[$key]['profitL1'][$ck] );
							$tpl->assign  ( 'systemrate', $apiData[$key]['selectrateL1o'][$ck] );
							$tpl->assign  ( 'price'		, $apiData[$key]['selectrateL1'][$ck] );
							$tpl->assign  ( 'fee'		, $apiData[$key]['marketpercentage'] );
							$tpl->assign  ( 'pawben'	, $apiData[$key]['pawben'][$ck]);
							//0706 nillie add
							$tpl->gotoBlock('MarketTable');
							$tpl->assign  ( 'marketid', $apiData[$key]['marketid'] );
						}
					}
					$listNum++;	//判斷未筆html
				}
				$r++;			//因應html分為兩表為一列之分隔
			}


			$tpl->printToScreen();
		break;
	}

?>