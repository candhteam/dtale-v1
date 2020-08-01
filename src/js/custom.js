$(document).ready(function () {
    $(".menu .ham-btn").click(function (e) {
        e.preventDefault();
        $(this).toggleClass('btn-active');
        $(this).parent().toggleClass('menu-active');
    });

    $('.banner-slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
    });
    $('.home-image-slider').slick({
        dots: false,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
    });
});