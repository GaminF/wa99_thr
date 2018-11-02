<?
	//取得會員資訊
	include( '../devInclude/includeBaseV2.php' ); //各類include檔案
	$mbInfoArr = getMemberInfo();
	$mbInfoArr['quotaView'] = number_format( $mbInfoArr['quota'], 2, '.', ',' );
	echo json_encode( $mbInfoArr );
?>