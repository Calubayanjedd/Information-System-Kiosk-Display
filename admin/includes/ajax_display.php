<?php
// ============================================================
//  AJAX — Display Settings  (New Sinai MDI Hospital Admin)
//  Handles: save scroll speed and pause timings.
// ============================================================

/**
 * POST ajax=save_display — persist TV display scroll settings.
 * Values are clamped to safe ranges before saving.
 */
function ajaxSaveDisplay(mysqli $conn): never
{
    $speed  = max(5,    min(100,   (int) ($_POST['scroll_speed']    ?? 25)));
    $top    = max(1000, min(10000, (int) ($_POST['pause_at_top']    ?? 3000)));
    $bottom = max(1000, min(10000, (int) ($_POST['pause_at_bottom'] ?? 3000)));

    $stmt = $conn->prepare(
        "UPDATE display_settings
         SET scroll_speed = ?, pause_at_top = ?, pause_at_bottom = ?
         WHERE id = 1"
    );
    $stmt->bind_param('iii', $speed, $top, $bottom);
    $stmt->execute();

    jsonResponse(['ok' => true]);
}