<?php
	include( 'config.php' );
	//if( $sys->userAlive['errorCode'] != 'OK' ) $sys->redirectUrl( 'logout.php' );
	$menuInfoBarTag = ( is_array( $mbInfoArr ) ) ? 'tgIndex.html' : 'tgIndex_out.html' ;
	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/".$menuInfoBarTag."" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/hotnews.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );
	$Arr['news_id']=$_GET['news_id'];
	if($Arr['news_id'])//如果有news_id,显示新闻内容
	{
		$tpl->newBlock('SEENEWS');
		$inout = ( is_array( $mbInfoArr ) ) ? 'COMMENTAREA' : 'CANTCOMMENT' ;//登入后才可发表评论
		$tpl->newBlock($inout);

		$Arr['news_id']=$_GET['news_id'];
		$content=news_detail($Arr);
		$msglist=news_msg_list($Arr);
		$tpl->newBlock('newscontent');

		while (list($key)=each($content['news_content'])) //显示新闻内容
		{
			$tpl->assign($content['news_content']);
			$tpl->assign('news_time',substr($content['news_content']['news_time'], 0,10));
			$tpl->goToBlock('COMMENTAREA');
			$tpl->assign('id',$content['news_content']['id']);
		}


		while (list($key)=each($msglist)) //显示留言列表
		{
			$tpl->goToBlock('SEENEWS');
			$tpl->assign('msg_num',$msglist['msg_num']);
			$inlist=$msglist[$key];
			while (list($key2)=each($inlist)) 
			{
				$tpl->newBlock('MSG');
				$tpl->assign($inlist[$key2]);
				if($key2>4)
				{
					$tpl->assign('x','x');
				}
				$status=($key2>4)?'none':'block';
				$tpl->assign('status',$status);
				if($key2==4)
				{
					$tpl->newBlock('MORE');
				}
			}
		}
	}
	else
	{
		$tpl->newBlock('NEWSLIST');//显示新闻清单
		$hotnews=hotnews();
		//print_r($hotnews);
		while(list($key)=each($hotnews['news_list']))
		{
			$newsarea=($key<4)?'HOTNEWSBAR':'HOTNEWSLINE';
			$tpl->newBlock($newsarea);
			$tpl->assign($hotnews['news_list'][$key]);
			$tpl->assign('news_time',substr($hotnews['news_list'][$key]['news_time'],0,10));
		}
	
	}
	
	//actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();



?>