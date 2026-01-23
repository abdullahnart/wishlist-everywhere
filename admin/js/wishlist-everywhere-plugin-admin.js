(function ( $ ) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

   jQuery(document).ready(function(){

    


    // $('.copy_code').on('click', function() {
    //     var codeText = $(this).text();
    //     navigator.clipboard.writeText(codeText);
    //     alert('Shortcode copied to clipboard: ' + codeText);
    // });
    function toggleEnableCss(){
            var wishCss = $('#enable_css');
            console.log();
            if(wishCss.is(':checked')) {
                $(wishCss).closest('.admin-post-sec').find('.for_css').css('display', 'block');
            }else{
                $(wishCss).closest('.admin-post-sec').find('.for_css').css('display', 'none');
            }
    }

    toggleEnableCss();
    $('#enable_css').on('change', function () {
        toggleEnableCss();
    });

    function toggleWishlistEnable() {
        var wishName = $('#filter_post_type').val();

        if (wishName === 'product') {
            $('#filter_post_type').closest('.form-group').parent().parent().parent().parent().find('.wishev_position').css('display', 'flex');

        } else {
            $('#filter_post_type').closest('.form-group').parent().parent().parent().parent().find('.wishev_position').css('display', 'none');
        }
    }

    // Run on page load
    toggleWishlistEnable();

    function toggleLoginEnable() {
        var wishName = $('#filter_post_type').val();

        if (wishName === 'product') {
            $('#filter_post_type').closest('.form-group').parent().parent().parent().parent().find('.login-tab').css('display', 'flex');

        } else {
            $('#filter_post_type').closest('.form-group').parent().parent().parent().parent().find('.login-tab').css('display', 'none');
        }
    }

    // Run on page load
    toggleLoginEnable();


    function toggleAccountEnable() {
        var wishName = $('#filter_post_type').val();

        if (wishName === 'product') {
            $('#filter_post_type').closest('.form-group').parent().parent().parent().parent().find('.account-tab').css('display', 'flex');

        } else {
            $('#filter_post_type').closest('.form-group').parent().parent().parent().parent().find('.account-tab').css('display', 'none');
        }
    }

    // Run on page load
    toggleAccountEnable();


    function toggleCustomPlacement() {
        var wishName = $('#filter_post_type').val();

        if (wishName === 'post') {
            $('#filter_post_type').closest('.form-group').parent().parent().parent().parent().find('.placement-tab').css('display', 'flex');

        } else {
            $('#filter_post_type').closest('.form-group').parent().parent().parent().parent().find('.placement-tab').css('display', 'none');
        }
    }

    // Run on page load
    toggleCustomPlacement();


var $wishpost = $('.row_wrapper.wishev_position'),
    $archiveCheckbox = $wishpost.find('#wishlist_archive'),
    $singleCheckbox = $wishpost.find('#wishlist_single'),
    $archiveTarget = $wishpost.find('.for_archive'),
    $singleTarget = $wishpost.find('.for_single');


function toggleWishlistPosition() {
    $archiveTarget.toggle($archiveCheckbox.prop('checked'));
    $singleTarget.toggle($singleCheckbox.prop('checked'));
}

toggleWishlistPosition();
$archiveCheckbox.on('change', toggleWishlistPosition);
$singleCheckbox.on('change', toggleWishlistPosition);




    // Run on select change
    $('#filter_post_type').on('change', function () {
        toggleWishlistEnable();
        toggleLoginEnable();
        toggleAccountEnable();
        toggleCustomPlacement();
    });

   });

})(jQuery);
