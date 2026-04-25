<?php
// ============================================================
//  AJAX — Departments  (New Sinai MDI Hospital Admin)
//  Handles: get list, add, delete.
// ============================================================

/**
 * GET ?ajax=departments — return all departments ordered by name.
 */
function ajaxGetDepartments(mysqli $conn): never
{
    $rows  = $conn->query("SELECT * FROM departments ORDER BY name ASC");
    $depts = [];
    while ($row = $rows->fetch_assoc()) $depts[] = $row;
    jsonResponse(['ok' => true, 'departments' => $depts]);
}

/**
 * POST ajax=add_department — add a new department.
 * Duplicate names are rejected.
 */
function ajaxAddDepartment(mysqli $conn): never
{
    $name = strtoupper(trim($_POST['name'] ?? ''));
    if (!$name) jsonResponse(['ok' => false, 'error' => 'Specialization name is required.']);

    $check = $conn->prepare("SELECT id FROM departments WHERE name = ?");
    $check->bind_param('s', $name);
    $check->execute();
    if ($check->get_result()->fetch_assoc()) {
        jsonResponse(['ok' => false, 'error' => 'Specialization already exists.']);
    }

    $stmt = $conn->prepare("INSERT INTO departments (name) VALUES (?)");
    $stmt->bind_param('s', $name);
    $stmt->execute();

    jsonResponse(['ok' => true, 'id' => $conn->insert_id, 'name' => $name]);
}

/**
 * POST ajax=delete_department — remove a department.
 * Blocked if any doctors are still assigned to it.
 */
function ajaxDeleteDepartment(mysqli $conn): never
{
    $id = (int) ($_POST['id'] ?? 0);
    if (!$id) jsonResponse(['ok' => false, 'error' => 'Invalid id.']);

    $check = $conn->prepare(
        "SELECT COUNT(*) AS c FROM doctors
         WHERE department = (SELECT name FROM departments WHERE id = ?)"
    );
    $check->bind_param('i', $id);
    $check->execute();
    $row = $check->get_result()->fetch_assoc();
    if ($row['c'] > 0) {
        jsonResponse(['ok' => false, 'error' => "Cannot delete — {$row['c']} doctor(s) still assigned to this specialization."]);
    }

    $stmt = $conn->prepare("DELETE FROM departments WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    jsonResponse(['ok' => true]);
}