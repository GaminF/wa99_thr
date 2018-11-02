// Set the date we're counting down to
var countDownDate = parseInt($('#lefttime').val())*1000;

var nowtime=new Date().getTime();
var endtime= countDownDate+nowtime;

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = endtime - now;
//alert( 'countDownDate:'+countDownDate+' - now:'+now+' = distance:'+distance );
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Output the result in an element with id="demo"
    document.getElementById("day").innerHTML = ('0'+'0' + days).slice(-3);
    document.getElementById("hour").innerHTML =('0' + hours).slice(-2);
    document.getElementById("min").innerHTML = ('0' + minutes).slice(-2);
    document.getElementById("sec").innerHTML = ('0' + seconds).slice(-2);

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
