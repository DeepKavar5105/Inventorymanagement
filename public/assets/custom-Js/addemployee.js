$(document).ready(function () {
    $('#submitBtn').click(function (e) {
        e.preventDefault();

        var empId = $('#editempId').val();
        var form = $('#employeeForm')[0];
        var formData = new FormData(form);
        var url = empId ? EMPLOYEE_UPDATE_URL + empId : EMPLOYEE_ADDEMP_URL;

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if (!response.success) {
                    $.each(response.errors, function (key, val) {
                        $('.error-' + key).text(val);
                    });
                } else {
                    window.location.href = EMPLOYEE_URL;
                    $('#editempId').val('');
                    if (typeof table !== 'undefined') {
                        table.ajax.reload();
                    }
                }
            }

        });
    });
});

$(document).on('click', '.edit_btn', function () {
    let empId = $(this).data('eid');
    window.location.href = EMPLOYEE_ADDEMP_URL + empId;
});

$('#ajaxDownloadBtn').click(function () {
    $.ajax({
        url: EMPLOYEE_SAMPLE_URL,
        type: 'GET',
        success: function (res) {
            if (res.status === 'success') {
                const link = document.createElement('a');
                link.href = EMPLOYEE_DOWN_URL;
                link.setAttribute('download', '');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    });
});
$('#csv-upload-form').on('submit', function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: EMPLOYEE_UPLODE_URL,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.success) {
                $('#message').html('<p style="color: green;">Employees added successfully!</p>');
                loadEmployeeTable(response.employees);
            } else {
                let errorHtml = `<p style="color: red;"><strong>${response.error}</strong></p>`;

                if (Array.isArray(response.errors) && response.errors.length > 0) {
                    errorHtml += '<ul style="color: red;">';
                    response.errors.forEach(function (err) {
                        errorHtml += `<li>${err}</li>`;
                    });
                    errorHtml += '</ul>';
                }

                $('#message').html(errorHtml);
            }
        },
        error: function () {
            $('#message').html('<p style="color: red;">Something went wrong, please try again.</p>');
        }
    });
});

