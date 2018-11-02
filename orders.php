<?php
	//交易明細
	include( 'config.php' );

	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/orders.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );
	
	$tpl->newBlock( 'c2GetMatchBetInfoBlock');
	$result=getOrderList();
	// print_r($result);
	// print_r($_SESSION);
	$i='';
	$totaldealmoney='';
	$totalestimatedprofit='';
	$now=date('Y-m-d H:i:s');
	//$countnow=strtotime($now); for test
	
if(is_array($result))
{
	while (list($key)=each($result)) 
	{
		$i+=1;
		$tpl->newBlock( 'c2GetMatchBetInfodetailBlock');
		$tpl->assign($result[$key]);
		if($result[$key]['market']=='上半場波胆')
		{
			$tpl->assign('market','上半场波胆');
		}

		//echo $result[$key]['createtime'].'--';
		
		/*if( (strtotime($now) - strtotime($result[$key]['createtime']) )<180) 
		{
			$tpl->assign('cancel_button','<button onclick="delorder('.$result[$key]['betId'].')">取消订单</button>');
		}*/
		//$tpl->assign('ans',(strtotime($now) - strtotime($result[$key]['createtime']) ));//測試用，記得刪

		$tpl->assign('dealmoney',number_format($result[$key]['dealmoney'],2,'.',','));
		$tpl->assign('profit',$result[$key]['profit']*100);
		$tpl->assign('Fee',$result[$key]['marketFee']*100);
		//$estimatedprofit=floor($result[$key]['dealmoney']*$result[$key]['profit']*(1-$result[$key]['marketFee'])*100)/100;
		$estimatedprofit=floor($result[$key]['dealmoney']*$result[$key]['profit']*(100-$result[$key]['marketFee']*100))/100;
		$tpl->assign('estimatedprofit',$estimatedprofit);
		$totaldealmoney += $result[$key]['dealmoney'];
		$totalestimatedprofit += $estimatedprofit;
	}

	if($i=='')
	{
		$tpl->newBlock('nonBlock');
		$i=0;
		$totaldealmoney=0;
		$totalestimatedprofit=0;
	}
	$tpl->gotoBlock( 'c2GetMatchBetInfoBlock' );

	$tpl->assign('i',count($result));
	$tpl->assign('totaldealmoney',@number_format($totaldealmoney,2,'.',','));
	$tpl->assign('totalestimatedprofit',@number_format($totalestimatedprofit,2,'.',','));
}
	actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();
?>