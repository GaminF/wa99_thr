
//開始 控制所有function
 		function result(function_name,i)
			{
				//alert("i:"+i+'_'+function_name);
				var iData = new Object;
				iData['tag']=i;
				ajaxPost( iData );
				return;
			}
//結束 控制所有function

//開始 把userHistoryAmount的資料送到userHistoryDetail-->
		function amount(starttime,endtime)
		{
			//alert("i:"+i);
			var iData = new Object;
			iData['starttime'] = starttime;
			iData['endtime'] = endtime;
			iData['function_name'] ='userHistoryDetail';
			iData['tag'] = 'result15';
			ajaxPost( iData );
			return;
		}
		function week(value)
		{
			alert("i:"+ value);
			var iData = new Object;
			iData['week'] = value;
			// iData['starttime'] = starttime;
			// iData['endtime'] = endtime;
			//iData['function_name'] ='userHistoryAmount';
			iData['tag'] = 'historyamount';
			ajaxPost( iData );
			return;
		}
		function ajaxPost( iData )
		{
			Actions = jQuery.ajax({
				type: 'GET',
				url:  'history.php',
				data: iData,
				error: function(xhr) {
					
				},
				beforeSend:function(result)
				{
	
				},
				success: function(answer) {
					$('#'+iData['tag']).html(answer); //# MEANS ID

				}
			});
		}

//結束 把userHistoryAmount的資料送到userHistoryDetail

//開始 c2GetNoticeInfo設置按鈕呼叫公告內容-->

	    function info(value) //傳送按鈕的值
		{
			alert("i:"+value);
			var iData = new Object;
			iData['type'] =value;
			iData['function_name'] ='c2GetNoticeInfo';
			iData['tag'] = 'result14';
			ajaxPost( iData );
			return;
		}

// 結束 c2GetNoticeInfo設置按鈕呼叫公告內容

//開始 gameHistoryDetail選擇日期以呼叫當日賽事列表

		    function selectDate(va) //把option的值拿出來
			{
				//alert("i:"+va);
				var iData = new Object;
				iData['day'] = va;
				iData['function_name'] ='gameHistoryDetail';
				iData['tag'] = 'result2';
				ajaxPost( iData );
				return;
			}
			

//結束 gameHistoryDetail選擇日期以呼叫當日賽事列表

//開始 由c2gamelist送資料給c2selectlist4

		    function showList4(gameid,ga12,effectivetime,competitionname)//,) 
			{
				//alert("i:"+$('#competitionname').val() );
				var iData = new Object;
				iData['gameid'] = gameid;
				iData['ga12'] = ga12;
				iData['effectivetime'] = effectivetime;
				iData['competitionname']=competitionname;
				iData['function_name'] ='c2gselectlist4';
				iData['tag'] = 'result4';
				ajaxPost( iData );
				return;
			}

//結束 由c2gamelist送資料給c2selectlist4

//開始 輸入帳號密碼得到回傳值

		    function login() 
			{

				//alert( "hello");
				if($('#userid').val()=='')
				{
					alert("請輸入帳號");
				}
				else if($('#userpw').val()=='')
				{
					alert("請輸入密碼");
				}
				else
				{
					var iData = new Object;
					iData['id'] = $('#userid').val();
					iData['pw'] = $('#userpw').val();
					iData['function_name'] ='memberlogin';
					iData['tag'] = 'result23';
				}
				
				ajaxPost( iData );
				return;
				
			}

//結束 輸入帳號密碼得到回傳值



//開始 輸入代理帳號得到帳號列表

		    function agent() 
			{ 
				//var sre = /^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/;
				//var str= 	/[a-z]/;
				
				if($('#agentid').val()=='' )
				{
					alert('請輸入代理帳號');
				}
				// else if(!sre.test($('#agentid').val()))
				// {
				// 	 	alert('xxx');
				// }
				else if(!$('#agentid').val().match(/^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/g))
				{
					alert('請輸入由英文加數字組合之代理帳號');
				}
				else
				{
					var iData = new Object;
					iData['agentid'] = $('#agentid').val();
					iData['step']=1;
					iData['function_name'] ='memberadd';
					iData['tag'] = 'result28';
				}
				ajaxPost( iData );
				return;
			}

//結束 輸入代理帳號得到帳號列表

