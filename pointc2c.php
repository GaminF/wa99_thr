<?php
	/* 會員互轉開放限制
	$date=date("His");
	if($date>"210000" || $date<"020000")
	{
		header("location:pointDeposit.php");
		die();
	}
	*/
	include("config.php");
	//include('financeC2C_sample.php');
	//include('../apitest/TemplatePower3.0.2.1/class.TemplatePower.inc.php');
	if( $sys->userAlive['errorCode'] != 'OK' ) $sys->redirectUrl( 'logout.php' );//KeepLive( $sys->userAlive );//檢驗登入狀態
	//print_r($_SESSION);
	//die();
	$financeSetp   = array( 1=>"待确认", 2=>"确认中", 3=>"已完成", 4=>"已取消", 5=>"已删除" );
	$financeAction = array( 1=>array( 'FAction'=>"充值", 'Color'=>'#008800' ), 2=>array( 'FAction'=>"提领", 'Color'=>'#CC0000' ) );
	//$kindArr在config.php
					
	$layout = ( $_REQUEST["uc"] ) ? $_REQUEST["uc"] : "default" ;

	$upUserInfo = getUserUpdate();
	// print_r($upUserInfo);
	// die();
	$countrycode= getCountryCode();
	//$reservice=ckIsRecive8C2C($Arr);
	$userinfo = ( is_array( $upUserInfo[0] ) ) ? array_merge( $upUserInfo[0], $userinfo  ) : $userinfo ;

	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/tgIndex.html" );
	$tpl->assignInclude( "Content", "interface/".$siteInfo['interface']."/html/pointc2c.html" );
	$tpl->assignInclude( "Tips", "interface/".$siteInfo['interface']."/html/tips.html" );

	$tpl->prepare();
	$tpl->assign( 'hostUrl', $_SERVER['HTTP_HOST'] );

	$tpl->assign  ( $siteInfo );
	$tpl->assign  ( $mbInfoArr );
	$tpl->newBlock( 'pointc2cTitle' );
	if($date>"210000" || $date<"020000")
	{
		$tpl->assign('status','0');//close
	}
	else
	{
		$tpl->assign('status','1');//open
	}
	
	if($upUserInfo[0]['mobile']!='')
	{

		$tpl->newBlock( 'pointc2cBank' );
		$tpl->assign('payuser',$mbInfoArr['username']);
		
			$phonenumber=explode('-', $upUserInfo[0]['mobile']);
			if($phonenumber[1]=='')
			{
				$personal['countrycode']='';
				$personal['mobile']=$phonenumber[0];
			}
			else
			{
				$personal['countrycode']=$phonenumber[0];
				$personal['mobile']=$phonenumber[1];
			}
			//print_r($personal);
		
		$mobile=(!empty($personal['mobile']))?$personal['mobile']:$upUserInfo[0]['mobile'];
		$tpl->assign('usermobile',substr_replace($mobile,'***',4,3));
		$tpl->assign('nowtime',date("Y-m-d H:i:s") );
			
		/*20180822 新增國碼判斷式*/
		if($personal['countrycode']!=''|| !empty($personal['countrycode']))
		{
			echo $personal['countrycode'];
			$tpl->newBlock('YESCOUNTRYCODE');
			$tpl->assign('countrycode',$personal['countrycode']);
			for($i=0;$i<=count($countrycode);$i++)
			{
				if(@$countrycode[$i]['code']==$personal['countrycode'])
				{
					//echo $i;
					$tpl->assign('country',$countrycode[$i]['country']);
				}

			}

		}
		else
		{	
			$tpl->newBlock('NOCOUNTRYCODE');
			while(list($key)=each($countrycode))
			{
				$tpl->newBlock('GETCOUNTRYCODE');
				$tpl->assign($countrycode[$key]);
			}
		}
		$ssTag = 'quota'.$_SESSION["WEB2"]['id'];
		$ssVar = $mbInfoArr['quota'];
		$rc->setVar( $ssTag, $ssVar ,300);/*cache time 5min*/
		actionLogs( 'ssTag:'.$ssTag.', ssVar:'.$ssVar, 'SET CACHE C2C' );
	}
	else
	{
		$tpl->newBlock('pointc2clock');
	}

  	$tpl->printToScreen();

  	

?>