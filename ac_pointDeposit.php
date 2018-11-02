<?php
	//充值外應程序Gamin.

	//ini_set('date.timezone','Asia/Shanghai');
	//include( '../devInclude/includeBaseV2.php' ); //各類include檔案
	include("config.php");

	switch( $_REQUEST['step'] )
	{
		//第三方支付—進行串接取回支付QRCode
		case 'pay3QRCodeResponse':
			if( empty( $_REQUEST['amount'] ) || empty( $_REQUEST['ptype'] ) ) die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 100, '数据有误', $_REQUEST['step'] ) );
			if( $_REQUEST['amount'] < 100 ) die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 101, '最低金额为100元', $_REQUEST['step'] ) );
			
			//同金額與內容，不重複取得API資料
			$rc			= new redisCache;
			$rcData		= $rc->getVar( $_SESSION["WEB2"]['MemID'].'_payWayIndex' );
			$cacheData	= $rc->getVar( $_SESSION["WEB2"]['MemID'].'_payWayIndexCache' );
			if( $rcData == 'setData' || $rcData == 'waitData' ) die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 102, '操作逾时，请重新操作', $_REQUEST['step'] ) );
			$rc->delVar( $_SESSION["WEB2"]['MemID'].'_payWayIndex' );

			$getData		= json_decode( $rcData, true );
			$getCacheData	= json_decode( $cacheData, true );

			$dArr = $getData[0];

			//重複發送，則取用Cache記錄QRCode
			if( $getCacheData['amount'] != $_REQUEST['amount'] || $getCacheData['kind'] != $_REQUEST['ptype'] || empty( $getCacheData['payCode'] ) )
			{
				$dArr['amount']	= $_REQUEST['amount'];
				$dArr['kind']	= $_REQUEST['ptype'];
				$dArr['step']	= $_REQUEST['step'];

				//取得第三方付款資料
				$pay3Info	= getPay3Way( $dArr );
				$setArr		= array_merge( $dArr, $pay3Info );
				$rc->setVar( $_SESSION["WEB2"]['MemID'].'_payWayIndexCache', json_encode( $setArr ), 300 );
				$payWayIndexCache = $rc->getVar( $_SESSION["WEB2"]['MemID'].'_payWayIndexCache' );
				actionLogs( $payWayIndexCache, 'payWayIndexCache' );
				$dArr = $setArr;
			}
			else
			{
				$dArr = $getCacheData;
			}
			$returnStr = json_encode( $dArr );
			actionLogs( $returnStr, 'pay3QRCodeResponse RETURN' );
			echo $returnStr;
		break;
		//網路銀行-取得記錄資料
		case 'bankResponse':
			if( empty( $_REQUEST['amount'] ) || empty( $_REQUEST['bankIndex'] ) || empty( $_REQUEST['ptype'] ) ) die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 100, '数据有误', $_REQUEST['step'] ) );
			if( $_REQUEST['amount'] < 100 ) die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 101, '最低金额为100元', $_REQUEST['step'] ) );
			$bkid = $_REQUEST['bankIndex'];
			$rc = new redisCache;
			$rcData = $rc->getVar( $_SESSION["WEB2"]['MemID'].'_payWayIndex' );
			if( $rcData == 'setData' || $rcData == 'waitData' ) die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 102, '操作逾时，请重新操作', $_REQUEST['step'] ) );

			$result = json_decode( $rcData, true );

			while( list( $key ) = @each( $result ) )
			{
				if( $result[$key]['id'] == $bkid ) $dArr = $result[$key];
			}
			if( !is_array( $dArr ) ) die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 103, '资料有误，请重新操作', $_REQUEST['step'] ) );
			$dArr['amount']		= $_REQUEST['amount'];
			$dArr['ptype']		= $_REQUEST['ptype'];
			$dArr['step']		= $_REQUEST['step'];
			$dArr['reCode']		= '000';
			$rc->setVar( $_SESSION["WEB2"]['MemID'].'_payWayIndex', json_encode( $dArr ), 600 );
			$returnStr = $rc->getVar( $_SESSION["WEB2"]['MemID'].'_payWayIndex' );
			actionLogs( $returnStr, 'bankResponse RETURN' );
			echo $returnStr;
		break;
		//網路銀行-執行交易
		case 'bankSubmit':
			$rc = new redisCache;
			$rcData = $rc->getVar( $_SESSION["WEB2"]['MemID'].'_payWayIndex' );
			if( $rcData == 'setData' || $rcData == 'waitData' ) die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 201, '操作逾时，请重新操作', $_REQUEST['step'] ) );
			$rc->delVar( $_SESSION["WEB2"]['MemID'].'_payWayIndex' );
			
			$getData = json_decode( $rcData, true );

			//系統掃碼直接帶入輸入資料 / 網銀已於bankResponse先存入參數
			if( $_REQUEST['ptype'] == 3 || $_REQUEST['ptype'] == 4 || $_REQUEST['ptype'] == 5 )
			{
				if( empty( $_REQUEST['payAccount'] ) ) die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 202, '支付帐号有误，请重新操作', $_REQUEST['step'] ) );
				$dArr = $getData[0];
				$dArr['payAccount'] = $_REQUEST['payAccount'];
				$dArr['amount']		= $_REQUEST['amount'];
				$dArr['ptype']		= $_REQUEST['ptype'];
			}
			else
			{
				$dArr = $getData;
			}
			if( empty( $dArr['id'] ) )		die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 203, '交易数据有误，请重新操作', $_REQUEST['step'] ) );
			if( empty( $dArr['ptype'] ) )	die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 204, '交易数据有误，请重新操作', $_REQUEST['step'] ) );
			if( empty( $dArr['amount'] ) || $dArr['amount'] < 100 )	die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 205, '交易金額有误，请重新操作', $_REQUEST['step'] ) );

			$Arr['action']				= 1;
			$Arr['amount']				= $dArr['amount'];
			$Arr['companyAccount']		= $dArr['id'];
			$Arr['saveBy']				= $kindArr[$dArr['ptype']]['kindName'];
			$Arr['bankName']			= '';
			$Arr['accountNum']			= $dArr['payAccount'];
			$Arr['accountName']			= '';
			$Arr['transferTime']		= date( 'Y-m-d H:i:s' );
			$Arr['widthdrawpassword']	= '';
			$Arr['fee']					= '';

			$result = setAccountMoney( $Arr );
			if( $result != 1 ) die( sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', 206, '您本次交易未完成，请确认资料后，重新尝试', $_REQUEST['step'] ) );

			$returnStr = sprintf( '{"reCode":"%s","reMsg":"%s","step":"%s"}', '000', '「申请成功」系统将自动审核，请耐心等候！', $_REQUEST['step'] );
			actionLogs( $returnStr, 'bankSubmit RETURN' );
			echo $returnStr;
		break;

	}
?>