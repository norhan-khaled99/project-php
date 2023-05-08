<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Check if the user is logged in and is an admin
check_session();

// Get all products from the database
$query = "SELECT * FROM products";
$stmt = $pdo->query($query);

// Check if there are any products
if ($stmt->rowCount() == 0) {
  $message = "There are no products available.";
} else {
  // Display the products in a table
  $table = "<table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Category</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>";
  while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = $product['id'];
    $name = $product['name'];
    $description = $product['description'];
    $price = $product['price'];
    $category_id = $product['category_id'];

    // Get the category name
    $query2 = "SELECT * FROM categories WHERE id = :category_id";
    $stmt2 = $pdo->prepare($query2);
    $stmt2->bindParam(':category_id', $category_id);
    $stmt2->execute();
    $category = $stmt2->fetch(PDO::FETCH_ASSOC);
    $category_name = $category['name'];

    // Add the product to the table
    $table .= "<tr>
                  <td>$id</td>
                  <td>$name</td>
                  <td>$description</td>
                  <td>$price</td>
                  <td>$category_name</td>
                  <td><a href='edit_product.php?id=$id'>Edit</a> | <a href='delete_product.php?id=$id'>Delete</a></td>
                </tr>";
  }
  $table .= "</tbody></table>";
}

// Load the header
include('../includes/header.php');
?>

<h1>Products</h1>

<?php if (!empty($message)) { ?>
<p><?php echo $message; ?></p>
<?php } else { ?>
<?php echo $table; ?>
<?php } ?>

<a href="add_product.php">Add Product</a>

<?php
// Load the footer
include('../includes/footer.php');
?>