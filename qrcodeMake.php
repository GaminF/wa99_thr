<?php
	/*** 系統來源 http://phpqrcode.sourceforge.net/ ***/
	
	include( "../devInclude/phpqrcode/qrlib.php" ); // 引用 PHP QR code

	//$_REQUEST['level'] //L、M、Q、H，Error Correction Level，錯誤修正能力
	//$_REQUEST['size'] //1~10
	//$_REQUEST['data'] //要編成 QR code 的資料

	$errorCorrectionLevel = 'L';
	if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L', 'M', 'Q', 'H'))) {
		$errorCorrectionLevel = $_REQUEST['level'];
	}

	$matrixPointSize = 4;
	if (isset($_REQUEST['size'])) {
		$matrixPointSize = min(max((int) $_REQUEST['size'], 1), 10);
	}

	if (isset($_REQUEST['data'])) {
		if (trim($_REQUEST['data']) == '') {
			die('沒有資料');
		}
		QRcode::png($_REQUEST['data'], false, $errorCorrectionLevel, $matrixPointSize, 2);
	}
?>