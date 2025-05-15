$(document).ready(function() {
    var table = $('#myTable_transfers').DataTable({
        "ajax": {
            "url": TRANSFER_DATA_URL,
            "type": "GET",
            "dataSrc": "data" 
        },
        "columns": [
            // {
            //     "data": "transfers_id",
            //     width: '3%'
            // },
            {
                "data": "from_store_name",
            },
            {
                "data": "to_store_name",
            },
            {
                "data": "specialNotes"
            },
            {
                "data": "status",
                render: function(data) {
                    switch (parseInt(data)) {
                        case 1:
                            return '<h5><span class="badge bg-primary">SEND</span></h5>';
                        case 2:
                            return '<h5><span class="badge bg-success text-dark">RECEIVED</span></h5>';
                        case 3:
                            return '<h5><span class="badge bg-danger text-dark">REJECT</span></h5>'
                        default:
                            return '<h5><span class="badge bg-info text-light">PENDING</span></h5>'
                    }
                }
            },
            {
                data: 'created_By',
                render: function(data) {
                    switch (parseInt(data)) {
                        case 0:
                            return '<h5><span class="badge bg-success">Admin</span></h5>';
                        case 1:
                            return '<h5><span class="badge bg-primary">User</span></h5>';
                        case 2:
                            return '<h5><span class="badge bg-warning text-dark">Manager</span></h5>';
                    }
                }
            },
            {
                data: 'updated_By',
                render: function(data) {
                    switch (parseInt(data)) {
                        case 0:
                            return '<h5><span class="badge bg-success">Admin</span></h5>';
                        case 1:
                            return '<h5><span class="badge bg-primary">User</span></h5>';
                        case 2:
                            return '<h5><span class="badge bg-warning text-dark">Manager</span></h5>';
                    }
                }
            },
            {
                data: 'action', orderable: false, searchable: false 
            }
            
            // {
            //     data: "transfers_id",
            //     render: function(data, type, row) {
            //         return `<button class='delete-transfer btn btn-outline-danger' data-did='${row.transfers_id}'>Delete</button>`;
            //     }
            // }
        ]
    });
});

// For delete 
$(document).on('click', '.delete-btn', function() {
    var transfers_id = $(this).data('id');
    var data = {
        transfers_id: transfers_id
    }
    console.log(transfers_id);
    if (confirm('Are you sure you want to delete this employee?')) {
        $.ajax({
            url: TRANSFER_DELETE_URL,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.status === 'success') {
                    $('#myTable_transfers').DataTable().ajax.reload();
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