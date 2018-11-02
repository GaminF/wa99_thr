

//var tips=msgcontent();
function msgx()
{
     $("#msgx").css('display', 'none');
     $('#intoRegister').css('display','none');	
     $('#Modal_deal_chart').css('display','none');
}

function closePopup8Url( urlStr )  //關閉視窗

{
	$("#msgx").css('display', 'none');	
	$('#Modal_deal_chart').css('display','none');
	directUrl( urlStr );
}
//info Obj INPUT status, title, mainTxt, subTxt
function msg(info)
{
	var colorTag = 'success_text';
	var iconTag = 'success_icon';
	var title = '系统讯息';
	if( info['title'] ) title = info['title'];
	if( info['status'] == 0 ) //0是失敗 1是成功
	{
		colorTag = 'failure_text';
		iconTag = 'failure_icon';
	}
	if( info['nextUrl'] )
	{
		$( '#popupClose' ).attr( 'onClick', "closePopup8Url( '"+info['nextUrl']+"' )" );
	}
	$("#title").html( title );
	$('#icon').attr('class',iconTag);
	$('#fontstyle').attr('class',colorTag);
	$("#text1").html( info['text1'] );
	$("#text2").html( info['text2'] );
	$("#msgx").css('display', 'block');
}
function fee()
{
	 $("#Modal_times").css('display', 'none');	
	 $("#Modal_times_none").css('display', 'none');
}
function feemoneytips(change)
{

	pos(change);
}

function freefeetips()
{
	
	Actions = jQuery.ajax({
			type: 'POST',
			url:  'fee.php',
			error: function(xhr) {
				
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );
			},
			success: function(answer) 
			{

				loadingCtrl( 0 );
				//alert(answer);
				$('#countdown').html(answer);

		
			}
		});
	$("#Modal_times").css('display', 'block');

}
//這裡是交易歷史統計的迴圈 history
function week(value)
	{
		//alert(value);
		var change=new Object;
		change['week']=value;
		if($('#mark').val()==1)
		{
			window.location.href = 'fifa_history_all.php?week='+value;
		}
		else
		{
			for(x=0;x<=3;x++)
			{
				if(value==x)
				{
					$('#history_table'+x).slideDown();//向下展開
				}
				else
				{
					$('#history_table'+x).slideUp();//向上收起
				}
			}
		}
		
		
	}
//這裡是交易歷史統計的迴圈 history 結束

//交易歷史明細檢查 開始
function fromto()
{
	if($('#starttime').val()=='' || $('#endtime').val()=='')
	{
		
		var info = {'status':0, 'title':'', 'text1':'请选择起讫时间', 
								'text2':'' ,'nextUrl':''};
		msg(info);
		return false;
	}
	else
	{
		//alert($('#starttime').val());
        document.detail_form.submit();
		//$('#detail_form').submit()
	}
}


//交易歷史明細檢查 結束  


//這裡是會員資料修改的功能 userCenter
function alter(value) 
{
	//alert(value);
	var change= new Object;
	$('#chgmun').val(value);
	if($('#chgmun').val()=='passwd')
	{
		$('#tag').html('会员');
		$('#tag2').html('会员');
		$('#tag3').html('会员');
	}
	if($('#chgmun').val()=='pickup')
	{
		$('#tag').html('提领');
		$('#tag2').html('提领');
		$('#tag3').html('提领');
	}
	
	//alert($('#chgmun').val());
	//pass(change);
	return;
}
function modify()  
	{
		//alert($('#chgmun').val());
		if($('#old').val()!=$('#new').val() && $('#new').val()==$('#new2').val())
		{
			var change= new Object;
			change['chgmun'] = $('#chgmun').val();
			change['old']=$('#old').val();
			change['new']=$('#new').val();
			change['new2']=$('#new2').val();
			pass(change);
			return;
		}
		else
		{
			//alert('请检查修改资料');
			var info = {'status':0, 'title':'', 'text1':'请检查修改资料是否输入错误', 'text2':'' };
			msg(info);
			$('#old').val('');
			$('#new').val('');
			$('#new2').val('');
		}
	}
	function pass( change )
	{
		//alert('aaaaa');
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_userCenter.php',
			data: change,
			error: function(xhr) {
				
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );
			},
			success: function(answer) {

				loadingCtrl( 0 );
				if(answer=='S')
				{
					var info = {'status':1, 'title':'', 'text1':'资料修改成功', 'text2':'' ,'nextUrl':'logout.php' };
					msg(info);
				}
				else
				{
					var info = {'status':0, 'title':'', 'text1':'资料修改失败', 
								'text2':'请重新尝试或洽询客服' ,'nextUrl':'userCenter.php'};
					msg(info);
				}
				$('#old').val('');
				$('#new').val('');
				$('#new2').val('');

			} 
		});
	}

function reset()
{
	$('#old').val('');
	$('#new').val('');
	$('#new2').val('');
}

//會員資料修改的功能結束 userCenter
//這裡要做會員互轉c2c
function c2cphp(status)
{
	if(status==0)
	{
		var info = {'status':0, 'title':'', 'text1':'此功能暂停服务', 'text2':'此功能于21:00~02:00间暂停服务' ,'nextUrl':'pointDeposit.php' };
		msg(info);
	}
	else
	{
		window.location.href = "pointc2c.php" ;
	}
	
}

