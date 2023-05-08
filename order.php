<?php
// start the session
session_start();

// include the database connection and helper functions
require_once('includes/config.php');
require_once('includes/functions.php');

// if user is not logged in, redirect to login page
if (!is_logged_in()) {
    redirect('login.php');
}

// if the user submitted an order
if (isset($_POST['submit_order'])) {
    // get the user's selected items and order details
    $items = $_POST['items'];
    $notes = $_POST['notes'];
    $room_no = $_POST['room_no'];
    $total_price = calculate_total_price($items);

    // insert the order into the database
    $query = "INSERT INTO orders (user_id, room_no, total_price, order_date, order_status) 
              VALUES (:user_id, :room_no, :total_price, NOW(), 'processing')";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->bindParam(':room_no', $room_no);
    $stmt->bindParam(':total_price', $total_price);
    $stmt->execute();

    // get the ID of the newly inserted order
    $order_id = $pdo->lastInsertId();

    // insert the selected items into the order_items table
    foreach ($items as $item_id => $count) {
        if ($count > 0) {
            $query = "INSERT INTO order_items (order_id, product_id, quantity, notes) 
                      VALUES (:order_id, :product_id, :quantity, :notes)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':product_id', $item_id);
            $stmt->bindParam(':quantity', $count);
            $stmt->bindParam(':notes', $notes[$item_id]);
            $stmt->execute();
        }
    }

    // redirect the user to their orders page
    redirect('orders.php');
}

// get all products from the database
$products = get_products();

// include the header file
include('includes/header.php');
?>

<!-- display the products and order form -->
<div class="container">
    <h1>Order Form</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="room_no">Room No:</label>
            <input type="text" class="form-control" id="room_no" name="room_no" required>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td>
                        <input type="number" class="form-control" name="items[<?php echo $product['id']; ?>]" value="0"
                            min="0">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="notes[<?php echo $product['id']; ?>]" value="">
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="form-group">
            <button type="submit" name="submit_order" class="btn btn-primary">Confirm Order</button>
        </div>
    </form>
</div>

<!-- include the footer file -->
<?php include('includes/footer.php'); ?>