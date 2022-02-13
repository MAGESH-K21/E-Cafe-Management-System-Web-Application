<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        session_start(); 
        include("../conn_db.php"); 
        include('../head.php');
        if($_SESSION["utype"]!="shopowner"){
            header("location: ../restricted.php");
            exit(1);
        }
        $s_id = $_SESSION["sid"];
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/menu.css" rel="stylesheet">
    <title>Order Detail | SaiCafe</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_shop.php')?>

    <?php
        $orh_id = $_GET["orh_id"];
        $orh_query = "SELECT * FROM order_header WHERE orh_id = {$orh_id}";
        $orh_arr = $mysqli -> query($orh_query) -> fetch_array();
    ?>

    <div class="container px-5 pt-4" id="cart-body">
        <div class="row my-4 border-bottom">
            <a class="nav nav-item text-decoration-none text-muted mb-2" href="#" onclick="history.back();">
                <i class="bi bi-arrow-left-square me-2"></i>Go back
            </a>
            <h2 class="pt-3 display-5">Order #<?php echo $orh_arr["orh_refcode"];?></h2>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mb-2 mb-md-0">
                    <ul class="list-unstyled fw-light">
                        <li class="list-item mb-2">
                            <?php if($orh_arr["orh_orderstatus"]=="ACPT"){ ?>
                            <h5>Current Status: <span class="fw-bold badge bg-info text-dark">Accepted</span></h5>
                            <?php }else if($orh_arr["orh_orderstatus"]=="PREP"){ ?>
                            <h5>Current Status: <span class="fw-bold badge bg-warning text-dark">Preparing</span></h5>
                            <?php }else if($orh_arr["orh_orderstatus"]=="RDPK"){ ?>
                            <h5>Current Status: <span class="fw-bold badge bg-primary text-white">Ready to pick up</span></h5>
                            <?php }else if($orh_arr["orh_orderstatus"]=="FNSH"){?>
                            <h5>Current Status: <span class="fw-bold badge bg-success text-white">Completed</span></h5>
                            <?php } ?>
                        </li>
                        <li class="list-item">Order of
                            <?php
                                $cust_query = "SELECT c_firstname,c_lastname,c_type FROM customer WHERE c_id = {$orh_arr['c_id']};";
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
                        </li>
                    </ul>
                </div>
                <div class="col">
                    <ul class="list-unstyled fw-light">
                        <?php 
                            $od_placedate = (new Datetime($orh_arr["orh_ordertime"])) -> format("F j, Y H:i"); 
                            $od_pickupdate = (new Datetime($orh_arr["orh_pickuptime"])) -> format("F j, Y H:i");
                        ?>
                        <li>Placed on <?php echo $od_placedate;?></li>
                        <li>Pick-up time is <?php echo $od_pickupdate;?></li>
                        <?php if($orh_arr["orh_orderstatus"]!="FNSH"){ ?>
                        <li>The order is not finish yet.</li>
                        <?php }else{
                            $od_finishtime = (new Datetime($orh_arr["orh_finishedtime"])) -> format("F j, Y H:i");
                        ?>
                        <li>Finished on <?php echo $od_finishtime;?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                <?php if($orh_arr["orh_orderstatus"]!='FNSH'){ ?>
                <a class="btn btn-sm btn-warning mt-2 mt-md-0" href="shop_order_forward.php?orh_id=<?php echo $_GET["orh_id"]?>&cur_stage=1">Mark as Preparing</a>
                <a class="btn btn-sm btn-primary mt-2 mt-md-0" href="shop_order_forward.php?orh_id=<?php echo $_GET["orh_id"]?>&cur_stage=2">Mark as Ready for pick-up</a>
                <a class="btn btn-sm btn-success mt-2 mt-md-0" href="shop_order_forward.php?orh_id=<?php echo $_GET["orh_id"]?>&cur_stage=3">Mark as Finished</a>
                <?php }?>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <div class="row row-cols-1">
                    <div class="col">
                        <h5 class="fw-light">Menu</h5>
                    </div>
                    <div class="col row row-cols-1 row-cols-md-2 border-bottom">
                        <?php 
                            $ord_query = "SELECT f.f_id,f.f_name,f.f_pic,ord.ord_amount,ord.ord_buyprice,ord_note FROM order_detail ord INNER JOIN food f ON ord.f_id = f.f_id WHERE ord.orh_id = {$orh_id}";
                            $ord_result = $mysqli -> query($ord_query);
                            while($ord_row = $ord_result -> fetch_array()){
                        ?>
                        <div class="col">
                            <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex border-0 pb-3 border-bottom w-100 justify-content-between align-items-center">
                                        <div class="image-parent">
                                            <img <?php
                                            if(is_null($ord_row["f_pic"])){echo "src='../img/default.png'";}
                                            else{echo "src=\"../img/{$ord_row['f_pic']}\"";}
                                        ?> class="img-fluid rounded"
                                                style="width: 100px; height:100px; object-fit:cover;"
                                                alt="<?php echo $ord_row["f_name"]?>">
                                        </div>
                                        <div class="ms-3 me-auto">
                                            <div class="fw-normal"><span class="h5"><?php echo $ord_row["ord_amount"]?>x
                                                </span><?php echo $ord_row["f_name"]?>
                                                <p><?php printf("%.2f Rs. <small class='text-muted'>(%.2f Rs. each)</small>",$ord_row["ord_buyprice"]*$ord_row["ord_amount"],$ord_row["ord_buyprice"]);?><br />
                                                    <span
                                                        class="text-muted small"><?php echo $ord_row["ord_note"]?></span>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                            </ul>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col my-3">
                        <ul class="list-inline justify-content-between">
                            <li class="list-inline-item fw-light me-5">Grand Total</li>
                            <li class="list-inline-item fw-bold h4">
                                <?php
                                    $gt_query = "SELECT SUM(ord_amount*ord_buyprice) AS gt FROM order_detail WHERE orh_id = {$orh_id}";
                                    $gt_arr = $mysqli -> query($gt_query) -> fetch_array();
                                    printf("%.2f Rs.",$gt_arr["gt"]);
                                ?>
                            </li>
                            <li class="list-item fw-light small">Pay by
                                <?php 
                                    $py_query = "SELECT p_type,p_detail FROM payment WHERE p_id = {$orh_arr['p_id']} LIMIT 0,1;";
                                    $py_arr = $mysqli -> query($py_query) -> fetch_array();
                                    switch($py_arr["p_type"]){
                                        case "CRDC": echo "Credit Card"; break;
                                        case "DBTC": echo "Debit Card"; break;
                                        case "PPDC": echo "Prepaid Card"; break;
                                        case "PMTP": echo "Promptpay QR Code"; break;
                                        case "TMNY": echo "TrueMoney"; break;
                                        case "PYPL": echo "Paypal"; break;
                                        default: echo "Default Payment Channel";
                                    }
                                    echo " ".$py_arr["p_detail"];
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
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