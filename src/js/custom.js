$(document).ready(function () {
    $(".menu .ham-btn").click(function (e) {
        e.preventDefault();
        $(this).toggleClass('btn-active');
        $(this).parent().toggleClass('menu-active');
    });

    $('.banner-slider').slick({
        dots: false,
        arrows: false,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        autoplay: true
    });
    $('.home-image-slider').slick({
        dots: false,
        infinite: true,
        speed: 500,
        fade: true,
        autoplay: true,
        cssEase: 'linear',
        responsive: [
            {
                breakpoint: 545,
                settings: "unslick"
            }
        ]
    });

    // ================booking_model starts here============================
    $(".booking_form").click(function (e) {
        e.preventDefault();
        $(".booking_model").addClass("booking_model_open");
    });

    $(".form_modal .form_modal_container .close").click(function (e) {
        e.preventDefault();
        $(".booking_model").removeClass("booking_model_open");
    });
    // ================booking_model ends here==============================

});