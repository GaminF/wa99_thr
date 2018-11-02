<?php
	include( 'config.php' );
	//if( $sys->userAlive['errorCode'] != 'OK' ) $sys->redirectUrl( 'logout.php' );

	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/fifa_history.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );
	//$tpl->assign('date',date('Y/m/d'));
	$no='';
	$mark=1;
	$weeklist = array('日', '一', '二', '三', '四', '五', '六');
	$tpl->assign('mark',1);
	//$dates=date('Y-m-d');
			
			//$starttime=date("Y-m-d",strtotime("-1 day")); 
			$starttime="2018-05-24";
			$endtime="2018-05-29";
			//$endtime=date("Y-m-d",strtotime("+1 day"));	
			$tpl->assign('startdate',date("Y-m-d",strtotime("-1 day")));
			$tpl->assign('enddate',date("Y-m-d",strtotime("+1 day")));
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
	//actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();

?>