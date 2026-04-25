<?php
// ============================================================
//  View — Layout Foot  (New Sinai MDI Hospital Admin)
//  Contains: all modals, toast wrapper, all JavaScript, closing tags.
//  Expects: $isSuperadmin, $deptList, $initialDoctors
// ============================================================
?>

</div><!-- /main-content -->

<!-- ============================================================
     MODALS
============================================================ -->

<!-- Add / Edit Doctor -->
<div class="modal fade" id="doctorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none; border-radius:14px; overflow:hidden;">
            <div class="modal-title-bar">
                <h5 id="doctorModalTitle"><i class="bi bi-plus-circle"></i> Add New Doctor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">Doctor Name *</label>
                        <input type="text" class="form-control" id="m-name" placeholder="e.g. Dr. Juan Dela Cruz">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Specialization *</label>
                        <select class="form-select" id="m-dept">
                            <option value="">Select Specialization</option>
                            <?php foreach ($deptList as $d): ?>
                            <option><?= htmlspecialchars($d) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Status *</label>
                        <select class="form-select" id="m-status" onchange="toggleLeaveFields()">
                            <option value="On Schedule">Available</option>
                            <option value="No Medical">No Clinic</option>
                            <option value="On Leave">On Leave</option>
                        </select>
                    </div>
                    <div class="col-md-6 leave-fields" style="display:none;">
                        <label class="form-label-custom">Resume Date *</label>
                        <input type="date" class="form-control" id="m-resume">
                    </div>
                    <div class="col-12 leave-fields" style="display:none;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="m-tentative">
                            <label class="form-check-label" for="m-tentative" style="font-size:13px; font-weight:600;">
                                <i class="bi bi-calendar-question"></i> Resume date is tentative
                            </label>
                        </div>
                    <div class="col-12 leave-fields" style="display:none;">
                        <label class="form-label-custom">Leave Type *</label>
                        <select class="form-select" id="m-remarks">
                            <option value="">— Select leave type —</option>
                            <?php foreach (LEAVE_TYPES as $type): ?>
                                <option value="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($type) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    </div>
                </div>
                <div id="form-error" class="mt-3"
                     style="display:none; color:var(--danger); font-size:13px; font-weight:600;
                            padding:10px 14px; background:#fff5f5; border-radius:8px; border-left:3px solid var(--danger);">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" onclick="saveDoctor()">
                    <i class="bi bi-check-circle"></i> Save Doctor
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Delete All -->
<div class="modal fade" id="deleteAllModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border:none; border-radius:14px; overflow:hidden;">
            <div class="modal-title-bar" style="background:var(--danger);">
                <h5><i class="bi bi-exclamation-triangle"></i> Delete All Doctors</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="font-size:14px; color:var(--muted); margin-bottom:12px;">
                    <strong style="color:var(--danger);">⚠️ Warning:</strong> This will permanently delete ALL doctors.
                </p>
                <p style="font-size:13px; margin-bottom:8px;">Type <strong>DELETE ALL</strong> to confirm:</p>
                <input type="text" id="confirm-input" class="form-control" placeholder="Type DELETE ALL">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-danger-custom" id="confirm-delete-btn" disabled onclick="confirmDeleteAll()">
                    Delete ALL
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="border:none; border-radius:14px; overflow:hidden;">
            <div class="modal-title-bar">
                <h5><i class="bi bi-key-fill"></i> Change Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="cp-alert" style="display:none;" class="mb-3"></div>
                <div class="mb-3">
                    <label class="form-label-custom">Current Password or Master Reset Key</label>
                    <div class="pw-wrap">
                        <input type="password" class="form-control" id="pw_current"
                               placeholder="Current password or reset key" autocomplete="off">
                        <button type="button" class="pw-eye" onclick="togglePw('pw_current', this)" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div style="font-size:11px; color:#aaa; margin-top:4px;">
                        <i class="bi bi-info-circle"></i> Forgot password? Use the master reset key.
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">New Password</label>
                    <div class="pw-wrap">
                        <input type="password" class="form-control" id="pw_new"
                               placeholder="Enter password" autocomplete="new-password">
                        <button type="button" class="pw-eye" onclick="togglePw('pw_new', this)" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Confirm New Password</label>
                    <div class="pw-wrap">
                        <input type="password" class="form-control" id="pw_confirm"
                               placeholder="Repeat new password" autocomplete="new-password">
                        <button type="button" class="pw-eye" onclick="togglePw('pw_confirm', this)" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" onclick="savePassword()">
                    <i class="bi bi-check-circle"></i> Save Password
                </button>
            </div>
        </div>
    </div>
