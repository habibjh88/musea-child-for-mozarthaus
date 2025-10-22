;(function ($) {

    'use strict';

    $(document).ready(function () {
        function initMozartSwipers() {
            $('.mozart-swiper-wrapper').each(function () {
                var $wrapper = $(this);
                $wrapper.css({'opacity':1})

                $wrapper.find('.swiper').each(function(){
                    if (this.swiper) this.swiper.destroy(true, true);
                });

                var galleryPerView = $wrapper.data('gallery-perview') || 4;
                var isMobile = window.innerWidth < 768;

                var thumbSwiper = new Swiper($wrapper.find('.mozart-swiper-thumbs')[0], {
                    direction: isMobile ? 'horizontal' : 'vertical',
                    slidesPerView: galleryPerView,
                    spaceBetween: 4,
                    watchSlidesProgress: true,
                    mousewheel: !isMobile,
                });

                new Swiper($wrapper.find('.mozart-swiper-main')[0], {
                    direction: 'horizontal',
                    slidesPerView: 1,
                    spaceBetween: 4,
                    loop: true,
                    navigation: {
                        nextEl: $wrapper.find('.swiper-button-next')[0],
                        prevEl: $wrapper.find('.swiper-button-prev')[0],
                    },
                    thumbs: { swiper: thumbSwiper },
                });
            });
        }

        initMozartSwipers();

        // Reinitialize on resize (with debounce)
        var resizeTimer;
        $(window).on('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(initMozartSwipers, 400);
        });
    });

})(jQuery);