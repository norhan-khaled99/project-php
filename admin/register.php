<!DOCTYPE html>
<html>

<head>
    <title>User Registration</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>


    <div class="container mt-5">
        <h1 class="mb-4">User Registration</h1>
        <?php if (isset($_SESSION['success_message'])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION['success_message']; ?></div>
        <?php unset($_SESSION['success_message']); ?>
        <?php } ?>
        <form method="post" action="process_registration.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
            </div>
            <div class="form-group">
                <label for="room_no">Room No:</label>
                <select class="form-control" name="room_no" id="room_no">
                    <option value="Application1">Application1</option>
                    <option value="Application2">Application2</option>
                    <option value="cloud">cloud</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ext">Ext:</label>
                <input type="text" class="form-control" name="ext" id="ext" required>
            </div>
            <div class="form-group">
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" class="form-control-file" name="profile_picture" id="profile_picture"
                    accept="image/*" required>
            </div>
            <input type="submit" class="btn btn-primary" name="submit" value="Submit">
            <input type="reset" class="btn btn-secondary" name="reset" value="Reset">
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>