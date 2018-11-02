var height_tmp = [0, 0, 0, 0, 0, 0, 0, 0, 0,0]
var height_tmpSec = [0, 0, 0, 0, 0, 0, 0, 0, 0]

var stAll = st.concat(st2);
var max = Math.max.apply(Math, stAll);


function main() {
	for (var i = 0; i < st.length; i++) {

		var wrap = document.createElement("div");
		wrap.className = ('bar_wrap');

		var bar_font = document.createElement("div");
		bar_font.className = ('bar');
		wrap.appendChild(bar_font);

		var bar_side = document.createElement("div");
		bar_side.className = ('bar_side');
		wrap.appendChild(bar_side);

		var bar_value = document.createElement("div");
		bar_value.className = ('bar_value');
		bar_font.appendChild(bar_value);
		bar_value.innerHTML = st[i];

		document.getElementById('chart_column').appendChild(wrap);
		
		var Value = document.createElement("div");
		Value.className = ('score');
		wrap.appendChild(Value);
		Value.innerHTML = '<p>' + stChartValue[i] + '</p>';
	}
	
	for (var i = 0; i < st2.length; i++) {
		
		var wrap2 = document.createElement("div");
		wrap2.className = ('bar_wrap2');
		
		var bar_font2 = document.createElement("div");
		bar_font2.className = ('barSec');
		wrap2.appendChild(bar_font2);

		var bar_sideSec = document.createElement("div");
		bar_sideSec.className = ('bar_sideSec');
		wrap2.appendChild(bar_sideSec);

		var bar_value2 = document.createElement("div");
		bar_value2.className = ('bar_value2');
		bar_font2.appendChild(bar_value2);
		bar_value2.innerHTML = st2[i];

		document.getElementById('chart_columnSec').appendChild(wrap2);
	
		var ValueSec = document.createElement("div");
		ValueSec.className = ('score');
		wrap2.appendChild(ValueSec);
		ValueSec.innerHTML = '<p>' + stChartValueSec[i] + '</p>';
	}


	function bar_loading_f() {

		function bar_loading() {

			var bar = document.getElementsByClassName("bar");
			var bar2 = document.getElementsByClassName("bar_side");
			setInterval(function () {

				for (var i = 0; i < bar.length; i++) {

					 if ( height_tmp[i] === st[i]  ){
						continue;
					} 
					  else if ( height_tmp[i] >= (st[i] / max) * 100) {
						continue;
					} 
					  else {
						height_tmp[i] += 1;
						bar[i].style.height = (height_tmp[i]) + '%';
					}

					if ( height_tmp[i] < 20) {
						bar[i].classList.add('first_color');
					} else if (height_tmp[i] >= 20 && height_tmp[i] <= 40) {
						bar[i].classList.add('second_color');
						bar[i].classList.remove('first_color');
					} else if (height_tmp[i] >= 40 && height_tmp[i] <= 60) {
						bar[i].classList.add('third_color');
						bar[i].classList.remove('second_color');
					} else if (height_tmp[i] >= 60) {
						bar[i].classList.add('fourth_color');
						bar[i].classList.remove('third_color');
					}
					bar_loading_side(bar2);
				}

			}, 12);
			
		}

		function bar_loading_side(bar) {
			for (var i = 0; i < bar.length; i++) {
				bar[i].style.height = (height_tmp[i]) + '%';

				if ( height_tmp[i] < 20) {
					bar[i].classList.add('first_color');
				} else if (height_tmp[i] >= 20 && height_tmp[i] <= 40) {
					bar[i].classList.add('second_color');
					bar[i].classList.remove('first_color');
				} else if (height_tmp[i] >= 40 && height_tmp[i] <= 60) {
					bar[i].classList.add('third_color');
					bar[i].classList.remove('second_color');
				} else if (height_tmp[i] >= 60) {
					bar[i].classList.add('fourth_color');
					bar[i].classList.remove('third_color');
				}
			}

		}
		bar_loading();

	}
	bar_loading_f();
	
	
	
	function bar_loading_fSec() {

		function bar_loadingSec() {

			var barA = document.getElementsByClassName("barSec");
			var barB = document.getElementsByClassName("bar_sideSec");
			setInterval(function () {

				for (var i = 0; i < barA.length; i++) {

					if ( height_tmpSec[i] === st2[i]  ){
						continue;
					}
					else if (height_tmpSec[i] >= (st2[i] / max) * 100) {
						continue;

					} 
					else {
						height_tmpSec[i] += 1;
						barA[i].style.height = (height_tmpSec[i]) + '%';
					}
					
					if (height_tmpSec[i] >= 1 && height_tmpSec[i] < 20) {
						barA[i].classList.add('first_color');
					} else if (height_tmpSec[i] >= 20 && height_tmpSec[i] <= 40) {
						barA[i].classList.add('second_color');
						barA[i].classList.remove('first_color');
					} else if (height_tmpSec[i] >= 40 && height_tmpSec[i] <= 60) {
						barA[i].classList.add('third_color');
						barA[i].classList.remove('second_color');
					} else if (height_tmpSec[i] >= 60) {
						barA[i].classList.add('fourth_color');
						barA[i].classList.remove('third_color');
					}
					bar_loading_sideSec(barB);
				}

			}, 12);
			
		}

		function bar_loading_sideSec(barA) {
			for (var i = 0; i < barA.length; i++) {
				barA[i].style.height = (height_tmpSec[i]) + '%';

				if (height_tmpSec[i] >= 1 && height_tmpSec[i] < 20) {
					barA[i].classList.add('first_color');
				} else if (height_tmpSec[i] >= 20 && height_tmpSec[i] <= 40) {
					barA[i].classList.add('second_color');
					barA[i].classList.remove('first_color');
				} else if (height_tmpSec[i] >= 40 && height_tmpSec[i] <= 60) {
					barA[i].classList.add('third_color');
					barA[i].classList.remove('second_color');
				} else if (height_tmpSec[i] >= 60) {
					barA[i].classList.add('fourth_color');
					barA[i].classList.remove('third_color');
				}
			}

		}
		bar_loadingSec();

	}
	bar_loading_fSec();
	
	
	
	function backGround (){
		
		function bgA () {
			var coordinate = document.createElement('div');
			coordinate.setAttribute('class','coordinate');
			document.querySelector('.chart_bg').appendChild(coordinate);
			for (var i=1; i<6 ; i++) {
				var newDiv = document.createElement('div');
				newDiv.setAttribute('class','coors');
				document.querySelector('.coordinate').appendChild(newDiv);
			}
		}
		function bgB () {
			var coordinate = document.createElement('div');
			coordinate.setAttribute('class','coordinate2');
			document.querySelector('.chart_bg2').appendChild(coordinate);
			for (var i=1; i<6 ; i++) {
				var newDiv = document.createElement('div');
				newDiv.setAttribute('class','coors');
				document.querySelector('.coordinate2').appendChild(newDiv);
			}
		}
		 bgA ();
		 bgB ();
		
	};
	backGround ();
	
};
main();


