<?php
	include( 'config.php' );
	
	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/notice.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );

	$tpl->assign( 'titlename', ( $_GET['type'] == 3 ) ? '个人讯息' : '网站公告' );
	$tpl->newBlock('c2GetNoticeInfoTitleBlock');

	if( empty( $_GET['type'] ) )
	{
		$result = $siteInfo['notice'];
	}
	else
	{
		$Arr['maxnumber']	= 200 ;
		$Arr['number']		= 0 ;
		$Arr['type']		= $_GET['type'];
		$result				= getNotice( $Arr );
	}
	$i='';
	//print_r($result);
	rsort($result);
	@reset( $result );
	//$pkey=rsort($result);
	while( list( $key ) = @each( $result ) ) 
	{
		if( $result[$key]['show'] != 1 ) continue;
		if( $_GET['type'] == 3 && $result[$key]['member'] != $_SESSION["WEB2"]['MemID'] ) continue;
		$i+=1;
		$tpl->newBlock( 'c2GetNoticeInfoBlock' );
		$tpl->assign  ( $result[$key] );
		$tpl->assign  ( 'noticdate', substr( $result[$key]['noticdate'], 0, 16 ) );
		$tpl->assign  ( 'i', $i );
	}
	if( $i == '' ) $tpl->newBlock( 'c2GetNoticeInfoNotFindBlock' );
	actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();
?>