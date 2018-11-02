<?php
	include( 'config.php' );

	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/my.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );
	$tpl->prepare();
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );
	$Arr['id']=$_SESSION["WEB2"]['id'];
			$Arr['username']=$_SESSION["WEB2"]['MemID'];
			$Arr['uid']=$_SESSION['WEB2']['userid'];
			$i=0;
			if( $Arr['id'] && $Arr['username'])
			{
				$result=getMemberInfo( $Arr );
				////print_r($result);
				$getUserUpdateresult=getUserUpdate();
				$getOrderListresult=getOrderList();
				////print_r($getUserUpdateresult);
				////print_r($getOrderListresult);
				
				$tpl->newBlock( 'memberinfoBlock');
				$tpl->assign($result);
				$tpl->assign($getUserUpdateresult[0]);
				$tpl->assign('mobile', mkStr( $getUserUpdateresult[0]['mobile'], '*', 3, 1 ));
				// echo '<pre>';
				// print_r($getUserUpdateresult);
				if($getOrderListresult){
					while(list($key)=each($getOrderListresult))
					{
						$i+=1;
					}
				}
				$tpl->assign('i',$i);
				/*if(isset($_POST['chgmun']))
				{
					
						$Arr['chgmun']=$_GET['chgmun'];//email qq mobile wechat passwd pickup(提領密碼) 要改什麼就帶什麼進去改
						$tpl->newBlock('userpickupBlock');

						$tagname=array('mail'=>'電子信箱', 'qq'=>'QQ帳號', 'wechat'=>'微信帳號', 'pickup'=>'提領密碼', 'passwd'=>'登入密碼');
						$tpl->assign('itemname', $tagname[$_GET['chgmun']]);
						$tpl->assign('item',$Arr['chgmun']);
						$tpl->assign('compare',$getUserUpdateresult[0][$Arr['chgmun']]);

				}*/

		}
		else
		{
			echo '導回登入頁';
		}

	actionKeepLive();//檢驗登入狀態
	$tpl->printToScreen();
?>