<?php
session_start();
?>

<!-- Page content -->
<div class="container">
    <h1>Welcome to our Cafeteria</h1>

    <?php
  if (!empty($_SESSION['user_id'])) {
    include 'order.php';
  } else {
    include 'login.php';
  }
  ?>
</div>
