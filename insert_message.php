<?php
// Database configuration - centralized connection
$servername = "localhost";
$db_username = "v8zx7hspzxaw"; 
$db_password = "ThaZ5c@Oik1s";
$dbname = "register";

// Create single database connection for the entire page
$mysqli = new mysqli('servername', 'db_username', 'db_password', 'dbname');

session_start();
$created_by = 1; // Hard-coded for demo, replace with $_SESSION['user_id']

$content = trim($_POST['content']);
$lines = $_POST['lines']; // array of line_ids

if (!$content || empty($lines)) die("Content and at least one line required.");

// Insert message
$stmt = $mysqli->prepare("INSERT INTO Messages (content, created_by) VALUES (?, ?)");
$stmt->bind_param("si", $content, $created_by);
$stmt->execute();
$message_id = $stmt->insert_id;
$stmt->close();

// Insert message lines
foreach($lines as $line_id){
    $stmt = $mysqli->prepare("INSERT INTO MessageLines (message_id, line_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $message_id, $line_id);
    $stmt->execute();
    $message_line_id = $stmt->insert_id;
    $stmt->close();

    // Insert into prep sheet with default position
    $stmt = $mysqli->prepare("INSERT INTO PrepSheet (message_line_id, position) VALUES (?, ?)");
    $position = 0;
    $stmt->bind_param("ii", $message_line_id, $position);
    $stmt->execute();
    $stmt->close();
}

echo "Message submitted successfully.";
$mysqli->close();
?>
