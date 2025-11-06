<?php
$page_title = "Confessions";
require_once 'includes/header.php';

// Check if the user is logged in, if not then redirect to login page for posting
if (!$is_logged_in) {
    $post_message = "Please log in to submit a confession.";
}

$post_err = $post_msg = "";

// Handle confession post
if ($is_logged_in && $_SERVER["REQUEST_METHOD"] == "POST") {
    $content = trim($_POST["content"] ?? "");

    if (empty($content)) {
        $post_err = "Confession content cannot be empty.";
    }

    if (empty($post_err)) {
        // Generate a random anonymous ID (e.g., for "Anonymous 123")
        $anonymous_id = rand(100, 999);

        // Prepare an insert statement
        $sql = "INSERT INTO confessions (content, anonymous_id) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $param_content, $param_anonymous_id);

            $param_content = $content;
            $param_anonymous_id = $anonymous_id;

            if (mysqli_stmt_execute($stmt)) {
                $post_msg = '<div class="alert alert-success">Your confession has been submitted anonymously!</div>';
                // Clear form fields
                $content = "";
            } else {
                $post_msg = '<div class="alert alert-danger">Error: Could not save your confession. Please try again.</div>';
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $post_msg = '<div class="alert alert-danger">' . $post_err . '</div>';
    }
}

// Fetch all confessions
$confessions = [];
$sql = "SELECT content, anonymous_id, created_at FROM confessions ORDER BY created_at DESC";
if ($result = mysqli_query($link, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $confessions[] = $row;
    }
    mysqli_free_result($result);
}
?>

<div class="page-header">
    <h1>Anonymous Confessions</h1>
    <p class="lead">Share your secrets, thoughts, and feelings anonymously.</p>
</div>

<?php if ($is_logged_in): ?>
<div class="card form-card mb-4">
    <h2>Submit a Confession</h2>
    <?php echo $post_msg; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="content">Your Confession (Will be posted as "Anonymous <?php echo rand(100, 999); ?>")</label>
            <textarea name="content" id="content" class="form-control" rows="8" required><?php echo htmlspecialchars($content ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit Confession">
        </div>
    </form>
</div>
<?php else: ?>
    <div class="alert alert-info text-center">
        <?php echo $post_message; ?>
    </div>
<?php endif; ?>

<section class="confession-list">
    <?php if (!empty($confessions)): ?>
        <?php foreach ($confessions as $confession): ?>
            <div class="confession-item card">
                <p class="confession-content"><?php echo nl2br(htmlspecialchars($confession['content'])); ?></p>
                <small>Posted by Anonymous <?php echo htmlspecialchars($confession['anonymous_id']); ?> on <?php echo date("F j, Y", strtotime($confession['created_at'])); ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">No confessions have been shared yet. Be the first!</p>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>
<?php
$page_title = "Confessions";
include 'includes/header.php';

// 💌 Anonymous name generator
function generateAnonymousName() {
    $names = ["Secret Butterfly", "Midnight Whisper", "Hidden Star", "Quiet Soul", "Soft Echo", "Fuzzy Panda"];
    $random = $names[array_rand($names)];
    $number = rand(1, 1000);
    return "$random #$number";
}

// 💌 Handle submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $confession = trim($_POST["confession"]);
    if (!empty($confession)) {
        $anonName = generateAnonymousName();
        // Save confession in database (you can skip for now)
        echo "<script>showHeartPopup('$anonName');</script>";
    }
}
?>

<div class="floral-background"></div>

<section class="confession-section">
  <h2>💌 Anonymous Confessions 💌</h2>
  <p>Share your thoughts freely — your identity stays hidden 🌙</p>

  <form action="confessions.php" method="POST" class="confession-form">
    <textarea name="confession" placeholder="Write your confession..." required></textarea><br>
    <button type="submit">Send Confession 💜</button>
  </form>

  <div class="confession-display">
    <div class="confession-card">"Sometimes I miss the old us..." — <i>Secret Butterfly #17 🦋</i></div>
    <div class="confession-card">"He smiled at me today, and I forgot how to breathe 😳" — <i>Hidden Star #42 🌟</i></div>
  </div>
</section>

<?php include 'includes/footer.php';
?>
<!-- 🌹 Confessions Page Magical Animation -->
<style>
.confession-bg {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  z-index: -1;
  pointer-events: none;
  background: radial-gradient(circle at bottom, #ffe6f0 0%, #fff 80%);
}

/* ✨ Floating Sparkles */
.sparkle {
  position: absolute;
  background: rgba(255, 220, 250, 0.9);
  width: 4px;
  height: 4px;
  border-radius: 50%;
  box-shadow: 0 0 8px 3px rgba(255, 150, 200, 0.6);
  animation: sparkleFloat 8s linear infinite;
}

@keyframes sparkleFloat {
  0% {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
  100% {
    transform: translateY(-120vh) scale(0.8);
    opacity: 0;
  }
}

/* 💖 Floating Hearts */
.confession-heart {
  position: absolute;
  bottom: -10px;
  width: 18px;
  height: 18px;
  background: rgba(255, 120, 150, 0.4);
  transform: rotate(45deg);
  animation: heartFloat 10s ease-in-out infinite;
}

.confession-heart::before,
.confession-heart::after {
  content: "";
  position: absolute;
  width: 18px;
  height: 18px;
  background: rgba(255, 120, 150, 0.4);
  border-radius: 50%;
}
.confession-heart::before {
  top: -9px;
  left: 0;
}
.confession-heart::after {
  top: 0;
  left: -9px;
}

@keyframes heartFloat {
  0% {
    transform: translateY(0) rotate(45deg) scale(0.9);
    opacity: 0.7;
  }
  50% {
    opacity: 1;
  }
  100% {
    transform: translateY(-120vh) rotate(45deg) scale(1.2);
    opacity: 0;
  }
}<!-- 💬 Confession Form Glow Style -->
<style>
.confession-form {
  background: rgba(255, 255, 255, 0.9);
  border-radius: 15px;
  box-shadow: 0 0 20px rgba(255, 180, 200, 0.3);
  padding: 25px;
  transition: 0.3s;
}
.confession-form:hover {
  box-shadow: 0 0 30px rgba(255, 100, 150, 0.6);
}

.confession-form input,
.confession-form textarea {
  border: 1.5px solid #ff99b8;
  border-radius: 10px;
  transition: 0.3s;
}

.confession-form input:focus,
.confession-form textarea:focus {
  border-color: #ff4d88;
  box-shadow: 0 0 10px rgba(255, 100, 150, 0.5);
}

.confession-form button {
  background-color: #ff4d88;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 10px 20px;
  font-weight: 600;
  transition: 0.3s;
}

.confession-form button:hover {
  background-color: #ff3366;
  box-shadow: 0 0 15px rgba(255, 100, 150, 0.7);
}
</style>
</style>

<div class="confession-bg" id="confession-bg"></div>

<script>
const bg = document.getElementById("confession-bg");

// create hearts
function createHeart() {
  const heart = document.createElement("div");
  heart.classList.add("confession-heart");
  heart.style.left = Math.random() * 100 + "vw";
  heart.style.animationDuration = 8 + Math.random() * 4 + "s";
  bg.appendChild(heart);
  setTimeout(() => heart.remove(), 12000);
}

// create sparkles
function createSparkle() {
  const sparkle = document.createElement("div");
  sparkle.classList.add("sparkle");
  sparkle.style.left = Math.random() * 100 + "vw";
  sparkle.style.animationDuration = 5 + Math.random() * 5 + "s";
  sparkle.style.opacity = Math.random();
  bg.appendChild(sparkle);
  setTimeout(() => sparkle.remove(), 10000);
}

setInterval(createHeart, 800);
setInterval(createSparkle, 400);
</script>
<!-- 🌹 End Confessions Animation -->
