$(document).ready(function () {
    var table = $('#myTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "searching": false,
        "ajax": {
            "url": EMPLOYEE_DATA_URL,
            "type": "POST",
            "data": function (d) {
                d.empName = $('#empName').val();
                d.empEmail = $('#empEmail').val();
                d.empMobile = $('#empMobile').val();
                d.status = $('#status').val();
            },
            "dataSrc": "data"
        },
        "columns": [
            // {
            //         data: 'emp_id',
            //         render: function(data) {
            //             return `<input type="checkbox" class="employee-checkbox" value="${data}">`;
            //         }
            //     },
            // {
            //     data: "emp_id",
            //     width: '3%'
            // },
            {
                data: "employee_code",
                width: '3%'
            },
            {
                data: "store_name"
            },
            {
                data: "empname"
            },
            {
                data: "email"
            },
            {
                data: "mobile"
            },
            {
                data: "profile",
                render: function (data) {
                    return `<img src= ${EMPLOYEE_PROFILE_URL}${data} class="img-thumbnail" style="width: 80px; height: 80px;" />`;
                }
            },
            {
                data: "status",
                render: function (data) {
                    return data == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                }
            },
            {
                data: 'action', orderable: false, searchable: false 
            }
            // {
            //     data: "emp_id",
            //     render: function (data, type, row) {
            //         return `<button class='edit_btn btn btn-outline-primary' data-eid='${row.emp_id}'>Edit</button>
            //         <button class='delete_employee_btn btn btn-outline-danger' data-id='${row.emp_id}'>Delete</button>`;
            //     }
            // }
        ]
    });

    // Reload table on filter submit
    $('form').on('submit', function (e) {
        e.preventDefault();
        table.ajax.reload();
    });
});


$(document).on('click', '.editbtn', function () {
    let roleId = $(this).data('id');
    window.location.href = EMPLOYEE_ADD_URL + roleId;
});
//delete button
$(document).on('click', '.delete-btn', function () {
    var empId = $(this).data('id');
    if (confirm('Are you sure you want to delete this employee?')) {
        $.ajax({
            url: EMPLOYEE_DELETE_URL,
            type: 'POST',
            data: {
                empId: empId
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#myTable').DataTable().ajax.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('Something went wrong during deletion.');
            }
        });
    }
});


$('#Export').click(function () {
    $.ajax({
        url: EMPLOYEE_DOWN_URL,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'ok') {
                const link = document.createElement('a');
                link.href = EMPLOYEE_CSV_URL;
                link.setAttribute('download', '');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                alert('Something went wrong.');
            }
        },
        error: function () {
            alert('Error contacting server.');
        }
    });
});
// $('#delete-multiple-employee-btn').on('click', function() {
//     var selectedIds = [];
//     $('.employee-checkbox:checked').each(function() {
//         selectedIds.push($(this).val());
//     });

//     if (selectedIds.length === 0) {
//         alert('Please select at least one employee.');
//         return;
//     }

//     var data = {
//         empIds: selectedIds
//     };

//     if (confirm('Are you sure you want to delete selected employees?')) {
//         $.ajax({
//             url: "<?= site_url('employee/deleteMultiple') ?>",
//             type: 'POST',
//             data: data,
//             traditional: true, // Important for array handling
//             success: function(response) {
//                 if (response.status === 'success') {
//                     $('#myTable').DataTable().ajax.reload();
//                     alert(response.message);
//                 } else {
//                     alert(response.message);
//                 }
//             },
//             error: function(xhr, status, error) {
//                 console.error('AJAX Error');
//                 console.error('Status:', status);
//                 console.error('Error:', error);
//                 console.error('Response Text:', xhr.responseText); // <-- This is the detailed server error

//                 alert('Something went wrong during bulk deletion.\n' + error);
//             }

//         });
//     }
// });