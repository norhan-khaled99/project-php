<?php
// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login.php');
    exit;
}

// Include database connection
require_once '../includes/config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from form
    $check_num = $_POST['check_num'];
    $order_id = $_POST['order_id'];
    $total = $_POST['total'];
    $date = date('Y-m-d H:i:s');

    // Prepare and execute SQL statement to insert data into checks table
    $stmt = $pdo->prepare("INSERT INTO checks (check_num, order_id, total, date) VALUES (:check_num, :order_id, :total, :date)");
    $stmt->execute(['check_num' => $check_num, 'order_id' => $order_id, 'total' => $total, 'date' => $date]);

    // Redirect to current orders page
    header('Location: current_orders.php');
    exit;
}

// Prepare and execute SQL statement to get current orders from database
$stmt = $pdo->prepare("SELECT * FROM orders WHERE status = 'pending'");
$stmt->execute();

// Include header and navigation bar
require_once 'header.php';
?>

<div class="container">
    <h1 class="my-4">Checks</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
            <label for="order_id">Order ID:</label>
            <select class="form-control" name="order_id" required>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="check_num">Check Number:</label>
            <input type="text" class="form-control" name="check_num" required>
        </div>
        <div class="form-group">
            <label for="total">Total:</label>
            <input type="number" step="0.01" min="0" class="form-control" name="total" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Check</button>
    </form>
</div>

<?php
// Include footer
require_once 'footer.php';
?>