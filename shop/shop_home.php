<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        session_start(); 
        if($_SESSION["utype"]!="shopowner"){
            header("location: ../restricted.php");
            exit(1);
        }
        include("../conn_db.php"); 
        include('../head.php');
        $s_id = $_SESSION["sid"];
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <title>Shop Owner Home | SaiCafe</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_shop.php'); ?>

    <div class="d-flex text-center text-white promo-banner-bg py-3">
        <div class="p-lg-2 mx-auto my-3">
            <h1 class="display-5 fw-normal"><?php echo $_SESSION["shopname"]?></h1>
            <h1 class="display-5 fw-normal">Welcome to Sai Cafe</h1>
            <p class="lead fw-normal">Online Food ordering system of Sairam Campus Canteen</p>
        </div>
    </div>

    <div class="container p-5" id="shop-dashboard">
        <h2 class="border-bottom pb-2"><i class="bi bi-graph-up"></i> Shop Dashboard <span
                class="small fw-light"><?php echo date('F j, Y');?></span></h2>

        <!-- SHOP OWNER GRID DASHBOARD -->
        <div class="row row-cols-1 row-cols-lg-2 align-items-stretch g-4 py-3">
            <!-- TODAY ORDER GRID -->
            <div class="col">
                <div class="card rounded-5 border-secondary p-2">
                    <div class="card-body">
                        <p class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-card-list" viewBox="0 0 16 16">
                                <path
                                    d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                <path
                                    d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                            </svg>&nbsp;&nbsp;Today Completed Order</p>
                        <p class="card-text my-2">
                            <span class="display-5">
                                <?php 
                                    $query = "SELECT COUNT(*) AS cnt_order FROM order_header WHERE s_id = {$s_id} AND DATE(orh_pickuptime) = CURDATE() AND orh_orderstatus = 'FNSH';";
                                    $result = $mysqli -> query($query) -> fetch_array();
                                    echo $result["cnt_order"];
                                    ?>
                                Orders
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- END TODAY ORDER GRID -->
            <!-- TODAY REVENUE GRID -->
            <div class="col">
                <div class="card rounded-5 border-secondary p-2">
                    <div class="card-body">
                        <p class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-coin" viewBox="0 0 16 16">
                                <path
                                    d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z" />
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path
                                    d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                            </svg>&nbsp;&nbsp;Today Revenue</p>
                        <p class="card-text my-2">
                            <span class="display-5">
                                <?php 
                                        $query = "SELECT SUM(ord.ord_buyprice*ord.ord_amount) AS revenue FROM order_header orh INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
                                        WHERE orh.s_id = {$s_id} AND DATE(orh.orh_pickuptime) = CURDATE() AND orh.orh_orderstatus = 'FNSH';";
                                        $result = $mysqli -> query($query) -> fetch_array();
                                        if(!is_null($result["revenue"])){echo $result["revenue"];}else{echo "0.00";}
                                    ?>
                                
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- END TODAY REVENUE GRID -->

            <!-- GRID OF ORDER NEEDED TO BE COMPLETE -->
            <div class="col">
                <a href="shop_order_list.php" class="text-decoration-none text-dark">
                    <div class="card rounded-5 border p-2">
                        <div class="card-body">
                            <h5 class="card-title fw-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-card-list" viewBox="0 0 16 16">
                                    <path
                                        d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                    <path
                                        d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                                </svg>
                                Remaining Order</h5>
                            <p class="card-text my-2">
                                <span class="h6">
                                    <?php 
                                    $query = "SELECT COUNT(*) AS cnt_remain FROM order_header WHERE s_id = {$s_id} AND orh_orderstatus NOT LIKE 'FNSH';";
                                    $result = $mysqli -> query($query) -> fetch_array();
                                    echo $result["cnt_remain"];
                                ?>
                                </span>
                                orders left to be finished
                            </p>
                            <div class="text-end">
                                <a href="shop_order_list.php" class="btn btn-sm btn-outline-dark">Go to Order List</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END GRID OF ORDER NEEDED TO BE COMPLETE -->

            <!-- GRID OF ORDER NEEDED TO BE COMPLETE -->
            <div class="col">
                <a href="shop_menu_list.php" class="text-decoration-none text-dark">
                    <div class="card rounded-5 border p-2">
                        <div class="card-body">
                            <h5 class="card-title fw-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-card-list" viewBox="0 0 16 16">
                                    <path
                                        d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                    <path
                                        d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                                </svg>
                                Food Menu</h5>
                            <p class="card-text my-2">
                                <span class="h6">
                                    <?php
                                    $query = "SELECT COUNT(*) AS cnt_menu FROM food f INNER JOIN shop s ON f.s_id = s.s_id 
                                    WHERE (s.s_status = 1 AND (CURTIME() BETWEEN s.s_openhour AND s.s_closehour) AND f.f_todayavail = 1) OR (s.s_preorderstatus = 1 AND f.f_preorderavail = 1) AND s.s_id = {$s_id};";
                                    $result = $mysqli -> query($query) -> fetch_array();
                                    echo $result["cnt_menu"];
                                ?>
                                </span>
                                Menus available to order
                            </p>
                            <div class="text-end">
                                <a href="shop_menu_list.php" class="btn btn-sm btn-outline-dark">Go to Menu List</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END GRID OF ORDER NEEDED TO BE COMPLETE -->
        </div>
        <!-- END ADMIN GRID DASHBOARD -->
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