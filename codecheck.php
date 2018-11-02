<?php

include( 'config.php' );
//print_r($_SESSION);
	if($_SESSION['code4']==$_POST['code4'])
	{
		$_SESSION['code4']='';
		
		//$_SESSION[$_POST['code4']]=$_POST['code4'];
		echo '1';
	}

?>