<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        session_start(); 
        include("conn_db.php");
        if(!isset($_SESSION["cid"]) || !isset($_GET["orh"])){
            header("location: restricted.php");
            exit(1);
        }
        include('head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/login.css" rel="stylesheet">

    <title>Successfully Order | SaiCafe</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header.php')?>
    <div class="mt-5"></div>
    <div class="container form-signin text-center reg-success mt-auto">
            <i class="mt-4 bi bi-cart-check text-success h1 display-1"></i>
            <h4 class="mt-2 fw-normal text-bold">Your order has been placed.</h4>
            <?php 
                //generate order reference code
                $orh_id = $_GET["orh"];
                $orh_query = "SELECT orh_refcode FROM order_header WHERE orh_id = {$orh_id} LIMIT 0,1;";
                $orh_arr = $mysqli -> query($orh_query) -> fetch_array();
                $orh_refcode = $orh_arr["orh_refcode"];
            ?>
            <h5 class="mb-3 fw-normal text-bold">Order #<?php echo $orh_refcode;?></h5> 
            <p class="mb-3 fw-normal text-bold text-wrap">We'll notify the shop in a few moments. <br/>You can check status in order history menu.</p>
            <a class="btn btn-outline-secondary btn-sm" href="index.php">Return to home</a>
            <a class="btn btn-success btn-sm" href="cust_order_history.php">Go to order history page</a>
    </div>

    <footer class="text-center text-white">
  <!-- Copyright -->
  <div class="text-center p-2 p-2 mb-1 bg-dark text-white">
    <p class="text-white">© 2022 Copyright : Sairam Group</p>
    <p class="text-white">Developed by :</p>
    <p class="text-white">&nbsp;1. Magesh K - CSE
        &nbsp;2. SelvaNarayanan A - CSE
        &nbsp;3. Keertheshwaran G - CSE</p>
  </div>
  <!-- Copyright -->
</footer>
</body>

</html>