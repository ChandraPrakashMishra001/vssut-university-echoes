<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Include database connection
require_once 'db_connect.php';

// Check if the user is logged in, if not then redirect to login page
$is_logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'VSSUT University Echoes'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
</head>
<body>
    <div class="floral-background"></div>
    <header>
        <nav class="container">
            <a href="index.php" class="logo"> VSSUT University Echoes</a>
            <ul>
                <?php if ($is_logged_in): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="photos.php">Photos</a></li>
                    <li><a href="memories.php">Memories</a></li>
                    <li><a href="confessions.php">Confessions</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION["username"]); ?>)</a></li>
                <?php else: ?>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="contact.php">Contact</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="container">