function checksms()
{
	//alert($('#area').val());
	if( $('#area').val() == '' )
	{
		var info = {'status':0, 'title':'', 'text1':'', 'text2':'请选择地区'};
		msg(info);
		return false;
	}
	var change = new Object;
	change['step']=1;
	change['area']=$('#area').val();
	
	Actions = jQuery.ajax({
				type: 'POST',
				url:  'ac_pointc2c.php',
				data: change,
				error: function(xhr) 
				{
					//alert('error');
				},
				beforeSend:function(result)
				{
					loadingCtrl( 1 );
				},
				success: function(answer) 
				{
					loadingCtrl( 0 );
					//var arr=new Array();
					var ercode=answer.split(":");
					//alert (ercode[0]+'+'+ercode[1]);
					if(ercode[0]=='000')
					{
						var info = {'status':1, 'title':'', 'text1':'验证码已传送', 'text2':'' };
						msg(info);
					}
					else
					{
						var info = {'status':0, 'title':'', 'text1':'验证码讯息', 'text2':'['+ercode[0]+']'+ercode[1] };
						msg(info);
					}
				}
			});

}

function c2cstep2()
{
	var sre = /^[0-9]+(\.[0-9]{1,2})?$/;//小數點2位
	if($('#username').val()=='')
	{
		var info = {'status':0, 'title':'', 'text1':'请输入接收会员帐号', 'text2':'' };
		msg(info);
		$('#username').val('');
	}
	else if( !sre.test($('#amount').val()) )
	{
		var info = {'status':0, 'title':'', 'text1':'请重新输入金额', 'text2':'交易金额最多小数点2位' };
		msg(info);
		$('#amount').val('');
	}
	else if($('#amount').val()=='' || $('#amount').val()<100 || isNaN($('#amount').val()))
	{
		var info = {'status':0, 'title':'', 'text1':'请重新输入金额', 'text2':'互转点数必须大于或等于100点' };
		msg(info);
		$('#amount').val('');
	}
	else if($('#amount').val()-$('#memberQuota').val()>0) //提領金額不可大於帳戶餘額
	{
		//alert($('#memberQuota').val());
		var info = {'status':0, 'title':'', 'text1':'超过帐户余额', 'text2':$('#amount').val()+' > '+$('#memberQuota').val() };
		msg(info);
		$('#amount').val('');

	}
	else if( $('#wdpw').val()=='' )
	{
		//alert('请检查资料是否填写完毕');
		var info = {'status':0, 'title':'', 'text1':'请输入交易密码', 'text2':'' };
		msg(info);	
		$('wdpw').val('');
	}
	else if( $('#smscode').val()=='' )
	{
		//alert('请检查资料是否填写完毕');
		var info = {'status':0, 'title':'', 'text1':'请输入验证码', 'text2':'' };
		msg(info);	
		$('smscode').val('');
	}
	else
	{
		
		var change=new Object;
		change['step']=2;
		change['ckUserName']=$('#username').val();
		change['amount']=$('#amount').val();
		change['wdpw']=$('#wdpw').val();
		change['smscode']=$('#smscode').val();
		Actions = jQuery.ajax({
				type: 'POST',
				url:  'ac_pointc2c.php',
				data: change,
				error: function(xhr) 
				{
					//alert('error');
				},
				beforeSend:function(result)
				{
					loadingCtrl( 1 );
				},
				success: function(answer) 
				{
					loadingCtrl( 0 );
					//alert(answer);
					if( answer  !='0000')
					{
						var info = {'status':0, 'title':'', 'text1':'交易失败', 'text2':answer };
						msg(info);	
					}
					else
					{
						$( '#bankStep1' ).slideUp();
						$( '#bankStep2' ).slideDown();
						$('#icomeuser').val($('#username').val());
						$('#payamount').val($('#amount').val());
					}
				}
			});
	}
}

function checkc2c()
{

	var change=new Object;
	change['step']=3;
	change['ckUserName']=$('#username').val();
	change['amount']=$('#amount').val();
	change['wdpw']=$('#wdpw').val();
	sendc2c(change);
	return;
}

function sendc2c(change)
{
	Actions = jQuery.ajax({
				type: 'POST',
				url:  'ac_pointc2c.php',
				data: change,
				error: function(xhr) 
				{
					//alert('error');
				},
				beforeSend:function(result)
				{
					loadingCtrl( 1 );
				},
				success: function(answer) 
				{
					loadingCtrl( 0 );
					//alert('sendc2c():'+answer);
					var res = JSON.parse( answer );
					if( res.reCode == '0000' )
					{
						reLoadUserInfo();
						//CacheReLoadData = 1; //設定是否重設市場項目Cache(剛交易後，取得新的資料)
						$( '#res_orderNum' ).html( '#'+res.orderNum );
						$( '#res_orderTime' ).html( res.orderTime );
						$('#incomeamount').html(res.orderAmount);
						$('#incomeuser').html(res.incomeUserName);
						$('#payuser').html(res.payUserName);
						$( '#Modal_order03' ).css( 'display', 'block' );
						reLoadUserInfo();
					}
					else if( res.reCode == '004' )
					{
						var info = {'status':0, 'title':'会员互转', 'text1':'会员互转失败', 'text2':'※'+res.reMsg, 'nextUrl':'pointc2c.php'};
						msg(info);
					}
					else
					{
						var info = {'status':0, 'title':'会员互转', 'text1':'会员互转失败', 'text2':'※'+res.reMsg};
						msg(info);
						$( '#bankStep2' ).slideUp();
						$( '#bankStep1' ).slideDown();
					}
				}
			});

}
//會員互轉c2c結束

