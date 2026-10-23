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
if (!defined('ADMIN_SECURITY_KEY')) define('ADMIN_SECURITY_KEY', getenv('ADMIN_SECURITY_KEY') ?: ''); // empty = admin override disabled

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

mysqli_set_charset($conn, DB_CHARSET);

if (!function_exists('safe_query')) {
    /**
     * Runs a parameterized query with mysqli prepared statements.
     * Returns a mysqli_result for SELECT-like statements, true for successful writes, false on error.
     */
    function safe_query(mysqli $conn, string $sql, array $params = [])
    {
        if (!$params) {
            return mysqli_query($conn, $sql);
        }
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            return false;
        }
        $types = '';
        $values = [];
        foreach ($params as $value) {
            // Missing request values were previously interpolated as '' - keep that behavior
            if ($value === null) {
                $value = '';
            }
            $types .= is_int($value) ? 'i' : (is_float($value) ? 'd' : 's');
            $values[] = $value;
        }
        mysqli_stmt_bind_param($stmt, $types, ...$values);
        if (!mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return false;
        }
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result === false ? true : $result;
    }
}
