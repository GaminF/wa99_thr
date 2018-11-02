<?php
	include('config.php');
	if(!isset($_SESSION)){ session_start(); } //檢查SESSION是否啟動
        $_SESSION['code4'] = ''; //設置存放檢查碼的SESSION
	if(!isset($_SESSION))
		{
	   		session_start();

	    }
	   if($_POST['step']<=2)
	   {
	   		$code4=rand(1000,9999);
	    	echo $code4;
	    	 $_SESSION['code4']=$code4;
	   }
	    


?>