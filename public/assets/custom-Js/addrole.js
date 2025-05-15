const modules = [
    "Role", "Stores", "Employee","Categories",
    "Product", "Transfers", "ReceiveItem"
];

const permissions = modules.map((name, index) => ({
    id: index + 1,
    name
}));
    
$(document).ready(function() {
    const tableBody = $('#permisionTable tbody');

    permissions.forEach(permission => {
        const row = `
            <tr id="permission_tr">
                <td><input type="hidden" class="checkbox" id="permissionID" name="[${permission.id}]" /></td>
                <td>${permission.name}</td>
                <td><input type="checkbox" class="checkbox"  name="view[${permission.id}] "  data-field="viewAccess"></td>
                <td><input type="checkbox" class="checkbox"  name="add[${permission.id}] "  data-field="addAccess"></td>
                <td><input type="checkbox" class="checkbox" name="edit[${permission.id}]"  data-field="editAccess"></td>
                <td><input type="checkbox" class="checkbox" name="delete[${permission.id}]" data-field="deleteAccess"></td>
                <td><input type="checkbox" class="checkbox"  name="import[${permission.id}] "  data-field="importAccess"></td>
                <td><input type="checkbox" class="checkbox"  name="export[${permission.id}] "  data-field="exportAccess"></td>
            </tr>
        `;
        tableBody.append(row);
    });




    $('#savePermissions').click(function(e) {
        e.preventDefault();

        const name = $('#name').val().trim();
        const status = $('#status').val();

        if (!name) {
            alert("Role Name is required.");
            $('#name').focus();
            return;
        }

        if (!status) {
            alert("Status is required.");
            $('#status').focus();
            return;
        }

        $.ajax({
            url: ROLE_CHECK_URL, 
            type: "POST",
            data: {
                name: name
            },
            success: function(response) {
                if (response.exists) {
                    alert("This role name already exists. Please choose a different name.");
                } else {
                    saveRolePermissions(name, status);
                }
            }
        });
    });

    // Function to save the role and permissions
    function saveRolePermissions(name, status) {
        let permissionData = [];

        $('#permisionTable tbody tr').each(function() {
            const moduleName = $(this).find('td:nth-child(2)').text().trim();
            const view = $(this).find('input[data-field="viewAccess"').is(':checked') ? 1 : 0;
            const add = $(this).find('input[data-field="addAccess"]').is(':checked') ? 1 : 0;
            const edit = $(this).find('input[data-field="editAccess"]').is(':checked') ? 1 : 0;
            const del = $(this).find('input[data-field="deleteAccess"]').is(':checked') ? 1 : 0;
            const importAccess = $(this).find('input[data-field="importAccess"]').is(':checked') ? 1 : 0;
            const exportAccess = $(this).find('input[data-field="exportAccess"]').is(':checked') ? 1 : 0;

            permissionData.push({
                module: moduleName,
                view,
                add,
                edit,
                delete: del,
                importAccess,
                exportAccess
            });
        });

        const roleData = {
            name: name,
            status: status,
            permissions: permissionData
        };

        $.ajax({
            url: ROLE_PEMI_URL,
            type: "POST",
            data: JSON.stringify(roleData),
            contentType: "application/json",
            success: function(response) {
                console.log(response);          
                if (response.status === 'success') {
                    $('#successText').text(response.message);
                    $('#successMessage').removeClass('d-none');
                    $('#errorMessage').addClass('d-none');
                    window.location.href = ROLE_URL;
                } else {
                    $('#errorText').text(response.message);
                    $('#errorMessage').removeClass('d-none');
                    $('#successMessage').addClass('d-none');
                }
                setTimeout(() => {
                    $('#successMessage, #errorMessage').addClass('d-none');
                }, 5000);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },
            error: function(xhr) {
                console.error("Error:", xhr.responseText);
                alert("Something went wrong.");
            }
        });
    }
});