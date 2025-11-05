;(function ($) {

    'use strict';

    $(document).ready(function () {
        function initMozartSwipers() {
            $('.mozart-swiper-wrapper').each(function () {
                var $wrapper = $(this);
                $wrapper.css({'opacity': 1})

                $wrapper.find('.swiper').each(function () {
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
                    thumbs: {swiper: thumbSwiper},
                });
            });


            //Slider Gallery - JS

            jQuery(document).ready(function ($) {
                $('.mozart-swiper-slider').each(function () {
                    const $slider = $(this);
                    const swiperEl = $slider.find('.swiper')[0];
                    if (!swiperEl) return;

                    const uid = $slider.attr('id');
                    const gap = parseInt($slider.data('gap')) || 15;
                    const desktop = parseInt($slider.data('desktop')) || 3;
                    const tablet = parseInt($slider.data('tablet')) || 2;
                    const mobile = parseInt($slider.data('mobile')) || 1;

                    new Swiper(swiperEl, {
                        loop: true,
                        spaceBetween: gap,
                        slidesPerView: desktop,
                        centeredSlides: false,
                        navigation: {
                            nextEl: `#${uid} .swiper-button-next`,
                            prevEl: `#${uid} .swiper-button-prev`,
                        },
                        pagination: {
                            el: `#${uid} .swiper-pagination`,
                            clickable: true,
                        },
                        breakpoints: {
                            0: {slidesPerView: mobile},
                            768: {slidesPerView: tablet},
                            992: {slidesPerView: desktop},
                        },
                    });
                });

            });

        }

        $(document).ready(function(){
            // Target all active/open accordion contents and close them
            $('.eltdf-accordion-holder .ui-accordion-content-active')
                .removeClass('ui-accordion-content-active')
                .hide();

            // Also remove active classes from their headers
            $('.eltdf-accordion-holder .ui-accordion-header-active')
                .removeClass('ui-accordion-header-active ui-state-active')
                .addClass('ui-state-default');
        });


        initMozartSwipers();

        // Reinitialize on resize (with debounce)
        var resizeTimer;
        $(window).on('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(initMozartSwipers, 400);
        });

        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 0) {
                console.log('asdfasdf')
                $('body .eltdf-mobile-nav').slideUp(300);
            }

            /*else {
                $('.eltdf-mobile-header .eltdf-mobile-nav').stop(true, true).slideUp(300);
            }*/
        });
    });

})(jQuery);