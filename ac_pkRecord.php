<?php
	include( 'ac_config.php' );	//各類include檔案
	$tpl=new TemplatePower( "interface/".$siteInfo['interface']."/html/ac_pkRecord.html" );
			$_REQUEST['openDate']=$_POST['gametime'];
			$_REQUEST['event']=$_POST['gamename'];
			// $_REQUEST['openDate']='2017-10-06 20:00:00';
			// $_REQUEST['event']='俄罗斯U21 v 奥地利U21';
			$result=getPkRecord();
			//$tpl = new TemplatePower( "gamelist.html" );
			$tpl->prepare();
		
			while (list($key)=each($result))
			{
				$tpl->newBlock( 'pkrecordBlock');
				$tpl->assign($result[$key]);
			}
			$tpl->printToScreen();
			// echo '<pre>';
			 //print_r($_REQUEST);
			// print_r($result);
?>