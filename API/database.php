<?php
/**
 * AgroPan — Database Connection
 * 
 * Centralized PDO connection for all API endpoints.
 * Include this file at the top of every CRUD script:
 *   require_once __DIR__ . '/../database.php';
 * 
 * Uses PDO with prepared statements for SQL injection prevention.
 * Returns a $pdo connection object and a helper function for
 * sending JSON responses.
 */

// ── Database credentials ──
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'agropan');
define('DB_USER', 'root');
define('DB_PASS', '');          // Default XAMPP — no password
define('DB_CHARSET', 'utf8mb4');

// ── CORS & Headers ──
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// ── PDO Connection ──
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,   // Throw exceptions on error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // Return associative arrays
        PDO::ATTR_EMULATE_PREPARES => false,                    // Use real prepared statements
    ];

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $e->getMessage()
    ]);
    exit();
}

// ── Helper: Send JSON Response ──
/**
 * Sends a JSON response and terminates the script.
 *
 * @param int    $statusCode  HTTP status code (200, 201, 400, 404, 500)
 * @param bool   $success     Whether the operation succeeded
 * @param string $message     Human-readable message
 * @param array  $data        Optional data payload
 */
function sendResponse(int $statusCode, bool $success, string $message, array $data = []): void
{
    http_response_code($statusCode);
    $response = [
        'success' => $success,
        'message' => $message,
    ];
    if (!empty($data)) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit();
}

// ── Helper: Get JSON Input ──
/**
 * Reads and decodes the raw JSON request body.
 *
 * @return array  Decoded JSON as associative array (empty array if no body)
 */
function getJsonInput(): array
{
    $raw = file_get_contents('php://input');
    if (empty($raw)) {
        return [];
    }
    $decoded = json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        sendResponse(400, false, 'Invalid JSON input: ' . json_last_error_msg());
    }
    return $decoded;
}

// ── Helper: Send Email Notification ──
/**
 * Sends an email notification to all active subscribers in the emails table.
 * Called by create/data.php (new sensor data) and create/warnings.php (new alert).
 *
 * @param PDO    $pdo     Database connection
 * @param string $subject Email subject line
 * @param string $body    Email body (plain text)
 */
function notifyAllSubscribers(PDO $pdo, string $subject, string $body): void
{
    try {
        $stmt = $pdo->query("SELECT email, name FROM emails WHERE is_active = 1");
        $subscribers = $stmt->fetchAll();

        if (empty($subscribers)) {
            return; // No active subscribers
        }

        $headers = "From: AgroPan Alerts <noreply@agropan.com>\r\n";
        $headers .= "Reply-To: noreply@agropan.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        foreach ($subscribers as $subscriber) {
            $personalBody = "Hello " . $subscriber['name'] . ",\n\n" . $body;
            $personalBody .= "\n\n---\nAgroPan — Nepal's Smart Agriculture Platform\n";
            $personalBody .= "To unsubscribe, contact admin@agropan.com";

            @mail($subscriber['email'], $subject, $personalBody, $headers);
        }
    } catch (PDOException $e) {
        // Silently fail — email notification should not break the main operation
        error_log('AgroPan email notification error: ' . $e->getMessage());
    }
}
