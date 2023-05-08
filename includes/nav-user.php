<?php
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css' rel='stylesheet'
integrity='sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp' crossorigin='anonymous'>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js'></script>
<style>
.nav-item:hover{
background-color: rgba(98, 192, 250, 0.827);
cursor: pointer;
}
</style>
";
?>
<nav class='navbar navbar-expand-lg'>
        <div class='w-100 d-flex justify-content-between'>
            <div class=' d-flex justify-content-between'>

                <div class='collapse navbar-collapse '>
                    <ul class='navbar-nav '>

                        <li class='nav-item mx-5'>
                            <a href='./index.php' class='fs-3 ' active>Home</a>
                        </li>
                        <li class='nav-item me-5'>
                            <a href='../order.php' class='fs-3'>orders</a>
                        </li>
                        <li class='nav-item mx-5'>
                            <a href='logout.php' class='fs-3 ' active>log out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
</nav>