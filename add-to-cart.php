<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if the product ID and quantity are provided
if (empty($_POST['product_id']) || empty($_POST['quantity'])) {
    header('Location: index.php');
    exit();
}

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$notes = $_POST['notes'];

// Retrieve the product details from the database
$product = get_product_by_id($product_id);

// Check if the product exists
if (!$product) {
    header('Location: index.php');
    exit();
}

// Create a new item for the shopping cart
$item = [
    'id' => $product['id'],
    'name' => $product['name'],
    'price' => $product['price'],
    'quantity' => $quantity,
    'notes' => $notes,
];

// Add the item to the shopping cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the same product already exists in the cart
$existingItem = null;
foreach ($_SESSION['cart'] as $index => $cartItem) {
    if ($cartItem['id'] === $product_id) {
        $existingItem = $index;
        break;
    }
}

if ($existingItem !== null) {
    // Update the quantity and notes of the existing item
    $_SESSION['cart'][$existingItem]['quantity'] += $quantity;
    $_SESSION['cart'][$existingItem]['notes'] = $notes;
} else {
    // Add the new item to the cart
    $_SESSION['cart'][] = $item;
}

// Redirect the user to the index page
header('Location: index.php');
exit();
