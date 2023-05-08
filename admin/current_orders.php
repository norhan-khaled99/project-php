<?php 
// Include config file
require_once '../includes/config.php';

// Redirect to login page if not logged in
if (!is_logged_in()) {
    redirect('login.php');
}

// Check if user is an admin
if (!is_admin()) {
    redirect('index.php');
}

// Get current orders
$sql = "SELECT * FROM orders WHERE status != 'completed' ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include header
include_once('../includes/header.php');
?>

<div class="container my-5">
    <h2>Current Orders</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User Name</th>
                <th>Room No</th>
                <th>Ext</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) { ?>
            <?php $user_id = $order['user_id']; ?>
            <?php $sql2 = "SELECT * FROM users WHERE id = :id"; ?>
            <?php $stmt2 = $pdo->prepare($sql2); ?>
            <?php $stmt2->execute(['id' => $user_id]); ?>
            <?php $user = $stmt2->fetch(PDO::FETCH_ASSOC); ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['room']; ?></td>
                <td><?php echo $user['ext']; ?></td>
                <td><?php echo $order['total_price']; ?></td>
                <td><?php echo ucfirst($order['status']); ?></td>
                <td><a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-primary btn-sm">View
                        Details</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
// Include footer
include_once('../includes/footer.php');
?>