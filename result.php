<?php
	ini_set('display_errors','Off');
	error_reporting(NULL);
	include( 'config.php' );
	//if( $sys->userAlive['errorCode'] != 'OK' ) $sys->redirectUrl( 'logout.php' );

	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/result.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );
	$dates=date('Y-m-d');
	
	for($i=-1;$i<=12;$i++){
		if($i==-1){
			$st=strtotime("$dates + 1 days");
		}
		else{
			$st=strtotime("$dates - $i days") ;
			
		}

		$tpl->newBlock('gameHistoryDetailTitleBlock');
		$day=date('Y-m-d',$st);
		$dayshow=date('m月d日',$st);
		$weekday = date('w', strtotime($day));
		$weeklist = array('日', '一', '二', '三', '四', '五', '六');
		//echo $dayshow.'星期'.$weeklist[$weekday].'<br>';
		$tpl->assign( 'datetime',$day);
		$tpl->assign( 'dayshow',$dayshow);
		$tpl->assign( 'w',$weeklist[$weekday]);

		if($day==$_GET['day'] || !isset($_GET['day']) && $day==$dates)
		{
			$tpl->assign('s','selected');
		}
	} 
	
	$starttime=($_GET['day'])?$_GET['day']:date('Y-m-d');

	
	$result=getGameResult($starttime);
	
	while (list($key)=@each($result)) {
		$opendate=explode(' ', $result[$key]['openDate']);
		$timestamp=explode(' ',$result[$key]['timestamp']);
		$score=explode('-',$result[$key]['correctScore']);
		$totalscore=$score[0]+$score[1];
		
		$tpl->newBlock( 'gameHistoryDetailcontentBlock');	
				
			
			$host=@$result[$key]['home'];
			$guest=@$result[$key]['away'];
			
			$tpl->assign('opendate',$starttime);
			$tpl->assign('opentime',$opendate[1]);
			$tpl->assign('timestamp_date',$timestamp[0]);
			$tpl->assign('timestamp_time',$timestamp[1]);
			$tpl->assign('totalscore',$totalscore);
			$tpl->assign($result[$key]);
			

			$tpl->assign( 'host', $host);
			$tpl->assign('guest',$guest);
	}
	actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();
?>