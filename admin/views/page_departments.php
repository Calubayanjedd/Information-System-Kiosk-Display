<?php
// ============================================================
//  View — Departments Page  (New Sinai MDI Hospital Admin)
// ============================================================
?>
<div class="page" id="page-departments">
    <div class="section-card">
        <div class="section-card-header">
            <div class="section-card-title"><i class="bi bi-diagram-3-fill"></i> Departments</div>
        </div>
        <div style="padding:20px 24px; border-bottom:1px solid var(--border);">
            <div style="display:flex; gap:10px; align-items:flex-start; max-width:420px;">
                <div style="flex:1;">
                    <input type="text" id="dept-new-name" class="form-control"
                           placeholder="e.g. Neurology, Surgery…"
                           onkeydown="if(event.key==='Enter') addDepartment()"
                           style="font-size:13px;">
                    <div id="dept-error" style="color:var(--danger); font-size:12px; margin-top:5px; display:none;"></div>
                </div>
                <button class="btn-primary-custom" onclick="addDepartment()" style="white-space:nowrap;">
                    <i class="bi bi-plus-lg"></i> Add Department
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Specialization Name</th>
                        <th style="width:100px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="dept-tbody">
                    <tr><td colspan="3" class="table-empty">Loading…</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>