$(document).ready(function() {
    var table = $('#myTable_product').DataTable({
        "ajax": {
            "url": PRODUCT_DATA_URL,
            "type": "GET",
            dataSrc: 'data'
        },
        "columns": [
            // {
            //     data: 'product_id',
            //     render: function(data) {
            //         return `<input type="checkbox" class="product-checkbox" value="${data}">`;
            //     }
            // },
            {
                "data": "name",
            },
            {
                "data": "catName",
            },
            {
                "data": "productName",
            },
            {   
                "data": "sku",
            },
            {
                "data": "barcode",
            },
            {
                "data": "quantity",
                width: '2%'
            },
            {
                "data": "productImage",
                render: function(data, type, row) {
                    if (data) {
                        return `<img src="${PRODUCT_UPLOAD_URL}${data}" class="img-thumbnail" style="width: 80px; height: 80px;" />`;
                    }
                }
            },
            {
                "data": "status",
                render: function(data) {
                    return data == 1 ? '<h5><span class="badge bg-success">Active</span></h5>' : '<h5><span class="badge bg-danger">Inactive</span></h5>';
                }
            },
            {
                "data": 'created_By',
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
                "data": 'updated_By',
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
});

$(document).on('click', '.editbtn', function() {
        let productId = $(this).data('id');
        console.log
        window.location.href = PRODUCT_ADD_URL + productId;
    });

// for delete 
$(document).on('click', '.delete-btn', function() {
    var productId = $(this).data('id');
    var data = {
        productId: productId
    }
    console.log(productId);
    if (confirm('Are you sure you want to delete this employee?')) {
        $.ajax({
            url: PRODUCT_DELETE_URL,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.status === 'success') {
                    $('#myTable_product').DataTable().ajax.reload();
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

//for storewise product search ajax
$('#productNameFilter').on('keyup', function() {
    const name = $(this).val();

    $.ajax({
        url: PRODUCT_FILTER_URL,
        method: 'GET',
        data: {
            name: name
        },
        success: function(data) {
            let rows = '';
            data.forEach(product => {
                rows += `<tr>
                            <td>${product.productName}</td>
                            <td>${product.sku}</td>
                            <td>${product.barcode}</td>
                         </tr>`;
            });
            $('#productTable tbody').html(rows);
        }
    });
});