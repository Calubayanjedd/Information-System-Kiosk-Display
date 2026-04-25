<?php
// ============================================================
//  View — Doctor List Page  (New Sinai MDI Hospital Admin)
//  Expects: $deptList (array of department name strings)
// ============================================================
?>
<div class="page" id="page-doctors">
    <div class="section-card">
        <div class="section-card-header">
            <div class="section-card-title"><i class="bi bi-person-lines-fill"></i> Doctor List</div>
            <div class="filter-bar">
                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" id="global-search"
                           placeholder="Search by name…" oninput="filterTable()" style="width:200px;">
                </div>
                <select id="f-dept" class="form-select" onchange="filterTable()" style="width:150px;">
                    <option value="">All Specializations</option>
                    <?php foreach ($deptList as $d): ?>
                    <option><?= htmlspecialchars($d) ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="f-status" class="form-select" onchange="filterTable()" style="width:140px;">
                    <option value="">All Status</option>
                    <option value="Available">Available</option>
                    <option value="No Clinic">No Clinic</option>
                    <option value="On Leave">On Leave</option>
                </select>
                <button class="btn-clear" onclick="clearAllFilters()"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>

        <div class="section-card-header" style="border-top:none; padding-top:0; justify-content:flex-end;">
            <div style="display:flex; gap:8px;">
                <button class="btn-primary-custom" onclick="showDoctorModal()">
                    <i class="bi bi-plus-lg"></i> Add Doctor
                </button>
                <button class="btn-icon btn-delete-sm" id="delete-selected-btn"
                        onclick="deleteSelected()" style="display:none; padding:10px 14px;">
                    <i class="bi bi-trash"></i> Delete Selected
                </button>
                <button class="btn-danger-custom" onclick="showDeleteAllModal()">
                    <i class="bi bi-trash3"></i> Delete All
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="doctor-table">
                <thead>
                    <tr>
                        <th style="width:40px;"><input type="checkbox" id="select-all" onclick="toggleSelectAll()"></th>
                        <th onclick="sortTable(1)">Name <i class="bi bi-arrow-down-up" style="font-size:10px;opacity:.5;" id="si-1"></i></th>
                        <th onclick="sortTable(2)">Specialization <i class="bi bi-arrow-down-up" style="font-size:10px;opacity:.5;" id="si-2"></i></th>
                        <th onclick="sortTable(3)">Status <i class="bi bi-arrow-down-up" style="font-size:10px;opacity:.5;" id="si-3"></i></th>
                        <th>Resume Date</th>
                        <th>Leave Type</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="doctor-tbody"></tbody>
            </table>
        </div>
    </div>
</div>