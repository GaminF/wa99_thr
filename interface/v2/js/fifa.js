$(function () {
	$('#sche_lists_date').change(function () {
		$('.sche_list_content').hide();
		$('#date' + $(this).val()).show();
	});
});




//<div id="LiveClock"></div>
function ActivityTime() {
	var activityDeadline = new Date("07/15/2018"); //开幕倒计时 
	var activityNow = new Date();
	var activityLeave = (activityDeadline.getTime() - activityNow.getTime());
	var activityDay = Math.floor(activityLeave / (1000 * 60 * 60 * 24));

	var LiveClock = document.getElementById("LiveClock")
	activityDay = activityDay + 1;

	if (activityDay > 0) {
		LiveClock.innerHTML = activityDay;
		setTimeout("ActivityTime()", 10000);
	}
}
ActivityTime();



function DigitalTime() {
	var deadline = new Date("06/14/2018 23:00"); //开幕倒计时 
	var now = new Date();
	var leave = (deadline.getTime() - now.getTime());
	var day = Math.floor(leave / (1000 * 60 * 60 * 24));
	
	var hour = Math.floor(leave / (1000 * 3600)) - (day * 24);
	var hourOne = parseInt(hour / 10);
	var hourTwo = hour%10;
	
	var minute = Math.floor(leave / (1000 * 60)) - (day * 24 * 60) - (hour * 60);
	var minOne = parseInt(minute / 10);
	var minTwo = minute%10;
	
	var second = Math.floor(leave / (1000)) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
	var secOne = parseInt(second / 10);
	var secTwo = second%10;
	

	var LiveClockD = document.querySelector('.LiveClockDays');
	var LiveClockH = document.querySelector('.timeHour');
	var LiveClockM = document.querySelector('.timeMin');
	var LiveClockS = document.querySelector('.timeSec');

	day = day + 1;

	if (day > 0) {

		LiveClockD.innerHTML = day;

		LiveClockH.innerHTML = '<span>' + hourOne + '</span><span>' + hourTwo + '</span>';
		LiveClockM.innerHTML = '<span>' + minOne + '</span><span>' + minTwo + '</span>';
		LiveClockS.innerHTML = '<span>' + secOne + '</span><span>' + secTwo + '</span>';
		
		
		setTimeout("DigitalTime()", 1000);
	}
}
DigitalTime();









