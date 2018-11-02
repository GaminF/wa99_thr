		var arr = TodayStr.split(/[- :]/),
		Today = new Date(arr[0], arr[1]-1, arr[2], arr[3], arr[4], arr[5]);
		var yearTd	= Today.getFullYear();
		var monthTd	= Today.getMonth();
		var weekTd	= Today.getDay();
		var dayTd	= Today.getDate();
		var hoursTd = Today.getHours();
		var minutesTd = Today.getMinutes();
		var secondsTd = Today.getSeconds();
		
	var yearTag = "年";
	//var months = "一月,二月,三月,四月,五月,六月,七月,八月,九月,十月,十一月,十二月".split(",");
	var weekdays = "日,一,二,三,四,五,六".split(",");

	var countdownid;
	function runTime(){
		runFunc();
	}
	function runFunc(){
		if( secondsTd == 59 )
		{
			secondsTd = 0;
			minutesTd++;
		}
		else
		{
			secondsTd++;
		}
		if( minutesTd == 59 )
		{
			minutesTd = 0;
			hoursTd++;
		}

		if( hoursTd == 24 )
		{
			location.reload();
		}
		
		if( secondsTd < 10 ) ss = '0'+secondsTd; else ss = secondsTd;
		if( minutesTd < 10 ) mm = '0'+minutesTd; else mm = minutesTd;
		if( hoursTd < 10 )	hh = '0'+hoursTd; else hh = hoursTd;
		var nowTime = yearTd+yearTag+(monthTd+1)+'月'+dayTd+'日 星期'+weekdays[weekTd]+'&nbsp;'+hh+':'+mm+':'+ss+'&nbsp;(&nbsp;北京标准时间&nbsp;)';
		$("#sysDateTime").html( nowTime );
		//$( '#MICHAT-FLOAT-WRAP' ).css( 'display', 'none' );//180625TGService強制關閉icon
		countdownid=setTimeout(runFunc,1000);
	}
