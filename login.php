<?php
include 'includes/DB_class.php';
require_once 'includes/functions.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = get_user_by_email($email); // Use the function from functions.php
    if ($user && $password == $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit();
    } else {
        $error = 'Invalid email or password';
    }
}
?>



<?php
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css' rel='stylesheet'
        integrity='sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp' crossorigin='anonymous'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js'></script>
        <link rel='stylesheet' href='css/login.css'>";
?>

<!-- Page content -->
<div class="container">
    <div id='cafe' class='mt-5 text-center text-primary fw-light'>Cafeteria
        <img style='width: 110px;' src='images/coffee-logo.png' alt='logo'/>
    </div>
    <br>

    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <div class='container d-flex justify-content-center'>
        <form class='w-50' action='' method='POST'>
            <label for='email' class='form-label'>Email</label>
            <input type='email' name='email' class='form-control' required>
            <br>
            <label for='password' class='form-label'>Password</label>
            <input type='password' name='password' class='form-control' required>

            <div class='mt-3 text-center'>
                <button type='submit' class='btn btn-primary text-center mb-3'>Log in</button><br>
                <a href='forget-password.php'>Forgot password?</a>
            </div>
        </form>
    </div>
</div>
