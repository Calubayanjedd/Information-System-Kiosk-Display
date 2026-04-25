<?php
// ============================================================
//  Helpers — New Sinai MDI Hospital Admin
//  Pure utility functions shared across AJAX handlers and views.
//  No side effects — safe to include anywhere.
// ============================================================

/**
 * Send a JSON response and halt execution.
 */
function jsonResponse(array $data): never
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

/**
 * Map a raw DB status string to a user-facing label and CSS badge class.
 * Returns ['label' => string, 'badge' => string]
 */
function resolveDoctorLabel(string $status): array
{
    $lower = strtolower(trim($status));

    if ($lower === '' || in_array($lower, ['not available', 'no clinic', 'no medical'], true)) {
        return ['label' => 'No Clinic', 'badge' => 'status-nomedical'];
    }

    if (in_array($lower, ['available', 'on schedule'], true)) {
        return ['label' => 'Available', 'badge' => 'status-onschedule'];
    }

    if (str_contains($lower, 'leave')) {
        return ['label' => 'On Leave', 'badge' => 'status-onleave'];
    }

    return ['label' => ucwords($lower) ?: 'No Clinic', 'badge' => 'status-nomedical'];
}

/**
 * Convert a raw DB row into the normalised array the front-end expects.
 */
function formatDoctorRow(array $row): array
{
    $label = resolveDoctorLabel($row['status']);

    return [
        'id'           => $row['id'],
        'name'         => $row['name'],
        'department'   => $row['department'],
        'status'       => $row['status'],
        'label'        => $label['label'],
        'badge'        => $label['badge'],
        'resume_date'  => $row['resume_date'],
        'is_tentative' => (int) ($row['is_tentative'] ?? 0),
        'remarks'      => trim($row['remarks'] ?? ''),
    ];
}

/**
 * Both confirmed and tentative leave records are flagged for manual admin
 * review when their resume date has passed. Auto-cleanup is disabled to
 * prevent unintended status changes.
 */
function autoCleanExpiredLeave(mysqli $conn): void
{
    // Intentionally empty — admin must review expired dates manually.
}