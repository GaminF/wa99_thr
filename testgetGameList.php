<?
	//取得所有賽事列表，並分類為依全賽事、日期、聯盟
	$gArr = getGameList();
	
	$typeArr['All']['list'] = $gArr;
	//進行賽事分類整理
	while( list( $key ) = @each( $gArr ) )
	{
		$timeStr = substr( $gArr[$key]['gametime'], 11, 2 );
		echo 'timeStr:'.$timeStr.'------------<br>';
		$dateStr = ( $timeStr >= 12 ) ? date( 'Y-m-d', strtotime( $gArr[$key]['gametime']." +1 day" ) ) : substr( $gArr[$key]['gametime'], 0, 10 ) ;
		echo 'dateStr:'.$dateStr.'====<br>';
		//$dateStr = substr( $gArr[$key]['gametime'], 0, 10 );
		$typeArr['Day'][$dateStr][] = $gArr[$key];//依日期分列
		$typeArr['CP'][$gArr[$key]['competitionname']]['CPName'] = $gArr[$key]['competitionname'];
		$typeArr['CP'][$gArr[$key]['competitionname']]['Count']++;
		$typeArr['CP'][$gArr[$key]['competitionname']]['dataArr'][] = $gArr[$key];//依聯盟分列
	}
	@reset( $typeArr );

	if( $_GET['debug'] ) print_r( $typeArr );
?>