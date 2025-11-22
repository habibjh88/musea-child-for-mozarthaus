;(function ($) {

    'use strict';

    function rank_math_faq(){
        // Hide all answers initially
        $('.rank-math-answer').hide();

        // Make the first item active by default
        var $firstItem = $('.rank-math-list-item').first();
        $firstItem.addClass('active');
        $firstItem.find('.rank-math-answer').show();

        // Toggle on question click
        $('.rank-math-question').on('click', function () {
            var $item = $(this).closest('.rank-math-list-item'); // parent container
            var $answer = $item.find('.rank-math-answer');

            // Close other items
            $('.rank-math-list-item').not($item).removeClass('active')
                .find('.rank-math-answer').slideUp();

            // Toggle current one
            $item.toggleClass('active');
            $answer.stop(true, true).slideToggle();
        });
    }

    $(document).ready(function () {

        rank_math_faq();

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


        var accordions = {};
        eltdf = window.eltdf || {}; // Ensure eltdf exists
        eltdf.modules = eltdf.modules || {};
        eltdf.modules.accordions = accordions;

        accordions.eltdfInitAccordions = eltdfInitAccordions;
        accordions.eltdfOnDocumentReady = eltdfOnDocumentReady;

        $(document).ready(eltdfOnDocumentReady);

        function eltdfOnDocumentReady() {
            eltdfInitAccordions();
        }

        function eltdfInitAccordions() {
            var accordion = $('.eltdf-accordion-holder');

            if (accordion.length) {
                accordion.each(function () {
                    var thisAccordion = $(this);

                    // For normal accordion type
                    if (thisAccordion.hasClass('eltdf-accordion')) {
                        thisAccordion.accordion({
                            animate: "swing",
                            collapsible: true,
                            active: false, // ✅ all closed by default
                            icons: "",
                            heightStyle: "content"
                        });
                    }

                    // For toggle type accordions
                    if (thisAccordion.hasClass('eltdf-toggle')) {
                        var toggleAccordion = $(this),
                            toggleAccordionTitle = toggleAccordion.find('.eltdf-accordion-title'),
                            toggleAccordionContent = toggleAccordionTitle.next();

                        toggleAccordion.addClass("accordion ui-accordion ui-accordion-icons ui-widget ui-helper-reset");
                        toggleAccordionTitle.addClass("ui-accordion-header ui-state-default ui-corner-top ui-corner-bottom");
                        toggleAccordionContent.addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom").hide();

                        toggleAccordionTitle.each(function () {
                            var thisTitle = $(this);

                            thisTitle.on('mouseenter mouseleave', function () {
                                thisTitle.toggleClass("ui-state-hover");
                            });

                            thisTitle.on('click', function () {
                                thisTitle.toggleClass('ui-accordion-header-active ui-state-active ui-state-default ui-corner-bottom');
                                thisTitle.next().toggleClass('ui-accordion-content-active').slideToggle(400);
                            });
                        });
                    }
                });
            }
        }


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