</div>

<?php if ($isSuperadmin): ?>
<!-- Add / Edit User -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none; border-radius:14px; overflow:hidden;">
            <div class="modal-title-bar">
                <h5 id="au-modal-title"><i class="bi bi-person-plus-fill"></i> Add User Account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="au-alert" style="display:none;" class="mb-3"></div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">Username</label>
                        <input type="text" class="form-control" id="au-username"
                               placeholder="Enter username" autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom" id="au-pw-label">Password</label>
                        <div class="pw-wrap">
                            <input type="password" class="form-control" id="au-password"
                                   placeholder="Enter password" autocomplete="new-password">
                            <button type="button" class="pw-eye" onclick="togglePw('au-password', this)" tabindex="-1">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div id="au-pw-hint" style="display:none; font-size:11px; color:var(--muted); margin-top:4px;">
                            <i class="bi bi-info-circle"></i> Leave blank to keep current password.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Role</label>
                        <select class="form-select" id="au-role">
                            <option value="0">Admin</option>
                            <option value="1">Super Admin</option>
                        </select>
                        <div style="font-size:11px; color:var(--muted); margin-top:4px;">
                            <i class="bi bi-info-circle"></i> Super Admin can manage user accounts and change passwords.
                        </div>
                    </div>
                    <div class="col-md-6" id="au-admin-pw-wrap" style="display:none;">
                        <label class="form-label-custom">Administrator Password <span style="color:var(--danger);">*</span></label>
                        <div class="pw-wrap">
                            <input type="password" class="form-control" id="au-admin-password"
                                   placeholder="Required to change password" autocomplete="off">
                            <button type="button" class="pw-eye" onclick="togglePw('au-admin-password', this)" tabindex="-1">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div style="font-size:11px; color:var(--muted); margin-top:4px;">
                            <i class="bi bi-shield-lock"></i> Enter the administrator password to confirm this change.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" id="au-submit-btn" onclick="submitUserModal()">
                    <i class="bi bi-check-circle"></i> Create Account
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Logout Confirmation -->
<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered" style="max-width:340px;">
        <div class="modal-content" style="border:none; border-radius:14px; overflow:hidden;">
            <div class="modal-title-bar" style="background:linear-gradient(135deg, #1e3a5f, #0052CC);">
                <h5><i class="bi bi-box-arrow-right"></i> Confirm Logout</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="text-align:center; padding:32px 24px;">
                <div style="font-size:16px; font-weight:700; margin-bottom:8px;">Are you sure you want to logout?</div>
                <div style="font-size:13px; color:var(--muted);">You will be redirected to the login page.</div>
            </div>
            <div class="modal-footer" style="justify-content:center; gap:10px; padding-bottom:24px; border:none;">
                <a href="logout.php" class="btn-danger-custom" style="padding:8px 22px; font-size:13px; text-decoration:none;">
                    <i class="bi bi-box-arrow-right"></i> Yes, Logout
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="padding:8px 22px; border-radius:10px; font-weight:600; font-size:13px;">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<div class="toast-wrap" id="toast-wrap"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ============================================================
//  State
// ============================================================
let allDoctors    = <?= json_encode($initialDoctors) ?>;
let editingId     = 0;
let sortCol       = -1;
let sortAsc       = true;
let editingUserId = 0;

const IS_SUPERADMIN = <?= $isSuperadmin ? 'true' : 'false' ?>;

const SPEED_LABELS = { 15: 'Slow', 25: 'Normal', 50: 'Fast' };
const PAUSE_LABELS = { 2000: '2 seconds', 3000: '3 seconds', 5000: '5 seconds', 8000: '8 seconds', 10000: '10 seconds' };

const PAGE_META = {
    dashboard   : { title: 'Dashboard',        sub: 'Overview of doctor availability' },
    doctors     : { title: 'Doctor List',       sub: 'Manage all doctor records' },
    display     : { title: 'Display Settings',  sub: 'Configure TV display scroll behavior' },
    users       : { title: 'User Accounts',     sub: 'Manage admin user accounts' },
    departments : { title: 'Specializations',   sub: 'Manage specialization list for the doctor form' },
};

