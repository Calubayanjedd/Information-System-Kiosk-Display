project/
├── config/
│   ├── db.php                    (unchanged)
│   └── setup.php                 (unchanged)
├── admin/
│   ├── index.php                 (thin bootstrap — just wires everything together)
│   ├── login.php                 (unchanged)
│   ├── logout.php                (unchanged)
|   |
│   ├── includes/                 (PHP logic, never accessed directly)
│   │   ├── constants.php         (MASTER_RESET_KEY, LEAVE_TYPES, SPEED_LABELS, etc.)
│   │   ├── helpers.php           (resolveDoctorLabel, formatDoctorRow, jsonResponse, fmtDate)
│   │   ├── ajax_doctors.php      (ajaxGetDoctors, ajaxSaveDoctor, ajaxDeleteDoctor, etc.)
│   │   ├── ajax_users.php        (ajaxGetUsers, ajaxAddUser, ajaxEditUser, ajaxDeleteUser)
│   │   ├── ajax_departments.php  (ajaxGetDepartments, ajaxAddDepartment, ajaxDeleteDepartment)
│   │   ├── ajax_display.php      (ajaxSaveDisplay)
│   │   ├── ajax_password.php     (ajaxChangePassword)
│   │   └── router.php            (the match() blocks that dispatch GET/POST)
│   │
│   └── views/                    (HTML partials, included by index.php)
│       ├── layout_head.php       (<head>, CSS, opening <body>, sidebar, topbar)
│       ├── layout_foot.php       (modals, toast wrapper, JS, closing tags)
│       ├── page_dashboard.php    (stats grid + recent table)
│       ├── page_doctors.php      (doctor list + filter bar)
│       ├── page_display.php      (scroll settings form)
│       ├── page_users.php        (user accounts table)
│       └── page_departments.php  (departments table + add form)
│
└── display/
    └── index.php                 (unchanged)
