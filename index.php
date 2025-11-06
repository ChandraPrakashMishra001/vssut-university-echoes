<?php
$page_title = "Welcome";
require_once 'includes/header.php';
?>

<div class="hero-section">
    <h1>Welcome to VSSUT University Echoes</h1>
    <p class="lead">Share your photos, memories, and anonymous confessions with the university community.</p>
    <?php if (!$is_logged_in): ?>
        <div class="hero-actions">
            <a href="register.php" class="btn btn-primary btn-lg">Join Now</a>
            <a href="login.php" class="btn btn-secondary btn-lg">Login</a>
        </div>
    <?php else: ?>
        <div class="hero-actions">
            <a href="dashboard.php" class="btn btn-primary btn-lg">Go to Dashboard</a>
        </div>
    <?php endif; ?>
</div>

<section class="features-section">
    <div class="feature-card">
        <h3><i class="fas fa-camera"></i> Photos</h3>
        <p>Capture and share your favorite moments from campus life.</p>
    </div>
    <div class="feature-card">
        <h3><i class="fas fa-book-open"></i> Memories</h3>
        <p>Write down your stories, experiences, and long-form thoughts.</p>
    </div>
    <div class="feature-card">
        <h3><i class="fas fa-mask"></i> Confessions</h3>
        <p>Share your secrets and thoughts anonymously with the community.</p>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
