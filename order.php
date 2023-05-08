<?php
include 'includes/DB_class.php';
// require_once('includes/config.php');
require_once('includes/functions.php');

if (!is_logged_in()) {
    redirect('login.php');
}

// // if the user submitted an order
// if (isset($_POST['submit_order'])) {
//     // get the user's selected items and order details
//     $items = $_POST['items'];
//     $notes = $_POST['notes'];
//     $room_no = $_POST['room_no'];
//     $total_price = calculate_total_price($items);

//     // insert the order into the database
//     $query = "INSERT INTO orders (user_id, room_no, total_price, order_date, order_status) 
//               VALUES (:user_id, :room_no, :total_price, NOW(), 'processing')";
//     $stmt = $pdo->prepare($query);
//     $stmt->bindParam(':user_id', $_SESSION['user_id']);
//     $stmt->bindParam(':room_no', $room_no);
//     $stmt->bindParam(':total_price', $total_price);
//     $stmt->execute();

//     // get the ID of the newly inserted order
//     $order_id = $pdo->lastInsertId();

//     // insert the selected items into the order_items table
//     foreach ($items as $item_id => $count) {
//         if ($count > 0) {
//             $query = "INSERT INTO order_items (order_id, product_id, quantity, notes) 
//                       VALUES (:order_id, :product_id, :quantity, :notes)";
//             $stmt = $pdo->prepare($query);
//             $stmt->bindParam(':order_id', $order_id);
//             $stmt->bindParam(':product_id', $item_id);
//             $stmt->bindParam(':quantity', $count);
//             $stmt->bindParam(':notes', $notes[$item_id]);
//             $stmt->execute();
//         }
//     }

//     // redirect the user to their orders page
//     redirect('orders.php');
// }

// // get all products from the database
// $products = get_products();


include 'includes/nav-user.php';
?>
<div class="container">
    <div class="row d-flex ">

    <div class="col-6">
    <h1 class='text-primary'>Order Form</h1>
    <div class="container border border-primary  w-50 p-3">
    <form action="" method="post">
        <div class="form-group">
            <label for="room_no">Room No:</label>
            <select  class="form-control w-50" id="room_no"
             name="room_no" required>
             <option selected></option>
             <option value='room 1'>room 1</option>
             <option value='room 2'>room 2</option>
             <option value='room 3'>room 3</option>
            </select>
        </div>
       
        <div class="row d-flex justify-content-start">
            tea <input type="text">
            tea <input type="text" class=''>
            notes<textarea name="" id="" cols="30" rows="10"></textarea>
            <br/>
            <br/>
            <hr/>
        </div>
        <div class="form-group">
            <button type="submit" name="submit_order" class="btn btn-primary">Confirm Order</button>
        </div>
    </form>
    </div>
    </div>
    <div class="col-6">
        here list your product
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <img width='70rem' src="images/coffee-logo.png" alt="product">
                </div>
               
            </div>
        </div>
    </div>
    </div>
</div>
