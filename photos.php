<?php
$page_title = "Photos";
require_once 'includes/header.php';
?>
<!-- Floating Animation Background -->
<div class="floating-hearts"></div>


<!-- 🌸 Animation background -->
<div class="floral-background"></div>

<?php
// Check if the user is logged in, if not then redirect to login page for posting
if (!$is_logged_in) {
    // Allow viewing, but redirect to login for posting
    $upload_message = "Please log in to upload photos.";
}

// Check if the user is logged in, if not then redirect to login page for posting
if (!$is_logged_in) {
    // Allow viewing, but redirect to login for posting
    $upload_message = "Please log in to upload photos.";
}

$upload_err = $upload_msg = "";

// Handle photo upload
if ($is_logged_in && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["photo"])) {
    $target_dir = "uploads/";
    $file_name = basename($_FILES["photo"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $upload_err = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["photo"]["size"] > 5000000) {
        $upload_err = "Sorry, your file is too large (max 5MB).";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $upload_err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $upload_msg = '<div class="alert alert-danger">' . $upload_err . '</div>';
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Insert photo record into database
            $sql = "INSERT INTO photos (user_id, title, description, file_path) VALUES (?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "isss", $param_user_id, $param_title, $param_description, $param_file_path);

                $param_user_id = $_SESSION["id"];
                $param_title = trim($_POST["title"] ?? "Untitled Photo");
                $param_description = trim($_POST["description"] ?? "");
                $param_file_path = $target_file;

                if (mysqli_stmt_execute($stmt)) {
                    $upload_msg = '<div class="alert alert-success">The photo "' . htmlspecialchars($param_title) . '" has been uploaded.</div>';
                } else {
                    $upload_msg = '<div class="alert alert-danger">Error: Could not save photo details to database.</div>';
                }
                mysqli_stmt_close($stmt);
            }
        } else {
            $upload_msg = '<div class="alert alert-danger">Sorry, there was an error uploading your file.</div>';
        }
    }
}

// Fetch all photos
$photos = [];
$sql = "SELECT p.title, p.description, p.file_path, p.created_at, u.username FROM photos p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC";
if ($result = mysqli_query($link, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $photos[] = $row;
    }
    mysqli_free_result($result);
}
?>

<div class="page-header">
    <h1>University Photos</h1>
    <p class="lead">Share the visual memories of your university life.</p>
</div>

<?php if ($is_logged_in): ?>
<div class="card form-card mb-4">
    <h2>Upload a New Photo</h2>
    <?php echo $upload_msg; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="photo">Select Image File (Max 5MB)</label>
            <input type="file" name="photo" id="photo" class="form-control-file" accept="image/*" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Upload Photo">
        </div>
    </form>
</div>
<?php else: ?>
    <div class="alert alert-info text-center">
        <?php echo $upload_message; ?>
    </div>
<?php endif; ?>

<section class="photo-gallery">
    <?php if (!empty($photos)): ?>
        <?php foreach ($photos as $photo): ?>
            <div class="photo-item card">
                <img src="<?php echo htmlspecialchars($photo['file_path']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>">
                <div class="photo-info">
                    <h3><?php echo htmlspecialchars($photo['title']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($photo['description'])); ?></p>
                    <small>Posted by <?php echo htmlspecialchars($photo['username']); ?> on <?php echo date("F j, Y", strtotime($photo['created_at'])); ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">No photos have been shared yet. Be the first!</p>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>
<?php include('includes/header.php'); ?>

<div class="floral-background"></div>

<section class="photo-gallery">
  <h1 class="page-title">📸 Campus Moments</h1>
  <p class="page-subtitle">Share your favorite pictures and memories with a touch of love 💜</p>

  <div class="photo-grid">
    <div class="photo-card">
      <img src="assets/images/sample1.jpg" alt="Memory 1">
      <div class="quote">"Friendship makes every moment sparkle."</div>
    </div>
    <div class="photo-card">
      <img src="assets/images/sample2.jpg" alt="Memory 2">
      <div class="quote">"Laughter is the best filter."</div>
    </div>
    <div class="photo-card">
      <img src="assets/images/sample3.jpg" alt="Memory 3">
      <div class="quote">"Memories bloom forever."</div>
    </div>
  </div>

  <div class="upload-btn">
    <form action="photos.php" method="post" enctype="multipart/form-data">
      <input type="file" name="photo" accept="image/*" required>
      <button type="submit" id="uploadPhotoBtn">💖 Upload New Photo</button>
    </form>
  </div>
</section>

<?php include('includes/footer.php');?>
<!-- ✨ Elegant Floating Hearts -->
<style>
/* Background container */
.floating-hearts {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  z-index: -1; /* behind content */
  pointer-events: none;
}

/* Heart style */
.heart {
  position: absolute;
  bottom: -10px;
  width: 16px;
  height: 16px;
  background: rgba(255, 100, 150, 0.4);
  transform: rotate(45deg);
  animation: floatUp 12s linear infinite;
}
.heart::before,
.heart::after {
  content: "";
  position: absolute;
  width: 16px;
  height: 16px;
  background: rgba(255, 100, 150, 0.4);
  border-radius: 50%;
}
.heart::before {
  top: -8px;
  left: 0;
}
.heart::after {
  left: -8px;
  top: 0;
}

/* Keyframes for soft floating */
@keyframes floatUp {
  0% {
    transform: translateY(0) rotate(45deg) scale(0.8);
    opacity: 0.6;
  }
  50% {
    opacity: 0.9;
  }
  100% {
    transform: translateY(-120vh) rotate(45deg) scale(1.2);
    opacity: 0;
  }
}
</style>

<div class="floating-hearts" id="heart-container"></div>

<script>
const container = document.getElementById("heart-container");

function createHeart() {
  const heart = document.createElement("div");
  heart.classList.add("heart");
  heart.style.left = Math.random() * 100 + "vw";
  heart.style.animationDuration = 8 + Math.random() * 4 + "s";
  heart.style.width = heart.style.height = 12 + Math.random() * 10 + "px";
  container.appendChild(heart);
  setTimeout(() => heart.remove(), 12000);
}

setInterval(createHeart, 800);
</script>
<!-- ✨ End Elegant Animation -->