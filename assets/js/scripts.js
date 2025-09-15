;(function ($) {

    'use strict';


/*    jQuery(document).ready(function($) {
        $("iframe[id^='tt-iframe-']").on("load", function() {
            let iframeDoc = $(this).contents();

            setTimeout(function (){
                let $button = iframeDoc.find('.new-page-body');
                console.log($button)

                if ($button.length) {
                    console.log($button)
                    $button.css({backgroundColor: '#FF0032'}); // your custom color
                }
            }, 1500)

        });
    });*/


    jQuery(document).ready(function($) {
        let $target = $('.mozarthaus-ticket .tt-widget-inline');
        if (!$target.length) return;

        // Save the initial height so we ignore the first load
        let lastHeight = $target.height();

        const observer = new MutationObserver(function() {
            let newHeight = $target.height();
            if (newHeight !== lastHeight) {
                $target.addClass('height-changed');
                console.log('Height changed after DOM change:', newHeight);
                lastHeight = newHeight;
            }
        });

        observer.observe($target[0], {
            childList: true,  // detect children added/removed
            subtree: true,    // detect deeply inside
            characterData: true // detect text changes
        });
    });



})(jQuery);