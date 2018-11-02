<?php
	include( '../devInclude/includeBaseV2.php' );	//各類include檔案
	$to = "ameko78613@gmail.com";
	$subject = "Test mail from TG";
	$message = "Hello! This is a simple email message.";
	//$from = ($_POST['mail'])?$_POST['mail']:'';
	$headers = "From:";//"From: $from"
	//mail($to,$subject,$message,$headers);
	//echo "Mail Sent.";
	if(!isset($_SESSION))
	{
   		session_start();

    }  //判斷session是否已啟動

	if((!empty($_SESSION['check_word'])) && (!empty($_POST['check_word'])))//判斷此兩個變數是否為空
	{  
    	
    	if($_SESSION['check_word'] == $_POST['check_word'])
    	{
          	$_SESSION['check_word'] = '';//比對正確後，清空將check_word值
         //  header('content-Type: text/html; charset=utf-8');
         // mail($to,$subject,$message,$headers);
          	 echo 'ok';
	 	}
		 else
		 {
		 	print_r($_SESSION);
		    echo 'error';
		         
	     }

	}
	else
	{
		print_r($_SESSION);
		print_r($_POST);
	}


?>