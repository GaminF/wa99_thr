
	//進入註冊頁
	function intoRegister( agent )
	{
		if( !agent )
		{
			msg( {'status':0, 'title':'', 'text1':'此功能暂不开放，请联络上层管理员', 'text2':'' } );
			return false;
		}
		window.location.href='./register.php?agent='+agent;	
	}

	//市場-選擇聯盟
	function cpMenu()
	{
		clearTimeout( upTimeId );//取消市場項目60秒倒數動作，聯盟狀態時才不會被影響
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_targetCPMenu.php',
			//data: iData,
			error: function(xhr) {
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );
			},
			success: function(response) {
				loadingCtrl( 0 );
				$( '#MarketInfo' ).html( response );
			}
		});
	}

	//市場-選擇聯盟
	var mkCPs = new Object;
	function showMarketCPTab( cpID )
	{
		//alert( $( '#c'+cpID ).prop("checked") );
		if( $( '#tab'+cpID ).css( 'display' ) == 'none' )
		{
			$( '#tab'+cpID ).css( 'display', 'block' );
		}
		else
		{
			$( '#tab'+cpID ).css( 'display', 'none' );
		}
	}
	function clearMarketCPTab()
	{
		alert( $('#cpTabArrs').length );
	}

	//關閉POPUP8ID
	function closePopup( tagID )
	{
		$( '#'+tagID ).css( 'display', 'none' );
	}
	
	//登入檢驗 START----------------------
	function ckLogin()
	{
		var account	= $( '#account' ).val();
		var pwd		= $( '#pwd' ).val();
		var reg = /^[a-zA-Z]/;
		var re2 = /(?!^[0-9]{6,}$)(?!^[a-zA-Z]{6,}$)^[0-9a-zA-Z]{6,}$/;

		if( !account.match( reg ) )
		{
			msg( {'status':0, 'title':'', 'text1':'账号开头请用英文字母', 'text2':'' } );
			return false;
		}
		else if( pwd.length < 6 )
		{
			msg( {'status':0, 'title':'', 'text1':'密码长度至少6个字符', 'text2':'' } );
			return false;
		}
		else if( account.length > 10 )
		{
			msg( {'status':0, 'title':'', 'text1':'请重新确认帐号', 'text2':'' } );
			return false;
		}
		else
		{
			SubmitLogin();
		}
	}
	//執行登入
	function SubmitLogin()
	{
		var account	= $( '#account' ).val();
		var pwd		= $( '#pwd' ).val();
		if( account == '' || pwd == '')
		{
			return false;
		}
		jQuery.ajax({
			type: 'POST',
			url:  'ac_session.php',
			data: 'account=' + account + '&pwd=' + pwd,
			error: function(xhr) 
			{
				msg( {'status':0, 'title':'', 'text1':'网络忙线中，请稍后再试！', 'text2':'' } );
			},
			beforeSend:function(response)
			{
				loadingCtrl( 1 );
			},
			success: function(response)
			{
				loadingCtrl( 0 );
				var code = response.split(':');
				/*預防不正常登入
				if( code[0].trim() == "111" )
				{
					msg( {'status':0, 'title':'', 'text1':'登入失败', 'text2':'请重新尝试登入['+code[0]+']', 'nextUrl':'./' } );
					//location.reload();
					return false;
				}
				*/
				if(code[0].trim()=="60")
				{
					msg( {'status':0, 'title':'', 'text1':'登入失败', 'text2':code[1] } );
					return false;
				}
				if(code[0].trim()=="13")
				{
					msg( {'status':0, 'title':'', 'text1':'登入失败', 'text2':code[1]+'['+code[0]+']' } );
					return false;
				}
				if(code[0].trim()=="0")
				{
					msg( {'status':0, 'title':'', 'text1':'登入失败', 'text2':'[密码错误]连续输入错误五次时，您的账号会被锁定' } );
					return false;
				}
				if(code[0].trim()=="4")
				{
					msg( {'status':0, 'title':'', 'text1':'密码错误 x '+code[2]+' 次!!', 'text2':'连续输入错误五次时，您的账号会被锁定' } );
					return false;
				}
				if(code[0].trim()=="5")
				{
					msg( {'status':0, 'title':'', 'text1':'登入失败', 'text2':'此账号已锁定，请洽上层管理员或客服人员！！' } );
					return false;
				}
				if(code[0].trim()=="104")
				{
					msg( {'status':0, 'title':'', 'text1':'登入失败', 'text2':'因多次登入错误暂时锁定IP！' } );
					return false;
				}
				if(code[0].trim()=="105")
				{
					msg( {'status':0, 'title':'', 'text1':'账号锁定', 'text2':'如有问题请洽上层管理员或客服人员！' } );
					return false;
				}
				if(code[0].trim()=="6")
				{
					msg( {'status':0, 'title':'', 'text1':'登入失败', 'text2':'账号与密码有特殊字符' } );
					return false;
				}
				if(code[0].trim()=="3")
				{
					msg( {'status':0, 'title':'', 'text1':'查无此账号！', 'text2':'' } );
					return false;
				}
				if(code[3].trim()=="1")
				{
					window.location.href='./register.php';
					return false;
				}
				if(code[0].trim()=="1")
				{
					//window.location.href='./targetList.php';
					window.location.href='./index.php';	//20180715 nillie modify for function hot3
				}
			}
		});
	}

	//hot3 的登入檢查
		function gologin()
		{
			msg( {'status':0, 'title':'', 'text1':'请先登入', 'text2':'' } );
					return false;
		}
	//更新會員餘額
	function reLoadUserInfo()
	{
		console.log( 'reLoadUserInfo()');

		var iData			= new Object;
		iData['noCache']	= 1; //設定是否重設市場項目Cache(剛交易後，取得新的資料)
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_memberInfo.php',
			data: iData,
			error: function(xhr) {
			},
			beforeSend:function(result)
			{
			},
			success: function(response) {
				var reArr = JSON.parse( response );
				if( reArr.username != '' )
				{
					$( '#quotaView' ).html( reArr.quotaView );
					$( '#pQuotaView' ).html( reArr.quotaView );
					$( '#memberQuota' ).val( reArr.quota );
				}
			}
		});
	}
	
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
	var reLoadSet		= '';
	//市場訂單
	var CacheOrderNo	= '';
	var CachePawbem		= '';
	
	// STEP1 市場列表左選單切換
	var showListID = 'GIlist';
	function showList( showItem )
	{
		console.log( 'showList( '+showItem+' )');
		//alert( 'showListID:'+showListID+' / showItem:'+showItem );
		$( '#B'+showListID ).removeClass( "active" );
		$( '#'+showListID ).slideUp();
		$( '#B'+showItem ).addClass( "active" );
		$( '#'+showItem ).slideDown();
		showListID = showItem;
	}
	//清理重設市場參數
	function clearCacheVal()
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
		CachePawbem		= '';
	}
	//市場項目下單後，兩秒(API Cache)更新市場項目&會員餘額
	var upDataTime;
	var upDataTimeId;
	function upDataTimeFunc(){
		console.log( 'upDataTimeFunc()'+upDataTime);
		clearTimeout( upTimeId );
		if( upDataTime == 0 )
		{
			reLoadSet = 'noReload';
			//更新會員餘額
			reLoadUserInfo();
			//更新市場項目
			reLoadMarket();
		}else{
			upDataTime--;
			upDataTimeId = setTimeout( upDataTimeFunc, 1000 );
		}
	}
	//市場項目自動更新時間
	var upTimeNum;
	var upTimeId;
	function upTimeFunc(){
		$( "#runMarketTime" ).html( upTimeNum );
		clearTimeout( upTimeId );
		if( upTimeNum == 0 )
		{
			reLoadMarket();
		}else{
			upTimeNum--;
			upTimeId = setTimeout( upTimeFunc, 1000 );
		}
	}
	function reLoadMarket()
	{
		marketTab( CacheGameID, CacheGa12, CacheGameTime, CacheCPName, CacheGameName );
	}
	// STEP2 呼叫右側市場項目表
	function marketTab( gameid, ga12, gametime, competitionname, gamename )
	{
		//alert(gameid+', '+ ga12+', '+gametime+', '+competitionname+', '+gamename);
		console.log( 'marketTab( '+gameid+', '+ga12+', '+gametime+', '+competitionname+', '+gamename+' )');
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
		console.log( 'noCache:'+iData['noCache']+'-------' );
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_targetList.php',
			data: iData,
			error: function(xhr) {
			},
			beforeSend:function(result)
			{
				if( reLoadSet == '' ) loadingCtrl( 1 );
				reLoadSet = '';
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
				upTimeFunc();//啟動更新計時
			}
		});
	}
	
	//下單POPUP STEP1
	function MarketOrder( marketid, selectid, TradingVol, marketname, selectname, profit, systemrate, price, fee,pawben )
	{
		console.log( 'MarketOrder( '+marketid+', '+selectid+', '+TradingVol+', '+marketname+', '+selectname+', '+profit+', '+systemrate+', '+price+', '+fee+','+pawben+' )');
		
		CacheMarketID	= marketid;
		CacheSelectID	= selectid;
		CacheTradingVol = TradingVol;
		CacheMarketName	= marketname;
		CacheSelectName	= selectname;
		CacheProfit		= profit;
		CacheFee		= fee;
		CachePawbem		= pawben;

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
		iData['pawben']			=pawben;
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_targetList.php',
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
					reLoadMarket();
				}
			}
		});
		//alert( 'selectid:'+selectid+' TradingVol:'+TradingVol+' marketid:'+marketid );
	}
	//下單快捷金額增加金額
	function addOrderAmount( inputVal )
	{
		var addVal		= 0;
		var OrderAmount	= 0;
		var mbQuota		= 0;
		var setNewVal	= 0;
		if( $('#OrderAmount').val() )	{ OrderAmount = parseFloat( $('#OrderAmount').val() ); }
		if( $('#memberQuota').val() )	{ mbQuota = parseFloat( $('#memberQuota').val() ); }
		if( inputVal )					{ addVal = parseFloat( inputVal ); }
		if( inputVal == 'all' )			{ setNewVal = mbQuota; }else{ setNewVal = OrderAmount + addVal; }
		if( setNewVal > CacheTradingVol ) { setNewVal = CacheTradingVol; msg( {'status':0, 'title':'', 'text1':'可交易量为'+CacheTradingVol, 'text2':'' } ); }
		$('#OrderAmount').val( setNewVal );
		Calculate();
	}
	//執行快捷金額設定
	function upFastAmount()
	{
		var fastAmount0 = jQuery( "#fastAmount0" ).val();
		var fastAmount1 = jQuery( "#fastAmount1" ).val();
		var fastAmount2 = jQuery( "#fastAmount2" ).val();

		if( isNaN(fastAmount1) || isNaN(fastAmount2) || isNaN(fastAmount0) )
		{
			msg( {'status':0, 'title':'', 'text1':'请输入数字', 'text2':'' } );
			return;
		}
		if( fastAmount1 == '' && fastAmount2 == '' && fastAmount0 == '' )
		{
			msg( {'status':0, 'title':'', 'text1':'请输入数字', 'text2':'' } );
			return;
		}
		if( fastAmount1.length > 6 || fastAmount2.length > 6 || fastAmount0.length > 6 )
		{
			msg( {'status':0, 'title':'', 'text1':'设定金额过大', 'text2':'' } );
			return;
		}
		var faArr = { fastAmount:[] };

		if( fastAmount0 ) faArr.fastAmount.push( fastAmount0 );
		if( fastAmount1 ) faArr.fastAmount.push( fastAmount1 );
		if( fastAmount2 ) faArr.fastAmount.push( fastAmount2 );

		var iData		 = new Object;
		iData['actionStep'] = 'upFastAmount';
		iData['fastAmount']	 = faArr.fastAmount;
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_userCenter.php',
			data: iData,
			error: function(xhr) {
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );
			},
			success: function(response)
			{
				$( "#Modal_setting" ).css( 'display', 'none' );
				/*
				if( response != 1 )
				{
					msg( {'status':0, 'title':'', 'text1':'快捷金额设定未完成', 'text2':'' } );
					return;
				}
				*/
				var newBar = '';
				for( var i = 0 ; i <=2 ; i++ )
				{
					if( faArr.fastAmount[i] )
					{
						newBar = newBar+'<button onclick="addOrderAmount(\''+faArr.fastAmount[i]+'\')">+'+faArr.fastAmount[i]+'</button>'
					}
				}
				$( '#fastAmountBar' ).html( newBar+'<button class="all_btn" onclick="addOrderAmount(\'all\')">全部</button>');
				loadingCtrl( 0 );
			}
		});
	}
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
	function MarketConfirm()
	{
		//var OrderAmount = $('#OrderAmount').val();
		if( !ckOrderAmount( CacheSize ) ) return false;
		$("#Modal_orderInput").css('display', 'none');
		$("#Modal_order02").css('display', 'block');//開啟確認POPUP
	}
	//送出注單
	function orderSubmit()
	{
		var iData		 = new Object;
		iData['ac']		 = 'actionOrder';
		iData['size']	 = CacheSize;
		iData['OrderNo'] = CacheOrderNo;
		//alert( 'Ready Submit Order gameid:'+iData['gameid']+', ga12:'+iData['ga12']+', effectivetime:'+iData['effectivetime']+', marketid:'+iData['marketid']+', selectid:'+iData['selectid']+', profit:'+iData['profit'] );
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_targetList.php',
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
				var reLoadData = ['000','0039','00501','0041','0043'];
				if( reLoadData.indexOf( res.errorcode ) >= 0 ) CacheReLoadData = 1;//設定是否重設市場項目Cache(剛交易後，取得新的資料)
				console.log( 'reCode:'+res.errorcode+' / reLoadSet:'+CacheReLoadData );
				if( res.errorcode == '000' )
				{
					//CacheReLoadData = 1; //設定是否重設市場項目Cache(剛交易後，取得新的資料)
					$( '#res_competitionname' ).html( res.competitionname );
					$( '#res_gametime' ).html( res.gametime );
					$( '#res_game' ).html( res.game );
					$( '#res_gameselect' ).html( res.gamemarket+' '+res.gameselect );
					$( '#res_betid' ).html( res.betid );
					$( '#res_dealmoney' ).html( res.dealmoney );
					$( '#res_profit' ).html( res.profit );
					$( '#res_conversion' ).html( res.conversion );
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
				else if(res.errorcode == '999')
				{
					msg( {'status':0, 'title':'', 'text1':'系统讯息', 'text2':'['+res.errorcode+']'+res.msg  ,'nextUrl':'orders.php' });
					
				}
				
				else
				{
					msg( {'status':0, 'title':'', 'text1':'交易失敗', 'text2':'['+res.errorcode+']'+res.msg } );
				}
				//更新市場項目表
				//reLoadMarket();
				upDataTime = 2;
				upDataTimeFunc();//2秒經過API Cache更新資料
			}
		});
		
	}

	//檢驗金額
	function ckOrderAmount( OrderAmount )
	{
		var sre = /^[0-9]+(\.[0-9]{1,2})?$/;//小數點2位
		
		if( OrderAmount == '' )
		{
			msg( {'status':0, 'title':'', 'text1':'请输入金额', 'text2':"最低交易金额100元" } );
			$('#OrderAmount').focus();
			return;
		}
		if( isNaN( OrderAmount ) )
		{
			msg( {'status':0, 'title':'', 'text1':'请重新输入金额', 'text2':"请输正确数字，不含其他文字符号" } );
			$('#OrderAmount').focus();
			return;
		}
	
		if( !sre.test( OrderAmount ) )
		{
			msg( {'status':0, 'title':'', 'text1':'请重新输入金额', 'text2':"交易金额最多小数点2位" } );
			$('#OrderAmount').focus();
			return;
		}
		if( OrderAmount < 100 )
		{
			msg( {'status':0, 'title':'', 'text1':'请重新输入金额', 'text2':"最低交易金额100元" } );
			$('#OrderAmount').focus();
			return;
		}
		if( OrderAmount > CacheTradingVol )
		{
			//msg( {'status':0, 'title':'', 'text1':'请重新输入金额', 'text2':"交易金额，超过可交易量"+CacheTradingVol } );
			//$( '#OrderAmount' ).focus();
			$( '#OrderAmount' ).val( CacheTradingVol );
			Calculate();
			return;
		}
		if( OrderAmount > $('#memberQuota').val() )
		{
			msg( {'status':0, 'title':'', 'text1':'请重新输入金额', 'text2':"交易金额，超出可用余额"+$('#memberQuota').val() } );
			$('#OrderAmount').focus();
			return;
		}
		return true;
	}
	//市場下單 END----------------------
	
	//充值金額檢驗
	function amountCK()
	{
		var sre = /^[0-9]*$/;
		if( !sre.test( $('#amount').val() ) )
		{
			msg( {'status':0, 'title':'', 'text1':'存款金额请输入整数', 'text2':"" } );
			$('#amount').val( '' );
			$('#amount').focus();
			return false;
		}
		if( $( '#amount' ).val() < 100 || isNaN( $('#amount').val() ) )
		{
			msg( {'status':0, 'title':'', 'text1':'最低充值金额为100', 'text2':"" } );
			$( '#amount' ).val( '' );
			$( '#amount' ).focus();
			return false;
		}
		if( $( '#amount' ).val() > 999999 )
		{
			msg( {'status':0, 'title':'', 'text1':'最高充值金额为999,999.00', 'text2':"" } );
			$( '#amount' ).val( '' );
			$( '#amount' ).focus();
			return false;
		}
		return true;
	}

	//充值-第三方支付
	function pay3DepositStep2()
	{
		if( !amountCK() ) return false;

		var iData			= new Object;
		iData['step']		= 'pay3QRCodeResponse';
		iData['amount']		= $( '#amount' ).val();
		iData['ptype']		= $( '#ptype' ).val();
		ajaxPointDeposit( iData );
		return;
	}
	//充值-網銀進入步驟2
	function bankDepositStep2()
	{
		if( !amountCK() ) return false;

		var iData			= new Object;
		iData['step']		= 'bankResponse';
		iData['amount']		= $( '#amount' ).val();
		iData['bankIndex']	= $( '#bankIndex' ).val();
		iData['ptype']		= $( '#ptype' ).val();
		ajaxPointDeposit( iData );
		return;
	}
	//充值-網銀送出申請
	function bankDepositSubmit()
	{
		var iData		= new Object;
		iData['step']	= 'bankSubmit';
		ajaxPointDeposit( iData );
		return;
	}
	//充值-系統QRCode支付進入輸入步驟2輸入資料
	function payQRCodeStep1to2()
	{
		$( '#payQRCodeStep1' ).slideUp();
		$( '#payQRCodeStep2' ).slideDown();
	}

	//充值-系統QRCode支付
	function payQRCodeDepositStep2toSubmit()
	{
		var payAccount = $( '#payAccount' ).val();
		if( !checkEmail( payAccount ) && !checkVal( payAccount ) )
		{
			msg( {'status':0, 'title':'', 'text1':'请输入正确支付帐号', 'text2':"" } );
			$( '#payAccount' ).focus();
			return false;
		}
		if( !amountCK() ) return false;
		if( $( '#amount' ).val() > 50000 )
		{
			msg( {'status':0, 'title':'', 'text1':'充值上限50000', 'text2':"" } );
			$( '#amount' ).focus();
			return false;
		}

		var iData			= new Object;
		iData['step']		= 'bankSubmit';
		iData['amount']		= $( '#amount' ).val();
		iData['payAccount']	= $( '#payAccount' ).val();
		iData['ptype']		= $( '#ptype' ).val();
		ajaxPointDeposit( iData );
		return;
	}
	//檢查只限英數字
	function checkVal( str ) {
		var regExp = /^[\d|a-zA-Z]+$/;
		if (regExp.test(str))
			return true;
		else
			return false;
	}
	function checkEmail( str )
	{
		var re1 = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9])+$/; 
		if( re1.test( str ) )
			return true;
		else
			return false;
	}
	//充值
	function ajaxPointDeposit( iData )
	{
		//alert( 'ajaxPointDeposit...' );
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_pointDeposit.php',
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
				//alert( 'response:'+response );
				var res = JSON.parse( response );
				if( response == 'null' )
				{
					msg( {'status':0, 'title':'', 'text1':'【申请失败】', 'text2':'此功能暂停服务', 'nextUrl':'pointDeposit.php' } );
				}
				
				if( res.step == 'bankResponse' )//銀行充值，進入第二、三步驟
				{
					if( res.reCode != '000' )
					{
						//alert( '申请失败，请重新输入' );
						msg( {'status':0, 'title':'', 'text1':'【申请失败】', 'text2':res.reMsg } );
						location.reload();
						return;
					}
					$( '#fbank' ).html( res.fbank );
					$( '#fbranch' ).html( res.fbranch );
					$( '#fname' ).html( res.fname );
					$( '#faccount' ).html( res.faccount );
					$( '#amounts' ).html( res.amount );
					$( '#bankStep1' ).slideUp();
					$( '#bankStep2' ).slideDown();
				}
				else if( res.step == 'bankSubmit' )//執行充值-網路銀行
				{
					if( res.reCode == '000' )
					{
						//$( "#Modal_success" ).css( 'display', 'block' );
						//alert( '【申请成功】系统将自动审核请耐心等候，谢谢！' );
						msg( {'status':1, 'title':'', 'text1':'【申请成功】', 'text2':res.reMsg, 'nextUrl':'pointDetails.php' } );
					}
					else
					{
						msg( {'status':0, 'title':'', 'text1':'【申请失败】', 'text2':res.reMsg } );
						location.reload();
					}
				}
				else if( res.step == 'pay3QRCodeResponse' )//充值-取得第三方支付付款資料
				{
					//未完成
					if( res.reCode == '0000' )
					{
						//msg( {'status':1, 'title':'', 'text1':'【申请成功】', 'text2':res.reMsg, 'nextUrl':'pointDetails.php' } );
						$( '#pay3QRCode' ).html( '<img src="qrcodeMake.php?level=L&size=10&data='+res.payCode+'" />' );
						$( '#pay3OrderNo' ).html( res.orderNo );
						$( '#pay3OrderAmount' ).html( res.amount );
						$( '#pay3Step1' ).slideUp();
						$( '#pay3Step2' ).slideDown();
					}
					else
					{
						msg( {'status':0, 'title':'', 'text1':'【申请失败】', 'text2':res.reMsg, 'nextUrl':'pointDeposit.php' } );
						//msg( {'status':0, 'title':'', 'text1':'【申请失败】', 'text2':'['+res.reCode+']'+res.reMsg, 'nextUrl':'pointDeposit.php' } );
						//location.reload();
					}
				}
			}
		});
	}
	//導至位址
	function directUrl( url )
	{
		document.location.href = url;
	}
	//導至充提記錄
	function directPointDetails()
	{
		document.location.href="pointDetails.php";
	}
	//Loading控制1開啟0關閉
	function loadingCtrl( actionStatus )
	{
		var setStatus = 'none';
		if( actionStatus ) setStatus = 'block';
		$( '#Loading' ).css( 'display', setStatus );
	}