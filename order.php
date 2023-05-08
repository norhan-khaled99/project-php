<?php
include 'includes/DB_class.php';
require_once('includes/functions.php');

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
    $db = new DB();
    $db->insertOrder($_SESSION['user_id'], $room_no, $total_price, 'processing');

    // get the ID of the newly inserted order
    $order_id = $db->getLastInsertedOrderId();

    // insert the selected items into the order_items table
    foreach ($items as $item_id => $count) {
        if ($count > 0) {
            $db->insertOrderItem($order_id, $item_id, $count, $notes[$item_id]);
        }
    }

    // redirect the user to their orders page
    redirect('orders.php');
}

include 'nav-user.php';
?>
<div class="container">
    <div class="row d-flex ">
        <div class="col-6">
            <h1 class='text-primary'>Order Form</h1>
            <div class="container border border-primary w-50 p-3">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="room_no">Room No:</label>
                        <select class="form-control w-50" id="room_no" name="room_no" required>
                            <option selected></option>
                            <option value='room 1'>room 1</option>
                            <option value='room 2'>room 2</option>
                            <option value='room 3'>room 3</option>
                        </select>
                    </div>

                    <!-- Add your product inputs here -->
                    <!-- Example: -->
                    <!-- <div class="form-group">
                        <label for="product_1">Product 1:</label>
                        <input type="text" name="items[1]">
                        <textarea name="notes[1]" cols="30" rows="10"></textarea>
                    </div> -->

                    <div class="form-group">
                        <button type="submit" name="submit_order" class="btn btn-primary">Confirm Order</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-6">
            <!-- List your products here -->
            <!-- Example: -->
            <!-- <div class="container">
                <div class="row">
                    <div class="col-3">
                        <img width='70rem' src="images/coffee-logo.png" alt="product">
                    </div>
                    <div class="col-9">
                        <p>Product Name</p>
                        <p>Product Description</p>
                        <input type="number" name="items[product_id]">
                        <textarea name="notes[product_id]" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