// ============================================================
//  Utilities
// ============================================================

function escH(str) {
    return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function fmtDate(s) {
    if (!s) return '—';
    const [y, m, d] = s.split('-').map(Number);
    return new Date(y, m - 1, d).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: '2-digit' });
}

function badgeClass(label) {
    if (label === 'Available') return 'badge-available';
    if (label === 'No Clinic') return 'badge-noclinic';
    return 'badge-onleave';
}

function toast(message, isError = false) {
    const container = document.getElementById('toast-wrap');
    const el = document.createElement('div');
    el.className = 'toast-msg' + (isError ? ' err' : '');
    el.innerHTML = `<i class="bi ${isError ? 'bi-x-circle-fill' : 'bi-check-circle-fill'}"
                       style="color:${isError ? 'var(--danger)' : 'var(--success)'}"></i>${message}`;
    container.appendChild(el);
    setTimeout(() => el.remove(), 3200);
}

function showFormError(el, message) {
    el.textContent = message;
    el.style.display = 'block';
}

async function apiPost(data) {
    const fd = new FormData();
    for (const key in data) fd.append(key, data[key]);
    const res = await fetch(window.location.pathname, { method: 'POST', body: fd });
    return res.json();
}

// ============================================================
//  Sidebar
// ============================================================

let sidebarCollapsed = false;

function toggleSidebar() {
    sidebarCollapsed = !sidebarCollapsed;
    document.getElementById('sidebar').classList.toggle('collapsed', sidebarCollapsed);
    document.getElementById('mainContent').classList.toggle('sidebar-collapsed', sidebarCollapsed);
    document.getElementById('toggle-icon').className = sidebarCollapsed ? 'bi bi-chevron-right' : 'bi bi-chevron-left';
}

// ============================================================
//  Page navigation
// ============================================================

function showPage(page) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));

    document.getElementById('page-' + page)?.classList.add('active');
    document.getElementById('nav-'  + page)?.classList.add('active');

    const meta = PAGE_META[page] ?? {};
    document.getElementById('topbar-title').textContent = meta.title ?? page;
    document.getElementById('topbar-sub').textContent   = meta.sub   ?? '';

    if (page === 'users')       loadUsers();
    if (page === 'dashboard')   updateDashboard();
    if (page === 'departments') loadDepartmentsPage();
}

// ============================================================
//  Dashboard
// ============================================================

function updateDashboard() {
    const counts = {
        available : allDoctors.filter(d => d.label === 'Available').length,
        noclinic  : allDoctors.filter(d => d.label === 'No Clinic').length,
        onleave   : allDoctors.filter(d => d.label === 'On Leave').length,
    };

    document.getElementById('count-available').textContent = counts.available;
    document.getElementById('count-noclinic').textContent  = counts.noclinic;
    document.getElementById('count-onleave').textContent   = counts.onleave;

    const tbody  = document.getElementById('dashboard-tbody');
    const recent = allDoctors.slice(0, 8);

    if (!recent.length) {
        tbody.innerHTML = '<tr><td colspan="4" class="table-empty">No doctors yet</td></tr>';
        return;
    }

    tbody.innerHTML = recent.map(d => `
        <tr>
            <td style="font-weight:600;">${escH(d.name)}</td>
            <td>${escH(d.department ?? '')}</td>
            <td><span class="badge-status ${badgeClass(d.label)}">${escH(d.label)}</span></td>
            <td>${d.resume_date ? fmtDate(d.resume_date) : '<span style="color:#ccc;">—</span>'}</td>
        </tr>
    `).join('');
}

// ============================================================
//  Doctor table
// ============================================================

