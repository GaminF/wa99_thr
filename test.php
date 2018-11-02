<?php

	include( '../devInclude/includeBaseV2.php' );
ini_set("display_errors", "off"); // 顯示錯誤是否打開( On=開, Off=關 )
error_reporting(E_ALL & ~E_NOTICE);
	echo '<pre>';
	//$data['function_name'] = 'TESTAPI';
	//userApiMonitorRecord( $data );
	if( $_REQUEST['delMonitorCache'] ) userApiMonitorClear();
	else userApiMonitorDisplay();
	function userApiMonitorRecordxxx( $data )
	{
		if( empty( $_SESSION["WEB2"]['MemID'] ) || empty( $data['function_name'] ) ) return false;
		$arr['user'] = $_SESSION["WEB2"]['MemID'];
		$arr['func'] = $data['function_name'];
		$arr['route']= 'WEB';
		$mRc = new sysMonitor();
		$mRc->monitorItemName = 'userApiMonitor';
		$mRc->userApiMonitorRecord( $arr );
	}
	function userApiMonitorDisplay()
	{
		$mRc = new sysMonitor();
		$mRc->monitorItemName = 'userApiMonitor';
		print_r( json_decode( $mRc->userApiMonitorDisplay(), true ) );
	}
	function userApiMonitorClear()
	{
		$mRc = new sysMonitor();
		$mRc->monitorItemName = 'userApiMonitor';
		print_r( json_decode( $mRc->userApiMonitorClear(), true ) );
	}
?>