/*
*/
//這裡是提領功能
function widthdraw() 
	{
		if($('#amount').val()=='' || $('#accountName').val()=='' || $('#account').val()=='' 
			|| $('#widthdrawpassword').val()==''  ||  $('#bankid').val()=='')
		{
			
			var info = {'status':0, 'title':'', 'text1':'请检查资料是否填写完毕', 'text2':'' };
			msg(info);	
		}
		else if( ckAccountName( $('#accountName').val() ) != true )
		{
			
			var ckResult = ckAccountName( $('#accountName').val() );
			if( ckResult == 'Contains numbers' ) msg( {'status':0, 'title':'', 'text1':'提款户名不可含数字', 'text2':'' } );
			if( ckResult == 'Contains symbols' ) msg( {'status':0, 'title':'', 'text1':'提款户名不可含符号', 'text2':'' } );
			return false;
		}
		else if( isNaN($('#amount').val()) || isNaN($('#account').val()) ||  !isNaN($('#accountName').val())  )
		{
			//alert('请检查资料是否正确');
			var info = {'status':0, 'title':'', 'text1':'请检查资料是否正确', 'text2':'' };
			msg(info);

		}
		else if(String($('#amount').val()).indexOf(".")>-1)
		{
			var info = {'status':0, 'title':'', 'text1':'提领点数请输入整数', 'text2':'' };
			msg(info);
		}
		else if($('#amount').val()<100)
		{
			var info = {'status':0, 'title':'', 'text1':'提领点数必须大于或等于100点', 'text2':'' };
			msg(info);
		}
		else if($('#amount').val()-$('#memberQuota').val()>0) //提領金額不可大於帳戶餘額
		{
			//alert($('#memberQuota').val());
			var info = {'status':0, 'title':'', 'text1':'超过帐户余额', 'text2':$('#amount').val()+' > '+$('#memberQuota').val() };
			msg(info);
		}
		else if($('#memberQuota').val()-$('#savenotice').val()-$('#amount').val()<0 )//提領金額>账户余额-保留余额
		{
			//alert($('#memberQuota').val());
			var info = {'status':0, 'title':'', 'text1':'交易失败', 'text2':'您尚有保留点数'+$('#savenotice').val()+'未到期' };
			msg(info);
		}
		else if($('#fee').val()>0 && $('#amount').val()>0)
		{
			Actions = jQuery.ajax({
			type: 'POST',
			url:  'fee.php',
				error: function(xhr) {
					
				},
				beforeSend:function(result)
				{
					loadingCtrl( 1 );
				},
				success: function(answer) 
				{

					loadingCtrl( 0 );
					$('#countdown_money').html(answer);
					$('#feecount').html($('#amount').val()+'X'+($('#fee').val()*100)+'% ='+$('#amount').val()*$('#fee').val() )
				}
			});
			$("#Modal_times_none").css('display', 'block');

		}
		else
		{	
			pos();
			return;
		}

	}
		function pos()
		{
			var change= new Object;
			change['amount']=$('#amount').val();
			change['accountName']=$('#accountName').val();
			change['accountNum']=$('#account').val();
			//change['bankname']=$('#bankname').val();
			change['bankid']=$('#bankid').val();
			change['widthdrawpassword']=$('#widthdrawpassword').val();
			change['fee']=Math.ceil($('#fee').val()*$('#amount').val());
			change['reached']=$('#reached').val();
			Actions = jQuery.ajax({
				type: 'POST',
				url:  'ac_pointRecive.php',
				data: change,
				error: function(xhr) 
				{
					//alert('error');
				},
				beforeSend:function(result)
				{
					loadingCtrl( 1 );
				},
				success: function(answer) 
				{
					loadingCtrl( 0 );
					//alert(answer);
					if(answer==1)
					{
						if(change['reached']<=5)
							{
								freefeetips();
							}
							else
							{
								var info = {'status':1, 'title':'', 'text1':'提领申请成功', 
										'text2':'系统将自动审核，请耐心等候，谢谢！','nextUrl':'pointDetails.php' };
								msg(info);

							}
						reLoadUserInfo();
					}
					else if(answer=='201')
					{
						var info = {'status':0, 'title':'', 'text1':'提领申请失败', 
									'text2':'您尚有保留点数未到期','nextUrl':'pointDetails.php' };
						msg(info);
					}
					else if(answer=='102')
					{
						var info = {'status':0, 'title':'', 'text1':'提领申请失败', 
									'text2':'提领密码错误','nextUrl':'pointDetails.php' };
						msg(info);
					}
					else if(answer=='103')
					{
						var info = {'status':0, 'title':'', 'text1':'提领申请失败', 
									'text2':'超过帐户余额','nextUrl':'pointDetails.php' };
						msg(info);
					}
					else
					{
						var info = {'status':0, 'title':'', 'text1':'提领申请失败', 
									'text2':'请重新尝试或洽询客服','nextUrl':'pointDetails.php' };
						msg(info);
					}
					
				}
			});
			
		}

