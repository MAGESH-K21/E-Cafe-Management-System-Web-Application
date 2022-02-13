<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        session_start(); 
        include("../conn_db.php"); 
        include('../head.php');
        if($_SESSION["utype"]!="ADMIN"){
            header("location: ../restricted.php");
            exit(1);
        }
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/menu.css" rel="stylesheet">
    <title>Order Detail | EATERIO</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_admin.php')?>

    <div class="container px-5 py-4" id="cart-body">
        <div class="row my-4 border-bottom">
            <a class="nav nav-item text-decoration-none text-muted mb-2" href="#" onclick="history.back();">
                <i class="bi bi-arrow-left-square me-2"></i>Go back
            </a>
            <h2 class="pt-3 display-5">Order Detail</h2>

            <?php
                $orh_id = $_GET["orh_id"];
                $orh_query = "SELECT * FROM order_header WHERE orh_id = {$orh_id}";
                $orh_arr = $mysqli -> query($orh_query) -> fetch_array();
            ?>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mb-2 mb-md-0">
                    <ul class="list-unstyled fw-light">
                        <li class="list-item mb-2">
                            <?php if($orh_arr["orh_orderstatus"]=="ACPT"){ ?>
                            <h5><span class="fw-bold badge bg-info text-dark">Accepted</span></h5>
                            <?php }else if($orh_arr["orh_orderstatus"]=="PREP"){ ?>
                            <h5><span class="fw-bold badge bg-warning text-dark">Preparing</span></h5>
                            <?php }else if($orh_arr["orh_orderstatus"]=="RDPK"){ ?>
                            <h5><span class="fw-bold badge bg-primary text-white">Ready to pick up</span></h5>
                            <?php }else if($orh_arr["orh_orderstatus"]=="FNSH"){?>
                            <h5><span class="fw-bold badge bg-success text-white">Completed</span></h5>
                            <?php } ?>
                        </li>
                        <li class="list-item">Order #<?php echo $orh_arr["orh_refcode"];?></li>
                        <li class="list-item">From
                            <a class="text-decoration-none link-primary"
                                href="admin_shop_detail.php?c_id=<?php echo $orh_arr['s_id']?>">
                                <?php
                                $shop_query = "SELECT s_name FROM shop WHERE s_id = {$orh_arr['s_id']};";
                                $shop_arr = $mysqli -> query($shop_query) -> fetch_array();
                                echo $shop_arr["s_name"];
                            ?>
                            </a>
                        </li>
                        <li class="list-item">Order of
                            <a class="text-decoration-none link-primary"
                                href="admin_customer_detail.php?c_id=<?php echo $orh_arr['c_id']?>">
                                <?php
                                $cust_query = "SELECT c_firstname,c_lastname FROM customer WHERE c_id = {$orh_arr['c_id']};";
                                $cust_arr = $mysqli -> query($cust_query) -> fetch_array();
                                echo $cust_arr["c_firstname"]." ".$cust_arr["c_lastname"];
                            ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col">
                    <ul class="list-unstyled fw-light">
                        <?php 
                            $od_placedate = (new Datetime($orh_arr["orh_ordertime"])) -> format("F j, Y H:i"); 
                            $od_pickupdate = (new Datetime($orh_arr["orh_pickuptime"])) -> format("F j, Y H:i");
                        ?>
                        <li class="mb-2">&nbsp;</li>
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
                <a class="btn btn-sm btn-primary mt-2 mt-md-0" href="admin_order_update.php?orh_id=<?php echo $_GET["orh_id"]?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path
                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                    <path fill-rule="evenodd"
                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                </svg>
                Update order status
                </a>
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
                                <a class="text-decoration-none"
                                    href="admin_food_detail.php?f_id=<?php echo $ord_row["f_id"]?>">
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
                                </a>
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

    <footer
        class="footer d-flex flex-wrap justify-content-between align-items-center px-5 py-3 mt-auto bg-secondary text-light">
        <span class="smaller-font">&copy; 2021 SeriousEater Group<br /><span class="xsmall-font">Paphana Y. Sirada C.
                Thanakit L.</span></span>
        <ul class="nav justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-light" target="_blank" href="https://github.com/waterthatfrozen/EATERIO"><i
                        class="bi bi-github"></i></a></li>
        </ul>
    </footer>
</body>

</html>