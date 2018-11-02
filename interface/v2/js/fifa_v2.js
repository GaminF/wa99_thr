
	//市場下單 START----------------------
	var CacheReLoadData	= '';
	//市場參數-賽事列表
	var CacheGameID		= '';
	var CacheGa12		= '';
	var CacheGameTime	= '';
	var CacheCPName		= '';
	var CacheGameName	= '';
	//市場參數-市場項目
	var CacheMarketID	= '';
	var CacheSelectID	= '';
	var CacheTradingVol = '';
	var CacheMarketName	= '';
	var CacheSelectName	= '';
	var CacheProfit		= '';
	var CacheSize		= '';
	//市場訂單
	var CacheOrderNo	= '';
	
	// STEP1 市場列表左選單切換
	var showListID = 'GIlist';
	function fifa_showList( showItem )
	{
		console.log( 'fifa_showList( '+showItem+' )');
		//alert( 'showListID:'+showListID+' / showItem:'+showItem );
		$( '#B'+showListID ).removeClass( "active" );
		$( '#'+showListID ).slideUp();
		$( '#B'+showItem ).addClass( "active" );
		$( '#'+showItem ).slideDown();
		showListID = showItem;
	}
	//清理重設市場參數
	function fifa_clearCacheVal()
	{
		console.log( 'clearCacheVal()');
		CacheGameID		= '';
		CacheGa12		= '';
		CacheGameTime	= '';
		CacheCPName		= '';
		CacheGameName	= '';
		CacheMarketID	= '';
		CacheSelectID	= '';
		CacheTradingVol = '';
		CacheMarketName	= '';
		CacheSelectName	= '';
		CacheProfit		= '';
		CacheSize		= '';
		CacheOrderNo	= '';
	}
	//市場項目下單後，兩秒(API Cache)更新市場項目&會員餘額
	var upDataTime;
	var upDataTimeId;
	function fifa_upDataTimeFunc(){
		console.log( 'fifa_upDataTimeFunc()'+upDataTime);
		clearTimeout( upTimeId );
		if( upDataTime == 0 )
		{
			//更新會員餘額
			reLoadUserInfo();
			//更新市場項目
			fifa_reLoadMarket();
		}else{
			upDataTime--;
			upDataTimeId = setTimeout( fifa_upDataTimeFunc, 1000 );
		}
	}
	//市場項目自動更新時間
	var upTimeNum;
	var upTimeId;
	function fifa_upTimeFunc(){
		$( "#runMarketTime" ).html( upTimeNum );
		clearTimeout( upTimeId );
		if( upTimeNum == 0 )
		{
			//reLoadMarket();
		}
		else{
			upTimeNum--;
			upTimeId = setTimeout( fifa_upTimeFunc, 1000 );
		}
	}
	function fifa_reLoadMarket()
	{
		fifa_marketTab( CacheGameID, CacheGa12, CacheGameTime, CacheCPName, CacheGameName );
	}
	// STEP2 呼叫右側市場項目表
	function fifa_marketTab( gameid, ga12, gametime, competitionname, gamename )
	{
		console.log( 'fifa_marketTab( '+gameid+', '+ga12+', '+gametime+', '+competitionname+', '+gamename+' )');
		clearCacheVal();//清理重設市場參數
		CacheGameID				= gameid;
		CacheGa12				= ga12;
		CacheGameTime			= gametime;
		CacheCPName				= competitionname;
		CacheGameName			= gamename;

		var iData				= new Object;
		iData['gameid']			= gameid;
		iData['ga12']			= ga12;
		iData['gametime']		= gametime;
		iData['noCache']		= CacheReLoadData; //設定是否重設市場項目Cache(剛交易後，取得新的資料)
		console.log( 'fifa_noCache:'+iData['noCache']+'-------' );
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'fifa_ac_targetList.php',
			data: iData,
			error: function(xhr) {
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );
			},
			success: function(response) {
				loadingCtrl( 0 );
				CacheReLoadData = ''; //清除設定, 依照市場項目Cache
				var now = new Date().getTime();
				$( '#MarketInfo' ).html( response );
				$( '#GameTitleInfo' ).html( '&nbsp;&nbsp;【'+CacheCPName+'】'+' '+CacheGameTime.slice(5)+' '+CacheGameName.replace(/ v /, "(主) vs ") );
				$( '#GameTitleInfo_chart' ).html( '&nbsp;&nbsp;【'+CacheCPName+'】'+' '+CacheGameTime.slice(5)+' '+CacheGameName.replace(/ v /, "(主) vs ") );
				//$( '#GameTitleInfo' ).html( '&nbsp;&nbsp;【'+CacheCPName+'】'+' '+CacheGameTime.slice(5)+' '+CacheGameName.replace(/ v /, "(主) vs ")+' '+now );
				upTimeNum = 60;
				fifa_upTimeFunc();//啟動更新計時
			}
		});
	}
	
	//下單POPUP STEP1
	//0531 nillie update pawben相關*/
	function fifa_MarketOrder( marketid, selectid, TradingVol, marketname, selectname, profit, systemrate, price, fee, pawben )
	{
		console.log( 'fifa_MarketOrder( '+marketid+', '+selectid+', '+TradingVol+', '+marketname+', '+selectname+', '+profit+', '+systemrate+', '+price+', '+fee+','+pawben+' )');

		CacheMarketID	= marketid;
		CacheSelectID	= selectid;
		CacheTradingVol = TradingVol;
		CacheMarketName	= marketname;
		CacheSelectName	= selectname;
		CacheProfit		= profit;
		CacheFee		= fee;
		CachePawbem		=pawben;

		//獲取單號
		var profitNum			= new Number( profit*100 );
		var iData				= new Object;
		iData['ac']				= 'getOrderNo';
		iData['gameid']			= CacheGameID;
		iData['ga12']			= CacheGa12;
		iData['gametime']		= CacheGameTime+':00';
		iData['competitionname']= CacheCPName;
		iData['gamename']		= CacheGameName;
		iData['marketid']		= CacheMarketID;
		iData['selectid']		= CacheSelectID;
		iData['profit']			= CacheProfit;
		iData['systemrate']		= systemrate;
		iData['price']			= price;
		iData['fee']			= fee;
		iData['pawben']			=CachePawbem;
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'fifa_ac_targetList.php',
			data: iData,
			error: function(xhr) {
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );
			},
			success: function(response)
			{
				loadingCtrl( 0 );
				reArr = response.split( ":" );
				var reArr = JSON.parse( response );
				if( reArr.errorcode == '000' )
				{
					CacheOrderNo = reArr.msg;
					
					//輸入金額POPUP資料
					$( '#sGameTime' ).html( CacheGameTime );
					$( '#sCPName' ).html( CacheCPName );
					$( '#sGameName' ).html( CacheGameName );
					$( '#sProfit' ).val( profitNum.toFixed(2)+'%' );
					$( '#MarketInfo_Item' ).html( CacheMarketName );
					$( '#MarketInfo_Select' ).html( CacheSelectName );
					$( '#MarketInfo_Item2' ).html( CacheMarketName );
					$( '#MarketInfo_Select2' ).html( CacheSelectName );
					$('#OrderAmount').val( '' );
					$( '#Result' ).html( '' );
					if(CachePawbem==1)
					{
						$('#sPawben').addClass("fifa_sPawben");
						$('#sPawben2').addClass("fifa_sPawben");
						$('#sPawben').text('保本');
						$('#sPawben2').text('保本');
					}
					if(CachePawbem==0)
					{
						$('#sPawben').removeClass("fifa_sPawben");
						$('#sPawben2').removeClass("fifa_sPawben");
						$('#sPawben').text('');
						$('#sPawben2').text('');
					}
					$( '#Modal_orderInput' ).css( 'display', 'block' );
					/*0531 nillie update test*/
					
					//確認POPUP資料
					$( '#sGameTime2' ).html( CacheGameTime );
					$( '#sCPName2' ).html( CacheCPName );
					$( '#sGameName2' ).html( CacheGameName );
					$( '#sProfit2' ).html( profitNum.toFixed(2)+'%' );
					$( '#MarketInfo_ItemSelect' ).html( CacheMarketName+' '+CacheSelectName );
					$( '#MarketInfo_ItemSelect2' ).html( CacheMarketName+' '+CacheSelectName );
					$('#OrderAmount').focus();
				}
				else
				{
					msg( {'status':0, 'title':'', 'text1':'资料已更新，请重新进行['+reArr.errorcode+']', 'text2':'' } );
					fifa_reLoadMarket();
				}
			}
		});
		//alert( 'selectid:'+selectid+' TradingVol:'+TradingVol+' marketid:'+marketid );
	}
	//下單快捷金額增加金額

	//下單計算預估獲利STEP1.2
	function Calculate()
	{
		CacheSize = parseFloat( $('#OrderAmount').val() );
		//ckOrderAmount( CacheSize );//檢查金額
		
		var size = Math.pow( 10, 2 );
		result = Math.floor( ( CacheSize*CacheProfit*0.95 ) * size ) / size ;//計算預估獲利

		$( '#Result' ).html( result );
		$( '#Result2' ).html( result );
		$( '#OrderAmount2' ).html( CacheSize );
	}

	//下單確認STEP1.3
	function fifa_MarketConfirm()
	{
		//var OrderAmount = $('#OrderAmount').val();
		if( !ckOrderAmount( CacheSize ) ) return false;
		$("#Modal_orderInput").css('display', 'none');
		$("#Modal_order02").css('display', 'block');//開啟確認POPUP
	}
	//送出注單
	function fifa_orderSubmit()
	{
		var iData		 = new Object;
		iData['ac']		 = 'actionOrder';
		iData['size']	 = CacheSize;
		iData['OrderNo'] = CacheOrderNo;
		//alert( 'Ready Submit Order gameid:'+iData['gameid']+', ga12:'+iData['ga12']+', effectivetime:'+iData['effectivetime']+', marketid:'+iData['marketid']+', selectid:'+iData['selectid']+', profit:'+iData['profit'] );
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'fifa_ac_targetList.php',
			data: iData,
			error: function(xhr) {
			},
			beforeSend:function(result)
			{
				$( "#Modal_order02" ).css( 'display', 'none' );
				loadingCtrl( 1 );
			},
			success: function(response)
			{
				loadingCtrl( 0 );

				var res = JSON.parse( response );
				if( res.errorcode == '000' )
				{
					CacheReLoadData = 1; //設定是否重設市場項目Cache(剛交易後，取得新的資料)
					$( '#res_competitionname' ).html( res.competitionname );
					$( '#res_gametime' ).html( res.gametime );
					$( '#res_game' ).html( res.game );
					$( '#res_gameselect' ).html( res.gamemarket+' '+res.gameselect );
					$( '#res_betid' ).html( res.betid );
					$( '#res_dealmoney' ).html( res.dealmoney );
					$( '#res_profit' ).html( res.profit );
					$( '#res_conversion' ).html( res.conversion );
					/*0613 nillie update test*/
					if(CachePawbem==1)
					{
						$('#res_pawben').addClass('fifa_res_sPawben');
						$('#res_pawben').text('保本');
					}
					else
					{
						$('#res_pawben').removeClass('fifa_res_sPawben');
						$('#res_pawben').text('');
					}
					$( '#Modal_order03' ).css( 'display', 'block' );
				}
				else
				{
					msg( {'status':0, 'title':'', 'text1':'交易失敗', 'text2':'['+res.errorcode+']'+res.msg } );
				}
				//更新市場項目表
				//fifa_reLoadMarket();
				upDataTime = 2;
				fifa_upDataTimeFunc();//2秒經過API Cache更新資料
			}
		});
		
	}
