<?php
	include("config.php");
	include('fifa_data.php');
	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/fifa_tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/fifa_schedule.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );

	$tpl->prepare();
	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );

	$date=date("Y-m-d");
	//$date='2018-06-18';
	//$tomorrow=date('2018-06-18',strtotime("+1 day"));
	$tomorrow=date("Y-m-d",strtotime('+1 day'));
	$tpl->newBlock('today'.$date);
	$tpl->newBlock('tomorrow'.$tomorrow);
	if($date>"2018-07-08")
	{
		$tpl->newBlock('week2018-07-09');

	}
	else
	{
		$tpl->newBlock('week2018-07-02');
	}
	
	//print_r($winer32);

	
	while(list($group)=each($winer32))
	{
		$tpl->newBlock('GROUP');
		$tpl->assign('group',strtoupper($group));
		$team=$winer32[$group];
		$i=0;
		while (list($key)=each($team)) {

			$tpl->newBlock('teamscore');
			$tpl->assign($team[$key]);
			$i+=1;
			if($i<3)
			{
				$tpl->assign('color','#EEFFFD');
			}

		}
		
				
	}

	actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();


	
?>