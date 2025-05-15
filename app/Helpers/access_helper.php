<?php
if (!function_exists('get_permission_buttons')) {
    function get_permission_buttons($row) {
        $permissions = session()->get('permissions');
       
        $btns = '';

        if (!empty($permissions)) {
            $permissions = array_values($permissions)[0];

            if (!empty($permissions['editAccess']) && $permissions['editAccess'] == 1) {
                $btns .= "<button class='btn btn-outline-success editbtn' data-id='{$row['role_id']}'>Edit</button> ";
            } 
            
            if (!empty($permissions['deleteAccess']) && $permissions['deleteAccess'] == 1) {
                $btns .= "<button class='btn btn-outline-danger delete-btn' data-id='{$row['role_id']}'>Delete</button>";
            }
        }

        return $btns ?? "-"; 
    }
}
?>