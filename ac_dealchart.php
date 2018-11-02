<?php
	include( 'ac_config.php' );	//各類include檔案
	$chart = array(	1=>array( 'chartname'=>'波胆', ),
					2=>array( 'chartname'=>'半场波胆', ),
					3=>array( 'chartname'=>'总得分', ),
					0=>array( 'chartname'=>'首入球时间', )
					);

	// $Arr['gameid']=$_POST['gameid'];
	// $Arr['ga12']=$_POST['ga12'];
	// $Arr['chartid']=$_POST['chartid'];
	//print_r($Arr);
	//$apiData=getGameItemList( $_POST['gameid'], $_POST['ga12'], $_POST['chartid']);

	//獨立交易量表
	$Arr['eventId']=$_POST['gameid'];
	$Arr['marketId']=$_POST['marketid'];
	$Arr['chartid']=$_POST['chartid'];
	//print_r($Arr);

	$result=dealmoneychart($Arr);
	//print_r($result);
	$deal=array();
	$x=1;
	
	while (list($key)=@each($result)) 
	{
		$dealdata[$x]['selection'][]=sprintf( "'%s'",$result[$key]['selection']);
		$dealdata[$x]['totaldealmoney'][]=$result[$key]['selection_sum_deal_money'];
		//20180920 add by nillie to replace Traditional characters.
		$dealdata[$x]['selection']	= str_replace ( "進", "进",$dealdata[$x]['selection'] );
		if($key==9)
		{
			$deal[$x]['item']=@implode(',',$dealdata[$x]['selection']);
			$deal[$x]['num']=@implode(',',$dealdata[$x]['totaldealmoney']);
			$x+=1;
		}
				
		$deal[$x]['item']=@implode(',',$dealdata[$x]['selection']);
		$deal[$x]['num']=@implode(',',$dealdata[$x]['totaldealmoney']);
	}

	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/ac_dealchart.html" );
	$tpl->prepare();
	/*if(empty($apiData["deal_money_array"]))
	{
		$tpl->newBlock('dealnochart');
	}*/
	$tpl->newBlock('dealchart');

	
	
	$i=0;
	for($i=0;$i<=2;$i++)
	{
		$tpl->assign('num'.$i,	$deal[$i]['num']);
		$tpl->assign('item'.$i, $deal[$i]['item']);
		//echo $deal[$key][$x]['item'];
	}
		
			
			
	

	$tpl->printToScreen();

?>