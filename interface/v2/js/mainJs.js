//var d = new Date();
//document.getElementById("date").innerHTML = d;


$(document).ready(function(){
    $('#service_more_btn').click(function(event){
        event.stopPropagation();
        $("#more").toggle("fast");
    });
    $("#more").on("click", function (event) {
        event.stopPropagation();
    });
});
$(document).on("click", function () {
    $("#more").hide();
});



$("#rules_btn01").click(function() {
    $('html,body').animate({
            scrollTop: $("#title01").offset().top},
        'slow');
});
$("#rules_btn02").click(function() {
    $('html,body').animate({
            scrollTop: $("#title02").offset().top},
        'slow');
});
$("#rules_btn03").click(function() {
    $('html,body').animate({
            scrollTop: $("#title03").offset().top},
        'slow');
});
$("#rules_btn04").click(function() {
    $('html,body').animate({
            scrollTop: $("#title04").offset().top},
        'slow');
});
$("#about_us_01").click(function() {
    $('html,body').animate({
            scrollTop: $("#title04").offset().top},
        'slow');
});
$("#about_us_02").click(function() {
    $('html,body').animate({
            scrollTop: $("#title05").offset().top},
        'slow');
});
$(".market_game").on("click",function(){
     $(this).addClass("market_game_active").siblings().removeClass("market_game_active");
})

$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 500) {
            $('#return-to-top').fadeIn();
        } else {
            $('#return-to-top').fadeOut();
        }
    });

    // scroll body to 0px on click
    $('#return-to-top').click(function () {
        $('html,body').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
});

var cover = document.getElementById('Modal_cover');
var cover2 = document.getElementById('Modal_success');
var cover3 = document.getElementById('Modal_failure');
var cover4 = document.getElementById('Modal_times');
var cover5 = document.getElementById('Modal_order01');
var cover6 = document.getElementById('Modal_order02');
var cover7 = document.getElementById('Modal_order03');
var cover8 = document.getElementById('Modal_game_record');
var cover9 = document.getElementById('Modal_pmode');
var cover10 = document.getElementById('Modal_service');
var cover11 = document.getElementById('Modal_service');
var cover12 = document.getElementById('Modal_times_none');
var cover13 = document.getElementById('Modal_deal_chart');

window.onclick = function (event) {
    if (event.target == cover) {
        cover.style.display = "none";
    }
    if (event.target == cover2) {
        cover2.style.display = "none";
    }
    if (event.target == cover3) {
        cover3.style.display = "none";
    }
    if (event.target == cover4) {
        cover4.style.display = "none";
    }
    if (event.target == cover5) {
        cover5.style.display = "none";
    }
    if (event.target == cover6) {
        cover6.style.display = "none";
    }
    if (event.target == cover7) {
        cover7.style.display = "none";
    }
    if (event.target == cover8) {
        cover8.style.display = "none";
    }
    if (event.target == cover9) {
        cover9.style.display = "none";
    }
    if (event.target == cover10) {
        cover10.style.display = "none";
    }
    if (event.target == cover11) {
        cover11.style.display = "none";
    }
    if (event.target == cover12) {
        cover12.style.display = "none";
    }
     if (event.target == cover13) {
        cover13.style.display = "none";
    }
    
   
};

$("#modify01").on('click', function () {
    $("#Modal_cover").css('display', 'block');
});


$("#Modal_order04").on('click', function () {
   window.location.href = "pointc2c.php";
}); //0326 nillie for test

$("#confirm_modify").on('click', function () {
    $("#Modal_cover").css('display', 'none');
    $("#Modal_success").css('display', 'block');
});
$("#confirm_modify03").on('click', function () {
    $("#Modal_cover03").css('display', 'none');
    $("#Modal_success").css('display', 'block');
});
$(".close_icon").on('click', function () {
    $("#Modal_cover").css('display', 'none');
    $("#Modal_cover02").css('display', 'none');
    $("#Modal_cover03").css('display', 'none');
    $("#Modal_success").css('display', 'none');
    $("#Modal_failure").css('display', 'none');
    $("#Modal_times").css('display', 'none');
    $("#Modal_times_none").css('display', 'none');
    $("#Modal_order01").css('display', 'none');
    $("#Modal_order02").css('display', 'none');
    $("#Modal_order03").css('display', 'none');
    $("#Modal_pmode").css('display', 'none');
    $("#Modal_service").css('display', 'none');
});

