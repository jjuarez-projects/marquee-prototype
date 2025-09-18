<?php

// connect
$mysqli = new mysqli("localhost", "v8zx7hspzxaw", "ThaZ5c@Oik1s", "marquee");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get POST data
$line_id = intval($_POST['line_id']);
$content = trim($_POST['content']);

if ($content === '') {
    die("Message content cannot be empty.");
}

// Insert into Messages
$stmt = $mysqli->prepare("INSERT INTO Messages (line_id, content) VALUES (?, ?)");
$stmt->bind_param("is", $line_id, $content);

if ($stmt->execute()) {
    echo "Message inserted with ID: " . $stmt->insert_id;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>