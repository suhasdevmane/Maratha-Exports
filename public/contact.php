<?php
// Database connection
$host = 'db5019237995.hosting-data.io';
$dbname = 'dbs15094906';
$username = 'dbu2567436';
$password = 'MarathaDB2025!Secure';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . $e->getMessage()]);
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON input
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Check if data is wrapped in 'values' key (as sent by the React app)
    if (isset($data['values'])) {
        $data = $data['values'];
    }

    $firstName = $data['firstName'] ?? '';
    $lastName = $data['lastName'] ?? '';
    $name = trim("$firstName $lastName");
    $email = $data['email'] ?? '';
    $phone = $data['phone'] ?? '';
    $messageRaw = $data['message'] ?? '';
    
    // Append phone to message since the database table doesn't have a phone column
    $message = "Phone: $phone\n\nMessage:\n$messageRaw";
    
    try {
        $sql = "INSERT INTO inquiries (name, email, message, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $message]);
        
        echo json_encode(["success" => true, "message" => "Thank you! We'll contact you soon."]);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}
?>
