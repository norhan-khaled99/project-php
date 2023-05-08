<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');
check_admin();

// Get all users
$query = "SELECT * FROM users";
$stmt = $pdo->query($query);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Users - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include_once '../includes/header.php'; ?>

    <main>
        <h1>Users</h1>
        <?php if (count($users) == 0) { ?>
        <p>There are no users.</p>
        <?php } else { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Room No</th>
                <th>Ext</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['room']; ?></td>
                <td><?php echo $user['ext']; ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <?php } ?>
        <a href="add_user.php">Add User</a>
    </main>

    <?php include_once '../includes/footer.php'; ?>
</body>

</html>