<?php
$host = 'db5019237995.hosting-data.io';
$db   = 'dbs15094906';
$user = 'dbu2567436';
$pass = 'MarathaDB2025!Secure';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $link = new mysqli($host, $user, $pass, $db);
    $link->set_charset('utf8mb4');

    $stmt = $link->prepare(
        "SELECT COUNT(*) AS cnt
         FROM information_schema.tables
         WHERE table_schema = ?
           AND table_name = 'inquiries'"
    );
    $stmt->bind_param('s', $db);
    $stmt->execute();
    $stmt->bind_result($tableCount);
    $stmt->fetch();
    $stmt->close();

    if ($tableCount === 0) {
        echo '<p>The table <strong>inquiries</strong> does <strong>NOT</strong> exist.</p>';
    } else {
        $result = $link->query("SELECT COUNT(*) AS rowsCnt FROM inquiries");
        $rowsCnt = $result->fetch_assoc()['rowsCnt'] ?? 0;
        echo '<p>The table <strong>inquiries</strong> exists. Rows stored: <strong>' . $rowsCnt . '</strong></p>';
    }
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo '<p>Database error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '</p>';
} finally {
    if (isset($link) && $link instanceof mysqli) {
        $link->close();
    }
}