<?php
// ============================================================
//  Router — New Sinai MDI Hospital Admin
//  Dispatches AJAX GET and POST requests to the right handler.
//  Exits early on any AJAX hit — page render never runs.
//
//  Adding a new endpoint:
//    1. Create the function in the appropriate ajax_*.php file.
//    2. Add a case here pointing to it.
// ============================================================

// ── GET requests ─────────────────────────────────────────────────────────────
if (isset($_GET['ajax'])) {
    match ($_GET['ajax']) {
        'doctors'     => ajaxGetDoctors($conn),
        'users'       => ajaxGetUsers($conn, $isSuperadmin),
        'departments' => ajaxGetDepartments($conn),
        default       => jsonResponse(['ok' => false, 'error' => 'Unknown endpoint.']),
    };
}

// ── POST requests ─────────────────────────────────────────────────────────────
if (isset($_POST['ajax'])) {
    match ($_POST['ajax']) {
        'save_doctor'       => ajaxSaveDoctor($conn),
        'delete_doctor'     => ajaxDeleteDoctor($conn),
        'delete_selected'   => ajaxDeleteSelected($conn),
        'delete_all'        => ajaxDeleteAll($conn),
        'save_display'      => ajaxSaveDisplay($conn),
        'change_password'   => ajaxChangePassword($conn),
        'add_user'          => ajaxAddUser($conn, $isSuperadmin),
        'edit_user'         => ajaxEditUser($conn, $isSuperadmin),
        'delete_user'       => ajaxDeleteUser($conn, $isSuperadmin, $currentUsername),
        'add_department'    => ajaxAddDepartment($conn),
        'delete_department' => ajaxDeleteDepartment($conn),
        default             => jsonResponse(['ok' => false, 'error' => 'Unknown endpoint.']),
    };
}