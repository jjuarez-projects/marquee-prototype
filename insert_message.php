<?php

// connect
$mysqli = new mysqli("localhost", "v8zx7hspzxaw", "ThaZ5c@Oik1s", "marquee");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    echo "Connected!";
}

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
if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}
$stmt->bind_param("is", $line_id, $content);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}
echo "Inserted ID: " . $stmt->insert_id;

$stmt->close();
$mysqli->close();
?>