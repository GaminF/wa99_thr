// Set the date we're counting down to
var fifa_date =new Date("June 14, 2018 23:00:00");
//var countDownDate = parseInt(fifa_date)*1000;
var countDownDate = fifa_date.getTime();
//alert(fifa_date+'/'+countDownDate);
// var nowtime=new Date().getTime();
// var endtime= countDownDate+nowtime;

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
   // var now = new Date().getTime();
    var now = new Date();
    //alert(now);
    // Find the distance between now an the count down date
    var distance = countDownDate - now;

   // alert( 'countDownDate:'+countDownDate+' - now:'+now+' = distance:'+distance );
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));

    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var hourOne = parseInt(hours / 10);
    var hourtwo = hours%10;
    
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var minOne = parseInt(minutes / 10);
    var minTwo = minutes%10;
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    var secOne = parseInt(seconds / 10);
    var secTwo = seconds%10;
    // Output the result in an element with id="demo"
    document.getElementById("fifa_day").innerHTML = '<span>'+'0</span><span>'+ days+'</span><span>天</span>';
    document.getElementById("fifa_hour").innerHTML ='<span>'+hourOne+'</span><span>'+hourtwo +'</span>'+'<span>时</span>';
    document.getElementById("fifa_min").innerHTML = '<span>'+minOne+'</span><span>'+minTwo+'</span><span>分</span>';
    document.getElementById("fifa_sec").innerHTML = '<span>'+secOne+'</span><span>'+secTwo+'</span><span>秒</span>';

    // If the count down is over, write some text
    // if (distance < 0) {
    //     clearInterval(x);
    //     document.getElementById("date").innerHTML = "EXPIRED";
    // }
}, 1000);





// function getTimeRemaining(endtime) {
//     var t = Date.parse(endtime) - Date.parse(new Date());
//     var seconds = Math.floor((t / 1000) % 60);
//     var minutes = Math.floor((t / 1000 / 60) % 60);
//     var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
//     var days = Math.floor(t / (1000 * 60 * 60 * 24));
//     return {
//         'total': t,
//         'days': days,
//         'hours': hours,
//         'minutes': minutes,
//         'seconds': seconds
//     };
// }
//
// function initializeClock(id, endtime) {
//     var clock = document.getElementById(id);
//     var daysSpan = clock.querySelector('.days');
//     var hoursSpan = clock.querySelector('.hours');
//     var minutesSpan = clock.querySelector('.minutes');
//     var secondsSpan = clock.querySelector('.seconds');
//
//     function updateClock() {
//         var t = getTimeRemaining(endtime);
//
//         daysSpan.innerHTML = ('0'+'0'+t.days).slice(-3);
//         hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
//         minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
//         secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
//
//         if (t.total <= 0) {
//             clearInterval(timeinterval);
//         }
//     }
//
//     updateClock();
//     var timeinterval = setInterval(updateClock, 1000);
// }
//
// var deadline = new Date(Date.parse(new Date()) + 1 * 10 * 60 * 60 * 1000);
// initializeClock('countdown', deadline);
