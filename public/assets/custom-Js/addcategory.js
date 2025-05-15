
$(document).ready(function() {
    $('#categorybtn').click(function(e) {
        e.preventDefault();

        var cat_id = $('#cat_id').val();
        var form = $('#categoryForm')[0];
        var formData = new FormData(form);
        var url = cat_id ? CAT_UPDATE_URL + cat_id : CAT_ADD_URL;
       
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (!response.success) {
                    $.each(response.errors, function(key, val) {
                        $('.error-' + key).text(val);
                    })
                } else {
                    $('#categoryForm')[0].reset();
                    $('#categoryId').val('');
                    window.location.href = CAT_URL;
                    if (typeof table !== 'undefined') {
                        table.ajax.reload();
                    }
                }
            },
            error: function(xhr) {
                alert('Error occurred: ' + xhr.responseText);
            }
        });
    });

    $(document).on('click', '.edit_btn', function() {
        let roleId = $(this).data('eid');
        window.location.href = CAT_ADD_URL + roleId; 
    });
});