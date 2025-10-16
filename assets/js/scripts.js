;(function ($) {

    'use strict';

    $(document).ready(function () {
        $('.mozart-swiper-wrapper').each(function () {
            var $wrapper = $(this);
            var galleryPerView = $wrapper.data('gallery-perview') || 4

            var thumbSwiper = new Swiper($wrapper.find('.mozart-swiper-thumbs')[0], {
                direction: 'vertical',
                slidesPerView: galleryPerView,
                spaceBetween: 10,
                watchSlidesProgress: true,
                mousewheel: true,
            });

            new Swiper($wrapper.find('.mozart-swiper-main')[0], {
                direction: 'vertical',
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,
                navigation: {
                    nextEl: $wrapper.find('.swiper-button-next')[0],
                    prevEl: $wrapper.find('.swiper-button-prev')[0],
                },
                thumbs: {swiper: thumbSwiper},
            });
        });
    });


})(jQuery);