<?php
include 'includes/DB_class.php';
require_once('includes/functions.php');

// Create a new PDO instance
$pdo = DataBase::connect();

// Create the necessary tables
create_tables($pdo);

if (!is_logged_in()) {
    redirect('login.php');
}

include 'nav-user.php';
?>

<div class="container">
    <h1>Welcome to the Cafeteria</h1>

    <div class="row">
        <?php
        $products = get_products();
foreach ($products as $product) {
    ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text"><?php echo $product['description']; ?></p>
                    </div>
                    <div class="card-footer">
                        <form action="add-to-cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <div class="mb-3">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1">
                            </div>
                            <div class="mb-3">
                                <label for="notes">Notes:</label>
                                <textarea name="notes" id="notes" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
}
?>
    </div>
</div>
