<?php
// ============================================================
//  View — Layout Head  (New Sinai MDI Hospital Admin)
//  Outputs everything from <!DOCTYPE> through the topbar.
//  Expects: $currentUsername, $isSuperadmin
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSMDIH MAB-IS - Admin</title>
    <link rel="icon" type="image/png" href="../display/assets/logo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================================
           Design tokens
        ============================================================ */
        :root {
            --primary:          #0052CC;
            --primary-light:    #1e88e5;
            --primary-dark:     #003d99;
            --accent:           #ffc107;
            --success:          #22c55e;
            --danger:           #ef4444;
            --warning:          #f59e0b;
            --sidebar-w:        260px;
            --sidebar-collapsed:68px;
            --bg:               #f0f4f8;
            --surface:          #ffffff;
            --border:           #e2e8f0;
            --text:             #0f172a;
            --muted:            #64748b;
            --radius:           12px;
            --transition:       0.22s cubic-bezier(0.4,0,0.2,1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 60%, var(--primary-light) 100%);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 200;
            transition: width var(--transition);
            overflow: hidden;
            box-shadow: 4px 0 24px rgba(0,52,153,0.18);
        }
        .sidebar.collapsed { width: var(--sidebar-collapsed); }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            min-height: 80px;
            overflow: hidden;
            white-space: nowrap;
        }
        .sidebar-logo {
            width: 38px; height: 38px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
            background: rgba(255,255,255,0.15);
            padding: 2px;
        }
        .sidebar-brand-text {
            opacity: 1;
            transition: opacity var(--transition);
            overflow: hidden;
        }
        .sidebar.collapsed .sidebar-brand-text { opacity: 0; pointer-events: none; }
        .brand-name { font-size: 13px; font-weight: 800; color: white; line-height: 1.2; }
        .brand-sub  { font-size: 10px; font-weight: 500; color: rgba(255,255,255,0.65); margin-top: 3px; display: block; }

        .sidebar-nav { flex: 1; padding: 16px 8px; display: flex; flex-direction: column; gap: 4px; overflow: hidden; }

        .nav-section-label {
            font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.4);
            text-transform: uppercase; letter-spacing: 1px;
            padding: 8px 10px 4px;
            white-space: nowrap;
            opacity: 1;
            transition: opacity var(--transition);
        }
        .sidebar.collapsed .nav-section-label { opacity: 0; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 12px;
            border-radius: 10px;
            cursor: pointer;
            color: rgba(255,255,255,0.75);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition);
            white-space: nowrap;
            overflow: hidden;
            position: relative;
        }
        .nav-item:hover  { background: rgba(255,255,255,0.12); color: white; }
        .nav-item.active { background: rgba(255,255,255,0.2);  color: white; }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 20%;
            height: 60%; width: 3px;
            background: var(--accent);
            border-radius: 0 3px 3px 0;
        }
        .nav-item i     { font-size: 18px; flex-shrink: 0; width: 22px; text-align: center; }
        .nav-label      { opacity: 1; transition: opacity var(--transition); }
        .sidebar.collapsed .nav-label { opacity: 0; }

        .sidebar-toggle {
            margin: 8px;
            align-self: flex-end;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px; height: 36px;
            border-radius: 8px;
            border: none;
            background: rgba(255,255,255,0.12);
            color: white;
            cursor: pointer;
            font-size: 16px;
            flex-shrink: 0;
            transition: background var(--transition);
        }
        .sidebar-toggle:hover { background: rgba(255,255,255,0.22); }

        .sidebar-footer {
            padding: 12px 8px;
            border-top: 1px solid rgba(255,255,255,0.12);
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        /* ── Main content ── */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            transition: margin-left var(--transition);
            display: flex;
            flex-direction: column;
        }
        .main-content.sidebar-collapsed { margin-left: var(--sidebar-collapsed); }

        /* ── Top bar ── */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .page-title  { font-size: 18px; font-weight: 700; color: var(--text); }
        .page-breadcrumb { font-size: 12px; color: var(--muted); margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .user-pill {
            display: flex; align-items: center; gap: 10px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 40px;
            padding: 6px 14px 6px 6px;
        }
        .user-avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 14px; font-weight: 700;
        }
        .user-name { font-size: 13px; font-weight: 600; color: var(--text); }
        .user-role { font-size: 10px; color: var(--muted); }

        /* ── Pages ── */
        .page        { padding: 28px; flex: 1; display: none; }
        .page.active { display: block; }

        /* ── Stats grid ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: var(--surface);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 18px;
            border: 1px solid var(--border);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }
        .stat-card.available::after { background: linear-gradient(90deg, #22c55e, #16a34a); }
        .stat-card.noclinic::after  { background: linear-gradient(90deg, #6b7280, #4b5563); }
        .stat-card.onleave::after   { background: linear-gradient(90deg, #ef4444, #dc2626); }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }

        .stat-icon {
            width: 56px; height: 56px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; flex-shrink: 0;
        }
        .stat-card.available .stat-icon { background: rgba(34,197,94,0.12); color: #22c55e; }
        .stat-card.noclinic  .stat-icon { background: rgba(107,114,128,0.12); color: #6b7280; }
        .stat-card.onleave   .stat-icon { background: rgba(239,68,68,0.12); color: #ef4444; }

        .stat-count { font-size: 36px; font-weight: 800; line-height: 1; }
        .stat-label { font-size: 13px; font-weight: 600; color: var(--muted); margin-top: 4px; }

        /* ── Section card ── */
        .section-card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid var(--border);
            margin-bottom: 24px;
            overflow: hidden;
        }
        .section-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .section-card-title {
            font-size: 16px; font-weight: 700;
            display: flex; align-items: center; gap: 8px;
        }
        .section-card-title i { color: var(--primary); }
        .section-card-body { padding: 24px; }

        /* ── Tables ── */
        .table-responsive { overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead th {
            background: #f8faff; color: var(--muted);
            font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px;
            padding: 12px 16px; border-bottom: 2px solid var(--border);
            white-space: nowrap; cursor: pointer; user-select: none;
        }
        .data-table thead th:hover { color: var(--primary); }
        .data-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background var(--transition); }
        .data-table tbody tr:hover { background: #f8faff; }
        .data-table tbody td { padding: 14px 16px; font-size: 14px; vertical-align: middle; }
        .table-empty { text-align: center; padding: 48px; color: var(--muted); }

        /* ── Status badges ── */
        .badge-status {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700;
        }
        .badge-status::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .badge-available { color: #16a34a; background: rgba(34,197,94,0.12); }
        .badge-noclinic  { color: #6b7280; background: rgba(107,114,128,0.12); }
        .badge-onleave   { color: #dc2626; background: rgba(239,68,68,0.12); }

        /* ── Buttons ── */
        .btn-icon { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; transition: all var(--transition); display: inline-flex; align-items: center; gap: 5px; }
        .btn-edit-sm   { background: #eff6ff; color: var(--primary); }
        .btn-edit-sm:hover   { background: var(--primary); color: white; }
        .btn-delete-sm { background: #fff5f5; color: var(--danger); }
        .btn-delete-sm:hover { background: var(--danger); color: white; }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white; border: none; border-radius: 10px;
            padding: 10px 18px; font-size: 13px; font-weight: 700;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
            transition: all var(--transition);
        }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,82,204,0.35); }

        .btn-danger-custom {
            background: var(--danger); color: white; border: none; border-radius: 10px;
            padding: 10px 18px; font-size: 13px; font-weight: 700;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
            transition: all var(--transition);
        }
        .btn-danger-custom:hover { background: #dc2626; transform: translateY(-2px); }

        /* ── Filter bar ── */
        .filter-bar { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .filter-bar .form-control,
        .filter-bar .form-select {
            border: 1.5px solid var(--border); border-radius: 8px;
            padding: 8px 12px; font-size: 13px; font-family: inherit; outline: none;
            transition: border-color var(--transition);
        }
        .filter-bar .form-control:focus,
        .filter-bar .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0,82,204,0.1);
        }
        .search-wrap { position: relative; }
        .search-wrap i { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 14px; pointer-events: none; }
        .search-wrap input { padding-left: 32px !important; }
        .btn-clear {
            background: #f1f5f9; border: 1.5px solid var(--border); color: var(--muted);
            border-radius: 8px; padding: 8px 12px; font-size: 13px; cursor: pointer;
            transition: all var(--transition);
        }
        .btn-clear:hover { border-color: var(--danger); color: var(--danger); background: #fff5f5; }

        /* ── Tentative / overdue pills ── */
        .tentative-pill {
            display: inline-block;
            color: #000000;
            font-size: 10px; font-weight: 700;
            margin-left: 6px;
        }
        .overdue-pill {
            display: inline-block;
            background: rgba(220,53,69,0.12); color: #b91c1c;
            padding: 2px 8px; border-radius: 4px;
            font-size: 10px; font-weight: 700;
            margin-left: 6px;
            border: 1px dashed rgba(220,53,69,0.5);
            animation: pulse-overdue 1.6s ease-in-out infinite;
        }
        .overdue-confirmed-pill {
            display: inline-block;
            background: rgba(217,119,6,0.12); color: #92400e;
            padding: 2px 8px; border-radius: 4px;
            font-size: 10px; font-weight: 700;
            margin-left: 6px;
            border: 1px dashed rgba(217,119,6,0.5);
            animation: pulse-overdue 1.6s ease-in-out infinite;
        }
        @keyframes pulse-overdue {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.5; }
        }

        /* ── Modal internals ── */
        .modal .form-control,
        .modal .form-select {
            border: 1.5px solid var(--border); border-radius: 8px;
            padding: 10px 14px; font-size: 14px; font-family: inherit; outline: none;
            transition: all var(--transition); width: 100%;
        }
        .modal .form-control:focus,
        .modal .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0,82,204,0.1);
        }
        .modal-title-bar {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white; padding: 18px 24px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .modal-title-bar h5 { font-size: 16px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
        .modal-body   { padding: 24px; }
        .modal-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }

        .form-label-custom { font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; display: block; }

        /* ── Uppercase inputs ── */
        #m-name, #dept-new-name { text-transform: uppercase; }

        /* ── Password eye toggle ── */
        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 40px !important; }
        .pw-eye { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #aaa; cursor: pointer; font-size: 16px; transition: color .15s; }
        .pw-eye:hover { color: var(--primary); }

        /* ── Display settings ── */
        .settings-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px; }
        .settings-grid label { font-size: 12px; font-weight: 700; color: var(--muted); display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
        .setting-select {
            width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 10px 36px 10px 14px;
            font-size: 14px; font-weight: 600; color: var(--primary); background: white;
            appearance: none; cursor: pointer; font-family: inherit; outline: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='%230052CC' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 12px center;
            transition: border-color var(--transition);
        }
        .setting-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(0,82,204,0.1); }
        .setting-hint { font-size: 11px; color: var(--muted); margin-top: 4px; }
        .summary-row {
            display: flex; flex-wrap: wrap; gap: 20px; align-items: center;
            padding: 14px 18px; background: #f0f4ff; border-radius: 10px;
            border-left: 3px solid var(--primary); margin-top: 16px;
        }
        .summary-item .s-lbl { font-size: 10px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; }
        .summary-item .s-val { font-size: 18px; font-weight: 800; color: var(--primary); }

        /* ── Toast notifications ── */
        .toast-wrap { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 8px; }
        .toast-msg {
            background: white; border-radius: 10px; padding: 12px 18px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15); font-size: 13px; font-weight: 600;
            display: flex; align-items: center; gap: 8px;
            animation: slideUp .22s ease;
            border-left: 4px solid var(--success);
            font-family: inherit;
        }
        .toast-msg.err { border-left-color: var(--danger); }
        @keyframes slideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }

        /* ── User management ── */
        .user-row-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .badge-superadmin { background: rgba(245,158,11,0.15); color: #92400e; }
        .badge-admin      { background: rgba(0,82,204,0.1);    color: var(--primary); }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar          { width: var(--sidebar-collapsed); }
            .main-content     { margin-left: var(--sidebar-collapsed); }
            .stats-grid       { grid-template-columns: 1fr; }
            .topbar           { padding: 0 16px; }
            .page             { padding: 16px; }
        }
    </style>