//開始 memberadd新增會員資料
		    function add() //memberadd
			{
				if($('#nickname').val()=='')
				{
					alert('請輸入會員暱稱');
					$('#nickname').val('');
				}
				else if($('#loginPwd').val()=='' || $('#receivePwd').val()=='')
				{
					alert('密碼不可為空白');
				}
				else if($('#loginPwd').val()!=$('#loginPwd2').val())
				{
					alert('登入密碼輸入不一致，請重新輸入密碼');
					$('#loginPwd').val('');
					$('#loginPwd2').val('');

				}
				else if(!$('#loginPwd').val().match(/^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/g) || 
						!$('#loginPwd2').val().match(/^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/g) ||
						 $('#loginPwd').val().length <6)
				{
					alert('登入密碼須由英數組成之六位數字元');
					$('#loginPwd').val('');
					$('#loginPwd2').val('');

				}
				else if(!$('#receivePwd').val().match(/^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/g) || 
						!$('#receivePwd2').val().match(/^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/g) || 
						 $('#receivePwd').val().length<6 )
				{
					alert('提領密碼須由英數組成之六位數字元');
					$('#receivePwd').val('');
					$('#receivePwd2').val('');
				}
				
				else if( $('#receivePwd').val()!=$('#receivePwd2').val())
				{
					alert('提領密碼輸入不一致，請重新輸入密碼');
					$('#receivePwd').val('');
					$('#receivePwd2').val('');
				}
				else if($('#loginPwd').val()==$('#receivePwd').val())
				{
					alert('登入密碼不可與提領密碼相同，請重新輸入');
				}
				else if($('#ans').val()=='')
				{
					alert('請輸入安全性問題答案');
				}
				else if($('#realname').val()=='' || !isNaN($('#realname').val()) )
				{
					alert('請輸入真實姓名');
				}
				else if ($('#mobile').val()=='' || $('#mobile').val().length!=10 || isNaN($('#mobile').val()))
				{
					alert('請輸入正確的手機號碼');
				}
				// else if( )
				// {
				// 	alert('xxx')
				// }
				else
				{
				var iData = new Object;;
				iData['userName'] =$('#name').val();
				iData['nickName']=$('#nickname').val();
				iData['loginPwd']=$('#loginPwd').val();
				iData['receivePwd']=$('#receivePwd').val();
				iData['agent']=$('#agentid').val();
				iData['function_name'] ='memberadd';
				iData['pointQuestion']=$('#question').val();
				iData['pointAnswer']=$('#ans').val();
				iData['accountName']=$('#realname').val();
				iData['mobile']=$('#mobile').val();
				iData['email']='';
				iData['birthday']='';
				iData['skype']='';
				iData['qq']='';
				iData['wechat']='';
				iData['step']='2';
				iData['tag'] = 'result28';
				}
				ajaxPost( iData );

				return;
			}
//結束 memberadd新增會員資料



//開始 saveMoney選擇帶入listMoneySave
		    function action(action,choice) //帶入action跟choice的直
			{
				alert("i:"+action+'-'+choice);
				var iData = new Object;
				iData['action'] = action;
				iData['choice'] = choice;
				iData['function_name'] ='saveMoney';
				iData['tag'] = 'result18';
				iData['step']=1;
				ajaxPost( iData );
				return;
			}
		    function banklist(fbranch) //把fbranch的值拿出來
			{
				//alert("i:"+fbranch);
				$('#fbranch').html(fbranch); //#表示id(+變數)
			}
			function datasure() //savemoney第二層 把option的值拿出來(存款)
			{
				
				//alert( 'i:'+'xxx');
				if(isNaN($('#amount').val()))
				{
					alert('請輸入金額');
					$('#amount').val('');
				}
				else
				{
					var iData = new Object;
					iData['action'] = $('#action').val();
					iData['choice'] = $('#choice').val();//=saveBy
					iData['amount']= $('#amount').val();//金額
					iData['banklist']=$('#banklist').val();
					iData['datacheck']= $('#datacheck').val();//標籤
					iData['function_name'] ='saveMoney';
					iData['tag'] = 'result18';
					iData['step']= 2;
					ajaxPost( iData );
					return;
				}
			}

			function makesure() //傳送表單值(提款)
			{
				//alert("i:");
				if(isNaN($('#amount').val()))
				{
					alert('請輸入金額');
					$('#amount').val('');
				}
				else{

					var iData = new Object;

					iData['action'] = $('#action').val();
					iData['choice'] = $('#choice').val();//=saveBy
					iData['amount']= $('#amount').val();//金額
					iData['banklist']=$('#id').val();//充值帶這個
					iData['bankid']=$('#banklist').val();//提領帶這個
					iData['bankName']=$('#bankname').val();//銀行名稱
					iData['accountNum']=$('#account').val();//戶號
					iData['accountName']=$('#accountName').val();//戶名
					iData['widthdrawpassword']=$('#widthdrawpassword').val();//提領密碼
					iData['getsave']= 'getsave'//標籤
					iData['first']=$('#first').val();
					iData['function_name'] ='saveMoney';
					iData['tag'] = 'result18';
					ajaxPost( iData );

					return;
				}
			}

			
//結束 saveMoney選擇帶入listMoneySave



