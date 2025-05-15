$(document).ready(function () {
    const roleId = $('#editRoleId').val();

    // Fetch role data and permissions
    $.ajax({
        url: ROLE_GET_URL + roleId,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log("Get Role Response:", response);
            if (response.success) {
                $('#edit_name').val(response.data.name);
                $('#edit_status').val(response.data.status);

                let tableBody = '';
                response.data.permissions.forEach(function (p) {
                    tableBody += `
                        <tr>
                            <td>${p.moduleName}</td>
                            <td><input type="checkbox" class="permission" data-type="view" data-id="${p.permission_id}" ${p.viewAccess == '1' ? 'checked' : ''}></td>
                            <td><input type="checkbox" class="permission" data-type="add" data-id="${p.permission_id}" ${p.addAccess == '1' ? 'checked' : ''}></td>
                            <td><input type="checkbox" class="permission" data-type="update" data-id="${p.permission_id}" ${p.editAccess == '1' ? 'checked' : ''}></td>
                            <td><input type="checkbox" class="permission" data-type="delete" data-id="${p.permission_id}" ${p.deleteAccess == '1' ? 'checked' : ''}></td>
                            <td><input type="checkbox" class="permission" data-type="importAccess" data-id="${p.permission_id}" ${p.importAccess == '1' ? 'checked' : ''}></td>
                            <td><input type="checkbox" class="permission" data-type="exportAccess" data-id="${p.permission_id}" ${p.exportAccess == '1' ? 'checked' : ''}></td>
                        </tr>`;
                });

                $('#permisionTable tbody').html(tableBody);
            } else {
                alert('Role data not found.');
            }
        },
        error: function (xhr) {
            console.error("AJAX error:", xhr.responseText);
            alert('Something went wrong while fetching role data.');
        }
    });

    // Update role permissions 
    $('#EditPermissions').on('click', function (e) {
        e.preventDefault();

        const roleId = $('#editRoleId').val();
        const editName = $('#edit_name').val();
        const editStatus = $('#edit_status').val();

        let permissions = {};

        $('.permission').each(function () {
            const id = $(this).data('id');
            const type = $(this).data('type');
            const value = $(this).is(':checked') ? 1 : 0;

            if (!permissions[id]) {
                permissions[id] = {};
            }
            permissions[id][type] = value;
        });
        console.log("Permissions Data:", permissions);
        $.ajax({
            url: ROLE_UPDATEPER_URL,
            type: "POST",
            dataType: "json",
            data: {
                editRoleId: roleId,
                edit_name: editName,
                edit_status: editStatus,
                permissions: permissions
            },
            success: function (response) {
                if (!response.success) {
                    $.each(response.errors, function (key, val) {
                        $('.error-' + key).text(val);
                    });
                } else {
                    alert(response.message);
                    window.location.href = ROLE_URL;
                }
            },

            error: function (xhr) {
                console.error("Update error:", xhr.responseText);
                alert('Failed to update permissions.');
            }
        });
    });

    // $('#EditPermissions').on('click', function (e) {
    //     e.preventDefault();

    //     const roleId = $('#editRoleId').val();
    //     let permissions = {};

    //     $('.permission').each(function () {
    //         const id = $(this).data('id');
    //         const type = $(this).data('type');
    //         const value = $(this).is(':checked') ? 1 : 0;

    //         if (!permissions[id]) {
    //             permissions[id] = {};
    //         }
    //         permissions[id][type] = value;
    //     });

    //     $.ajax({
    //         url: ROLE_UPDATEPER_URL,
    //         type: "POST",
    //         dataType: "json",
    //         data: {
    //             editRoleId: roleId,
    //             permissions: permissions
    //         },
    //         success: function (response) {
    //             console.log("Update Role Response:", response);
    //             if (!response.success) {
    //                 $.each(response.errors, function (key, val) {
    //                     $('.error-' + key).text(val);
    //                 });
    //             } else {
    //                 if (response.data && response.data.permissions) {
    //                     let tableBody = '';
    //                     response.data.permissions.forEach(function (p) {
    //                         tableBody += `
    //                         <tr>
    //                             <td>${p.moduleName}</td>
    //                             <td><input type="checkbox" class="permission" data-type="view" data-id="${p.permission_id}" ${p.viewAccess == '1' ? 'checked' : ''}></td>
    //                             <td><input type="checkbox" class="permission" data-type="add" data-id="${p.permission_id}" ${p.addAccess == '1' ? 'checked' : ''}></td>
    //                             <td><input type="checkbox" class="permission" data-type="update" data-id="${p.permission_id}" ${p.editAccess == '1' ? 'checked' : ''}></td>
    //                             <td><input type="checkbox" class="permission" data-type="delete" data-id="${p.permission_id}" ${p.deleteAccess == '1' ? 'checked' : ''}></td>
    //                             <td><input type="checkbox" class="permission" data-type="importAccess" data-id="${p.permission_id}" ${p.importAccess == '1' ? 'checked' : ''}></td>
    //                             <td><input type="checkbox" class="permission" data-type="exportAccess" data-id="${p.permission_id}" ${p.exportAccess == '1' ? 'checked' : ''}></td>
    //                         </tr>`;
    //                     });
    //                     $('#permisionTable tbody').html(tableBody);
    //                 }
    //             }
    //         },
    //         error: function (xhr) {
    //             console.error("Update error:", xhr.responseText);
    //             alert('Failed to update permissions.');
    //         }
    //     });
    // });
});