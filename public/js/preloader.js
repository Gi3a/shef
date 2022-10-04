$(window).on('load', function () {
    var $preloader = $('.preloader'),
        $animation   = $preloader.find('.pan-loader');
    $animation.fadeOut();
    $preloader.delay(600).fadeOut('slow');
});