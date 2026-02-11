<?php
/**
 * AgroPan API — Create Warning
 * 
 * Creates a new emergency alert / warning issued by an admin.
 * After a successful insert, emails all active subscribers.
 *
 * Method : POST
 * URL    : /API/create/warnings.php
 *
 * Request body (JSON):
 * {
 *   "title"      : "Flood Warning",
 *   "details"    : "Heavy rainfall expected in Terai region...",
 *   "timestamp"  : "2026-02-11 07:00:00",
 *   "valid_till" : "2026-02-13 07:00:00"
 * }
 */

require_once __DIR__ . '/../database.php';

// ── Read input ──
$input = getJsonInput();

$required = ['title', 'details', 'timestamp', 'valid_till'];
foreach ($required as $field) {
    if (empty($input[$field])) {
        sendResponse(400, false, "Missing required field: $field");
    }
}

// ── Insert warning ──
// TODO: Write the INSERT query here

// ── Notify subscribers ──
// After successful INSERT, email all active subscribers about the emergency alert
// notifyAllSubscribers($pdo,
//     '⚠️ AgroPan Emergency Alert — ' . $input['title'],
//     "An emergency alert has been issued:\n\n"
//     . "Title      : " . $input['title']      . "\n"
//     . "Details    : " . $input['details']     . "\n"
//     . "Issued at  : " . $input['timestamp']   . "\n"
//     . "Valid till : " . $input['valid_till']
// );

// sendResponse(201, true, 'Emergency alert created and subscribers notified');
