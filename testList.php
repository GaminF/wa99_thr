<?
	include("config.php");
	//if( $sys->userAlive['errorCode'] != 'OK' ) $sys->redirectUrl( 'logout.php' );

	//取得賽事列表 $gArr(全部賽事), $dateArr(日期賽事), $cpArr(聯盟賽事)
	include( 'testgetGameList.php' );

	@krsort( $typeArr );
	@reset( $typeArr );
	echo '<pre>';
print_r( $typeArr );
?>