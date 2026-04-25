<?php
// ============================================================
//  View — User Accounts Page  (New Sinai MDI Hospital Admin)
//  Only included when $isSuperadmin is true.
// ============================================================
?>
<div class="page" id="page-users">
    <div class="section-card">
        <div class="section-card-header">
            <div class="section-card-title"><i class="bi bi-people-fill"></i> User Accounts</div>
            <button class="btn-primary-custom" onclick="showAddUserModal()">
                <i class="bi bi-plus-lg"></i> Add User
            </button>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="users-tbody">
                    <tr><td colspan="5" class="table-empty">Loading…</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>