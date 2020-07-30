$(document).ready(function () {
    $(".menu .ham-btn").click(function (e) {
        e.preventDefault();
        $(this).toggleClass('btn-active');
        $(this).parent().toggleClass('menu-active');
    });
});