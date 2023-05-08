<?php
include 'includes/DB_class.php';
require_once('includes/functions.php');

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    // Check if the email and token are valid
    $user = DataBase::get_user_by_email('users', $email);
    if ($user && $user['token'] === $token) {
        // Show the password reset form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];

            // Update the user's password in the database
            DataBase::update_user_password('users', $user['id'], $password);

            // Clear the token in the database
            DataBase::clear_user_token('users', $user['id']);

            // Redirect to the login page
            redirect('login.php');
        }
    } else {
        // Invalid email or token, show an error message
        $error = 'Invalid email or token. Please check your email or request a new password reset.';
    }
} else {
    // Invalid parameters, show an error message
    $error = 'Invalid parameters. Please check your email or request a new password reset.';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>

    <?php if (isset($error)) { ?>
    <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <?php if (!isset($error)) { ?>
    <form method="post">
        <div>
            <label>New Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <button type="submit">Reset</button>
        </div>
    </form>
    <?php } ?>
</body>
</html>