//提領功能結束


//充提紀錄 開始
function wdrecord(value)
{
 	location.href="pointDetails.php?wdrecord="+value;
}
//充提紀錄 結束
 
//賽事結果 開始
function choosedate(value)
{
 	location.href="result.php?day="+value;
}

//檢查提領帳戶
function ckAccountName( ckStr )
{
	var ckStrang = /[`'*!?@=><,.:;|}{)(#\$%\^&\*+]+/g;
	var ckIndexNum = /\d/;
	if( ckIndexNum.test( ckStr ) )
	{
		return 'Contains numbers';
	}
	else if( ckStrang.test( ckStr ) )
	{
		return 'Contains symbols';
	}
	return true;
}

//這裡是會員註冊區 register


function regi_step1()
{
	//alert($('#name').val());
	if( $('#name').val()=='' || $('#name').val()==null)
	{
		var info = {'status':0, 'title':'', 'text1':'请选择帐号', 'text2':'' };
		msg(info);
	}
 	else if($('#loginPwd').val()=='' || $('#loginPwd').val().length <6
        || !$('#loginPwd').val().match(/^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/g) )  
    {
        //alert('帐号密码请英数混合,至少6字元');
        var info = {'status':0, 'title':'', 'text1':'密码请英数混合,至少6字元', 'text2':'' };
        msg(info);
        $('#loginPwd').val('');
        $('#loginPwd2').val('');
    }
    else if($('#loginPwd2').val()=='' || $('#loginPwd').val() != $('#loginPwd2').val() )
    {
        //alert('请检查帐号密码是否正确');
        var info = {'status':0, 'title':'', 'text1':'请检查密码是否正确', 'text2':'' };
        msg(info);
        $('#loginPwd').val('');
        $('#loginPwd2').val('');
    }   
    else
    {
        $('#modal-signin').iziModal('close');
        $('#phone-verification').iziModal('open');
    } 
    
}
function register2()
{
	if($('#receivePwd').val()=='' || $('#receivePwd').val().length<6
		|| !$('#receivePwd').val().match(/^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/g) )
			
	{
		//alert('提领密码请英数混合,至少6字元');
		var info = {'status':0, 'title':'', 'text1':'提领密码请英数混合,至少6字元', 'text2':'' };
		msg(info);
		$('#receivePwd').val('');
		$('#receivePwd2').val('');
	}
	else if($('#receivePwd2').val()=='' || $('#receivePwd').val()!= $('#receivePwd2').val() )
	{
		//alert('请检查提领密码是否正确');
		var info = {'status':0, 'title':'', 'text1':'请检查提领密码是否正确', 'text2':'' };
		msg(info);
		$('#receivePwd').val('');
		$('#receivePwd2').val('');
	}
	else if( $('#receivePwd').val()==$('#loginPwd').val() || $('#receivePwd2').val()==$('#loginPwd2').val() )
	{
		//alert('汇款户名请输入中文或英文字');
		var info = {'status':0, 'title':'', 'text1':'交易密码不可与密码相同', 'text2':'' };
		msg(info);
		$('#receivePwd').val('');
		$('#receivePwd2').val('');
	}
	else if( ckAccountName( $('#realname').val() ) != true )
	{
		var ckResult = ckAccountName( $('#realname').val() );
		if( ckResult == 'Contains numbers' ) msg( {'status':0, 'title':'', 'text1':'汇款户名不可含数字', 'text2':'' } );
		if( ckResult == 'Contains symbols' ) msg( {'status':0, 'title':'', 'text1':'汇款户名不可含符号', 'text2':'' } );
		return false;
	}
	else if ($('#mobile').val()==''|| $('#mobile').val().length<8 || isNaN($('#mobile').val()))
	{
		//alert('手机号码不足8位数字');
		$('#mobile').val('');
		var info = {'status':0, 'title':'', 'text1':'手机号码不足8位数字', 'text2':'' };
		msg(info);
	}
	else if($('#mobile_ans').val()<1)
	{
		$('#code4').val('');
		//alert($('#mobile_ans').val());
		var info = {'status':0, 'title':'', 'text1':'请完成手机验证', 'text2':'' };
		msg(info);
	}
	else
	{
		//alert($('#name').val());
		var change = new Object;
		change['userName'] =$('#name').val();
		change['nickName']=$('#nickname').val();
		change['loginPwd']=$('#loginPwd').val();
		change['receivePwd']=$('#receivePwd').val();
		change['agent']=$('#agentid').val();
		change['pointQuestion']=2;//$('#question').val();
		change['pointAnswer']=1;//$('#ans').val();
		change['AccountName']=$('#realname').val();
		change['mobile']=$('#area').val()+'-'+$('#mobile').val();
		change['email']='';
		change['birthday']='';
		change['skype']='';
		change['qq']='';
		change['wechat']='';
		change['inspection']=2;
		//change['tag']='memberadd';
		//alert(change['userName']+change['nickName']);
		adddd( change );
		return;
	}	
}



function register()
{
	
	if( $('#name').val()=='' )
	{
		var info = {'status':0, 'title':'', 'text1':'请输入帐号', 'text2':'' };
		msg(info);
	}
	else if( $('#nickname').val()=='' )
	{
		//alert('请输入帐号与昵称');
		var info = {'status':0, 'title':'', 'text1':'请输入昵称', 'text2':'' };
		msg(info);
	}
	else if( $('#loginPwd').val()=='' ||  $('#loginPwd').val().length <6
			|| !$('#loginPwd').val().match(/^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/g) )	
	{
			//alert('帐号密码请英数混合,至少6字元');
			var info = {'status':0, 'title':'', 'text1':'帐号密码请英数混合,至少6字元', 'text2':'' };
			msg(info);
			$('#loginPwd').val('');
			$('#loginPwd2').val('');
	}
	else if($('#loginPwd').val() != $('#loginPwd2').val() )
	{
		//alert('请检查帐号密码是否正确');
		var info = {'status':0, 'title':'', 'text1':'请检查帐号密码是否正确', 'text2':'' };
		msg(info);
		$('#loginPwd').val('');
		$('#loginPwd2').val('');
	}
	else if($('#receivePwd').val()=='' ||  $('#receivePwd').val().length<6
			|| !$('#receivePwd').val().match(/^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/g) )
			
	{
		//alert('提领密码请英数混合,至少6字元');
		var info = {'status':0, 'title':'', 'text1':'提领密码请英数混合,至少6字元', 'text2':'' };
		msg(info);
		$('#receivePwd').val('');
		$('#receivePwd2').val('');
	}
	else if($('#receivePwd').val()!= $('#receivePwd2').val())
	{
		//alert('请检查提领密码是否正确');
		var info = {'status':0, 'title':'', 'text1':'请检查提领密码是否正确', 'text2':'' };
		msg(info);
		$('#receivePwd').val('');
		$('#receivePwd2').val('');
	}
	else if($('#realname').val()=='' || !isNaN($('#realname').val()) )
	{
		//alert('汇款户名请输入中文或英文字');
		$('#realname').val('');
		var info = {'status':0, 'title':'', 'text1':'汇款户名请输入中文或英文字', 'text2':'' };
		msg(info);
	}
	else if( ckAccountName( $('#realname').val() ) != true )
	{
		var ckResult = ckAccountName( $('#realname').val() );
		if( ckResult == 'Contains numbers' ) msg( {'status':0, 'title':'', 'text1':'汇款户名不可含数字', 'text2':'' } );
		if( ckResult == 'Contains symbols' ) msg( {'status':0, 'title':'', 'text1':'汇款户名不可含符号', 'text2':'' } );
		return false;
	}
	else if($('#question').val()=='')
	{
		//alert('请输入安全性问题');
		var info = {'status':0, 'title':'', 'text1':'请输入安全性问题', 'text2':'' };
		msg(info);
	}
	else if($('#ans').val()=='')
	{
		//alert('请输入安全性答案');
		$('#ans').val('');
		var info = {'status':0, 'title':'', 'text1':'请输入安全性答案', 'text2':'' };
		msg(info);
	}
	else if ($('#mobile').val()=='' || $('#mobile').val().length<8 || isNaN($('#mobile').val()))
	{
		//alert('手机号码不足8位数字');
		$('#mobile').val('');
		var info = {'status':0, 'title':'', 'text1':'手机号码不足8位数字', 'text2':'' };
		msg(info);
	}
	else if($('#mobile_ans').val()<1)
	{
		$('#code4').val('');
		//alert($('#mobile_ans').val());
		var info = {'status':0, 'title':'', 'text1':'请完成手机验证', 'text2':'' };
		msg(info);
	}
	else
	{
		//alert($('#name').val());
		var change = new Object;
		change['userName'] =$('#name').val();
		change['nickName']=$('#nickname').val();
		change['loginPwd']=$('#loginPwd').val();
		change['receivePwd']=$('#receivePwd').val();
		change['agent']=$('#agentid').val();
		change['pointQuestion']=$('#question').val();
		change['pointAnswer']=$('#ans').val();
		change['AccountName']=$('#realname').val();
		change['mobile']=$('#area').val()+'-'+$('#mobile').val();
		change['email']='';
		change['birthday']='';
		change['skype']='';
		change['qq']='';
		change['wechat']='';
		change['inspection']=2;
		//change['tag']='memberadd';
		//alert(change['userName']+change['nickName']);
		adddd( change );

		return;
	}	
}

function adddd( change )
{
	$( '#submitBT' ).css( 'display', 'none' );
	Actions = jQuery.ajax({
		type: 'POST',
		url:  'ac_register.php',
		data: change,
		error: function(xhr)
		{
			//alert(1);
		},
		beforeSend:function(result)
		{
			//loadingCtrl( 1 );
		},
		success: function(answer)
		{
			if(answer==1)
			{
				var info = {'status':1, 'title':'注册成功', 'text1':'您的帐号'+change['userName']+'密码'+change['loginPwd'],
							'text2':'恭喜您已成为淘金网会员，请进行登入！','nextUrl':'logout.php' };
				msg(info);
			}
			else
			{
				var info = {'status':0, 'title':'系統訊息', 'text1':'您的帐号'+change['userName']+'密码'+change['loginPwd'],
							'text2':answer,'nextUrl':'./'+$('#agentid').val()};
				msg(info);
			}
		}
	});
}

//分頁選擇
function choose() 
{
	//alert($('#p').val());
	var change = new Object; 
	change['p']=$('#p').val();
	document.location.href="orders.php?p="+change['p'];
}

function page() 
{
	//alert($('#p').val());
	var change = new Object; 
	change['p']=$('#p').val();
	document.location.href="pointDetails.php?p="+change['p'];
}
//分頁選擇結束


//這裡是mail發送功能
function sendmail()
{
	// $("#msgx").css('display', 'block');
	// //alert('sendMail msgx');
	//return false;
	
	// //alert($('#check_word').val());
	// //alert($('#email').val());
	// //alert($('#name').val());
	emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
	
	if($('#email').val().search(emailRule)!= -1 && $('#name').val()!='' && $('#check_word').val() !='')
	{
	   // //alert("true");
	    var change= new Object;
	    change['mail']=$('#email').val();
	    change['name']=$('#name').val();
	    change['msg']=$('#msg').val();
	    change['check_word']=$('#check_word').val();
	    mailsend(change);
	    
	}
	else
	{
		var info = {'status':0, 'title':'', 'text1':'请检查资料是否输入错误', 'text2':'' };
		msg(info);

	}
	return false;
}
function mailsend( change )
	{
		//alert('ok');
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_tgContact.php',
			data: change,
			error: function(xhr)
			{
				//alert(1);
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );
			},
			success: function(answer)
			{
				//alert(3);
				loadingCtrl( 0 );
				if(answer=='ok')
				{
					var info = {'status':1, 'title':'', 'text1':'您的讯息已送出', 'text2':'我们会尽快与您联系' ,'nextUrl':'index.php'};
					msg(info);	
				}
				else
				{
					var info = {'status':0, 'title':'', 'text1':'抱歉,您的讯息无法送出', 'text2':'请洽询客服','nextUrl':'index.php' };
					msg(info);
				}
			}
		});
	}
//mail發送功能結束


//這裡是對戰紀錄
function pk() 
{
 var change = new Object;
 change['gamename'] = CacheGameName;
 change['gametime'] = CacheGameTime;
 showpk(change);
 return;
}

function showpk(change)
{
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_pkRecord.php',
			data: change,
			error: function(xhr)
			{
				//alert(10000);
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );
			},
			success: function(answer)
			{
				//alert(30000);
				loadingCtrl( 0 );
				$('#Modal_game_record').css('display', 'block');
				$('#pkrecord').html(answer);
			}
		});
}
//對戰紀錄結束

//找客服開始
function icon(value)
{
	//alert(value);
	$('#QRcode').html('');
	var change = new Object;
	change['icon']=value;
	if(change['icon']=='QQ')
	{
		$('#service').html('淘金网客服【QQ扫一扫】');
	}
	else
	{
		$('#service').html('淘金网客服【微信扫一扫】');
	}
	service(change);
	return;
}
function service(change)
{
	//alert(change['icon']);
	Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_service.php',
			data: change,
			error: function(xhr)
			{

			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );	
			},
			success: function(answer)
			{
				//alert(answer);
				loadingCtrl( 0 );
				$('#QRcode').html(answer);
			}
		});
}


//找客服結束



//傳送驗證碼 開始
function mobilecheck() 
{
	$('#point_notice').css('block');
	$('#point_notice').html('※请于10分钟内完成验证码输入，如有疑问请洽客服。');
	if($('#area').val()=='')
	{
		msg( {'status':0, 'title':'', 'text1':'请选择地区', 'text2':'' } );
		return false;
	}
	if($('#mobile').val()=='' || $('#mobile').val().length<8 || isNaN($('#mobile').val()))
	{
		msg( {'status':0, 'title':'', 'text1':'手机号码不足8位数字', 'text2':'' } );
		return false;
	}
	else
	{
		var change = new Object;
		change['mobile'] = $( '#area' ).val()+'-'+$( '#mobile' ).val();
		change['inspection']=1;
		Actions = jQuery.ajax({
				type: 'POST',
				url:  'ac_register.php',
				data:change,
				error: function(xhr)
				{
				},
				beforeSend:function(result)
				{
					loadingCtrl( 1 );	
				},
				success: function(answer)
				{
					loadingCtrl( 0 );
					//alert(answer);
					var res = JSON.parse( answer );
					if( res.reCode == "000" )
					{
						//send_code();//ac_regist.php已同時處理門號重複檢驗, 簡訊碼發送
						
						$( "#mobile" ).attr("readonly","readonly");//attr更改狀態
						$( '#send_code' ).css( 'display', 'none' );
						msg( {'status':1, 'title':'', 'text1':'验证码发送', 'text2':res.reMsg } );
					}
					else if( res.reCode == "666" )
					{
						msg( {'status':0, 'title':'', 'text1':'验证码发送', 'text2':'['+res.reCode+']'+res.reMsg } );
					}
					else
					{
						msg( {'status':0, 'title':'', 'text1':'验证码发送', 'text2':'['+res.reCode+']'+res.reMsg } );
					}
				}
			});
	}
}


function send_code()
{
	$('#send_code').css('display','none');
	Actions = jQuery.ajax({
			type: 'POST',
			url:  'code4.php',
		
			error: function(xhr)
			{
				
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );	
			},
			success: function(answer)
			{
				//alert(1);
				loadingCtrl( 0 );
				var info = {'status':1, 'title':'验证码讯息', 'text1':answer, 'text2':'' };
				msg(info);
			}
		});
}
 
function codecheck()
{
	//alert($('#code4').val());
	if( $('#mobile').val() == '' || $('#mobile').val().length < 8 || isNaN( $('#mobile').val() ) || $( '#area' ).val() == '' )
	{
		msg( {'status':0, 'title':'', 'text1':'请输入正确手机号', 'text2':'' } );
		return false;
	}
	else if( isNaN( $('#code4').val() ) || $('#code4').val().length != 4 )
	{
		msg( {'status':0, 'title':'', 'text1':'验证码验证', 'text2':'请输入正确数值验证码' } );
		return false;
	}
	var change=new Object;
	change['ckCode']	 = $('#code4').val();
	change['mobile']	 = $( '#area' ).val()+'-'+$( '#mobile' ).val();
	change['inspection'] = 'ckCode';
	Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_register.php',
			data: change,
			error: function(xhr)
			{
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );	
			},
			success: function(answer)
			{
				loadingCtrl( 0 );
				var res = JSON.parse( answer );
				if( res.reCode == '000' )
				{
					$( '#cfCode' ).css( 'display', 'none' );
					$( '#confirmCode' ).css( 'display', 'none' );
					$( '#reSendCode' ).css( 'display', 'none' );
					msg( {'status':1, 'title':'', 'text1':'手机认证', 'text2':'手机认证 '+res.reMsg } );	
					$('#mobile_ans').val(answer);
				}
				else
				{
					msg( {'status':0, 'title':'', 'text1':'手机认证', 'text2':'['+res.reCode+']'+res.reMsg } );
				}
				
				
			}
		});
}
//傳送驗證碼 結束


// 金額設定 開始
function setamount()
{
	// //alert($('#a').val());
	// //alert('xxx');
	if( isNaN($('#a').val()) || isNaN($('#b').val()) || isNaN($('#c').val()) || 
		$('#a').val()=='' || $('#b').val()=='' || $('#c').val()=='' )
	{
		//alert('请输入正确的数值');
		// var info = {'status':0, 'title':'', 'text1':'请输入正确的数值', 'text2':'' };
		// msg(info);
	}
	else
	{
		var change = new Object;
		change['a']=$('#a').val();
		change['b']=$('#b').val();
		change['c']=$('#c').val();
		changeamount(change);
	}
}

function changeamount(change)
{
	Actions = jQuery.ajax({
			type: 'GET',
			url:  'setamount.php',
			data: change,
			error: function(xhr)
			{
				
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );	
			},
			success: function(answer)
			{
				 //alert(change['icon']);
				loadingCtrl( 0 );
				if(answer==1)
				{
					//alert('修改成功'+change['a']+'---'+change['b']+'---'+change['c'] );
					$('#as').html(change['a']);
					$('#bs').html(change['b']);
					$('#cs').html(change['c']);
					var info = {'status':1, 'title':'', 'text1':'修改成功', 'text2':change['a']+change['b']+change['c'] };
					msg(info);	 

				}
				else
				{
					//alert(answer);
					//alert('修改失敗');
					var info = {'status':1, 'title':'', 'text1':'修改失敗', 'text2':'' };
					msg(info);	
				}
			 

			}
		});
}
//金額設定 結束
//取消订单 开始
function delorder(betid)
{
	var change=new Object;
	change['betid']=betid;
	Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_orders.php',
			data: change,
			error: function(xhr)
			{
				
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );	
			},
			success: function(answer)
			{
				 //alert(change['icon']);
				 alert(answer);
				loadingCtrl( 0 );
				/*if(answer==1)
				{
					var info = {'status':1, 'title':'', 'text1':'修改成功', 'text2':change['a']+change['b']+change['c'] };
					msg(info);	 

				}
				else
				{
					//alert(answer);
					//alert('修改失敗');
					var info = {'status':1, 'title':'', 'text1':'修改失敗', 'text2':'' };
					msg(info);	
				}*/
			 

			}
		});
}
//取消订单 结束

//打開獨立交易量表 
function openchartx(gameid,marketid,chartid)
{
	//alert(marketid);
	var change=new Object;
	change['gameid']=gameid;
	change['marketid']=marketid;
	change['chartid']=chartid;
	//$('#Modal_deal_chart').css('display','block');
	if(chartid==1)
	{
		$('#chartname').html('波胆');
	}
	if(chartid==2)
	{
		$('#chartname').html('半场波胆');
	}
	if(chartid==3)
	{
		$('#chartname').html('总得分');
	}
	if(chartid==0)
	{
		$('#chartname').html('首入球时间');
	}
	Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_dealchart.php',
			data: change,
			error: function(xhr)
			{
				//alert('error');
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );	
				//alert('beforeSend');
			},
			success: function(answer)
			{
				 //alert(change['icon']);
				// alert('xxx');
				loadingCtrl( 0 );
				$('#chart_content').html(answer);				
				$('#Modal_deal_chart').css('display','block');	

			}
		});
	
}

//打開交易量表
function openchart(gameid,ga12,marketid)
{
	//alert(marketid);
	var change=new Object;
	change['gameid']=gameid;
	change['ga12']=ga12;
	change['marketid']=marketid;
	//$('#Modal_deal_chart').css('display','block');
	if(marketid==1)
	{
		$('#chartname').html('波胆');
	}
	if(marketid==2)
	{
		$('#chartname').html('半场波胆');
	}
	if(marketid==3)
	{
		$('#chartname').html('总得分');
	}
	if(marketid==0)
	{
		$('#chartname').html('首入球时间');
	}
	Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_dealchart.php',
			data: change,
			error: function(xhr)
			{
				
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );	
			},
			success: function(answer)
			{
				 //alert(change['icon']);
				// alert('xxx');
				loadingCtrl( 0 );
				$('#chart_content').html(answer);				
				$('#Modal_deal_chart').css('display','block');	

			}
		});
	
}

//发表留言底家 
function notallow( ckStr ) //先过滤留言内容
{
	var ckStrang = /[`'*@=><|}{)(#\$%\^&\*+/]+/g;
	if( ckStrang.test( ckStr ) )
	{
		return 'Contains symbols';
	}
	if(ckStr.toLowerCase()=="https" || ckStr.toLowerCase()=="http") 
	{ 
  		return 'Contains words';
	} 
	return true;
}


function opinion()
{

	if( notallow( $('#msg').val() ) != true )
	{
		var ckResult = notallow( $('#msg').val() );
		if( ckResult == 'Contains symbols' ) msg( {'status':0, 'title':'', 'text1':'评论内容不可含符号', 'text2':'' } );
		if( ckResult == 'Contains words' ) msg( {'status':0, 'title':'', 'text1':'评论内容不可含特殊字符', 'text2':'' } );
		return false;
	}
	else if($('#msg').val() =='')
	{
		var info = {'status':0, 'title':'', 'text1':'请输入您的评论', 'text2':'' };
		msg(info);	
	}
	else
	{
		var change=new Object;
		change['content']=$('#msg').val();
		change['news_id']=$('#news_id').val();
		change['tag']='opinion';
		//alert(change['content']+change['news_id'] );
		Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_hotnews.php',
			data: change,
			error: function(xhr)
			{
				//alert('error');
			},
			beforeSend:function(result)
			{
				loadingCtrl( 1 );	
			},
			success: function(answer)
			{
				 //alert(answer);
				if( answer=="S01" )
				{
					location.reload();

				}
				
			}
		});
	}
	
}
//新闻按赞功能
function newslike(likes,id)
{
	//alert(likes);
	var likes=likes+1;
	var change= new Object;
	change['news_id']=id;
	change['tag']='newslike';
	Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_hotnews.php',
			data: change,
			error: function(xhr)
			{
				//alert('error');
			},
			beforeSend:function(result)
			{
				
			},
			success: function(answer)
			{
				//alert(answer);
				if( answer!="S01" )
				{
					 var info = {'status':0, 'title':'', 'text1':'您已经赞过了', 'text2':'' };
					 msg(info);
					//$('#newslike').html(likes-1);
				}
				else
				{
					$('#newslike').html(likes);
				}
				
			}
		});
}

