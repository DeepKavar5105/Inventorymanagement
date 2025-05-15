$(document).ready(function() {
    // Initialize DataTable
    var table = $('#myTable').DataTable({
        "ordering": false,
        "ajax": {
            "url": STORE_DATA_URL,
            "type": "GET",
            "dataSrc": "data"
        },
         "columns": [
        // {
        //         data: 'store_id',
        //         render: function(data) {
        //             return `<input type="checkbox" class="role-checkbox" value="${data}">`;
        //         }
        //     },
            // {
            //     "data": "store_id",
            //     "width": '5%',
            //     "defaultContent": ""
            // },
            {
                "data": "name"
            },
            {
                "data": "contactNumber"
            },
            {
                "data": "email"
            },
            // {
            //     "data": "phone"
            // },
            {
                "data": "address"
            },
            {
                "data": "status",
                render: function(data) {
                    return data == 1 ? '<h5><span class="badge bg-success">Active</span></h5>' : '<h5><span class="badge bg-danger">Inactive</span></h5>';
                }
            },
            {
                "data": 'action', orderable: false, searchable: false 
            }
        ]
    });

    $(document).on('click', '.editbtn', function() {
        let storeId = $(this).data('id');
        window.location.href = STORE_ADD_URL + storeId;
    });
});


// Edit button click event
function editStore(store_id) {
    $.ajax({
        type: "GET",
        url: STORE_GETDATA_URL + store_id,
        dataType: "json",
        success: function(data) {
            $('#storeid').val(data.store_id);
            $('#model_name').val(data.name);
            $('#model_contactNumber').val(data.contactNumber);
            $('#model_email').val(data.email);
            $('#model_phone').val(data.phone);
            $('#model_address').val(data.address);
            $('#model_status').val(data.status);
            $('#Modal_Store').modal('show');
        },
        error: function() {
            alert('Could not fetch data from the server.');
        }
    });
}

// Update button click event
$('#Store_Update').on('click', function(e) {
    e.preventDefault();
    var formData = new FormData($('#storeForm')[0]);

    $.ajax({
        url: STORE_UPDATE_URL,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.success) {
                $('#Modal_Store').modal('hide');
                $('#myTable').DataTable().ajax.reload();
                alert('store data has been updated successfully!');
            } else {
                alert('Failed to update store data.');
            }
        },
        error: function() {
            alert('Error occurred during update.');
        }
    });
});


$(document).on('click', '.delete-btn', function() {
    var storeId = $(this).data('id');
    if (confirm('Are you sure you want to delete this store?')) {
        $.ajax({
            url: STORE_DELETE_URL,
            type: 'POST',
            data: {
                storeId: storeId
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('#myTable').DataTable().ajax.reload();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Something went wrong during deletion.');
            }
        });
    }
});


// $('#delete-multiple-store-btn').on('click', function() {
//     var selectedIds = [];
//     $('.store-checkbox:checked').each(function() {
//         selectedIds.push($(this).val());
//     });

//     if (selectedIds.length === 0) {
//         alert('Please select at least one store.');
//         return;
//     }

//     if (confirm('Are you sure you want to delete selected stores?')) {
//         $.ajax({
//             url: "<?= site_url('store/deleteMultiple') ?>", // fixed URL
//             type: 'POST',
//             data: {
//                 storeIds: selectedIds
//             },
//             traditional: true,
//             success: function(response) {
//                 if (response.status === 'success') {
//                     $('#myTable').DataTable().ajax.reload();
//                     alert(response.message);
//                 } else {
//                     alert(response.message);
//                 }
//             },
//             error: function() {
//                 alert('Something went wrong during bulk deletion.');
//             }
//         });
//     }
// });