$(".close_icon_setting").on('click', function () {
    $("#Modal_setting").css('display', 'none');
});
$("#setting_cancel").on('click', function () {
    $("#Modal_setting").css('display', 'none');
});
$(".close_modal").on('click', function () {
    $("#Modal_game_record").css('display', 'none');
    $("#Modal_deal_chart").css('display', 'none');
});
$("#modify02").on('click', function () {
    $("#Modal_cover").css('display', 'block');
});
$("#confirm_modify02").on('click', function () {
    $("#Modal_cover02").css('display', 'none');
    $("#Modal_failure").css('display', 'block');
});
$('#cancel_modify').on('click',function () {
    $("#Modal_cover").css('display', 'none');
});
$('#cancel_modify02').on('click',function () {
    $("#Modal_cover02").css('display', 'none');
});
$('#cancel_modify03').on('click',function () {
    $("#Modal_cover03").css('display', 'none');
});
$("#modify03").on('click', function () {
    $("#Modal_cover03").css('display', 'block');
});
$("#complete").on('click', function () {
    $("#Modal_success").css('display', 'block');
});
$("#complete＿chinabank").on('click', function () {
    $("#Modal_times").css('display', 'block');
    getscript();
    function getscript() {
        $.getScript("../js/soon_test.js")
    }
});
/*$(".modal_times_confirm").on('click', function () {
    $("#Modal_times").css('display', 'none');
    $("#Modal_times_none").css('display', 'block');
    getscript();
    function getscript() {
        $.getScript("../js/soon_test.js")
    }
});*/
$("#confirm_next").on('click',function () {
    $("#Modal_times").css('display', 'none');
    $("#Modal_success").css('display', 'block');
})

$(".btn_order button").on('click', function () {
    $("#Modal_order01").css('display', 'block');

});

$("#confirm_order").on('click', function () {
    $("#Modal_order01").css('display', 'none');
    $("#Modal_order02").css('display', 'block');
});
$("#confirm_order02").on('click', function () {
    $("#Modal_order02").css('display', 'none');
    $("#Modal_order03").css('display', 'block');
    // $("#Modal_failure").css('display', 'block');
});
$('#cancel_order').on('click',function () {
    $("#Modal_order01").css('display', 'none');
});
$('#cancel_order02').on('click',function () {
    $("#Modal_order02").css('display', 'none');
});
$('#game_record').on('click',function () {
    $("#Modal_game_record").css('display', 'block');
});
$('#deal_volume').on('click',function () {
    $("#Modal_deal_chart").css('display', 'block');
});
$('#pmode').on('click',function () {
    $("#Modal_pmode").css('display', 'none');
});
$("#service_QQ").on('click', function () {
    $("#Modal_service").css('display', 'block');
});
$("#service_weixin").on('click', function () {
    $("#Modal_service").css('display', 'block');
});
$("#setting").on('click', function () {
    $("#Modal_setting").css('display', 'block');
});

$(".choose_alli").on('click',function () {
    $(this).find('input[type="checkbox"]').click();
});
$(".choose_alli label,.choose_alli label span").on('click',function () {
    $(this).parent().find('input[type="checkbox"]').click();

});

$('.modal_times_confirm2').on('click',function () {
    $("#Modal_times_none").css('display', 'none');
});
$('.modal_times_cancel').on('click',function () {
    $("#Modal_times_none").css('display', 'none');
});








$('#log_out').on('click',function(){
    //$('.main_content').load('../html/trade_detail.html .content').hide().fadeIn(300);
	window.location.href='./logout.php';
});

$('#trade_detail').on('click',function(){
    //$('.main_content').load('../html/trade_detail.html .content').hide().fadeIn(300);
	window.location.href='./orders.php';
});

$('#history').on('click',function(){
    //$('.main_content').load('../html/history.html .content').hide().fadeIn(300);
	window.location.href='./fifa_history_all.php';
});

$('#game_result').on('click',function(){
    //$('.main_content').load('../html/game_result.html .content').hide().fadeIn(300);
	window.location.href='./result.php';
});
$('#my').on('click',function(){
    //$('.main_content').load('../html/my.html .content').hide().fadeIn(300);
	window.location.href='./userCenter.php';
});

