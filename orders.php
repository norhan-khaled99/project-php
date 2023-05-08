<?php
include 'includes/DB_class.php';
// require_once('includes/config.php');
require_once('includes/functions.php');

if (!is_logged_in()) {
    redirect('login.php');
}

include 'nav-user.php';
?>

<div class="container">
    <h1>My Orders</h1>

    <!-- Display the user's orders -->
    <?php
    $user_id = $_SESSION['user_id'];
$orders = get_orders_by_user($user_id);

if (empty($orders)) {
    echo "<p>No orders found.</p>";
} else {
    foreach ($orders as $order) {
        $order_id = $order['id'];
        $order_date = $order['order_date'];
        $order_status = $order['order_status'];
        $total_price = $order['total_price'];

        echo "<div class='card mb-3'>";
        echo "<div class='card-header'>Order ID: $order_id</div>";
        echo "<div class='card-body'>";
        echo "<p>Order Date: $order_date</p>";
        echo "<p>Status: $order_status</p>";
        echo "<p>Total Price: $total_price</p>";
        echo "</div>";
        echo "</div>";
    }
}
?>
</div>
