jQuery(document).ready(

    function ($) {
    document.addEventListener('click', function (e) {
        if (e.target.closest('.wishlist-copy-link')) {
            const btn = e.target.closest('.wishlist-copy-link');
            const link = btn.dataset.link;

            navigator.clipboard.writeText(link).then(() => {
                alert('Link copied to clipboard!');
            }).catch(err => {
                console.error('Clipboard copy failed:', err);
            });
        }
    });


    $('#all-add-to-cart').on('click', function(e) {
        e.preventDefault();

        if (typeof wishlistPostIds === 'undefined' || wishlistPostIds.length === 0) {
            alert('No wishlist products found.');
            return;
        }

        $.ajax({
            url: wc_add_to_cart_params.ajax_url,
            type: 'POST',
            data: {
                action: 'wishlist_bulk_add_to_cart',
                product_ids: wishlistPostIds
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire(
                        {
                            text: "All products added to cart!",
                            icon: "success",
                            confirmButtonText: 'OK',
                            footer: '<a href="' + wishev_plugin_home.homeUrl + '/cart">Go to Cart Page</a>'
                        }
                    ).then(
                        (result) =>
                        {
                            if (result.isConfirmed) {
                                    location.reload();                           
                            }
                        }
                    );                    
                     // Or redirect to cart
                } else {
                    alert('Some products could not be added.');
                }
            }
        });
    });





        
        $('.wishlist-tabs-nav a').click(function(e) {
            e.preventDefault();
    
            const target = $(this).attr('href');
    
            $('.wishlist-tab-content').hide();
            $(target).fadeIn();
    
            $('.wishlist-tab-nav-item').removeClass('active');
            $(this).parent().addClass('active');
        });
        // Add to Wishlist
        $('.wishlist-icon').on(
            'click', function (e) {
                e.preventDefault();
                var postId = $(this).data('post-id');
                addToWishlist(postId);
            }
        );

        // Remove from Wishlist
        $('.wishlist-icon-remove').on(
            'click', function (e) {
                e.preventDefault();
                var postId = $(this).data('post-id');
                removeFromWishlist(postId);
            }
        );

        $('.remove-all-wishlist').on(
            'click', function (e) {
                e.preventDefault();
                $('.wishlist-icon-remove').each(function() {
                    var postId = $(this).data('post-id');
                    removeFromWishlist(postId,true);
                    jQuery(this).closest('.wishlist-wrapper').hide(1000); 
                });
                jQuery(this).html('<p class="wishlist-empty">No items in wishlist.</p>');
            }
        );

            if (typeof wishlistPostIds !== 'undefined') {
            wishlistPostIds.forEach(function(postId) {
                $('ul.products .post-' + postId + ' i.fa-heart')
                    .removeClass('fa-regular')
                    .addClass('fa-solid');
                });
            }
            if (typeof isInWishlist !== 'undefined' && isInWishlist) {
                var postId = $('.wishlist-icon').data('post-id');
                jQuery(`.product.post-${postId} i.fa-heart`).removeClass('fa-regular').addClass('fa-solid');                            
            }

    $('.wishlist-table tr td.var_product .button').each(function(){
        $(this).text('Add to Cart');
    });
        // Add to Wishlist AJAX function
        function addToWishlist(postId)
        {
            $.ajax(
                {
                    type: 'POST',
                    url: wishlistEverywhere_ajax.ajaxurl,
                    data: {
                        action: 'wishev_add_to_wishlist',
                        post_id: postId,
                        security: wishlistEverywhere_ajax.nonce
                    },
                    success: function (response) {
                        if (response.success) {

// Update wishlist counter in header (real-time)
jQuery.ajax({
    type: 'POST',
    url: wishlistEverywhere_ajax.ajaxurl,
    data: {
        action: 'wishev_get_wishlist_count'
    },
    success: function(res) {

        if (res.success) {
            var count = res.data.count;

            console.log('New count:', count);           // 👈 DEBUG

            var counterEl = jQuery('.wishlist-counter .wishlist-count');
            var iconEl    = jQuery('.wishlist-counter i');


            // Update number
            counterEl.text(count);

            // Update heart icon
            if (count > 0) {
                iconEl.removeClass('far fa-heart').addClass('fas fa-heart fa-solid');
            } else {
                iconEl.removeClass('fas fa-heart fa-solid').addClass('far fa-heart');
            }
        }
    },
    error: function(xhr, status, error) {
        console.error('Counter AJAX error:', error);     // 👈 DEBUG
    }
});
                            
                            Swal.fire(
                                {
                                    text: "Item added to wishlist!",
                                    icon: "success",
                                    confirmButtonText: 'OK',
                                    footer: '<a href="' + wishev_plugin_home.homeUrl + '/wishlist_page">Go to Wishlist Page</a>'
                                }
                            ).then(
                                (result) =>
                                {
                                    if (result.isConfirmed) {
                                        jQuery(`ul.products .post-${postId} i.fa-heart`).removeClass('fa-regular').addClass('fa-solid');                            
                                        jQuery(`.product.post-${postId} i.fa-heart`).removeClass('fa-regular').addClass('fa-solid');                            
                                    }
                                }
                            );
                            //   window.location.href = window.location.href+'?abc';

                            // You can perform additional actions here after successful addition to the wishlist
                        } else {
                            // alert('Post already exists in wishlist!');
                            // jQuery('ul.products').find('i.fa-heart').removeClass('hello');
                            Swal.fire(
                                {
                                    text: "Item already exists in wishlist!",
                                    icon: "warning",
                                    confirmButtonText: 'OK',
                                    footer: '<a href="' + wishev_plugin_home.homeUrl + '/wishlist_page">Go to Wishlist Page</a>'
                                }
                            );

                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        alert('An error occurred while adding item to wishlist!');
                    }
                }
            );
        }

        // Remove from Wishlist AJAX function
        function removeFromWishlist(postId, silent = false)
        {
            $.ajax(
                {
                    type: 'POST',
                    url: wishlistEverywhere_ajax.ajaxurl,
                    data: {
                        action: 'wishev_remove_from_wishlist',
                        post_id: postId,
                        security: wishlistEverywhere_ajax.nonce
                    },
                    success: function (response) {
                        if (response.success) {

// Update wishlist counter in header (real-time after REMOVE)
jQuery.ajax({
    type: 'POST',
    url: wishlistEverywhere_ajax.ajaxurl,
    data: {
        action: 'wishev_get_wishlist_count'
    },
    success: function(res) {
        if (res.success) {
            var count = res.data.count;

            // Update all counters safely (desktop + mobile)
            jQuery('.wishlist-counter').each(function() {

                jQuery(this).find('.wishlist-count').text(count);

                var icon = jQuery(this).find('i');
                if (count > 0) {
                    icon.removeClass('far fa-heart').addClass('fas fa-heart fa-solid');
                } else {
                    icon.removeClass('fas fa-heart fa-solid').addClass('far fa-heart');
                }
            });
        }
    }
});

                            if (!silent) {
                            Swal.fire(
                                {
                                    text: "Item removed from wishlist!",
                                    icon: "success",
                                    confirmButtonText: 'OK'
                                }
                            ).then(
                                (result) =>
                                {
                                    if (result.isConfirmed) {
                                        jQuery('[data-post-id="' + postId + '"]').closest('tr.wishlist-item').hide(1000);
                                    }
                                }
                            );
                        }   
                        
                        } else {
                            Swal.fire(
                                {
                                    text: "Failed to remove item from wishlist!",
                                    icon: "success",
                                    confirmButtonText: 'OK'
                                }
                            );
                        }
                    
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        alert('An error occurred while removing item from wishlist!');
                    }
                }
            );
        }

        var wishlistCount= jQuery('.wishlist-inmenu').length;

        jQuery(".wish-items div span").append(wishlistCount);

        jQuery('.wish-items').on(
            "click" ,function () {
                jQuery('.wishlist-lists').slideToggle("slow");
            }
        );
    }
);
