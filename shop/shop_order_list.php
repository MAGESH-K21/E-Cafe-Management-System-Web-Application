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
    <title>Customer Order List | SaiCafe</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_shop.php'); ?>

    <div class="container px-5 pt-4" id="shop-body">
        <a class="pt-4 nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>

        <?php
            if(isset($_GET["up_ods"])){
                if($_GET["up_ods"]==1){
                    ?>
            <!-- START SUCCESSFULLY UPDATE ORDER -->
            <div class="row row-cols-1 notibar">
                <div class="col ms-2 p-2 bg-success text-white rounded text-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-circle ms-2" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                    <span class="ms-2 mt-2">Successfully updated order status.</span>
                    <span class="me-2 float-end"><a class="text-decoration-none link-light" href="shop_order_list.php">X</a></span>
                </div>
            </div>
            <!-- END SUCCESSFULLY UPDATE ORDER -->
            <?php }else{ ?>
            <!-- START FAILED UPDATE ORDER -->
            <div class="row row-cols-1 notibar">
                <div class="col ms-2 p-2 bg-danger text-white rounded text-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-x-circle ms-2" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg><span class="ms-2 mt-2">Failed to update order status.</span>
                    <span class="me-2 float-end"><a class="text-decoration-none link-light" href="shop_order_list.php">X</a></span>
                </div>
            </div>
            <!-- END FAILED UPDATE ORDER -->
            <?php }
                }
            ?>

        <div class="my-3 text-wrap" id="shop-header">
            <h2 class="display-6 fw-light">Customer Order</h2>
        </div>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active px-4" id="acpt-tab" data-bs-toggle="tab" data-bs-target="#nav-acpt"
                    type="button" role="tab" aria-controls="nav-acpt"
                    aria-selected="true">ACPT | Accepted</button>
                <button class="nav-link px-4" id="prep-tab" data-bs-toggle="tab" data-bs-target="#nav-prep"
                    type="button" role="tab" aria-controls="nav-prep"
                    aria-selected="true">PREP | Preparing</button>
                <button class="nav-link px-4" id="rdpk-tab" data-bs-toggle="tab" data-bs-target="#nav-rdpk"
                    type="button" role="tab" aria-controls="nav-rdpk"
                    aria-selected="true">RDPK | Wait for pick-up</button>
                <button class="nav-link px-4" id="fnsh-tab" data-bs-toggle="tab" data-bs-target="#nav-fnsh"
                    type="button" role="tab" aria-controls="nav-fnsh" aria-selected="false">FNSH | Finished</button>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <!-- ONGOING ORDER TAB -->
            <div class="tab-pane fade show active p-3" id="nav-acpt" role="tabpanel" aria-labelledby="acpt-tab">
                <?php 
                $acpt_query = "SELECT * FROM order_header WHERE s_id = {$s_id} AND orh_orderstatus = 'ACPT' ORDER BY orh_pickuptime ASC;";
                $acpt_result = $mysqli -> query($acpt_query);
                $acpt_num = $acpt_result -> num_rows;
                if($acpt_num>0){
                ?>
                <div class="row row-cols-1 row-cols-md-3">
                    <!-- START EACH ORDER DETAIL -->
                    <?php while($og_row = $acpt_result -> fetch_array()){ ?>
                    <div class="col">
                        <a href="shop_order_detail.php?orh_id=<?php echo $og_row["orh_id"]?>"
                            class="text-dark text-decoration-none">
                            <div class="card mb-3">
                                <div class="card-header bg-info text-dark justify-content-between">
                                    <small class="me-auto d-flex" style="font-weight: 500;">Accepted order</small>
                                </div>
                                <div class="card-body">
                                    <div class="card-text row row-cols-1">
                                        <small>
                                        <div class="col">Order #<?php echo $og_row["orh_refcode"];?></div>
                                        <div class="col">Name: 
                                            <?php
                                            $cust_query = "SELECT c_firstname,c_lastname,c_type FROM customer WHERE c_id = {$og_row['c_id']};";
                                            $cust_arr = $mysqli -> query($cust_query) -> fetch_array();
                                            switch($cust_arr["c_type"]){
                                                case "STD": $cust_type = "Student"; break;
                                                case "INS": $cust_type = "Professor"; break;
                                                case "TAS": $cust_type = "Teaching Assistant"; break;
                                                case "STF": $cust_type = "Faculty Staff"; break;
                                                case "GUE": $cust_type = "Visitor"; break;
                                                default: $cust_type = "Other";
                                            }
                                            echo "{$cust_arr['c_firstname']} {$cust_arr['c_lastname']} ({$cust_type})";
                                        ?>
                                        </div>
                                        <div class="col mb-2">Pick-up time: 
                                            <?php 
                                            $order_time = (new Datetime($og_row["orh_ordertime"])) -> format("F j, Y H:i");
                                            echo $order_time;
                                            ?>
                                        </div>
                                        <?php 
                                        $ord_query = "SELECT COUNT(*) AS cnt,SUM(ord_amount*ord_buyprice) AS gt FROM order_detail WHERE orh_id = {$og_row['orh_id']}";
                                        $ord_arr = $mysqli -> query($ord_query) -> fetch_array();
                                    ?>
                                        <div class="col pt-2 mb-2 border-top"><?php echo $ord_arr["cnt"]?> menus | <?php echo $ord_arr["gt"]?> Rs.</div>
                                        </small>
                                        <div class="col">
                                            <ul class="list-unstyled">
                                            <?php
                                                $detail_query = "SELECT f.f_name,ord.ord_amount,ord.ord_note FROM order_detail ord INNER JOIN food f ON ord.f_id = f.f_id WHERE ord.orh_id = {$og_row['orh_id']}";
                                                $detail_result = $mysqli -> query($detail_query);
                                                while($detail_row = $detail_result -> fetch_array()){
                                            ?>
                                            <li><strong class="h5"><?php echo $detail_row["ord_amount"]?>x</strong> <?php echo $detail_row["f_name"]; if($detail_row["ord_note"]!=""){echo " ({$detail_row['ord_note']})";}?></li>
                                            <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="col text-end">
                                            <a href="shop_order_detail.php?orh_id=<?php echo $og_row["orh_id"]?>" class="btn btn-sm btn-outline-secondary">More Detail</a>
                                            <a href="shop_order_forward.php?orh_id=<?php echo $og_row["orh_id"]?>&cur_stage=1" class="btn btn-sm btn-success">Mark as Preparing</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                    <!-- END EACH ORDER DETAIL -->
                </div>
                <?php }else{ ?>
                <!-- IN CASE NO ORDER -->
                <div class="row row-cols-1">
                    <div class="col pt-3 px-3 bg-danger text-white rounded text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                        <p class="ms-2 mt-2">No order found.</p>
                    </div>
                </div>
                <!-- END CASE NO ORDER -->
                <?php } ?>
            </div>

            <div class="tab-pane fade p-3" id="nav-prep" role="tabpanel" aria-labelledby="prep-tab">
                <?php 
                $acpt_query = "SELECT * FROM order_header WHERE s_id = {$s_id} AND orh_orderstatus = 'PREP' ORDER BY orh_pickuptime ASC;";
                $acpt_result = $mysqli -> query($acpt_query);
                $acpt_num = $acpt_result -> num_rows;
                if($acpt_num>0){
                ?>
                <div class="row row-cols-1 row-cols-md-3">
                    <!-- START EACH ORDER DETAIL -->
                    <?php while($og_row = $acpt_result -> fetch_array()){ ?>
                    <div class="col">
                        <a href="shop_order_detail.php?orh_id=<?php echo $og_row["orh_id"]?>"
                            class="text-dark text-decoration-none">
                            <div class="card mb-3">
                                <div class="card-header bg-warning justify-content-between">
                                    <small class="me-auto d-flex" style="font-weight: 500;">Preparing order</small>
                                </div>
                                <div class="card-body">
                                    <div class="card-text row row-cols-1">
                                        <small>
                                        <div class="col">Order #<?php echo $og_row["orh_refcode"];?></div>
                                        <div class="col">Name: 
                                            <?php
                                            $cust_query = "SELECT c_firstname,c_lastname,c_type FROM customer WHERE c_id = {$og_row['c_id']};";
                                            $cust_arr = $mysqli -> query($cust_query) -> fetch_array();
                                            switch($cust_arr["c_type"]){
                                                case "STD": $cust_type = "Student"; break;
                                                case "INS": $cust_type = "Professor"; break;
                                                case "TAS": $cust_type = "Teaching Assistant"; break;
                                                case "STF": $cust_type = "Faculty Staff"; break;
                                                case "GUE": $cust_type = "Visitor"; break;
                                                default: $cust_type = "Other";
                                            }
                                            echo "{$cust_arr['c_firstname']} {$cust_arr['c_lastname']} ({$cust_type})";
                                        ?>
                                        </div>
                                        <div class="col mb-2">Pick-up time: 
                                            <?php 
                                            $order_time = (new Datetime($og_row["orh_ordertime"])) -> format("F j, Y H:i");
                                            echo $order_time;
                                            ?>
                                        </div>
                                        <?php 
                                        $ord_query = "SELECT COUNT(*) AS cnt,SUM(ord_amount*ord_buyprice) AS gt FROM order_detail WHERE orh_id = {$og_row['orh_id']}";
                                        $ord_arr = $mysqli -> query($ord_query) -> fetch_array();
                                    ?>
                                        <div class="col pt-2 mb-2 border-top"><?php echo $ord_arr["cnt"]?> menus | <?php echo $ord_arr["gt"]?> Rs.</div>
                                        </small>
                                        <div class="col">
                                            <ul class="list-unstyled">
                                            <?php
                                                $detail_query = "SELECT f.f_name,ord.ord_amount,ord.ord_note FROM order_detail ord INNER JOIN food f ON ord.f_id = f.f_id WHERE ord.orh_id = {$og_row['orh_id']}";
                                                $detail_result = $mysqli -> query($detail_query);
                                                while($detail_row = $detail_result -> fetch_array()){
                                            ?>
                                            <li><strong class="h5"><?php echo $detail_row["ord_amount"]?>x</strong> <?php echo $detail_row["f_name"]; if($detail_row["ord_note"]!=""){echo " ({$detail_row['ord_note']})";}?></li>
                                            <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="col text-end">
                                            <a href="shop_order_detail.php?orh_id=<?php echo $og_row["orh_id"]?>" class="btn btn-sm btn-outline-secondary">More Detail</a>
                                            <a href="shop_order_forward.php?orh_id=<?php echo $og_row["orh_id"]?>&cur_stage=2" class="btn btn-sm btn-success">Mark as Ready</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                    <!-- END EACH ORDER DETAIL -->
                </div>
                <?php }else{ ?>
                <!-- IN CASE NO ORDER -->
                <div class="row row-cols-1">
                    <div class="col pt-3 px-3 bg-danger text-white rounded text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                        <p class="ms-2 mt-2">No order found.</p>
                    </div>
                </div>
                <!-- END CASE NO ORDER -->
                <?php } ?>
            </div>

            <div class="tab-pane fade p-3" id="nav-rdpk" role="tabpanel" aria-labelledby="rdpk-tab">
                <?php 
                $acpt_query = "SELECT * FROM order_header WHERE s_id = {$s_id} AND orh_orderstatus = 'RDPK' ORDER BY orh_pickuptime ASC;";
                $acpt_result = $mysqli -> query($acpt_query);
                $acpt_num = $acpt_result -> num_rows;
                if($acpt_num>0){
                ?>
                <div class="row row-cols-1 row-cols-md-3">
                    <!-- START EACH ORDER DETAIL -->
                    <?php while($og_row = $acpt_result -> fetch_array()){ ?>
                    <div class="col">
                        <a href="shop_order_detail.php?orh_id=<?php echo $og_row["orh_id"]?>"
                            class="text-dark text-decoration-none">
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white justify-content-between">
                                    <small class="me-auto d-flex" style="font-weight: 500;">Ready to pick up</small>
                                </div>
                                <div class="card-body">
                                    <div class="card-text row row-cols-1">
                                        <small>
                                        <div class="col">Order #<?php echo $og_row["orh_refcode"];?></div>
                                        <div class="col">Name: 
                                            <?php
                                            $cust_query = "SELECT c_firstname,c_lastname,c_type FROM customer WHERE c_id = {$og_row['c_id']};";
                                            $cust_arr = $mysqli -> query($cust_query) -> fetch_array();
                                            switch($cust_arr["c_type"]){
                                                case "STD": $cust_type = "Student"; break;
                                                case "INS": $cust_type = "Professor"; break;
                                                case "TAS": $cust_type = "Teaching Assistant"; break;
                                                case "STF": $cust_type = "Faculty Staff"; break;
                                                case "GUE": $cust_type = "Visitor"; break;
                                                default: $cust_type = "Other";
                                            }
                                            echo "{$cust_arr['c_firstname']} {$cust_arr['c_lastname']} ({$cust_type})";
                                        ?>
                                        </div>
                                        <div class="col mb-2">Pick-up time: 
                                            <?php 
                                            $order_time = (new Datetime($og_row["orh_ordertime"])) -> format("F j, Y H:i");
                                            echo $order_time;
                                            ?>
                                        </div>
                                        <?php 
                                        $ord_query = "SELECT COUNT(*) AS cnt,SUM(ord_amount*ord_buyprice) AS gt FROM order_detail WHERE orh_id = {$og_row['orh_id']}";
                                        $ord_arr = $mysqli -> query($ord_query) -> fetch_array();
                                    ?>
                                        <div class="col pt-2 mb-2 border-top"><?php echo $ord_arr["cnt"]?> menus | <?php echo $ord_arr["gt"]?> Rs.</div>
                                        </small>
                                        <div class="col">
                                            <ul class="list-unstyled">
                                            <?php
                                                $detail_query = "SELECT f.f_name,ord.ord_amount,ord.ord_note FROM order_detail ord INNER JOIN food f ON ord.f_id = f.f_id WHERE ord.orh_id = {$og_row['orh_id']}";
                                                $detail_result = $mysqli -> query($detail_query);
                                                while($detail_row = $detail_result -> fetch_array()){
                                            ?>
                                            <li><strong class="h5"><?php echo $detail_row["ord_amount"]?>x</strong> <?php echo $detail_row["f_name"]; if($detail_row["ord_note"]!=""){echo " ({$detail_row['ord_note']})";}?></li>
                                            <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="col text-end">
                                            <a href="shop_order_detail.php?orh_id=<?php echo $og_row["orh_id"]?>" class="btn btn-sm btn-outline-secondary">More Detail</a>
                                            <a href="shop_order_forward.php?orh_id=<?php echo $og_row["orh_id"]?>&cur_stage=3" class="btn btn-sm btn-success">Mark as Finish</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                    <!-- END EACH ORDER DETAIL -->
                </div>
                <?php }else{ ?>
                <!-- IN CASE NO ORDER -->
                <div class="row row-cols-1">
                    <div class="col pt-3 px-3 bg-danger text-white rounded text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                        <p class="ms-2 mt-2">No order found.</p>
                    </div>
                </div>
                <!-- END CASE NO ORDER -->
                <?php } ?>
            </div>

            <div class="tab-pane fade p-3" id="nav-fnsh" role="tabpanel" aria-labelledby="fnsh-tab">
                <?php 
                $acpt_query = "SELECT * FROM order_header WHERE s_id = {$s_id} AND orh_orderstatus = 'FNSH' ORDER BY orh_finishedtime DESC;";
                $acpt_result = $mysqli -> query($acpt_query);
                $acpt_num = $acpt_result -> num_rows;
                if($acpt_num>0){
                ?>
                <div class="row row-cols-1 row-cols-md-3">
                    <!-- START EACH ORDER DETAIL -->
                    <?php while($og_row = $acpt_result -> fetch_array()){ ?>
                    <div class="col">
                        <a href="shop_order_detail.php?orh_id=<?php echo $og_row["orh_id"]?>"
                            class="text-dark text-decoration-none">
                            <div class="card mb-3">
                                <div class="card-header bg-success text-white justify-content-between">
                                    <small class="me-auto d-flex" style="font-weight: 500;">Order Finished</small>
                                </div>
                                <div class="card-body">
                                    <div class="card-text row row-cols-1">
                                        <small>
                                        <div class="col">Order #<?php echo $og_row["orh_refcode"];?></div>
                                        <div class="col">Name: 
                                            <?php
                                            $cust_query = "SELECT c_firstname,c_lastname,c_type FROM customer WHERE c_id = {$og_row['c_id']};";
                                            $cust_arr = $mysqli -> query($cust_query) -> fetch_array();
                                            switch($cust_arr["c_type"]){
                                                case "STD": $cust_type = "Student"; break;
                                                case "INS": $cust_type = "Professor"; break;
                                                case "TAS": $cust_type = "Teaching Assistant"; break;
                                                case "STF": $cust_type = "Faculty Staff"; break;
                                                case "GUE": $cust_type = "Visitor"; break;
                                                default: $cust_type = "Other";
                                            }
                                            echo "{$cust_arr['c_firstname']} {$cust_arr['c_lastname']} ({$cust_type})";
                                        ?>
                                        </div>
                                        <div class="col mb-2">Finished on  
                                            <?php 
                                            $order_time = (new Datetime($og_row["orh_finishedtime"])) -> format("F j, Y H:i");
                                            echo $order_time;
                                            ?>
                                        </div>
                                        <?php 
                                        $ord_query = "SELECT COUNT(*) AS cnt,SUM(ord_amount*ord_buyprice) AS gt FROM order_detail WHERE orh_id = {$og_row['orh_id']}";
                                        $ord_arr = $mysqli -> query($ord_query) -> fetch_array();
                                    ?>
                                        <div class="col pt-2 mb-2 border-top"><?php echo $ord_arr["cnt"]?> menus | <?php echo $ord_arr["gt"]?> Rs.</div>
                                        </small>
                                        <div class="col">
                                            <ul class="list-unstyled">
                                            <?php
                                                $detail_query = "SELECT f.f_name,ord.ord_amount,ord.ord_note FROM order_detail ord INNER JOIN food f ON ord.f_id = f.f_id WHERE ord.orh_id = {$og_row['orh_id']}";
                                                $detail_result = $mysqli -> query($detail_query);
                                                while($detail_row = $detail_result -> fetch_array()){
                                            ?>
                                            <li><strong class="h5"><?php echo $detail_row["ord_amount"]?>x</strong> <?php echo $detail_row["f_name"]; if($detail_row["ord_note"]!=""){echo " ({$detail_row['ord_note']})";}?></li>
                                            <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="col text-end">
                                            <a href="shop_order_detail.php?orh_id=<?php echo $og_row["orh_id"]?>" class="btn btn-sm btn-outline-secondary">More Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                    <!-- END EACH ORDER DETAIL -->
                </div>
                <?php }else{ ?>
                <!-- IN CASE NO ORDER -->
                <div class="row row-cols-1">
                    <div class="col pt-3 px-3 bg-danger text-white rounded text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                        <p class="ms-2 mt-2">No order found.</p>
                    </div>
                </div>
                <!-- END CASE NO ORDER -->
                <?php } ?>
            </div>

        </div>
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