<?php
require_once "config.php";

// Custom sanitization function for search query
function sanitizeSearchQuery($input) {
    $input = trim($input); // Remove whitespace
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // Prevent XSS
    return $input;
}

if (isset($_GET["query"])) {
    $query = "%" . sanitizeSearchQuery($_GET["query"]) . "%";
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
    $stmt->execute([$query, $query]);
    $products = $stmt->fetchAll();
    echo json_encode($products);
}
?>