//留言按赞功能
function msglike(like,msg_id)
{
	var like=like+1;
	

	var change= new Object;
	change['msg_id']=msg_id;
	change['tag']='msglike';
	Actions = jQuery.ajax({
			type: 'POST',
			url:  'ac_hotnews.php',
			data: change,
			error: function(xhr)
			{
				//alert('error');
			},
			beforeSend:function(result)
			{
				
			},
			success: function(answer)
			{
				//alert(answer);
				if( answer!="S01" )
				{
					var info = {'status':0, 'title':'', 'text1':'您已经赞过了', 'text2':'' };
					msg(info);
					//$('#msg_like'+msg_id).html(like-1);
				}
				else
				{
					$("#msg_like"+msg_id).html(like);
				}
				
			}
		});
}


//显示留言列表
 function showhide(msg_id)
 {
    $(".x").slideToggle("slow");
  }
//取消注单
function delorder(betid)
{
	var change=new Object;
	change['bet_id']=betid;
	Actions = jQuery.ajax({
            type: 'POST',
            url:  'ac_orders.php',
            data: change,
            error: function(xhr)
            {
               // alert('xxx');
            },
            beforeSend:function(result)
            {
                loadingCtrl( 1 );   
            },
            success: function(answer)
            {
                //alert(answer);
                loadingCtrl( 0 );
                
                //var res=JSON.parse( answer );
                if(res.error_code==106)
                {
                    var info = {'status':1, 'title':'', 'text1':'取消成功', 'text2':res.perform_result, 'nextUrl':'orders.php'};
                    msg(info);
                }
                else
                {
                    var info = {'status':0, 'title':'', 'text1':'取消失败', 'text2':res.perform_result, 'nextUrl':'orders.php'};
                    msg(info);
                }
                reLoadUserInfo();               
            }
        });
}