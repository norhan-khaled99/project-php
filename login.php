<?php
// session_start();
require_once 'includes/header.php';
require_once 'includes/functions.php';

// Redirect to index page if user is already logged in
if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Handle login form submission
if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = get_user_by_email($email);
    if ($user && password_verify($password, $user['password'])) {
        // Login successful, store user ID in session and redirect to index page
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit();
    } else {
        // Login failed, show error message
        $error = 'Invalid email or password';
    }
}
?>

<!-- Page content -->
<div class="container">
    <h1>Login</h1>

    <?php if (!empty($error)) { ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <form method="post">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
    <p>Forgot your password? <a href="forgot_password.php">Reset it here</a></p>
</div>

<?php
require_once 'includes/footer.php';
?>