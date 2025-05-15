$(document).ready(function() {
    var table = $('#transferItemTable').DataTable({
        "ajax": {
            "url": REC_DATA_URL,
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            // {
            //     data: 'transfer_item_id',
            //     render: function(data) {
            //         return `<input type="checkbox" class="product-checkbox" value="${data}">`;
            //     }
            // },
            // {
            //     "data": "transfer_item_id",
            //     width: '10%',
            // },
            {
                "data": "productName"
            },
            {
                "data": "transferQuantity",
                width: '10%',
            },
            {
                "data": "note"
            },
            {
                "data": "receivedMessage"
            },
            {
                "data": "status",
                render: function(data) {
                    switch (parseInt(data)) {
                        case 1:
                            return '<h5><span class="badge bg-primary">SEND</span></h5>';
                        case 2:
                            return '<h5><span class="badge bg-success text-light">RECEIVED</span></h5>';
                        case 3:
                            return '<h5><span class="badge bg-danger text-light">damage</span></h5>'
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
                        default:
                            return '<h5><span class="badge bg-info text-light">Null</span></h5>'
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
                        default:
                            return '<h5><span class="badge bg-info text-light">Null</span></h5>'
                    }
                }
            },
            {
                data: 'action', orderable: false, searchable: false 
            }
        ]
    });
    $('#toStoreId').on('change', function() {
        var storeId = $(this).val();
        if (storeId) {
            window.location.href = REC_GOTO_URL + storeId;
        }
    });
});

$(document).on('click', '.delete-btn', function () {
    var receiveId = $(this).data('id');
    if (confirm('Are you sure you want to delete this employee?')) {
        $.ajax({
            url: RECEIVE_DELETE_URL,
            type: 'POST',
            data: {
                receiveId: receiveId
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
