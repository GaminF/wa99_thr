<?php
	include( 'config.php' );
	include( '../devInclude/readFile/xfiles.php' );
	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/fifa_temp.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/statistics.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );

	$x_score = $ttss;
	@reset( $cpMenuArr );
	@reset( $x_score );
	
	$tpl->prepare();
	$tpl->assign( $siteInfo );
	
	//登入前後
	$menuInfoBarTag = ( is_array( $mbInfoArr ) ) ? 'menuInfoBar_Login' : 'menuInfoBar_notLogin' ;
	$tpl->newBlock( $menuInfoBarTag );
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( $_REQUEST );
	$tpl->assign  ( $mbInfoArr );

	$tpl->gotoBlock('_ROOT');
	$cp=($_GET['cp'])?$_GET['cp']:0;
	$tpl->assign('union_name',$cpMenuArr[$cp]);
	while(list($key)=each($cpMenuArr))
	{
		$tpl->newBlock('scorerBlock');
		
		$tpl->assign('file','<img src="interface/v2/img/soccer_'.sprintf( '%02d', $key+1 ).'.png" class="alli_logo">');
		$tpl->assign('union',$cpMenuArr[$key]);
		$tpl->assign('i',$key);
	}
	
	while(list($key)=each($x_score))
	{
		if(is_array($x_score))
		$tpl->newBlock('xfile'.$key);
		$tpl->assign('titleName',$x_score[$key]['titleName']);
		while(list($data)=each($x_score[$key]['dataArr']))
		{
			$tpl->newBlock('score'.$key);
			$tpl->assign($x_score[$key]['dataArr'][$data]);
			$tpl->assign('3',number_format($x_score[$key]['dataArr'][$data][3]*100,2).'%');
		}
	}

	$tpl->gotoBlock('_ROOT');
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->printToScreen();
?>