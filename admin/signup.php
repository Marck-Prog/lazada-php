<?php
session_start();
require_once "config.php";

// Validate CSRF token
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => "Invalid CSRF token"]);
    exit();
}

// Custom sanitization function for username
function sanitizeUsername($input) {
    $input = trim($input); // Remove whitespace
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // Prevent XSS by escaping HTML characters
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitizeUsername($_POST["username"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Invalid email format"]);
        exit();
    }
    if (strlen($password) < 8) {
        echo json_encode(["success" => false, "message" => "Password must be at least 8 characters long"]);
        exit();
    }
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        echo json_encode(["success" => false, "message" => "Username can only contain letters, numbers, and underscores"]);
        exit();
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    try {
        $stmt->execute([$username, $email, $password]);
        echo json_encode(["success" => true, "message" => "Signup successful"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Email or username already exists"]);
    }
}
?>