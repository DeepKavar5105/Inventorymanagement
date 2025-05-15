$(document).ready(function () {
    $('#Received').click(function (e) {
        e.preventDefault();

        var form = $('#transferForm')[0];
        var formData = new FormData(form);
        var url = REC_UPDATE_URL;
        console.log(formData);
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                try {
                    let data = JSON.parse(response);
                    $('#formError').addClass('d-none').text('');
                    $('.text-danger').text('');
                    if (!data.success) {
                        let allErrors = '';
                        $.each(data.errors, function(key, val) {
                            allErrors += val + '<br>';
                        });
                        $('#formError').removeClass('d-none').html(allErrors);
                        setTimeout(function () {
                            $('#formError').fadeOut('slow', function () {
                                $(this).addClass('d-none').show().html('');
                            });
                        }, 3000);
                    } else {
                        alert('Item marked as received successfully!');
                        window.location.href = REC_URL;
                    }
                } catch (err) {
                    console.error("Invalid JSON response", response);
                    $('#formError').removeClass('d-none').html('Something went wrong. Please try again.');
                    setTimeout(function () {
                        $('#formError').fadeOut('slow', function () {
                            $(this).addClass('d-none').show().html('');
                        });
                    }, 3000);
                }
            },  
            error: function (xhr, status, error) {
                console.log('AJAX Error:', error);
            }
        });
    });
    $('html, body').animate({
        scrollTop: $('#formError').offset().top - 100
    }, 500);
    
});