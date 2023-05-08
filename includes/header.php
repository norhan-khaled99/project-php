<!DOCTYPE html>
<html>

<head>
    <title>Cafeteria Website</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

    <header>
        <div class="container">
            <div class="logo">
                <a href="index.php">Cafeteria Website</a>
            </div>
            <nav>
                <ul>
                    <?php
          if(isset($_SESSION['user_id'])) {
            echo "<li><a href='order.php'>Order</a></li>";
            echo "<li><a href='includes/logout.php'>Logout</a></li>";
          } else {
            echo "<li><a href='login.php'>Login</a></li>";
          }
        ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">