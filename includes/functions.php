<?php

// Connect to database
require_once('config.php');

// Create PDO object
// try {
//     $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
// } catch(PDOException $e) {
//     die("ERROR: Could not connect. " . $e->getMessage());
// }

// Check if user is logged in
function is_logged_in()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

/**
 * Check if the logged in user is an admin
 * @return bool true if the user is an admin, false otherwise
 */
function is_admin()
{
    // check if the user is logged in and their role is admin
    if (is_logged_in() && $_SESSION['role'] == 'admin') {
        return true;
    } else {
        return false;
    }
}
// Get user data by email

function get_user_by_email($email)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function redirect($url)
{
    header("Location: $url");
    exit();
}


// Get user data by ID
function get_user_by_id($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

// Get all products
function get_all_products()
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY name ASC");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $products;
}

// Get product by ID
function get_product_by_id($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    return $product;
}

// Get all categories
function get_all_categories()
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY name ASC");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}

// Get category by ID
function get_category_by_id($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    return $category;
}

// Add product to cart
function add_to_cart($product_id, $quantity, $notes, $room_id)
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = array(
        'product_id' => $product_id,
        'quantity' => $quantity,
        'notes' => $notes,
        'room_id' => $room_id,
        );
    } else {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        $_SESSION['cart'][$product_id]['notes'] .= " / " . $notes;
    }
}

// Remove product from cart
function remove_from_cart($product_id)
{
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Update product quantity in cart
function update_cart_quantity($product_id, $quantity)
{
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    }
}

// Update product notes in cart
function update_cart_notes($product_id, $notes)
{
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['notes'] = $notes;
    }
}
// Get cart subtotal
function get_cart_subtotal()
{
    $subtotal = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $product = get_product_by_id($item['product_id']);
            $subtotal += $product['price'] * $item['quantity'];
        }
    }
    return $subtotal;
}

// Function to clear the cart by removing all items
function clear_cart()
{
    global $pdo;
    // Clear the cart items from the database
    $user_id = $_SESSION['user_id'];
    $query = "DELETE FROM cart WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $user_id]);

    // Reset the cart count to zero
    $_SESSION['cart_count'] = 0;

    // Reset the cart total to zero
    $_SESSION['cart_total'] = 0;

    // Return a success message
    return "Your cart has been cleared.";
}
// Function to get the order history for a user
function get_order_history($user_id)
{
    global $pdo;
    // Query the database for the user's orders
    $query = "SELECT * FROM orders WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $user_id]);
    // Create an array to store the order history
    $order_history = array();

    // Loop through the orders and add them to the array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $order_id = $row['id'];
        $order_date = $row['order_date'];
        $order_total = $row['order_total'];
        $order_status = $row['order_status'];

        // Get the products for the order
        $query2 = "SELECT * FROM order_items WHERE order_id = :order_id";
        $stmt2 = $pdo->prepare($query2);
        $stmt2->execute(['order_id' => $order_id]);

        // Create an array to store the products
        $order_products = array();

        // Loop through the products and add them to the array
        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $product_id = $row2['product_id'];
            $product_name = $row2['product_name'];
            $product_price = $row2['product_price'];
            $product_quantity = $row2['product_quantity'];

            // Add the product to the array
            $order_products[] = array(
                'id' => $product_id,
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => $product_quantity
            );
        }

        // Add the order to the array
        $order_history[] = array(
            'id' => $order_id,
            'date' => $order_date,
            'total' => $order_total,
            'status' => $order_status,
            'products' => $order_products
        );
    }

    // Return the order history array
    return $order_history;
}

// Function to get the order details for a specific order
function get_order_details($order_id)
{
    global $pdo;
    // Query the database for the order with the given ID
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the order doesn't exist, return null
    if (!$order) {
        return null;
    }
    // Query the database for the products in the order
    $stmt = $pdo->prepare("SELECT products.*, order_items.quantity FROM products INNER JOIN order_items ON products.product_id = order_items.product_id WHERE order_items.order_id = ?");
    $stmt->execute([$order_id]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Add the products to the order array
    $order['products'] = $products;

    return $order;
}

// Function to update the status of an order
function update_order_status($order_id, $status)
{
    global $pdo;
    // Update the order with the given status
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->execute([$status, $order_id]);
}
