<?
	$filename = "/var/www/html/wa99_thr/serviceQRCode/index.html";
	unlink( $filename );
	
	//讀取後端目錄檔案，建立比對索引檔案//
	$exec = 'wget -P /var/www/html/wa99_thr/serviceQRCode -N http://119.81.168.34/777/finance/serviceQRCode/';
	exec( $exec );
	
	echo 'exec:'.$exec;

	$str = "";
	if( file_exists( $filename ) )
	{
		$file = fopen($filename, "r");
		if( $file != NULL )
		{
			while( !feof( $file ) ) $str .= fgets($file);
			fclose($file);
		}
	}

	$imgArr	 = explode( ':', $str );
	while( list( $key ) = @each( $imgArr ) )
	{
		$imgArrs = explode( '.', $imgArr[$key] );
		if( count( $imgArrs ) < 3 ) continue;
		$img[$key]['tag']		= $imgArrs[0];
		$img[$key]['num']		= strtolower( $imgArrs[1] );
		$img[$key]['fileName']	= $imgArr[$key];
	}

print_r( $imgArr );

echo 'Get ImgArr:';
print_r( $img );

	//比對更新檔案//
	$toSet = 0;
	$Vhost_Dir = opendir( "/var/www/html/wa99_thr/serviceQRCode/" );
	while( $file = readdir( $Vhost_Dir ) )
	{
		$fArr = @explode( '.', $file );
		$qtype = strtolower( $fArr[0] );

		if( !$qtype || ( $qtype != 'wei' && $qtype != 'qq' && $qtype != 'paycode' ) ) continue;
		//$dArr[$qtype]['Img'] = $file;
		//$dArr[$qtype]['Num'] = $fArr[1];
		
		@reset( $img );
		while( list( $key ) = @each( $img ) )
		{
			if( $img[$key]['fileName'] == $file ) $dArr[] = $file;
		}
	}
	closedir($Vhost_Dir);
	
echo 'Local dArr:';
print_r( $dArr );
print_r( $img );

	if( is_array( $img ) )
	{
		echo 'Unlink.....';
		@reset( $dArr );
		while( list( $i ) = @each( $dArr ) ) unlink( '/var/www/html/wa99_thr/serviceQRCode/'.$dArr[$i] );
		@reset( $img );
		while( list( $x ) = @each( $img ) ) exec( $exec.$img[$x]['fileName'] );
	}
	unlink( $filename );
?>