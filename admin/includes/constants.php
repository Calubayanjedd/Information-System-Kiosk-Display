<?php
// ============================================================
//  Constants — New Sinai MDI Hospital Admin
//  All app-wide keys, labels, and lookup tables live here.
//  Edit this file when adding new leave types, speed options, etc.
// ============================================================

define('MASTER_RESET_KEY',   'Newsinaimdi#53');
define('ADMIN_PASSWORD_KEY', 'New@sinaimdi#53');

const LEAVE_TYPES = ['On Vacation', 'Personal', 'Sick Leave'];

const SPEED_LABELS = [
    15  => 'Slow',
    25  => 'Normal',
    50  => 'Fast',
];

const PAUSE_LABELS = [
    2000  => '2 seconds',
    3000  => '3 seconds',
    5000  => '5 seconds',
    8000  => '8 seconds',
    10000 => '10 seconds',
];