$('.history_content tr').on('click',function () {
    $('#history_table').load('../html/history_detail.html #history_table').hide().fadeIn(300);
	//window.location.href='./targetList.php';
})
$('#market_list').on('click',function () {
	window.location.href='./targetList.php';
})
$('#live_score').on('click',function () {
	window.open('http://bf.spbo1.com/');
});
$('#announce').on('click',function () {
    //$('.main_content').load('../html/announce.html .content')
	window.location.href='./notice.php';
});
$('#wd').on('click',function () {
    //$('.main_content').load('../html/wd.html .content')
	window.location.href='./pointDeposit.php';
});
$('#login').on('click',function () {
    $('.login_navbar_wrap').load('../html/login_after.html .login_navbar')
});

$(".v1").on('click', function () {
    if (!$(".v1.open").is($(this))) {
        for (var i = 0; i < $(".v1.open").length; i++) {
            drop_switch($(".v1.open").eq(i));
        }
    }
    drop_switch($(this));
});

function drop_switch(jq) {
    jq.toggleClass('open');
    jq.next().stop().animate({
        height: "toggle",
        opacity: "toggle"
    }, "normal");
}

// datepicker
/*
$( "#accordion" ).accordion();
$( "#accordion" ).accordion();
*/
var availableTags = [
    "ActionScript",
    "AppleScript",
    "Asp",
    "BASIC",
    "C",
    "C++",
    "Clojure",
    "COBOL",
    "ColdFusion",
    "Erlang",
    "Fortran",
    "Groovy",
    "Haskell",
    "Java",
    "JavaScript",
    "Lisp",
    "Perl",
    "PHP",
    "Python",
    "Ruby",
    "Scala",
    "Scheme"
];
$( "#autocomplete" ).autocomplete({
    source: availableTags
});



$( "#button" ).button();
$( "#button-icon" ).button({
    icon: "ui-icon-gear",
    showLabel: false
});



$( "#radioset" ).buttonset();



$( "#controlgroup" ).controlgroup();



$( "#tabs" ).tabs();



$( "#dialog" ).dialog({
    autoOpen: false,
    width: 400,
    buttons: [
        {
            text: "Ok",
            click: function() {
                $( this ).dialog( "close" );
            }
        },
        {
            text: "Cancel",
            click: function() {
                $( this ).dialog( "close" );
            }
        }
    ]
});

// Link to open the dialog
$( "#dialog-link" ).click(function( event ) {
    $( "#dialog" ).dialog( "open" );
    event.preventDefault();
});



$( "#datepicker" ).datepicker({
    inline: true
});



$( "#slider" ).slider({
    range: true,
    values: [ 17, 67 ]
});



$( "#progressbar" ).progressbar({
    value: 20
});



$( "#spinner" ).spinner();



$( "#menu" ).menu();



$( "#tooltip" ).tooltip();



$( "#selectmenu" ).selectmenu();


$(document).ready(function() {
	 console.log("TEST--------");
    $(".dropdown img.flag").addClass("flagvisibility");

    $(".dropdown dt a").click(function() {
        $(".dropdown dd ul").toggle();
    });

    $(".dropdown dd ul li a").click(function() {
        var text = $(this).html();
        $(".dropdown dt a span").html(text);
        $(".dropdown dd ul").hide();
        $("#result").html("Selected value is: " + getSelectedValue("sample"));
    });

    function getSelectedValue(id) {
        return $("#" + id).find("dt a span.value").html();
    }

    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasClass("dropdown"))
            $(".dropdown dd ul").hide();
    });


    $("#flagSwitcher").click(function() {
        $(".dropdown img.flag").toggleClass("flagvisibility");
    });
});


// Hover states on the static widgets
$( "#dialog-link, #icons li" ).hover(
    function() {
        $( this ).addClass( "ui-state-hover" );
    },
    function() {
        $( this ).removeClass( "ui-state-hover" );
    }
);

$( function() {
    var dateFormat = "yy/mm/dd",
        from = $( "#from" )
            .datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1
            })
            .on( "change", function() {
                to.datepicker( "option", "minDate", getDate( this ) );
            }),
        to = $( "#to" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1
        })
            .on( "change", function() {
                from.datepicker( "option", "maxDate", getDate( this ) );
            });

    function getDate( element ) {
        var date;
        try {
            date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
            date = null;
        }

        return date;
    }
} );

