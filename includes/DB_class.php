<?php

class DataBase
{
    private static $pdo;

    public static function connect()
    {
        $host = 'localhost';
        $dbname = 'cafeteria_db';
        $username = 'root';
        $password = 'Salama@99';

        try {
            self::$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }

        self::create_tables();
    }

    private static function create_tables()
    {
        $query = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                reset_token VARCHAR(255)
            );

            CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                category_id INT NOT NULL,
                FOREIGN KEY (category_id) REFERENCES categories(id)
            );

            CREATE TABLE IF NOT EXISTS categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL
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

        try {
            self::$pdo->exec($query);
        } catch (PDOException $e) {
            die('Table creation failed: ' . $e->getMessage());
        }
    }

    public static function getPDO()
    {
        return self::$pdo;
    }

    public static function get_user_by_email($table, $email)
    {
        $pdo = self::getPDO();

        $query = "SELECT * FROM $table WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function update_user_token($email, $token)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("UPDATE users SET reset_token = :token WHERE email = :email");
        $stmt->execute(['token' => $token, 'email' => $email]);
        return $stmt->rowCount();
    }

    public function generate_token($length = 32)
    {
        return bin2hex(random_bytes($length));
    }

}

// Establish the database connection
DataBase::connect();
