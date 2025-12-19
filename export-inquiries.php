<?php
$host = 'db5019237995.hosting-data.io';
$db   = 'dbs15094906';
$user = 'dbu2567436';
$pass = 'MarathaDB2025!Secure';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $link = new mysqli($host, $user, $pass, $db);
    $link->set_charset('utf8mb4');

    $sql = "SELECT id, name, email, message, created_at
            FROM inquiries
            ORDER BY created_at DESC";
    $result = $link->query($sql);

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    $timestamp = date('Ymd_His');
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="inquiries_' . $timestamp . '.json"');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

    echo json_encode([
        'exported_at' => date('c'),
        'count'       => count($rows),
        'data'        => $rows,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Database error: ' . $e->getMessage();
} finally {
    if (isset($link) && $link instanceof mysqli) {
        $link->close();
    }
}