<?php
// ============================================================
//  AJAX — Password  (New Sinai MDI Hospital Admin)
//  Handles: change the current user's own password.
//  Accepts either the current password or the MASTER_RESET_KEY.
// ============================================================

/**
 * POST ajax=change_password — change the logged-in user's password.
 * The 'current_or_key' field accepts either the existing password
 * or the master reset key (defined in constants.php).
 */
function ajaxChangePassword(mysqli $conn): never
{
    $currentOrKey    = trim($_POST['current_or_key']    ?? '');
    $newPassword     = trim($_POST['new_password']       ?? '');
    $confirmPassword = trim($_POST['confirm_password']   ?? '');

    if (!$currentOrKey || !$newPassword || !$confirmPassword) {
        jsonResponse(['ok' => false, 'error' => 'All fields are required.']);
    }
    if ($newPassword !== $confirmPassword) {
        jsonResponse(['ok' => false, 'error' => 'New passwords do not match.']);
    }

    $username = $_SESSION['admin'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    $correctPassword = $user && md5($currentOrKey) === $user['password'];
    $usedResetKey    = ($currentOrKey === MASTER_RESET_KEY);

    if (!$correctPassword && !$usedResetKey) {
        jsonResponse(['ok' => false, 'error' => 'Current password or master reset key is incorrect.']);
    }

    $hashed = md5($newPassword);
    $update = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $update->bind_param('ss', $hashed, $username);
    $update->execute();

    jsonResponse(['ok' => true, 'message' => 'Password changed successfully!']);
}