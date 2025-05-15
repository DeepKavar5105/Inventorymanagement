$(document).ready(function() {
    $('#storeBtn').click(function(e) {
        e.preventDefault();
        
        var storeId = $('#storeId').val();
        var form = $('#storeForm')[0];
        var formData = new FormData(form);
        var url = storeId ? STORE_UPDATE_URL + storeId : STORE_ADDSTORE_URL;

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (!response.success ) {
                    $.each(response.errors, function(key, val) {
                        $('.error-' + key).text(val);
                    })
                } else {
                let data = typeof response === 'string' ? JSON.parse(response) : response;
                $('#storeForm')[0].reset();
                $('#storeId').val('');
                if (typeof table !== 'undefined') {
                    table.ajax.reload();
                }
                window.location.href = STORE_URL;
            }
            },
            error: function(xhr) {
                alert('AJAX Error: ' + xhr.responseText);
            }
        });
    });
});