<?php
// ============================================================
//  Admin Panel — New Sinai MDI Hospital
//  This file is intentionally thin. It only:
//    1. Guards the session
//    2. Loads the DB connection
//    3. Includes all includes/ files (functions only, nothing runs yet)
//    4. Runs the router (exits early on any AJAX hit)
//    5. Prepares page data
//    6. Includes the view partials in order
// ============================================================

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/db.php';

// ── Logic / handlers (declare functions, nothing executes yet) ────────────────
require_once 'includes/constants.php';
require_once 'includes/helpers.php';
require_once 'includes/ajax_doctors.php';
require_once 'includes/ajax_users.php';
require_once 'includes/ajax_departments.php';
require_once 'includes/ajax_display.php';
require_once 'includes/ajax_password.php';

// ── Resolve auth context (needed by router + views) ───────────────────────────
$currentUsername = $_SESSION['admin'];
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param('s', $currentUsername);
$stmt->execute();
$me           = $stmt->get_result()->fetch_assoc();
$isSuperadmin = !empty($me['is_superadmin']);

// ── Route AJAX requests (exits here — page render never runs on AJAX) ─────────
require_once 'includes/router.php';

// ── Page data (only reached on normal page loads) ─────────────────────────────
autoCleanExpiredLeave($conn);

$deptResult = $conn->query("SELECT name FROM departments ORDER BY name ASC");
$deptList   = [];
while ($dr = $deptResult->fetch_assoc()) $deptList[] = $dr['name'];

$displaySettings    = $conn->query("SELECT * FROM display_settings ORDER BY id LIMIT 1")->fetch_assoc();
$currentSpeed       = (int) ($displaySettings['scroll_speed']    ?? 25);
$currentTop         = (int) ($displaySettings['pause_at_top']    ?? 3000);
$currentBottom      = (int) ($displaySettings['pause_at_bottom'] ?? 3000);
$currentSpeedLabel  = SPEED_LABELS[$currentSpeed]  ?? "{$currentSpeed} px/s";
$currentTopLabel    = PAUSE_LABELS[$currentTop]    ?? ($currentTop    / 1000) . ' sec';
$currentBottomLabel = PAUSE_LABELS[$currentBottom] ?? ($currentBottom / 1000) . ' sec';

$doctorResult   = $conn->query("SELECT * FROM doctors ORDER BY name ASC");
$initialDoctors = [];
while ($row = $doctorResult->fetch_assoc()) $initialDoctors[] = formatDoctorRow($row);

$countAvailable = count(array_filter($initialDoctors, fn($d) => $d['label'] === 'Available'));
$countNoClinic  = count(array_filter($initialDoctors, fn($d) => $d['label'] === 'No Clinic'));
$countOnLeave   = count(array_filter($initialDoctors, fn($d) => $d['label'] === 'On Leave'));

// ── Render ────────────────────────────────────────────────────────────────────
require_once 'views/layout_head.php';
require_once 'views/page_dashboard.php';
require_once 'views/page_doctors.php';
require_once 'views/page_display.php';
if ($isSuperadmin) require_once 'views/page_users.php';
require_once 'views/page_departments.php';
require_once 'views/layout_foot.php';