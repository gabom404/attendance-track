<?php
/**
 * AttendanceTrack - Smart Attendance & Shift Control
 * Database Configuration Template
 * 
 * Instructions:
 * 1. Duplicate this file as `config.php` in the root directory.
 * 2. Update credentials below according to your local or production database environment.
 * 3. `config.php` is ignored by version control to protect credentials.
 */

define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'attendancetrack_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');

// Default security salt for user passwords
define('AUTH_SALT', getenv('AUTH_SALT') ?: 'attendancetrack_salt');

// Master administration key for administrative password overrides
// Set a long random value; leave empty to disable the admin password override.
define('ADMIN_SECURITY_KEY', getenv('ADMIN_SECURITY_KEY') ?: '');
