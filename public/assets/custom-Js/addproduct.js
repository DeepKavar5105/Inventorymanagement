 $(document).ready(function() {
        $('#addproduct').click(function(e) {
            e.preventDefault();

            var productId = $('#product_id').val();
            console.log('product id', productId);
            var form = $('#productForm')[0];
            var formData = new FormData(form);
            var url = productId ? PRODUCT_UPDATE_URL + productId : PRODUCT_ADD_URL;

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect || PRODUCT_URL;
                    } else {
                        $.each(response.errors, function(key, val) {
                            $('.error-' + key).text(val);
                        });
                    }

                },
                error: function(xhr) {
                    alert('Error occurred: ' + xhr.responseText);
                }
            });
        });

        $(document).on('click', '.edit_btn', function() {
            let roleId = $(this).data('eid');
            window.location.href = PRODUCT_ADD_URL + roleId;
        });
    });