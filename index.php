<?php
session_start();
require_once 'includes/header.php';
require_once 'includes/functions.php';
?>

<!-- Page content -->
<div class="container">
    <h1>Welcome to our Cafeteria</h1>
    <p>Choose your order and room number and we will deliver it to you</p>

    <?php
  if (!empty($_SESSION['user_id'])) {
    // User is logged in, show order page
    include 'order.php';
  } else {
    // User is not logged in, show login form
    include 'login.php';
  }
  ?>
</div>

<?php
require_once 'includes/footer.php';
?>