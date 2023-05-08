<?php
include '../includes/config.php';


// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $room_no = $_POST['room_no'];
    $ext = $_POST['ext'];
    
    // Check if passwords match
    if ($password != $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        // Check if email already exists
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $error = 'Email already exists';
        } else {
            // Hash the password
            $password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert the user into the database
            $query = "INSERT INTO users (name, email, password, room, ext) VALUES (:name, :email, :password, :room_no, :ext)";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':room_no', $room_no);
            $stmt->bindValue(':ext', $ext);
            
            if ($stmt->execute()) {
                $success = 'User added successfully';
            } else {
                $error = 'Error adding user: ' . $stmt->errorInfo()[2];
            }
        }
    }
}

include '../includes/header.php';
?>
<h1>Add User</h1>
<?php if (isset($error)): ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<?php if (isset($success)): ?>
<div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>
<form method="POST">
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Room Number</label>
        <input type="text" name="room_no" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Extension</label>
        <input type="text" name="ext" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Add User</button>
</form>
<?php include '../includes/footer.php'; ?>