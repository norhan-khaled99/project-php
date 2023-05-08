<?php
include 'includes/DB_class.php';
require_once('includes/functions.php');

if (!is_logged_in()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];
$user = DataBase::get_user_by_id('users', $user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    // Update the user's profile in the database
    DataBase::update_user_profile('users', $user_id, $name, $email);
    
    // Refresh the user's data
    $user = DataBase::get_user_by_id('users', $user_id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
    <h1>Profile</h1>

    <form method="post">
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <div>
            <button type="submit">Save</button>
        </div>
    </form>
</body>
</html>
