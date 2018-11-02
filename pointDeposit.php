<?php
	include("config.php");
	//if( $sys->userAlive['errorCode'] != 'OK' ) $sys->redirectUrl( 'logout.php' );//KeepLive( $sys->userAlive );//檢驗登入狀態

	$financeSetp   = array( 1=>"待确认", 2=>"确认中", 3=>"已完成", 4=>"已取消", 5=>"已删除" );
	$financeAction = array( 1=>array( 'FAction'=>"充值", 'Color'=>'#008800' ), 2=>array( 'FAction'=>"提领", 'Color'=>'#CC0000' ) );
	//$kindArr在config.php
					
	$layout = ( $_REQUEST["uc"] ) ? $_REQUEST["uc"] : "default" ;

	$upUserInfo = getUserUpdate();

	$userinfo = ( is_array( $upUserInfo[0] ) ) ? array_merge( $upUserInfo[0], $mbInfoArr ) : $mbInfoArr ;

	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/pointDeposit.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );

	$tpl->prepare();
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );

	$tpl->newBlock( 'pointDepositTitle' );
	/*會員互轉開放限制
	$date=date("His");
	if($date>"210000" || $date<"020000")
	{
		$tpl->assign('status','0');//close
	}
	else
	{
		$tpl->assign('status','1');//open
	}*/
	//充值權限鎖定。不可使用
	if( $userinfo['savemoneyblocked'] )
	{
		$tpl->newBlock( 'pointDepositLocked' );
		actionKeepLive();//檢驗登入狀態
		$tpl->printToScreen();
		die();
	}

	switch( $_REQUEST['rout'] )
	{
		case 'bank':
		
		break;
		case 'payWay':
			//20170926升級後bankInfo+kind不為空，帶入的type為 1网上银行 2临柜汇款 3支付宝 4微信 5QQ
			//舊版bankInfo帶入的type為該帳戶的支付FinanceAccount.type代碼
			
			$payType = array( 3=>3, 4=>1, 5=>2 );//第三方支付對應Notify類檔案使用3=>3(支付宝), 4=>1(微信), 5=>2(QQ)
	
			if( !empty( $_REQUEST['ptype'] ) )
			{
				$art['kind'] = 1;//20170926升級版新增kind參數不為空
				$art['type'] = $_REQUEST['ptype'];
				$result		 = getBankInfo( $art );
				$bankInfoArr = $result[0];
				$pw = new redisCache;
				$pw->setVar( $_SESSION["WEB2"]['MemID'].'_payWayIndex', json_encode( $result ), 300 );//cache帳戶資料5分鐘
				if( $_REQUEST['debug'] ) print_r( $bankInfoArr );
			}

			if( $bankInfoArr['type'] == '1' )//銀行類別-網路銀行&臨櫃
			{
				$setData = bank2SelectBar( $result, 'bankIndex', 'bankIndex', '' );
				$tpl->newBlock( 'pointDepositBank' );
				$tpl->assign  ( $_REQUEST );
				$tpl->assign  ( "selectBar", selectBar( $setData ) );
				$tpl->newBlock( 'pointDepositSuccessMsg' );
				break;
			}
			else if( $bankInfoArr['type'] == '2' || $bankInfoArr['type'] == '4' )//系統QRCode支付
			{
				$tpl->newBlock( 'pointDepositQRCodeStep' );
				$tpl->assign  ( $bankInfoArr );
				$tpl->assign  ( $_REQUEST );

				$tpl->assign  ( 'saveBy'	, ( ( $bankInfoArr['type'] == 4 ) ? '微信' : '支付宝' ) );
				$set = 0;
				$Vhost_Dir = opendir( "/var/www/html/wa99_thr/serviceQRCode/" );
				while( $file = readdir( $Vhost_Dir ) )
				{
					if( $set ) continue;//已使用圖檔了
					$fArr	  = @explode( '.', $file );
					$qtype	  = strtolower( $fArr[0] );
					$fileName = sprintf( 'payCode.%s', $bankInfoArr["id"] );
					if( strtolower( $fileName ) == strtolower( $fArr[0].'.'.$fArr[1] ) )
					{
						$tpl->newBlock( 'DepositQRCode' );
						$tpl->assign  ( 'imgQRCode', $file );
						$set = 1;//避免重複
					}
				}
				closedir($Vhost_Dir);
				break;
			}
			else if( $bankInfoArr['type'] && ( $_REQUEST['ptype'] >= 3 && $_REQUEST['ptype'] <= 5 ) )//第三方支付通道 / $bankInfoArr['type']有值代表二版bankInfo
			{
				$tpl->newBlock( 'pointDeposit3PayStep' );
				$tpl->assign  ( $_REQUEST );
				//$url = './userCenter.php?uc=Deposit&wa=intelligent&paytype='.$payType[$_REQUEST['ptype']].'&ch='.$bankInfoArr['type'].'&id='.$bankInfoArr['id'].'&ptype='.$_REQUEST['ptype'];
				//header( 'location:'.$url );
				break;
			}

			$tpl->newBlock( 'pointDepositNone' );
			$tpl->assign  ( 'pointDepositNoneMsg', '[ 此功能暂停服务 ]' );
		break;
		default:
			$tpl->newBlock( 'pointDepositCenter' );
		break;
	}
	actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();
	
	function bank2SelectBar( $arr, $id, $name, $ckid='' )
	{
		for( $c = 0 ; $c < count( $arr ) ; $c++ )
		{
			//$idTag = sprintf( '%s:::%s:::%s:::%s:::%s:::%s', $arr[$c]["id"], $arr[$c]["fbank"], $arr[$c]["fbranch"], $arr[$c]["faccount"], $arr[$c]["fname"], $arr[$c]["url"] );
			$idTag = $arr[$c]["id"];
			$cArr[$idTag] = $arr[$c]["fbank"];
		}
		$setData["id"]	  = $id;
		$setData["name"]  = $name;
		$setData["ckid"]  = 1 ;
		$setData["arr"]	  = $cArr;
		$setData["class"] = 'nomoInput nomoSelectBarWidth';
		return $setData;
	}
?>