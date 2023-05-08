<?php 
    include('includes/header.php');
    include('includes/config.php');
    include('includes/functions.php');

    // Get check ID from URL
    if (isset($_GET['id'])) {
        $check_id = $_GET['id'];
    } else {
        header('Location: checks.php');
    }

    // Get check details
    $stmt = $pdo->prepare("SELECT * FROM checks WHERE id = :check_id");
    $stmt->bindParam(':check_id', $check_id);
    $stmt->execute();
    $check = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get user details
    $user_id = $check['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get order details
    $order_id = $check['order_id'];
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :order_id");
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get product details
    $product_id = $order['product_id'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Display check details
?>
<div class="container">
    <h1>Check Details</h1>
    <table class="table">
        <tbody>
            <tr>
                <th>User:</th>
                <td><?php echo $user['name']; ?></td>
            </tr>
            <tr>
                <th>Order:</th>
                <td><?php echo $product['name']; ?></td>
            </tr>
            <tr>
                <th>Price:</th>
                <td><?php echo $product['price']; ?></td>
            </tr>
            <tr>
                <th>Quantity:</th>
                <td><?php echo $order['quantity']; ?></td>
            </tr>
            <tr>
                <th>Total:</th>
                <td><?php echo $check['total']; ?></td>
            </tr>
            <tr>
                <th>Date:</th>
                <td><?php echo $check['created_at']; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php include('includes/footer.php'); ?>