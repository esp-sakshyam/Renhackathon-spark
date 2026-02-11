<?php
/**
 * AgroPan API — Create Data
 * 
 * Inserts a new sensor reading from an IoT device.
 * After a successful insert, emails all active subscribers.
 *
 * Method : POST
 * URL    : /API/create/data.php
 *
 * Request body (JSON):
 * {
 *   "timestamp"   : "2026-02-11 07:00:00",
 *   "temperature" : "28.5",
 *   "moisture"    : "65",
 *   "humidity"    : "72",
 *   "gases"       : "12",
 *   "nitrogen"    : "40",
 *   "device"      : "Device-A1"
 * }
 */

require_once __DIR__ . '/../database.php';

// ── Read input ──
$input = getJsonInput();

$required = ['timestamp', 'temperature', 'moisture', 'humidity', 'gases', 'nitrogen', 'device'];
foreach ($required as $field) {
    if (empty($input[$field])) {
        sendResponse(400, false, "Missing required field: $field");
    }
}

// ── Insert sensor data ──
// TODO: Write the INSERT query here

// ── Notify subscribers ──
// After successful INSERT, email all active subscribers about new sensor data
// notifyAllSubscribers($pdo,
//     'AgroPan — New Sensor Data Received',
//     "New sensor data has been recorded:\n\n"
//     . "Device      : " . $input['device']      . "\n"
//     . "Temperature : " . $input['temperature']  . " °C\n"
//     . "Moisture    : " . $input['moisture']     . " %\n"
//     . "Humidity    : " . $input['humidity']      . " %\n"
//     . "Gases       : " . $input['gases']         . " ppm\n"
//     . "Nitrogen    : " . $input['nitrogen']      . " mg/kg\n"
//     . "Timestamp   : " . $input['timestamp']
// );

// sendResponse(201, true, 'Sensor data recorded and subscribers notified');
