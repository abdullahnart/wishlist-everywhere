jQuery(document).ready(

    function ($) {
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

        // Add to Wishlist AJAX function
        function addToWishlist(postId)
        {
            $.ajax(
                {
                    type: 'POST',
                    url: customWishlistAjax.ajaxurl,
                    data: {
                        action: 'add_to_wishlist',
                        post_id: postId
                    },
                    success: function (response) {
                        if (response.success) {
                            // alert('Item added to wishlist!');
                            Swal.fire(
                                {
                                    text: "Item added to wishlist!",
                                    icon: "success",
                                    confirmButtonText: 'OK',
                                    footer: '<a href="' + window.location.origin + '/plugin-dev/wishlist">Go to Wishlist Page</a>'
                                }
                            ).then(
                                (result) =>
                                {
                                    if (result.isConfirmed) {
                                        window.location.href = window.location.href+'?a'; 
                                        // $('.wishlist-icon').removeClass('fa-regular');                               
                                        // $('.wishlist-icon').addClass('fa-solid');                               
                                    }
                                }
                            );
                            //   window.location.href = window.location.href+'?abc';

                            // You can perform additional actions here after successful addition to the wishlist
                        } else {
                            // alert('Post already exists in wishlist!');
                            Swal.fire(
                                {
                                    text: "Item already exists in wishlist!",
                                    icon: "warning",
                                    confirmButtonText: 'OK',
                                    footer: '<a href="' + window.location.origin + '/plugin-dev/wishlist">Go to Wishlist Page</a>'
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
        function removeFromWishlist(postId)
        {
            $.ajax(
                {
                    type: 'POST',
                    url: customWishlistAjax.ajaxurl,
                    data: {
                        action: 'remove_from_wishlist',
                        post_id: postId
                    },
                    success: function (response) {
                        if (response.success) {
                            // alert('Item removed from wishlist!');
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
                                        window.location.href = window.location.href+'?sd';
                                    }
                                }
                            );
                            //   window.location.href = window.location.href+'?sd';
                              jQuery('.wishlist-icon').removeClass("wishlist-added");
                            // You can perform additional actions here after successful removal from the wishlist
                        } else {
                            // alert('Failed to remove item from wishlist!');
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
