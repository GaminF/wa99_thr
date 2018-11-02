var cover = document.getElementById('Modal_cover');
var cover2 = document.getElementById('Modal_success');
window.onclick = function (event) {
    if (event.target == cover) {
        cover.style.display = "none";
    }
    if (event.target == cover2) {
        cover2.style.display = "none";
    }
};

$("#complete").on('click', function () {
    $("#Modal_success").css('display', 'block');
});
$(".close_icon").on('click', function () {
    $("#Modal_cover").css('display', 'none');
    $("#Modal_success").css('display', 'none');
    $("#Modal_failure").css('display', 'none');
});

$("#service_QQ").on('click', function () {
    $("#Modal_service").css('display', 'block');
});
$("#service_weixin").on('click', function () {
    $("#Modal_service").css('display', 'block');
});

$(".close_icon").on('click', function () {
    $("#Modal_service").css('display', 'none');
    $("#Modal_service02").css('display', 'none');
});