<?php
$page_title = "Dashboard";
require_once 'includes/header.php';

// Check if the user is logged in, if not then redirect to login page
if (!$is_logged_in) {
    header("location: login.php");
    exit;
}
?>

<div class="dashboard-header">
    <h1>Welcome back, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
    <p class="lead">Your central hub for all things University Echoes.</p>
</div>

<section class="dashboard-links">
    <div class="card">
        <h2><i class="fas fa-camera"></i> Photos</h2>
        <p>View and upload new photos.</p>
        <a href="photos.php" class="btn btn-primary">Go to Photos</a>
    </div>
    <div class="card">
        <h2><i class="fas fa-book-open"></i> Memories</h2>
        <p>Read and share your stories.</p>
        <a href="memories.php" class="btn btn-primary">Go to Memories</a>
    </div>
    <div class="card">
        <h2><i class="fas fa-mask"></i> Confessions</h2>
        <p>Read and submit anonymous confessions.</p>
        <a href="confessions.php" class="btn btn-primary">Go to Confessions</a>
    </div>
    <div class="card">
        <h2><i class="fas fa-envelope"></i> Contact</h2>
        <p>Share feedback or ask for guidance.</p>
        <a href="contact.php" class="btn btn-secondary">Contact Form</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
