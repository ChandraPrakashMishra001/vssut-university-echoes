<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 💌 Email sending logic — runs when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Your destination email (where you'll receive the message)
    $to = "mishrac373@gmail.com"; // <-- replace with your real Gmail

    // Email subject line
    $mail_subject = "📩 New Message from University Echoes - " . $subject;

    // Email body
    $body = "
    <html>
    <head><title>New Contact Message</title></head>
    <body style='font-family: Arial;'>
        <h2>New Message Received 💬</h2>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Subject:</strong> {$subject}</p>
        <p><strong>Message:</strong><br>" . nl2br($message) . "</p>
    </body>
    </html>
    ";

    // Email headers
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: {$name} <{$email}>" . "\r\n";

    // Send email
    if (mail($to, $mail_subject, $body, $headers)) {
        $success = "✅ Your message has been sent successfully!";
    } else {
        $error = "❌ Message could not be sent. Try again later.";
    }
}
?>

<?php
$page_title = "Contact & Guidance";
require_once 'includes/header.php';
$page_title = "Contact & Guidance";
require_once 'includes/header.php';

$name = $email = $subject = $message = "";
$name_err = $email_err = $subject_err = $message_err = "";
$contact_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate subject
    if (empty(trim($_POST["subject"]))) {
        $subject_err = "Please enter a subject.";
    } else {
        $subject = trim($_POST["subject"]);
    }

    // Validate message
    if (empty(trim($_POST["message"]))) {
        $message_err = "Please enter your message.";
    } else {
        $message = trim($_POST["message"]);
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($email_err) && empty($subject_err) && empty($message_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO feedback (name, email, subject, message) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_email, $param_subject, $param_message);

            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_subject = $subject;
            $param_message = $message;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $contact_msg = '<div class="alert alert-success">Thank you for your feedback! We will get back to you soon.</div>';
                // Clear form fields
                $name = $email = $subject = $message = "";
            } else {
                $contact_msg = '<div class="alert alert-danger">Something went wrong. Please try again later.</div>';
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    } else {
        $contact_msg = '<div class="alert alert-danger">Please correct the errors in the form.</div>';
    }

    // Close connection
    mysqli_close($link);
}
?>

<div class="card form-card">
    <h2>Contact & Guidance Form</h2>
    <p>Share your feedback, ask for guidance, or report an issue.</p>

    <?php echo $contact_msg; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
            <label>Your Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>">
            <span class="help-block"><?php echo $name_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Your Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($subject_err)) ? 'has-error' : ''; ?>">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control" value="<?php echo htmlspecialchars($subject); ?>">
            <span class="help-block"><?php echo $subject_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($message_err)) ? 'has-error' : ''; ?>">
            <label>Message</label>
            <textarea name="message" class="form-control" rows="5"><?php echo htmlspecialchars($message); ?></textarea>
            <span class="help-block"><?php echo $message_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Send Message">
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
