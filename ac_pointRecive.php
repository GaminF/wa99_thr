<?php
	include( '../devInclude/includeBaseV2.php' );	//各類include檔案
	$rc		 	= new redisCache;
	$temp		= $rc->getVar( 'UserBase'.$_SESSION["WEB2"]['userid'] );
	$userbase 	=json_decode($temp,true);
	$rc->setVar('savemoney'.$_SESSION["WEB2"]['userid'],$reservice['stayPoint'],300);
	if( ( $userbase['quota'] - $userbase['stayPoint'] ) < $_POST['amount'] ) die( 'Fail Quota');
	if( $userbase['times'] == 1 )
	{
		list( $key ) = @each( $userbase );
		if( $userbase[$key]['bkid'] != $_POST['bankid'] )			die( 'Fail bankid');
		if( $userbase[$key]['account'] != $_POST['accountNum'] )	die( 'Fail accountNum');
		if( $userbase[$key]['aname'] != $_POST['accountName'] )		die( 'Fail accountName');
	}
	elseif( $userbase['times'] == 0 )
	{
		if( $userbase['aname'] != $_POST['accountName'] )			die( 'Fail accountName');
		//寫入會員提領帳戶
		$addArr['bankID']		= $_POST['bankid'] ;
		$addArr['branch']		= '';
		$addArr['bankAccount']	= $_POST['accountNum'];
		$addArr['accountName']	= $_POST['accountName'];
		$addArr['receivePwd']	= $_POST['widthdrawpassword'];
		addUserBank( $addArr );
	}
	else
	{
		die( 'Fail NotCache Data');
	}

	//if($userbase['aname'])
	$Arr['uid']=$_SESSION["WEB2"]['id'];
	$Arr['userName'] =$_SESSION["WEB2"]['MemID'];
	$Arr['action']=2;
	$Arr['amount']='-'.$_POST['amount'] ;
	$Arr['companyAccount']= '';//提領才有 bank id
	$Arr['saveBy']= '银联卡'  ;
	$Arr['bankName']= $_POST['bankid'] ;
	$Arr['accountNum']= $_POST['accountNum'];
	$Arr['accountName']=$_POST['accountName'] ;
	$Arr['transferTime']=date("Y-m-d H:i:s");
	$Arr['widthdrawpassword']= $_POST['widthdrawpassword'] ;
	$Arr['receivePwd']=$_POST['widthdrawpassword'] ;
	$Arr['fee']=$_POST['fee'] ;
	//print_r($_POST);
	$pwdresult=ckReceivePwd( $Arr );
	if($pwdresult!='000')die( 'fail ckReceivePwd');
	$result=setAccountMoney( $Arr );
	echo $result;
?>