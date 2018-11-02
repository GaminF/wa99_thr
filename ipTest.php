<?php

	include( '../devInclude/includeBaseV2.php' );	//各類include檔案

	if( empty( $_REQUEST['ip'] ) ) die( 'INPUT Var ip' );

	
	
	$sys = new TaoginStationEG;
	$Arr['IP'] = $_REQUEST['ip'];
	echo 'IP Check Result:'.$sys->getUserIpPermission( $Arr );

	
	echo '<p>';
	echo '<pre>';
	$ipFile	  = '/var/www/html/devInclude/ipCtrl/iplist.txt' ;
	$getFile  = @fopen( $ipFile, "r" );
	$readFile = @fread( $getFile, filesize( $ipFile ) );
	$xArr	  = json_decode( gzuncompress( $readFile ), true );
	print_r($xArr);
?>