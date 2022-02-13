<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        session_start(); 
        include("../conn_db.php"); 
        if($_SESSION["utype"]!="ADMIN"){
            header("location: ../restricted.php");
            exit(1);
        }
        if(isset($_POST["upd_confirm"])){
            $orh_id = $_POST["orh_id"];
            $status = $_POST["os"];
            if($status == 'FNSH'){ $fnsh_date = date('Y-m-d\TH:i:s'); }else{$fnsh_date = "NULL";}
            $query = "UPDATE order_header SET orh_orderstatus = '{$status}', orh_finishedtime = '{$fnsh_date}' WHERE orh_id = {$orh_id};";
            $result = $mysqli -> query($query);
            if($result){
                header("location: admin_order_list.php?up_ods=1");
            }else{
                header("location: admin_order_list.php?up_ods=0");
            }
            exit(1);
        }
        include('../head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <title>Update Order Status | EATERIO</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_admin.php')?>

    <div class="container form-signin mt-auto w-50">
        <a class="nav nav-item text-decoration-none text-muted" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        <?php 
            //Select customer record from database
            $orh_id = $_GET["orh_id"];
            $query = "SELECT orh.orh_refcode,orh.orh_ordertime,c.c_firstname,c.c_lastname,orh.orh_orderstatus,orh.orh_pickuptime,p.p_amount,s.s_name
                FROM order_header orh INNER JOIN customer c ON orh.c_id = c.c_id INNER JOIN payment p ON p.p_id = orh.p_id 
                INNER JOIN shop s ON orh.s_id = s.s_id WHERE orh.orh_id = {$orh_id};";
            $result = $mysqli ->query($query);
            $row = $result -> fetch_array();
        ?>
        <form method="POST" action="admin_order_update.php" class="form-floating">
            <h2 class="mt-4 mb-3 fw-normal text-bold"><i class="bi bi-pencil-square me-2"></i>Update Order Status</h2>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="orderrefcode" placeholder="Order Reference Code" value="<?php echo $row["orh_refcode"];?>" disabled>
                <label for="orderrefcode">Order Reference Code</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="customername" placeholder="Customer Name" value="<?php echo $row["c_firstname"]." ".$row["c_lastname"];?>" disabled>
                <label for="customername">Customer Name</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="shopname" placeholder="Shop Name" value="<?php echo $row["s_name"];?>" disabled>
                <label for="shopname">Shop Name</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="ordercost" placeholder="Order Cost" value="<?php echo $row["p_amount"]." Rs.";?>" disabled>
                <label for="ordercost">Order Cost</label>
            </div>
            <div class="form-floating mb-2">
                <input type="datetime" class="form-control" id="pickuptime" placeholder="Pick-up time" value="<?php echo $row["orh_pickuptime"];?>" disabled>
                <label for="pickuptime">Pick-up time</label>
            </div>
            <div class="form-floating mb-2">
                <select class="form-select" id="orderstatus" name="os">
                    <option selected value="">Order Status</option>
                    <option value="ACPT" <?php if($row["orh_orderstatus"]=="ACPT"){ echo "selected";}?>>ACPT | Order Accepted</option>
                    <option value="PREP" <?php if($row["orh_orderstatus"]=="PREP"){ echo "selected";}?>>PREP | Order Preparing</option>
                    <option value="RDPK" <?php if($row["orh_orderstatus"]=="RDPK"){ echo "selected";}?>>RDPK | Ready for Pick-Up</option>
                    <option value="FNSH" <?php if($row["orh_orderstatus"]=="FNSH"){ echo "selected";}?>>FNSH | Order Finished</option>
                </select>
                <label for="orderstatus">Order Status</label>
            </div>
            <input type="hidden" name="orh_id" value="<?php echo $orh_id;?>">
            <button class="w-100 btn btn-success mb-3" name="upd_confirm" type="submit">Update order status</button>
        </form>
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