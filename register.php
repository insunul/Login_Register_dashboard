<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        // Get the user_id of the newly registered user
        $user_id = $stmt->insert_id;
        // Store user_id in session for future use
        session_start();
        $_SESSION['user_id'] = $user_id;
        header("Location: index.html");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>