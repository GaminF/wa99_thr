<?php
	include( 'config.php' );
	//if( $sys->userAlive['errorCode'] != 'OK' ) $sys->redirectUrl( 'logout.php' );

	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/fifa_history_all.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );
	//$tpl->assign('date',date('Y/m/d'));
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$no='';
	$mark=($_GET['detail']==1)?1:0;
	$mark=(isset($_GET['detail']))?1:0;
	$weeklist = array('日', '一', '二', '三', '四', '五', '六');
	$tpl->assign('mark',$mark);
	$ckdate=date("Y-m-d",strtotime(' -18 days'));
	//echo $ckdate;

	if($_GET['detail']==1 && !empty($_GET['starttime']) && !empty($_GET['endtime']))
	{		
		
		if($_GET['starttime']<$ckdate || $_GET['endtime']<$ckdate)
		{
			$starttime=$ckdate;
			$endtime=$ckdate;
			
		}	
		else
		{
			$starttime=$_GET['starttime']; 
			$endtime=$_GET['endtime'];	
		}
			
			$tpl->assign('startdate',$starttime);
			$tpl->assign('enddate',$endtime);
			$result=getHistoryDetails( $starttime, $endtime );
			
			//print_r($result);
				$tpl->newBlock('userHistoryDetailTitleBlock');
				$tpl->assign('startdate',$starttime);
				$tpl->assign('enddate',$endtime);
				$i='';
				$totaldealmoney='';
				$totalafter='';
				foreach ($result as  $detail) 
				{
					
					if(is_array($detail)) 
					{	
						$color=($detail['after']<0)?'#FF0000':'#228B22';
						$tpl->newBlock('userHistoryDetailBlock');
						$tpl->assign('color',$color);
						$tpl->assign($detail);
						if($detail['market']=='上半場波胆')
						{
							$tpl->assign('market','上半场波胆');
						}
						$tpl->assign('percentage',$detail['percentage']*100);
						$tpl->assign('profit',$detail['profit']*100);
						$tpl->assign('openDate',substr($detail['openDate'],5,-3));
						$tpl->assign('dealmoney',number_format($detail['dealmoney'],2,'.',','));
						$tpl->assign('after',number_format($detail['after'],2,'.',','));
						$totaldealmoney+=$detail['dealmoney'];
						$totalafter+=$detail['after'];
						$i+=1;
					}
				}
				if($i=='')
				{
					$tpl->newBlock('nonBlock');
					$i=0;
					$totaldealmoney=0;
					$totalafter=0;
				}
				$tpl->gotoBlock('userHistoryDetailTitleBlock');

				$tpl->assign('i',$i);
				$color=($totalafter<0)?'#FF0000':'#228B22';
				$tpl->assign('color',$color);
				$tpl->assign('totaldealmoney',number_format($totaldealmoney,2,'.',','));
				$tpl->assign('totalafter',number_format($totalafter,2,'.',','));	
			//}
//number_format($detail['dealmoney'],2,'.',',');
	}
	else
	{
		$result=getHistory();	
		
		while( list( $no ) = @each( $result ) ) 
		{
			$data=$result[$no];
			//print_r($result);
			//print_r($data);
			$tpl->newBlock('userhistoryamountTitleBlock');
			
			$week=(isset($_GET['week']))?$_GET['week']:0;
			if($no!=$week)
			{
				$tpl->assign('status','display:none');
			}

			while(list($key)=each($data))
			{
				$starttime=$data[$key]['acc_time'];
				$endtime=$data[$key]['acc_time'];
				$tpl->assign('no',$no);
				$tpl->newBlock( 'userhistoryamountBlock');
				$tpl->assign( $data[$key] );
				$weekday = date('w', strtotime($data[$key]['acc_time']));
				$acc_time=$data[$key]['acc_time'].'('.$weeklist[$weekday].')';
				
				$tpl->assign('acc_time',$data[$key]['acc_time'].'('.$weeklist[$weekday].')');
				$color=($data[$key]['after']<0 || $data[$key]['result_quantity'] <0)?'#FF0000':'#228B22';
				$tpl->assign('color',$color);
				if($no==3)
				{
					$starttime=substr($data[$key]['acc_time'],0,7).'-01';	
					$show_starttime=substr($data[$key]['acc_time'],0,-3);
					//echo $show_starttime;
					$tpl->assign('acctimefordetail',$show_starttime);
				}
				else
				{
					$tpl->assign('acctimefordetail','<a href="fifa_history_all.php?detail=1&starttime='.$starttime.'&endtime='.$endtime.'">'.$acc_time.'</a>');
				}
				
				//print_r($data);
				//$tpl->newBlock( 'userhistoryamountBlock');
				//$tpl->assign( $data[$key] );
				$tpl->assign('startdate',$starttime);
				$tpl->assign('enddate',$endtime);
				$tpl->assign('dealmoney',number_format($data[$key]['dealmoney'],2,'.',','));
				$tpl->assign('result_quantity',number_format($data[$key]['result_quantity'],2,'.',','));
				$tpl->assign('after',number_format($data[$key]['after'],2,'.',',')); 

						/*@$totalresult+=$data[$key]['result_quantity'];
						@$totalafter +=$data[$key]['after'];
						@$totaldealmoney +=$data[$key]['dealmoney'];*/

						@$totalresult+=$data[$key]['result_quantity'];
						@$totalafter +=$data[$key]['after'];
						@$totaldealmoney +=$data[$key]['dealmoney'];	

			}
			$tpl->gotoBlock( 'userhistoryamountTitleBlock' );
			$color=($totalafter<0)?'#FF0000':'#228B22';
			$tpl->assign('color',$color);
			$tpl->assign('totaldealmoney',number_format($totaldealmoney,2,'.',','));
			$tpl->assign('totalresult',number_format($totalresult,2,'.',','));
			$tpl->assign('totalafter',number_format($totalafter,2,'.',','));
			$totalresult='';
			$totalafter ='';
			$totaldealmoney ='';
			//number_format($dealmoney,2,'.',',')
		} 
	}	
	
	$cssFileArr = array( 'interface/v2/css/bootstrap-datetimepicker.css', 'interface/v2/css/bootstrapValidator.css' );
	while( list( $key ) = @each( $cssFileArr ) )
	{
		$tpl->newBlock( 'cssInc' );
		$tpl->assign  ( 'includeCssFile', $cssFileArr[$key] );
	}
	$jsFileArr = array( 'interface/v2/js/bootstrapValidator.js', 'interface/v2/js/moment-with-locales.js', 'interface/v2/js/bootstrap-datetimepicker.js', 'interface/v2/js/selectDate.js' );
	while( list( $key ) = @each( $jsFileArr ) )
	{
		$tpl->newBlock( 'javascriptInc' );
		$tpl->assign  ( 'includeJSFile', $jsFileArr[$key] );
	}
	actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();

?>