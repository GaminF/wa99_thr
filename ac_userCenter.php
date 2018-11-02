<?php
	include( '../devInclude/includeBaseV2.php' );	//各類include檔案

	switch( $_REQUEST['actionStep'] )
	{
		//快捷金額設定
		case "upFastAmount":
			if( !is_array( $_REQUEST['fastAmount'] ) ) die( false );
			while( list( $key ) = @each( $_REQUEST['fastAmount'] ) )
			{
				if( !empty( $_REQUEST['fastAmount'][$key] ) ) $fastAmountArr[] = $_REQUEST['fastAmount'][$key];
			}
			echo getUpdateCommon( @implode( ',', $fastAmountArr ) );
		break;
		default:
			$Arr['chgmun']=$_POST['chgmun'];//email qq mobile wechat phone2 skype passwd pickup(提領密碼) 要改什麼就帶什麼進去改
			$Arr['oldaccount']=$_POST['old'];//
			$Arr['newaccount']=$_POST['new'];//
			$result=getUpdatePwd( $Arr );
			echo $result[0]['changeStatus'];
		break;
	}
?>