<?php
// ============================================================
//  AJAX — Users  (New Sinai MDI Hospital Admin)
//  Handles: get list, add, edit, delete.
//  Superadmin-only — every function checks $isSuperadmin first.
// ============================================================

/**
 * GET ?ajax=users — list all user accounts (superadmin only).
 */
function ajaxGetUsers(mysqli $conn, bool $isSuperadmin): never
{
    if (!$isSuperadmin) jsonResponse(['ok' => false, 'error' => 'Access denied.']);

    $result = $conn->query("SELECT id, username, is_superadmin, created_at FROM users ORDER BY id ASC");
    if (!$result) jsonResponse(['ok' => false, 'error' => $conn->error]);

    $users = [];
    while ($row = $result->fetch_assoc()) $users[] = $row;

    jsonResponse(['ok' => true, 'users' => $users]);
}

/**
 * POST ajax=add_user — create a new user account (superadmin only).
 */
function ajaxAddUser(mysqli $conn, bool $isSuperadmin): never
{
    if (!$isSuperadmin) jsonResponse(['ok' => false, 'error' => 'Access denied.']);

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role     = (int) ($_POST['role']   ?? 0);

    if (!$username || !$password) {
        jsonResponse(['ok' => false, 'error' => 'Username and password are required.']);
    }

    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param('s', $username);
    $check->execute();
    if ($check->get_result()->fetch_assoc()) {
        jsonResponse(['ok' => false, 'error' => 'Username already exists.']);
    }

    $hashed = md5($password);
    $stmt   = $conn->prepare("INSERT INTO users (username, password, is_superadmin) VALUES (?, ?, ?)");
    $stmt->bind_param('ssi', $username, $hashed, $role);
    $stmt->execute();

    jsonResponse(['ok' => true, 'id' => $conn->insert_id, 'username' => $username, 'is_superadmin' => $role]);
}

/**
 * POST ajax=edit_user — update an existing user account (superadmin only).
 * Requires ADMIN_PASSWORD_KEY when changing the password field.
 */
function ajaxEditUser(mysqli $conn, bool $isSuperadmin): never
{
    if (!$isSuperadmin) jsonResponse(['ok' => false, 'error' => 'Access denied.']);

    $id       = (int)  ($_POST['id']       ?? 0);
    $username = trim($_POST['username']    ?? '');
    $password = trim($_POST['password']    ?? '');
    $role     = (int)  ($_POST['role']     ?? 0);

    if (!$id || !$username) jsonResponse(['ok' => false, 'error' => 'Username is required.']);

    // Ensure username isn't taken by a different account
    $check = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
    $check->bind_param('si', $username, $id);
    $check->execute();
    if ($check->get_result()->fetch_assoc()) {
        jsonResponse(['ok' => false, 'error' => 'Username already taken by another account.']);
    }

    // Prevent stripping super-admin role if no other super-admin exists
    $fetchTarget = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $fetchTarget->bind_param('i', $id);
    $fetchTarget->execute();
    $target = $fetchTarget->get_result()->fetch_assoc();
    if (!$target) jsonResponse(['ok' => false, 'error' => 'User not found.']);

    if ($target['is_superadmin'] == 1 && $role == 0) {
        $countStmt = $conn->prepare("SELECT COUNT(*) AS c FROM users WHERE is_superadmin = 1 AND id != ?");
        $countStmt->bind_param('i', $id);
        $countStmt->execute();
        $others = $countStmt->get_result()->fetch_assoc();
        if ($others['c'] == 0) {
            jsonResponse(['ok' => false, 'error' => 'Cannot remove Super Admin role — there must be at least one Super Admin.']);
        }
    }

    if ($password !== '') {
        $adminKey = trim($_POST['admin_password'] ?? '');
        if ($adminKey !== ADMIN_PASSWORD_KEY) {
            jsonResponse(['ok' => false, 'error' => 'Incorrect administrator password. Password was not changed.']);
        }
        $hashed = md5($password);
        $stmt   = $conn->prepare("UPDATE users SET username = ?, password = ?, is_superadmin = ? WHERE id = ?");
        $stmt->bind_param('ssii', $username, $hashed, $role, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, is_superadmin = ? WHERE id = ?");
        $stmt->bind_param('sii', $username, $role, $id);
    }

    $stmt->execute();
    jsonResponse(['ok' => true, 'message' => 'User updated successfully.']);
}

/**
 * POST ajax=delete_user — remove a user account (superadmin only).
 * Cannot delete the superadmin account or your own account.
 */
function ajaxDeleteUser(mysqli $conn, bool $isSuperadmin, string $currentUsername): never
{
    if (!$isSuperadmin) jsonResponse(['ok' => false, 'error' => 'Access denied.']);

    $id = (int) ($_POST['id'] ?? 0);

    $fetchTarget = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $fetchTarget->bind_param('i', $id);
    $fetchTarget->execute();
    $target = $fetchTarget->get_result()->fetch_assoc();

    if (!$target)                            jsonResponse(['ok' => false, 'error' => 'User not found.']);
    if ($target['is_superadmin'])            jsonResponse(['ok' => false, 'error' => 'Cannot delete the superadmin account.']);
    if ($target['username'] === $currentUsername) jsonResponse(['ok' => false, 'error' => 'Cannot delete your own account.']);

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    jsonResponse(['ok' => true]);
}