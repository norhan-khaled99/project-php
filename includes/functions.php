<?php

session_start();

// Redirect function
function redirect($url)
{
    header("Location: $url");
    exit();
}

// Check if the user is logged in
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

// Calculate total price of selected items
function calculate_total_price($items)
{
    $total = 0;
    foreach ($items as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// Get all products from the database
function get_products()
{
    // Replace with your database credentials
    $servername = "localhost";
    $username = "root";
    $password = "Salama@99";
    $dbname = "cafeteria_db";

    try {
        // Create a new PDO instance
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // Set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch all products from the database
        $stmt = $db->query('SELECT * FROM products');
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    } catch (PDOException $e) {
        // Handle database connection error
        die("Database error: " . $e->getMessage());
    }
}

// Get all orders for a specific user
function get_user_orders($userId)
{
    // Replace with your database credentials
    $servername = "localhost";
    $username = "root";
    $password = "Salama@99";
    $dbname = "cafeteria_db";

    try {
        // Create a new PDO instance
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // Set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch all orders for the user from the database
        $stmt = $db->prepare('SELECT * FROM orders WHERE user_id = :user_id');
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $orders;
    } catch (PDOException $e) {
        // Handle database connection error
        die("Database error: " . $e->getMessage());
    }
}

// Add more functions for other functionality as needed

// Function to retrieve a user by email
function get_user_by_email($email)
{
    $pdo = DataBase::getPDO();

    $query = "SELECT * FROM users WHERE email = :email";
    $statement = $pdo->prepare($query);
    $statement->execute(['email' => $email]);

    return $statement->fetch();
}


// Function to get orders by user ID
function get_orders_by_user($user_id)
{
    $pdo = DataBase::getPDO();

    $query = "
        SELECT *
        FROM orders
        WHERE user_id = :user_id
        ORDER BY order_date DESC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




// Function to create the necessary tables in the database
function create_tables()
{
    $query = "
        CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        );

        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            reset_token VARCHAR(255) DEFAULT NULL
        );

        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            category_id INT NOT NULL,
            FOREIGN KEY (category_id) REFERENCES categories(id)
        );

        CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            room_no VARCHAR(255) NOT NULL,
            total_price DECIMAL(10, 2) NOT NULL,
            order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            order_status ENUM('processing', 'out for delivery', 'done') NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id)
        );

        CREATE TABLE IF NOT EXISTS order_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL,
            notes TEXT,
            FOREIGN KEY (order_id) REFERENCES orders(id),
            FOREIGN KEY (product_id) REFERENCES products(id)
        );
    ";

    $pdo = DataBase::getPDO();
    $pdo->exec($query);
}



// Example function:
function cancel_order($orderId)
{
    // Replace with your database credentials
    $servername = "localhost";
    $username = "root";
    $password = "Salama@99";
    $dbname = "cafeteria_db";

    try {
        // Create a new PDO instance
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // Set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update the order status to "canceled" in the database
        $stmt = $db->prepare('UPDATE orders SET order_status = "canceled" WHERE id = :order_id');
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
    } catch (PDOException $e) {
        // Handle database connection error
        die("Database error: " . $e->getMessage());
    }
}
