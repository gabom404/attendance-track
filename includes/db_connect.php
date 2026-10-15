<?php
/**
 * AttendanceTrack - Central Database Connection
 */

$root_config = dirname(__DIR__) . '/config.php';
if (file_exists($root_config)) {
    require_once $root_config;
}

if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'attendancetrack_db');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'root');
if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
if (!defined('DB_CHARSET')) define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');
if (!defined('AUTH_SALT')) define('AUTH_SALT', getenv('AUTH_SALT') ?: 'attendancetrack_salt');
if (!defined('ADMIN_SECURITY_KEY')) define('ADMIN_SECURITY_KEY', getenv('ADMIN_SECURITY_KEY') ?: 'AttendanceTrack2024!$');

$conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    // If DB is not available yet, die gracefully with JSON or message depending on caller
    if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
        header('Content-Type: application/json');
        echo json_encode(["status" => "error", "message" => "Database connection error. Please verify config.php."]);
        exit;
    }
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, DB_CHARSET);
