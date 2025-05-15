$(document).ready(function () {
    $('#myTable').DataTable({
        processing: true,
        serverSide: false,
        autoWidth: false,
        "ordering": false,
        ajax: {
            url: ROLE_DATA_URL,
            dataSrc: 'data'
        },
        columns: [
            // { data: 'role_id', width: '3%' },
            { data: 'name', width: '40%' },
            {
                data: 'status',
                width: '10%',
                render: function (data) {
                    return data == 1 ? '<h5><span class="badge bg-success">Active</span></h5>' :
                        '<h5><span class="badge bg-danger">Inactive</span></h5>';
                }
            },
            {
                data: 'role_id',
                width: '10%',
                render: function (data, type, row) {
                    return `
                            <button type="button" class='btn btn-outline-success edit-btn' data-eid="${row.role_id}">Edit</button>
                            <button class="btn btn-outline-danger btn-sm delete-btn" data-roleid="${row.role_id}">Delete</button>
                        `;
                }
            }
        ]
    });

    $(document).on('click', '.edit-btn', function () {
        let roleId = $(this).data('eid');
        window.location.href = ROLE_EDIT_BASE_URL + roleId;
    });

    $(document).on('click', '.delete-btn', function () {
        var role_id = $(this).data('roleid');
        console.log(role_id);
        if (confirm('Are you sure you want to delete this role?')) {
            $.ajax({
                url: ROLE_DELETE_URL,
                type: 'POST',
                data: { roleid: role_id },
                success: function (response) {
                    if (response.status === 'success') {
                        $('#myTable').DataTable().ajax.reload();
                        alert(response.message);
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
});



// $('#delete-multiple-btn').on('click', function() {
//     var selectedIds = [];
//     $('.role-checkbox:checked').each(function() {
//         selectedIds.push($(this).val());
//     });

//     if (confirm('Are you sure you want to delete selected roles?')) {
//         $.ajax({
//             url: "<?= site_url('role/deleteMultiple') ?>",
//             type: 'POST',
//             data: {
//                 roleIds: selectedIds
//             },
//             traditional: true, // Important for array posting
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


// {
//     data: 'action', orderable: false, searchable: false
// }