function renderTable(doctors) {
    const tbody = document.getElementById('doctor-tbody');

    if (!doctors.length) {
        tbody.innerHTML = `<tr><td colspan="7" class="table-empty">
            <i class="bi bi-inbox" style="font-size:2rem; display:block; margin-bottom:8px;"></i>
            No doctors found
        </td></tr>`;
        updateDashboard();
        return;
    }

    tbody.innerHTML = doctors.map(d => {
        const today      = new Date(); today.setHours(0,0,0,0);
        const resumePast = d.resume_date && new Date(d.resume_date) < today;
        const resumeHtml = d.resume_date
            ? `${fmtDate(d.resume_date)}${
                resumePast
                    ? (d.is_tentative ? '<span class="overdue-pill">⚠ OVERDUE — Review</span>' : '<span class="overdue-confirmed-pill">⚠ EXPIRED — Review</span>')
                    : d.is_tentative
                        ? '<span class="tentative-pill">TENTATIVE</span>'
                        : ''
              }`
            : '<span style="color:#ccc;">—</span>';

        const remarksHtml = (d.remarks && d.label === 'On Leave')
            ? escH(d.remarks)
            : '<span style="color:#ccc;">—</span>';

        return `
            <tr data-id="${d.id}"
                data-name="${escH(d.name.toLowerCase())}"
                data-dept="${escH((d.department ?? '').toLowerCase())}"
                data-status="${escH(d.label)}"
                data-date="${escH(d.resume_date ?? '')}"
                data-leave="${escH(d.remarks ?? '')}">
                <td><input type="checkbox" class="doctor-checkbox" value="${d.id}" onchange="updateDeleteBtn()"></td>
                <td style="font-weight:600;">${escH(d.name)}</td>
                <td>${escH(d.department ?? '')}</td>
                <td><span class="badge-status ${badgeClass(d.label)}">${escH(d.label)}</span></td>
                <td>${resumeHtml}</td>
                <td>${remarksHtml}</td>
                <td>
                    <button class="btn-icon btn-edit-sm"   onclick="openEditModal(${d.id})"><i class="bi bi-pencil"></i></button>
                    <button class="btn-icon btn-delete-sm" onclick="deleteOne(${d.id}, this)"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
        `;
    }).join('');

    filterTable();
    updateDeleteBtn();
    updateDashboard();
}

// ── Sorting ───────────────────────────────────────────────────────────────────

const SORT_KEYS = [null, 'name', 'department', 'label', 'resume_date', 'remarks'];

function sortTable(col) {
    sortAsc = (sortCol === col) ? !sortAsc : true;
    sortCol = col;

    for (let i = 1; i <= 5; i++) {
        const icon = document.getElementById('si-' + i);
        if (!icon) continue;
        if (i === col) {
            icon.className = 'bi ' + (sortAsc ? 'bi-arrow-up' : 'bi-arrow-down');
        } else {
            icon.className = 'bi bi-arrow-down-up';
            icon.style.opacity = '.5';
        }
    }

    const key = SORT_KEYS[col];
    allDoctors.sort((a, b) => {
        const va = (a[key] ?? '').toLowerCase();
        const vb = (b[key] ?? '').toLowerCase();
        return sortAsc ? va.localeCompare(vb) : vb.localeCompare(va);
    });

    renderTable(allDoctors);
}

// ── Filtering ─────────────────────────────────────────────────────────────────

function filterTable() {
    const search = (document.getElementById('global-search')?.value ?? '').toLowerCase().trim();
    const dept   = (document.getElementById('f-dept')?.value        ?? '').toLowerCase().trim();
    const status = (document.getElementById('f-status')?.value      ?? '').trim();

    document.querySelectorAll('#doctor-tbody tr').forEach(row => {
        if (!row.dataset.id) { row.style.display = ''; return; }

        const visible =
            (!search || row.dataset.name.includes(search)) &&
            (!dept   || row.dataset.dept.includes(dept))   &&
            (!status || row.dataset.status === status);

        row.style.display = visible ? '' : 'none';
    });
}

