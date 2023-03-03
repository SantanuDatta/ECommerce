<script>
    $('.wishlist-btn').click(function(e) {
        e.preventDefault();
        let productId = $(this).data('product-id');
        let btn = $(this);
        $.ajax({
            url: "/wishlist/edit/" + productId,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.status == 'success') {
                    toastr.success("Product Added To Wishlist");
                    btn.attr('wishlisted', 'true');
                    btn.attr('style', 'color: red;');
                    //update the wishlist count 
                    $('#wishCount').text(response.wish_count);
                } else if (response.status == 'error') {
                    toastr.error("Product Removed From Wishlist");
                    // update the wishlist count 
                    $('#wishCount').text(response.wish_count);
                    btn.removeAttr('wishlisted');
                    btn.attr('style', '');
                } else if (response.status == 'warning') {
                    toastr.warning("Login To Wishlist This Product!")
                }
            },
        });
    });
</script>
