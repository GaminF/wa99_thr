var tradOne = Math.ceil(tradingVolume[0] / 1000);
var tradTwo = Math.ceil(tradingVolume[1] / 1000);
var tradThree = Math.ceil(tradingVolume[2] / 1000);


setTimeout(function () {
	$('#topOneScore').each(function () {
		$(this).prop('Counter', 0).animate({
			Counter: tradOne
		}, {
			duration: 1000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			}
		});
	});
	$('#topTwoScore').each(function () {
		$(this).prop('Counter', 0).animate({
			Counter: tradTwo
		}, {
			duration: 1000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			}
		});
	});
	$('#topThreeScore').each(function () {
		$(this).prop('Counter', 0).animate({
			Counter: tradThree
		}, {
			duration: 1000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			}
		});
	});
}, 0);

var oneNum = tradingVolume[0] / (tradingVolume[0] + surplusVolume[0]) * 410;
var twoNum = tradingVolume[1] / (tradingVolume[1] + surplusVolume[1]) * 410;
var threeNum = tradingVolume[2] / (tradingVolume[2] + surplusVolume[2]) * 410;


$('#one_value').attr('stroke-dashoffset', 410 - oneNum );
$('#two_value').attr('stroke-dashoffset', 410 - twoNum );
$('#three_value').attr('stroke-dashoffset', 410 - threeNum );
