<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in and is an admin
if (!is_admin()) {
    redirect('index.php');
}

// Get all orders
$query = "SELECT * FROM orders ORDER BY created_at DESC";
$stmt = $pdo->query($query);

// Set page title
$page_title = 'Orders';

// Include header
include_once '../includes/header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Orders</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Products</th>
                        <th>Total</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($stmt->rowCount() > 0) {
                        $i = 1;
                        while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $user_id = $order['user_id'];
                            $query2 = "SELECT * FROM users WHERE id = :user_id";
                            $stmt2 = $pdo->prepare($query2);
                            $stmt2->execute(['user_id' => $user_id]);
                            $user = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $user_name = $user['name'];
                            $user_email = $user['email'];
                            $user_room = $user['room'];
                            $user_ext = $user['ext'];

                            $order_id = $order['id'];
                            $query3 = "SELECT * FROM order_items WHERE order_id = :order_id";
                            $stmt3 = $pdo->prepare($query3);
                            $stmt3->execute(['order_id' => $order_id]);

                            $order_total = 0;
                            $order_products = '';
                            while ($item = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                $product_id = $item['product_id'];
                                $query4 = "SELECT * FROM products WHERE id = :product_id";
                                $stmt4 = $pdo->prepare($query4);
                                $stmt4->execute(['product_id' => $product_id]);
                                $product = $stmt4->fetch(PDO::FETCH_ASSOC);
                                $product_name = $product['name'];
                                $product_price = $product['price'];

                                $order_products .= $product_name . ' ($' . $product_price . '), ';
                                $order_total += $product_price;
                            }
                            $order_products = rtrim($order_products, ', ');

                            echo '<tr>';
                            echo '<td>' . $i++ . '</td>';
                            echo '<td>' . $user_name . ' (' . $user_email . ') - Room ' . $user_room . ' Ext. ' . $user_ext . '</td>';
                            echo '<td>' . $order_products . '</td>';
                            echo '<td>$' . number_format($order_total, 2) . '</td>';
                            echo '<td>' . date_format(date_create($order['created_at']), 'jS F Y h:i:s A') . '</td>';
                            echo '<td><a href="check_details.php?id=' . $order_id . '" class="btn btn-sm btn-info">View Details</a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6">No orders found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// Include footer
include_once '../includes/footer.php';
?>