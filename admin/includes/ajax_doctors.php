<?php
// ============================================================
//  AJAX — Doctors  (New Sinai MDI Hospital Admin)
//  Handles: get, save, delete one, delete selected, delete all.
//  Every function calls jsonResponse() and never returns.
// ============================================================

/**
 * GET ?ajax=doctors — return all doctors ordered by name.
 */
function ajaxGetDoctors(mysqli $conn): never
{
    $result = $conn->query("SELECT * FROM doctors ORDER BY name ASC");
    $rows   = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = formatDoctorRow($row);
    }
    jsonResponse(['ok' => true, 'doctors' => $rows]);
}

/**
 * POST ajax=save_doctor — insert or update a doctor record.
 */
function ajaxSaveDoctor(mysqli $conn): never
{
    $id        = (int)   ($_POST['id']           ?? 0);
    $name      = strtoupper(trim($_POST['name']      ?? ''));
    $dept      = strtoupper(trim($_POST['department'] ?? ''));
    $status    = trim($_POST['status']    ?? '');
    $resume    = trim($_POST['resume_date'] ?? '') ?: null;
    $remarks   = trim($_POST['remarks']   ?? '') ?: null;
    $tentative = isset($_POST['is_tentative']) ? 1 : 0;

    // ── Validation ────────────────────────────────────────────────────────
    if (!$name)   jsonResponse(['ok' => false, 'error' => 'Doctor name is required.']);
    if (!$dept)   jsonResponse(['ok' => false, 'error' => 'Please select a specialization.']);

    // Auto-create department if it doesn't exist yet
    $checkDept = $conn->prepare("SELECT id FROM departments WHERE name = ?");
    $checkDept->bind_param('s', $dept);
    $checkDept->execute();
    if (!$checkDept->get_result()->fetch_assoc()) {
        $insertDept = $conn->prepare("INSERT INTO departments (name) VALUES (?)");
        $insertDept->bind_param('s', $dept);
        $insertDept->execute();
    }

    if (!$status) jsonResponse(['ok' => false, 'error' => 'Please select a status.']);

    if ($status === 'On Leave') {
        if (!$resume) {
            jsonResponse(['ok' => false, 'error' => 'Resume date is required for On Leave.']);
        }
        $date = DateTime::createFromFormat('Y-m-d', $resume);
        if (!$date || $date->format('Y-m-d') !== $resume) {
            jsonResponse(['ok' => false, 'error' => 'Invalid resume date.']);
        }
        $today = (new DateTime())->setTime(0, 0, 0);
        if ($date < $today) {
            jsonResponse(['ok' => false, 'error' => 'Resume date cannot be in the past.']);
        }
        if (!$remarks) {
            jsonResponse(['ok' => false, 'error' => 'Please select a leave type.']);
        }
    } else {
        // Clear leave-only fields when not on leave
        $resume    = null;
        $tentative = 0;
        $remarks   = null;
    }

    // ── Persist ───────────────────────────────────────────────────────────
    $null = null; // placeholder for unused time columns

    if ($id === 0) {
        $stmt = $conn->prepare(
            "INSERT INTO doctors (name, department, status, resume_date, appt_start, appt_end, remarks, is_tentative)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('sssssssi', $name, $dept, $status, $resume, $null, $null, $remarks, $tentative);
    } else {
        $stmt = $conn->prepare(
            "UPDATE doctors
             SET name = ?, department = ?, status = ?, resume_date = ?,
                 appt_start = ?, appt_end = ?, remarks = ?, is_tentative = ?
             WHERE id = ?"
        );
        $stmt->bind_param('sssssssii', $name, $dept, $status, $resume, $null, $null, $remarks, $tentative, $id);
    }

    $stmt->execute();
    $newId = $id ?: $conn->insert_id;

    $fetch = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
    $fetch->bind_param('i', $newId);
    $fetch->execute();
    $saved = $fetch->get_result()->fetch_assoc();

    jsonResponse([
        'ok'     => true,
        'insert' => ($id === 0),
        'doctor' => formatDoctorRow($saved),
    ]);
}

/**
 * POST ajax=delete_doctor — delete a single doctor by id.
 */
function ajaxDeleteDoctor(mysqli $conn): never
{
    $id = (int) ($_POST['id'] ?? 0);
    if (!$id) jsonResponse(['ok' => false, 'error' => 'Invalid id.']);

    $stmt = $conn->prepare("DELETE FROM doctors WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    jsonResponse(['ok' => true]);
}

/**
 * POST ajax=delete_selected — delete a list of doctors by id array.
 */
function ajaxDeleteSelected(mysqli $conn): never
{
    $ids = json_decode($_POST['ids'] ?? '[]', true);
    foreach ($ids as $id) {
        $stmt = $conn->prepare("DELETE FROM doctors WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
    jsonResponse(['ok' => true]);
}

/**
 * POST ajax=delete_all — remove every doctor record.
 */
function ajaxDeleteAll(mysqli $conn): never
{
    $conn->query("DELETE FROM doctors");
    jsonResponse(['ok' => true]);
}