//開始 userpickup更改現有資料
	  function change(item) //把要改的東西的值拿出來
			{
				//alert("i:"+ item );
				var iData = new Object;
				iData['chgmun'] = item ;
				iData['function_name'] ='MemberInfo';
				iData['tag'] = 'result21';
				ajaxPost( iData );
				return;
			}

		function sure() //把要改的值拿出來
			{
				/*if($('#compare').val() != $('#old').val())
				 {
					alert('原始資料錯誤');
					$('#old').val('');
					$('#new').val('');
				}
				else if($('#old').val() == $('#new').val())
				{
					alert('不可相同');
					$('#old').val('');
					$('#new').val('');

				}
				else if(! $('#old').val().match(/^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/g) ||
						! $('#new').val().match(/^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/g) )
				{
					alert('輸入錯誤');
					$('#old').val('');
					$('#new').val(''); 
				}
				else
				}*/
					//alert("i:"+$('#item').val()+$('#compare').val());
					var iData = new Object;
					iData['chgmun'] = $('#item').val();
					iData['compare']= $('#compare').val();
					iData['old'] = $('#old').val();
					iData['new'] = $('#new').val();
					iData['function_name'] ='userpickup';
					iData['tag'] = 'userpickupShow';
					ajaxPost( iData );
					return;
				//}
			}
//結束 userpickupe更改現有資料


//開始 c2gselectlist4取值
 			function pk() 
			{
				//alert("i:"+$('#gamename').val());
				var iData = new Object;
				iData['gamename'] = $('#gamename').val();
				iData['gametime'] = $('#gametime').val();
				iData['function_name'] ='pkRecord';
				iData['tag'] = 'result44';
				ajaxPost( iData );
				return;
			}
//結束 c2gselectlist4取值


//開始 c2gselectlist4取值
 			function order() 
			{
				alert("i:"+$('#competition').val());
				var iData = new Object;
				iData['event'] = $('#gamename').val();
				iData['gametime'] = $('#gametime').val();
				iData['market']=$('#market').val();
				iData['systemrate'] = $('#systemrate').val();
				iData['profit'] = $('#profit').val();
				iData['price']=$('#selectrateL1').val();
				iData['selection']=$('#selection').val();
				iData['selectionId']=$('#selectid').val();
				iData['eventId'] = $('#eventId').val();
				iData['marketId'] = $('#marketid').val();
				iData['be14']=$('#be14').val();
				iData['competition']=$('#competition').val();
				iData['function_name'] ='C2GameSetBet';
				iData['step']='order';
				iData['fee']=$('#marketpercentage').val();
				iData['tag'] = 'result5';
				ajaxPost( iData );
				return;
			}
//結束 c2gselectlist4取值


//開始 updateUserBetsize設定
			function size() //傳送表單值
			{
				if(	$('#a').val()=='' || isNaN($('#a').val()) ||
					$('#b').val()=='' || isNaN($('#b').val()) ||
					$('#c').val()=='' || isNaN($('#c').val()) )
				{
					alert('請輸入金額');
				}
				else
				{
					var iData = new Object;
					iData['a'] = $('#a').val();
					iData['b'] = $('#b').val();
					iData['c'] = $('#c').val();
					iData['function_name'] ='updateUserBetsize';
					iData['tag'] = 'result32';
				}
				
				ajaxPost( iData );
				return;
			}

//結束 updateUserBetsize設定


//開始 c2gselectlist4下單金額設定
			function xx()//手動輸入值
			{
				//alert(fee);
				var money=$('#money').val();
				var fee=$('#fee').val();
				var profit=$('#profit').val();
				var iData = new Object;
				iData['tag'] = 'after';
				var after=money*(profit/100)*(1-fee/100);
				$('#'+iData['tag']).html(after.toFixed(2)); //# MEANS ID
				
			}

		function allxxx()//梭哈
			{
				var quota=$('#quota').val();
				$('#money').val(quota); //# MEANS ID
				xx();
			}

		function clean()//清除金額
			{
				var money=$('#money').val();
				$('#money').val(''); //# MEANS ID
				xx();
				
			}

		function setmoney(setsize)//按鈕加值
			{

				var minus=Number(setsize) + Number($('#money').val());
				
				//$('#money').val( Number(setsize) + Number($('#money').val())); //# MEANS ID
				var quota=$('#quota').val();
				alert(quota);
				if(minus<=quota)
				{
					$('#money').val( Number(setsize) + Number($('#money').val()));

				}
				else
				{
					$('#money').val(quota);
				}
				xx();
			}

		function qq()//取消
		{
			var iData = new Object;
			iData['step'] = 'qq';
			iData['function_name'] ='C2GameSetBet';
			iData['tag'] = 'result5';
			ajaxPost( iData );
			alert(iData['qq']);
		}


		function betsure()
		{
			alert("i:"+$('#money').val());
			var iData = new Object;
			iData['price']=$('#selectrateL1').val();
			iData['systemrate'] = $('#systemrate').val();
			iData['profit'] = $('#profit').val()/100;
			iData['size']=$('#money').val();
			iData['event'] = $('#gamename').val();
			iData['market']=$('#market').val();
			iData['selection']=$('#selection').val();
			iData['eventId'] = $('#eventId').val();
			iData['marketId'] = $('#marketid').val();
			iData['selectId']=$('#selectid').val();
			iData['be14']=$('#be14').val();
			iData['gametime'] = $('#gametime').val();		
			iData['competition']=$('#competition').val();
			iData['function_name'] ='C2GameSetBet';
			iData['step']='makesure';
			iData['tag'] = 'result5';
			ajaxPost( iData );
			return;
		}
//結束 c2gselectlist4下單金額設定