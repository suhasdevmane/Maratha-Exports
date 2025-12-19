<?php
$host = 'db5019237995.hosting-data.io';
$db   = 'dbs15094906';
$user = 'dbu2567436';
$pass = 'MarathaDB2025!Secure';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $link = new mysqli($host, $user, $pass, $db);
    $link->set_charset('utf8mb4');

    $sql = <<<SQL
CREATE TABLE IF NOT EXISTS inquiries (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
SQL;

    $link->query($sql);
    echo '<p>Table check complete (created if it was missing).</p>';
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo '<p>Database error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '</p>';
} finally {
    if (isset($link) && $link instanceof mysqli) {
        $link->close();
    }
}