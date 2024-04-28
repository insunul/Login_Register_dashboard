<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    // Get the user ID from the session or database based on your implementation
    $user_id = $_SESSION['user_id']; // This assumes you store user_id in the session during login

    $stmt = $conn->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $content);
    $stmt->execute();
}

// Query to retrieve posts along with the associated usernames
$sql = "SELECT posts.content, posts.created_at, users.username 
        FROM posts 
        INNER JOIN users ON posts.user_id = users.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $username; ?></h2>
        <form action="" method="post">
            <textarea name="content" placeholder="Write something..." required></textarea>
            <button type="submit">Post</button>
        </form>
        
        <h3>Posts:</h3>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="post">
                <p><?php echo $row['content']; ?></p>
                <span>Posted by: <?php echo $row['username']; ?></span>
                <span><?php echo $row['created_at']; ?></span>
            </div>
        <?php endwhile; ?>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>