function clearAllFilters() {
    ['global-search'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
    ['f-dept', 'f-status'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
    filterTable();
}

// ── Doctor modal ──────────────────────────────────────────────────────────────

let allDepartments = <?= json_encode($deptList) ?>;

function populateDeptDropdowns() {
    const opts = allDepartments.map(d =>
        `<option value="${escH(d)}">${escH(d)}</option>`
    ).join('');

    const mDept = document.getElementById('m-dept');
    if (mDept) {
        const cur = mDept.value;
        mDept.innerHTML = '<option value="">Select Specialization</option>' + opts;
        if (cur) mDept.value = cur;
    }

    const fDept = document.getElementById('f-dept');
    if (fDept) {
        const cur = fDept.value;
        fDept.innerHTML = '<option value="">All Specializations</option>' + opts;
        if (cur) fDept.value = cur;
    }
}

const STATUS_MAP = {
    'on schedule'  : 'On Schedule',
    'available'    : 'On Schedule',
    'no medical'   : 'No Medical',
    'no clinic'    : 'No Medical',
    'not available': 'No Medical',
    'on leave'     : 'On Leave',
};

function toggleLeaveFields() {
    const isLeave = document.getElementById('m-status').value === 'On Leave';
    document.querySelectorAll('.leave-fields').forEach(el => el.style.display = isLeave ? '' : 'none');
    if (!isLeave) {
        document.getElementById('m-remarks').value    = '';
        document.getElementById('m-resume').value     = '';
        document.getElementById('m-tentative').checked = false;
    }
}

function showDoctorModal() {
    editingId = 0;
    document.getElementById('doctorModalTitle').innerHTML = '<i class="bi bi-plus-circle"></i> Add New Doctor';
    document.getElementById('m-name').value    = '';
    document.getElementById('m-resume').value  = '';
    document.getElementById('m-dept').value    = '';
    document.getElementById('m-status').value  = 'On Schedule';
    document.getElementById('m-tentative').checked = false;
    document.getElementById('m-remarks').value = '';
    document.getElementById('form-error').style.display = 'none';
    toggleLeaveFields();
    new bootstrap.Modal(document.getElementById('doctorModal')).show();
}

function openEditModal(id) {
    const doctor = allDoctors.find(d => d.id == id);
    if (!doctor) return;

    editingId = id;
    const mappedStatus = STATUS_MAP[(doctor.status ?? '').toLowerCase().trim()] ?? 'On Schedule';

    document.getElementById('doctorModalTitle').innerHTML = '<i class="bi bi-pencil"></i> Edit Doctor';
    document.getElementById('m-name').value    = doctor.name;
    document.getElementById('m-dept').value    = doctor.department ?? '';
    document.getElementById('m-status').value  = mappedStatus;
    document.getElementById('m-resume').value  = doctor.resume_date ?? '';
    document.getElementById('m-tentative').checked = doctor.is_tentative == 1;
    document.getElementById('form-error').style.display = 'none';
    toggleLeaveFields();
    document.getElementById('m-remarks').value = doctor.remarks ?? '';

    new bootstrap.Modal(document.getElementById('doctorModal')).show();
}

async function saveDoctor() {
    const name      = document.getElementById('m-name').value.trim().toUpperCase();
    const dept      = document.getElementById('m-dept').value.toUpperCase();
    const status    = document.getElementById('m-status').value;
    const resume    = document.getElementById('m-resume').value;
    const tentative = document.getElementById('m-tentative').checked ? 1 : 0;
    const remarks   = document.getElementById('m-remarks').value;
    const errEl     = document.getElementById('form-error');

    errEl.style.display = 'none';

    if (!name)   { showFormError(errEl, 'Doctor name is required.'); return; }
    if (!dept)   { showFormError(errEl, 'Please select a specialization.'); return; }
    if (!status) { showFormError(errEl, 'Please select a status.'); return; }
    if (status === 'On Leave' && !resume)  { showFormError(errEl, 'Resume date is required for On Leave.'); return; }
    if (status === 'On Leave' && !remarks) { showFormError(errEl, 'Please select a leave type.'); return; }

    const payload = { ajax: 'save_doctor', id: editingId, name, department: dept, status, resume_date: resume, remarks };
    if (tentative) payload.is_tentative = '1';

    const res = await apiPost(payload);

    if (!res.ok) {
        errEl.textContent = res.error;
        errEl.style.display = 'block';
        return;
    }

    bootstrap.Modal.getInstance(document.getElementById('doctorModal'))?.hide();

    if (res.insert) {
        allDoctors.push(res.doctor);
    } else {
        const idx = allDoctors.findIndex(d => d.id == res.doctor.id);
        if (idx > -1) allDoctors[idx] = res.doctor;
    }

    renderTable(allDoctors);
    toast(res.insert ? 'Doctor added!' : 'Doctor updated!');
}

// ── Delete ────────────────────────────────────────────────────────────────────

async function deleteOne(id, btn) {
    if (!confirm('Delete this doctor?')) return;

    const res = await apiPost({ ajax: 'delete_doctor', id });
    if (!res.ok) { toast(res.error ?? 'Delete failed', true); return; }

    allDoctors = allDoctors.filter(d => d.id != id);

    const row = btn.closest('tr');
    row.style.transition = 'opacity .3s';
    row.style.opacity = '0';
    setTimeout(() => renderTable(allDoctors), 300);

    toast('Doctor deleted.');
}

function toggleSelectAll() {
    const checked = document.getElementById('select-all').checked;
    document.querySelectorAll('.doctor-checkbox').forEach(cb => cb.checked = checked);
    updateDeleteBtn();
}

function updateDeleteBtn() {
    const selected = document.querySelectorAll('.doctor-checkbox:checked').length;
    const btn = document.getElementById('delete-selected-btn');
    btn.style.display = selected > 0 ? 'inline-flex' : 'none';
    if (selected > 0) btn.innerHTML = `<i class="bi bi-trash"></i> Delete Selected (${selected})`;
    document.getElementById('select-all').checked =
        selected > 0 && selected === document.querySelectorAll('.doctor-checkbox').length;
}

async function deleteSelected() {
    const ids = Array.from(document.querySelectorAll('.doctor-checkbox:checked')).map(cb => cb.value);
    if (!ids.length) { toast('No doctors selected', true); return; }
    if (!confirm(`Delete ${ids.length} doctor(s)?`)) return;

    const res = await apiPost({ ajax: 'delete_selected', ids: JSON.stringify(ids) });
    if (!res.ok) { toast('Delete failed', true); return; }

    allDoctors = allDoctors.filter(d => !ids.includes(String(d.id)));
    renderTable(allDoctors);
    toast(`${ids.length} doctor(s) deleted.`);
}

function showDeleteAllModal() {
    document.getElementById('confirm-input').value = '';
    document.getElementById('confirm-delete-btn').disabled = true;
    new bootstrap.Modal(document.getElementById('deleteAllModal')).show();
}

document.getElementById('confirm-input').addEventListener('input', function () {
    document.getElementById('confirm-delete-btn').disabled = this.value !== 'DELETE ALL';
});

async function confirmDeleteAll() {
    if (document.getElementById('confirm-input').value !== 'DELETE ALL') return;
    if (!confirm('Are you absolutely sure?')) return;

    const res = await apiPost({ ajax: 'delete_all' });
    bootstrap.Modal.getInstance(document.getElementById('deleteAllModal'))?.hide();

    if (!res.ok) { toast('Delete failed', true); return; }
    allDoctors = [];
    renderTable([]);
    toast('All doctors deleted.');
}

// ============================================================
//  Display settings
// ============================================================

async function saveDisplaySettings() {
    const speed  = document.getElementById('set-speed').value;
    const top    = document.getElementById('set-top').value;
    const bottom = document.getElementById('set-bot').value;

    const res = await apiPost({ ajax: 'save_display', scroll_speed: speed, pause_at_top: top, pause_at_bottom: bottom });
    if (!res.ok) { toast('Failed to save', true); return; }

    document.getElementById('sum-speed').textContent = SPEED_LABELS[speed] ?? `${speed} px/s`;
    document.getElementById('sum-top').textContent   = PAUSE_LABELS[top]   ?? `${top / 1000} sec`;
    document.getElementById('sum-bot').textContent   = PAUSE_LABELS[bottom]?? `${bottom / 1000} sec`;

    toast('Display settings saved!');
}

// ============================================================
//  Password management
// ============================================================

function showChangePasswordModal() {
    ['pw_current', 'pw_new', 'pw_confirm'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('cp-alert').style.display = 'none';
    new bootstrap.Modal(document.getElementById('changePasswordModal')).show();
}

async function savePassword() {
    const current = document.getElementById('pw_current').value;
    const newPw   = document.getElementById('pw_new').value;
    const confirm = document.getElementById('pw_confirm').value;
    const alertEl = document.getElementById('cp-alert');
    alertEl.style.display = 'none';

    const res = await apiPost({ ajax: 'change_password', current_or_key: current, new_password: newPw, confirm_password: confirm });

    if (!res.ok) {
        alertEl.className = 'alert alert-danger py-2';
        alertEl.style.display = 'block';
        alertEl.innerHTML = `<i class="bi bi-x-circle-fill"></i> ${res.error}`;
        return;
    }

    alertEl.className = 'alert alert-success py-2';
    alertEl.style.display = 'block';
    alertEl.innerHTML = `<i class="bi bi-check-circle-fill"></i> ${res.message}`;
    setTimeout(() => bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'))?.hide(), 1500);
    toast('Password changed!');
}

function togglePw(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type    = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type    = 'password';
        icon.className = 'bi bi-eye';
    }
}

// ============================================================
//  User management
// ============================================================

async function loadUsers() {
    const res  = await fetch(window.location.pathname + '?ajax=users');
    const data = await res.json();
    if (!data.ok) return;
    renderUsersTable(data.users);
}

function renderUsersTable(users) {
    const tbody = document.getElementById('users-tbody');
    if (!users.length) {
        tbody.innerHTML = '<tr><td colspan="5" class="table-empty">No users found</td></tr>';
        return;
    }

    tbody.innerHTML = users.map((user, index) => `
        <tr>
            <td style="color:var(--muted);">${index + 1}</td>
            <td style="font-weight:600;">${escH(user.username)}</td>
            <td>
                <span class="user-row-badge ${user.is_superadmin == 1 ? 'badge-superadmin' : 'badge-admin'}">
                    ${user.is_superadmin == 1 ? '⭐ Super Admin' : 'Admin'}
                </span>
            </td>
            <td style="color:var(--muted); font-size:12px;">${user.created_at ?? '—'}</td>
            <td style="display:flex; gap:6px; align-items:center;">
                <button class="btn-icon btn-edit-sm"
                        onclick="showEditUserModal(${user.id}, '${escH(user.username)}', ${user.is_superadmin})">
                    <i class="bi bi-pencil"></i> Edit
                </button>
                ${user.is_superadmin == 1
                    ? '<span style="color:#ccc; font-size:12px;">Protected</span>'
                    : `<button class="btn-icon btn-delete-sm" onclick="deleteUser(${user.id}, '${escH(user.username)}')"><i class="bi bi-trash"></i> Delete</button>`
                }
            </td>
        </tr>
    `).join('');
}

function resetUserModal() {
    document.getElementById('au-username').value              = '';
    document.getElementById('au-password').value              = '';
    document.getElementById('au-admin-password').value        = '';
    document.getElementById('au-admin-pw-wrap').style.display = 'none';
    document.getElementById('au-alert').style.display         = 'none';
    document.getElementById('au-role').value                  = '0';
}

function onUserPasswordInput() {
    if (editingUserId === 0) return;
    const hasNewPassword = this.value.trim() !== '';
    document.getElementById('au-admin-pw-wrap').style.display = hasNewPassword ? '' : 'none';
    if (!hasNewPassword) document.getElementById('au-admin-password').value = '';
}

function showAddUserModal() {
    editingUserId = 0;
    resetUserModal();
    document.getElementById('au-modal-title').innerHTML  = '<i class="bi bi-person-plus-fill"></i> Add User Account';
    document.getElementById('au-submit-btn').innerHTML   = '<i class="bi bi-check-circle"></i> Create Account';
    document.getElementById('au-password').placeholder  = 'Enter password';
    document.getElementById('au-pw-label').textContent  = 'Password';
    document.getElementById('au-pw-hint').style.display = 'none';
    new bootstrap.Modal(document.getElementById('addUserModal')).show();
}

function showEditUserModal(id, username, isSuperadmin) {
    editingUserId = id;
    resetUserModal();
    document.getElementById('au-modal-title').innerHTML  = '<i class="bi bi-pencil-fill"></i> Edit User Account';
    document.getElementById('au-submit-btn').innerHTML   = '<i class="bi bi-check-circle"></i> Save Changes';
    document.getElementById('au-username').value         = username;
    document.getElementById('au-password').placeholder  = 'Leave blank to keep current';
    document.getElementById('au-pw-label').textContent  = 'New Password';
    document.getElementById('au-pw-hint').style.display = 'block';
    document.getElementById('au-role').value             = isSuperadmin == 1 ? '1' : '0';
    new bootstrap.Modal(document.getElementById('addUserModal')).show();
}

async function submitUserModal() {
    const username      = document.getElementById('au-username').value.trim();
    const password      = document.getElementById('au-password').value.trim();
    const adminPassword = document.getElementById('au-admin-password').value.trim();
    const role          = document.getElementById('au-role').value;
    const alertEl       = document.getElementById('au-alert');
    alertEl.style.display = 'none';

    const action  = editingUserId === 0 ? 'add_user' : 'edit_user';
    const payload = { ajax: action, username, password, role };
    if (editingUserId !== 0) {
        payload.id = editingUserId;
        if (password) payload.admin_password = adminPassword;
    }

    const res = await apiPost(payload);

    if (!res.ok) {
        alertEl.className = 'alert alert-danger py-2';
        alertEl.style.display = 'block';
        alertEl.innerHTML = `<i class="bi bi-x-circle-fill"></i> ${res.error}`;
        return;
    }

    bootstrap.Modal.getInstance(document.getElementById('addUserModal'))?.hide();
    toast(editingUserId === 0 ? `User "${username}" created!` : `User "${username}" updated!`);
    loadUsers();
}

async function deleteUser(id, name) {
    if (!confirm(`Delete user "${name}"? They will no longer be able to log in.`)) return;

    const res = await apiPost({ ajax: 'delete_user', id });
    if (!res.ok) { toast(res.error ?? 'Delete failed', true); return; }

    toast(`User "${name}" deleted.`);
    loadUsers();
}

function showLogoutModal() {
    new bootstrap.Modal(document.getElementById('logoutModal')).show();
}

// ============================================================
//  Background polling (users table)
// ============================================================

let lastUsersHash = '';

async function pollUsers() {
    if (!IS_SUPERADMIN) return;
    try {
        const res  = await fetch(window.location.pathname + '?ajax=users');
        const data = await res.json();
        if (!data.ok) return;

        const hash = JSON.stringify(data.users);
        if (hash === lastUsersHash) return;
        lastUsersHash = hash;

        if (document.getElementById('users-tbody')) {
            renderUsersTable(data.users);
        }
    } catch (e) { /* fail silently */ }
}

// ============================================================
//  Departments page
// ============================================================

async function loadDepartmentsPage() {
    const res  = await fetch(window.location.pathname + '?ajax=departments');
    const data = await res.json();
    if (!data.ok) return;
    renderDeptTable(data.departments);
}

function renderDeptTable(depts) {
    const tbody = document.getElementById('dept-tbody');
    if (!depts.length) {
        tbody.innerHTML = '<tr><td colspan="3" class="table-empty">No departments yet. Add one above.</td></tr>';
        return;
    }
    tbody.innerHTML = depts.map((d, i) => `
        <tr>
            <td style="color:var(--muted);">${i + 1}</td>
            <td style="font-weight:600;">${escH(d.name)}</td>
            <td>
                <button class="btn-icon btn-delete-sm" onclick="deleteDepartment(${d.id}, '${escH(d.name)}')">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

async function addDepartment() {
    const input = document.getElementById('dept-new-name');
    const errEl = document.getElementById('dept-error');
    const name  = input.value.trim().toUpperCase();

    errEl.style.display = 'none';

    if (!name) {
        errEl.textContent   = 'Specialization name is required.';
        errEl.style.display = 'block';
        return;
    }

    const res = await apiPost({ ajax: 'add_department', name });

    if (!res.ok) {
        errEl.textContent   = res.error;
        errEl.style.display = 'block';
        return;
    }

    input.value = '';

    if (!allDepartments.includes(res.name)) {
        allDepartments.push(res.name);
        allDepartments.sort();
        populateDeptDropdowns();
    }

    loadDepartmentsPage();
    toast(`Department "${res.name}" added!`);
}

async function deleteDepartment(id, name) {
    if (!confirm(`Delete department "${name}"?\n\nThis will fail if doctors are still assigned to it.`)) return;

    const res = await apiPost({ ajax: 'delete_department', id });

    if (!res.ok) {
        toast(res.error, true);
        return;
    }

    allDepartments = allDepartments.filter(d => d !== name);
    populateDeptDropdowns();

    loadDepartmentsPage();
    toast(`Department "${name}" deleted.`);
}

// ============================================================
//  Init
// ============================================================

renderTable(allDoctors);
updateDashboard();

if (IS_SUPERADMIN) {
    loadUsers();
    setInterval(pollUsers, 5000);
    document.getElementById('au-password').addEventListener('input', onUserPasswordInput);
}
</script>
</body>
</html>