<?php
// ============================================================
//  View — Dashboard Page  (New Sinai MDI Hospital Admin)
//  Expects: $countAvailable, $countNoClinic, $countOnLeave
// ============================================================
?>
<div class="page active" id="page-dashboard">
    <div class="stats-grid">
        <div class="stat-card available">
            <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
            <div class="stat-info">
                <div class="stat-count" id="count-available"><?= $countAvailable ?></div>
                <div class="stat-label">Available Today</div>
            </div>
        </div>
        <div class="stat-card noclinic">
            <div class="stat-icon"><i class="bi bi-x-circle-fill"></i></div>
            <div class="stat-info">
                <div class="stat-count" id="count-noclinic"><?= $countNoClinic ?></div>
                <div class="stat-label">No Clinic Today</div>
            </div>
        </div>
        <div class="stat-card onleave">
            <div class="stat-icon"><i class="bi bi-calendar-x-fill"></i></div>
            <div class="stat-info">
                <div class="stat-count" id="count-onleave"><?= $countOnLeave ?></div>
                <div class="stat-label">On Leave</div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-card-header">
            <div class="section-card-title"><i class="bi bi-clock-history"></i> Recent Doctor List</div>
            <button class="btn-primary-custom" onclick="showPage('doctors')">
                <i class="bi bi-arrow-right"></i> View All
            </button>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>Status</th>
                        <th>Resume Date</th>
                    </tr>
                </thead>
                <tbody id="dashboard-tbody">
                    <tr><td colspan="4" class="table-empty">Loading…</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>