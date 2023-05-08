<?php
session_start();
require_once('includes/config.php');
require_once('includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Check if the user exists
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a new password
        $new_password = generate_password();
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE email = ?');
        $stmt->execute([$hashed_password, $email]);

        // Send an email to the user with the new password
        $to = $email;
        $subject = 'New Password for Cafeteria Website';
        $message = 'Your new password is: ' . $new_password;
        $headers = 'From: webmaster@cafeteria.com' . "\r\n" .
            'Reply-To: webmaster@cafeteria.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if (mail($to, $subject, $message, $headers)) {
            $_SESSION['success_msg'] = 'A new password has been sent to your email.';
        } else {
            $_SESSION['error_msg'] = 'Failed to send email. Please try again later.';
        }
    } else {
        $_SESSION['error_msg'] = 'Invalid email address.';
    }

    header('Location: forgot_password.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Cafeteria Website</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <h1>Forgot Password</h1>
        <?php if (isset($_SESSION['success_msg'])): ?>
        <div class="success-msg">
            <?php echo $_SESSION['success_msg']; ?>
        </div>
        <?php unset($_SESSION['success_msg']); ?>
        <?php elseif (isset($_SESSION['error_msg'])): ?>
        <div class="error-msg">
            <?php echo $_SESSION['error_msg']; ?>
        </div>
        <?php unset($_SESSION['error_msg']); ?>
        <?php endif; ?>
        <form method="post">
            <div>
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <button type="submit">Reset Password</button>
            </div>
        </form>
    </div>
</body>

</html>