<?php
$page_title = "Memories";
require_once 'includes/header.php';
// Initialize variables to avoid undefined warnings
$title = "";
$content = "";
$post_err = "";
$post_msg ="";
// Check if the user is logged in, if not then redirect to login page for posting
if (!$is_logged_in) {
    $post_message = "Please log in to share a memory.";
}

$post_err = $post_msg = "";

// Handle memory post
if ($is_logged_in && $_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"] ?? "");
    $content = trim($_POST["content"] ?? "");

    if (empty($title)) {
        $post_err = "Title cannot be empty.";
    } elseif (empty($content)) {
        $post_err = "Content cannot be empty.";
    }

    if (empty($post_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO memories (user_id, title, content) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "iss", $param_user_id, $param_title, $param_content);

            $param_user_id = $_SESSION["id"];
            $param_title = $title;
            $param_content = $content;

            if (mysqli_stmt_execute($stmt)) {
                $post_msg = '<div class="alert alert-success">Your memory has been successfully shared!</div>';
                echo "<script>showEmojiPopup();</script>";
                // Clear form fields
                $title = $content = "";
            } else {
                $post_msg = '<div class="alert alert-danger">Error: Could not save your memory. Please try again.</div>';
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $post_msg = '<div class="alert alert-danger">' . $post_err . '</div>';
    }
}

// Fetch all memories
$memories = [];
$sql = "SELECT m.title, m.content, m.created_at, u.username FROM memories m JOIN users u ON m.user_id = u.id ORDER BY m.created_at DESC";
if ($result = mysqli_query($link, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $memories[] = $row;
    }
    mysqli_free_result($result);
}
?>

<div class="page-header">
    <h1>University Memories</h1>
    <p class="lead">Long-form stories and experiences from the community.</p>
</div>

<?php if ($is_logged_in): ?>
<div class="card form-card mb-4">
    <h2>Share a New Memory</h2>
    <?php echo $post_msg; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Your Memory</label>
            <textarea name="content" id="content" class="form-control" rows="8" required><?php echo htmlspecialchars($content); ?></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Share Memory">
        </div>
    </form>
</div>
<?php else: ?>
    <div class="alert alert-info text-center">
        <?php echo $post_message; ?>
    </div>
<?php endif; ?>

<section class="memory-list">
    <?php if (!empty($memories)): ?>
        <?php foreach ($memories as $memory): ?>
            <div class="memory-item card">
                <h2><?php echo htmlspecialchars($memory['title']); ?></h2>
                <p class="memory-content"><?php echo nl2br(htmlspecialchars($memory['content'])); ?></p>
                <small>Shared by <?php echo htmlspecialchars($memory['username']); ?> on <?php echo date("F j, Y", strtotime($memory['created_at'])); ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">No memories have been shared yet. Be the first!</p>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>
<section class="memories-section">
  <h2>✨ University Memories ✨</h2>
  <p>Relive your favorite moments and stories that made university unforgettable 💜</p>

  <div class="memories-grid">
    <div class="memory-card">"Friendship makes every moment sparkle."</div>
    <div class="memory-card">"Late-night laughs are forever."</div>
    <div class="memory-card">"Memories fade, but feelings don’t."</div>
    <div class="memory-card">"Some goodbyes last a lifetime."</div>
    <div id="emoji-popup"></div>
  </div>
</section>
