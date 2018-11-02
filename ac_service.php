<?php
	include( '../devInclude/includeBaseV2.php' );	//各類include檔案
	
	$directory = 'serviceQRCode'; 

	if (is_dir($directory)) 
	{
		if ($dh = opendir($directory))
		{
			while (($file = readdir($dh)) !== false)
			{ 
				//echo $file;
				$downmin=explode('.',$file);
				//print_r($downmin);
				if(strtolower($_POST['icon'])== strtolower($downmin[0]))
				{
					//echo $downmin[$i][0];
					echo '<img src="serviceQRCode/'.$file.'" class="QQ_qrcode">';
					break;
				}

			}
			closedir($dh);
		
		}
		
	}
//以下精簡版
/*	$directory = 'serviceQRCode'; 

	if (is_dir($directory)) 
	{
		$dh = opendir($directory);
		while (($file = readdir($dh)) !== false)
		{ 
			//echo $file;
			$downmin=explode('.',$file);
			print_r($downmin);
			if(strtolower($_POST['icon']) != strtolower($downmin[0]) || !empty($showimg)) continue;
			$showimg = '<img src="serviceQRCode/'.$file.'" class="QQ_qrcode">';
		}
		closedir($dh);
		echo $showimg;
	}*/
?>