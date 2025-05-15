$('#myTable_cateogory').DataTable({
    processing: true,
    serverSide: false,
    ordering: false,
    ajax: {
        url: CAT_DATA_URL,
        dataSrc: 'data'
    },
    columns: [
        // {
        //     data: 'cat_id',
        //     render: function(data) {
        //         return `<input type="checkbox" class="category-checkbox" value="${data}">`;
        //     }
        // },
        // {
        //     data: 'cat_id',
        //     width: '3%'
        // },
        {
            data: 'store_name'
        },
        {
            data: 'catName'
        },
        {
            data: 'status',
            render: function(data) {
                return data == 1 ? '<h5><span class="badge bg-success">Active</span></h5>' : '<h5><span class="badge bg-danger">Inactive</span></h5>';

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
   
        // {
        //     data: 'cat_id',
        //     render: function(data, type, row) {
        //         return `
        //     <button class="btn btn btn-outline-primary" id="edit_btn" data-eid='${row.cat_id}'>Edit</button>
        //     <button class="btn btn-outline-danger" id="delete-btn-category" data-cid='${row.cat_id}'>Delete</button>`;
        //     }
        // }
    ]
});

$(document).on('click', '.editbtn', function() {
    let catId = $(this).data('id');
    window.location.href = CAT_ADD_URL + catId;
});

$(document).on('click', '.delete-btn', function () {
    var Category_id = $(this).data('id');

    if (confirm('Are you sure you want to delete this category?')) {
        $.ajax({
            url: CAT_DELETE_URL,
            type: 'POST',
            data: { Category_id: Category_id },
            success: function (response) {
                if (response.status === 'success') {
                    alert(response.message);
                    $('#myTable_cateogory').DataTable().ajax.reload();
                    // Reload the DataTable using the correct reference
                    if (typeof table_category !== 'undefined') {
                        table_category.ajax.reload(null, false);
                    }
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


//for multipuldelete 
// $('#delete-multiple-category-btn').on('click', function() {
  //  var selectedIds = [];
 //   $('.category-checkbox:checked').each(function() {
    //    selectedIds.push($(this).val());
//    });

  //  if (selectedIds.length === 0) {
  //      alert('Please select at least one category.');
 //       return;
 //   }
 //   console.log(selectedIds);

  //  if (confirm('Are you sure you want to delete selected categories?')) {
    //     $.ajax({
    //         url: "",
    //         type: 'POST',
    //         data: {
    //             category_ids: selectedIds,
    //         },

    //         traditional: true,
    //         success: function(response) {
    //             if (response.status === 'success') {
    //                 $('#myTable_cateogory').DataTable().ajax.reload();
    //                 alert(response.message);
    //             } else {
    //                 alert(response.message);
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             try {
    //                 var res = JSON.parse(xhr.responseText);
    //                 alert(res.message);
    //             } catch (e) {
    //                 alert('Server Error: ' + xhr.status + '\n' + xhr.responseText);
    //             }
    //         }
    //     });
    // }
//  });