</head>
<body>

<!-- ============================================================
     SIDEBAR
============================================================ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <img src="../display/assets/logo2.png" alt="Logo" class="sidebar-logo">
        <div class="sidebar-brand-text">
            <span class="brand-name">New Sinai MDI Hospital</span>
            <span class="brand-sub"><?= $isSuperadmin ? 'Super Admin' : 'Admin Panel' ?></span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <span class="nav-section-label">Main</span>
        <a class="nav-item active" id="nav-dashboard" onclick="showPage('dashboard')">
            <i class="bi bi-grid-1x2-fill"></i>
            <span class="nav-label">Dashboard</span>
        </a>
        <a class="nav-item" id="nav-doctors" onclick="showPage('doctors')">
            <i class="bi bi-person-lines-fill"></i>
            <span class="nav-label">Doctor List</span>
        </a>

        <?php if ($isSuperadmin): ?>
        <span class="nav-section-label">Administration</span>
        <a class="nav-item" id="nav-users" onclick="showPage('users')">
            <i class="bi bi-people-fill"></i>
            <span class="nav-label">User Accounts</span>
        </a>
        <?php endif; ?>
        <a class="nav-item" id="nav-departments" onclick="showPage('departments')">
            <i class="bi bi-diagram-3-fill"></i>
            <span class="nav-label">Specializations</span>
        </a>

        <span class="nav-section-label">Settings</span>
        <a class="nav-item" id="nav-display" onclick="showPage('display')">
            <i class="bi bi-display"></i>
            <span class="nav-label">Display Settings</span>
        </a>
        <a class="nav-item" href="../display/index.php" target="_blank">
            <i class="bi bi-tv"></i>
            <span class="nav-label">Open Display</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <a class="nav-item" onclick="showLogoutModal()">
            <i class="bi bi-box-arrow-right"></i>
            <span class="nav-label">Logout</span>
        </a>
        <button class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle sidebar">
            <i class="bi bi-chevron-left" id="toggle-icon"></i>
        </button>
    </div>
</aside>

<!-- ============================================================
     MAIN CONTENT
============================================================ -->
<div class="main-content" id="mainContent">

    <!-- Top bar -->
    <div class="topbar">
        <div class="topbar-left">
            <div>
                <div class="page-title" id="topbar-title">Dashboard</div>
                <div class="page-breadcrumb" id="topbar-sub">Overview of doctor availability</div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="user-pill">
                <div class="user-avatar"><?= strtoupper(substr($currentUsername, 0, 1)) ?></div>
                <div>
                    <div class="user-name"><?= htmlspecialchars($currentUsername) ?></div>
                    <div class="user-role"><?= $isSuperadmin ? 'Super Admin' : 'Admin' ?></div>
                </div>
            </div>
        </div>
    </div>