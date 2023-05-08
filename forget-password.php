<?php
include 'includes/DB_class.php';
require_once('includes/functions.php');




if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    $user = DataBase::get_user_by_email('users', $email);

    if ($user) {
        // Generate a unique token for password reset
        $token = bin2hex(random_bytes(32));

        // Save the token in the database
        DataBase::update_user_token('users', $user['id'], $token);

        // Send password reset email to the user
        send_password_reset_email($user['email'], $token);

        // Redirect to a page indicating that password reset email has been sent
        redirect('reset-password.php?email=' . urlencode($user['email']));
    } else {
        $error = 'Invalid email. Please enter a valid email address.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>

    <?php if (isset($error)) { ?>
    <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <form method="post">
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <button type="submit">Reset Password</button>
        </div>
    </form>
</body>
</html>
