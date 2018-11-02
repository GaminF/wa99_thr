$(document).ready(function() {
    $("#content > div").hide(); // Initially hide all content
    $("#tabs li:first").attr("id","current"); // Activate first tab
    $("#content div:first").fadeIn(); // Show first tab content
    $('#tabs li a').click(function(e) {
        e.preventDefault();
        if ($(this).attr("id") == "current"){ //detection for current tab
            return
        }
        else{
            $("#content > div").hide(); //Hide all content
            $("#tabs li").attr("id",""); //Reset id's
            $(this).parent().attr("id","current"); // Activate this
            $( $(this).attr('href')).fadeIn(); // Show content for current tab
        }
    });
});


var elem = document.getElementById('mySwipe');
window.mySwipe = Swipe(elem, {
});
var elem02 = document.getElementById('mySwipe02');
window.mySwipe02 = Swipe(elem02, {
});
var elem03 = document.getElementById('mySwipe03');
window.mySwipe03 = Swipe(elem03, {
});
var elem04 = document.getElementById('mySwipe04');
window.mySwipe04 = Swipe(elem04, {
});


