<?
	include( '../devInclude/includeBaseV2.php' );	//各類include檔案
	include( 'getGameList.php' );
	$siteInfo = array( "interface"=>"v2" );

	$tpl = new TemplatePower( "interface/".$siteInfo['interface']."/html/ac_targetCPMenu.html" );
	$tpl->prepare();

	$cpArr = $typeArr['CP'];
	if( is_array( $cpArr ) )
	{
		$tpl->newBlock( 'MarketSelectCP' );
		$tpl->newBlock( 'MarketSelectCP_Row' );
	}
	
	$rowNum = 4;
	$i = 1;
	while( list( $cpID ) = @each( $cpArr ) )
	{
		$tpl->newBlock( 'MarketSelectCP_RowList' );
		$tpl->assign  ( $cpArr[$cpID] );
		$tpl->assign  ( 'lastTag', ( $i == $rowNum ) ? 'last_one' : '' );
		$tpl->assign  ( 'checked', ( $i == 1 ) ? 'checked' : '' );
		$i++;
	}
	$tpl->newBlock( 'MarketCPList' );

	$x = 1;
	@reset( $cpArr );
	while( list( $cpID ) = @each( $cpArr ) )
	{
		$tpl->newBlock( 'MarketCPList_Table' );
		$tpl->assign  ( $cpArr[$cpID] );
		$tpl->assign  ( 'inActive', ( $x == 1 ) ? 'in active' : '' );
		while( list( $i ) = @each( $cpArr[$cpID]['dataArr'] ) )
		{
			$tpl->newBlock( 'MarketCPList_TableRow' );
			$tpl->assign  ( $cpArr[$cpID]['dataArr'][$i] );
			$tpl->assign  ( 'lastRow', ( $cpArr[$cpID]['Count'] == $x ) ? 'last_row' : '' );
			$tpl->assign  ( 'gameDay', substr( $cpArr[$cpID]['dataArr'][$i]['gametime'], 0, 10 ) );
			$tpl->assign  ( 'gameTime', substr( $cpArr[$cpID]['dataArr'][$i]['gametime'], 11, 5 ) );
			$tpl->assign  ( 'gametime', substr( $cpArr[$cpID]['dataArr'][$i]['gametime'], 0, 16 ) );
		}
		$x++;
	}
	
	$tpl->printToScreen();
?>