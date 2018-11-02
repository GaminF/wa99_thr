<?php
	include( 'config.php' );
	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/showfee.html" );
	$tpl->prepare();

	$Arr['userName'] =$_SESSION["WEB2"]['MemID'];
	$result=getReceiveFee( $Arr );
	//echo $result['reached'];
	$tpl->assign('reached',$result['reached']) ;
	

	$tpl->printToScreen();
?>