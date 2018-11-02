<?php
	include( 'config.php' );
	//if( $sys->userAlive['errorCode'] != 'OK' ) $sys->redirectUrl( 'logout.php' );
	
	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/pointDetails.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );
	$wdrecord=(!isset($_GET['wdrecord']))?3:$_GET['wdrecord'];
	$tpl->assign('s'.$wdrecord,'selected');
	/*會員互轉開放限制
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
	$result=getAccountDetails();
	//$page=page($tpl,$result);
	$financeSetp = array( 1=>"待确认", 2=>"确认中", 3=>"已完成", 4=>"已取消", 5=>"已删除" );
	$total='';


		while(list($key)=each($result))
		{
			// echo '<pre>';
			//echo $result[$key]['saveBy'];
			//print_r($result);
			
			if($wdrecord!=$result[$key]['action'] && $wdrecord!=3)continue;
				
				$tpl->newBlock('listMoneySavedetailBlock');
				$requestTime=explode(' ',$result[$key]['requestTime']);
				$tpl->assign($result[$key]);
				if($result[$key]['step']==3)
				{
					//print_r($result[$key]);
					//echo $result[$key]['step'];
					$tpl->assign('color_step','#228B22');//GREEN
					$total+=$result[$key]['requestAmount'];
					
				}
				if($result[$key]['saveBy']=='会员互转')
				{
					//print_r($result[$key]);
					//echo $result[$key]['step'];
					$tpl->assign('color_save','#46a3ff');//skyblue
					//$total+=$result[$key]['requestAmount'];
					$tpl->assign( 'noteTag', '#'.$result[$key]['bankName'].'<br>'.$result[$key]['accountName'] );
				}
				
				
				$tpl->assign('requestdate',$requestTime[0]);
				$tpl->assign('requesttime',$requestTime[1]);
				if($result[$key]['action']==1)
				{
					//$tpl->assign('color','#228B22'); //GREEN
					$tpl->assign('action','充值');
					
				}
				if($result[$key]['action']==2)
				{
					//$tpl->assign('color','#FF0000'); //RED
					$tpl->assign('action','提领');
				}
				
				$tpl->assign('step',$financeSetp[$result[$key]['step']]);
				// $tpl->gotoBlock('listMoneySavedetailBlock');
			 // 	$tpl->assign('total',$result[$key]['mergeTotal']);

		}
		/*if($wdrecord<3) //如果全部也要合計，把這個if取消就可以了
		{*/
			$tpl->newBlock('listMoneySaveBlock');
			//$tpl->gotoBlock('listMoneySavedetailBlock');
			if($total=='')
			{
				$total=0;
			}
			$tpl->assign('total',number_format($total,2,'.',','));
		//}
		actionKeepLive();//檢驗登入狀態
 		$tpl->printToScreen();
?>