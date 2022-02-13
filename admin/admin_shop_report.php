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
        include("../shop/range_fn.php");
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/menu.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <script type="text/javascript" src="../js/revenue_date_selection.js"></script>
    <title>Shop Revenue Report | EATERIO</title>
</head>

<body class="d-flex flex-column h-100 bg-white">
    <?php include('nav_header_admin.php')?>

    <?php
        $s_id = $_GET["s_id"];
        $query = "SELECT s_name,s_location,s_openhour,s_closehour,s_status,s_preorderstatus,s_phoneno,s_pic
        FROM shop WHERE s_id = {$s_id} LIMIT 0,1";
        $result = $mysqli -> query($query);
        $shop_row = $result -> fetch_array();
    ?>

    <div class="container px-5 py-4" id="shop-body">
        <a class="nav nav-item text-decoration-none text-muted mb-2" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        <div class="container row row-cols-6 row-cols-md-12 g-5 pt-4 mb-4" id="shop-header">
            <div class="rounded-25 col-6 col-md-4" id="shop-img" style="
                    background: url(
                        <?php
                            if(is_null($shop_row["s_pic"])){echo "'../img/default.png'";}
                            else{echo "'../img/{$shop_row['s_pic']}'";}
                        ?> 
                    ) center; height: 225px;
                    background-size: cover; background-repeat: no-repeat;
                    background-position: center;">
            </div>
            <div class="col-6 col-md-8">
                <h1 class="display-5 strong"><?php echo $shop_row["s_name"];?></h1>
                <ul class="list-unstyled">
                    <li class="my-2">
                        <?php 
                            $now = date('H:i:s');
                            if((($now < $shop_row["s_openhour"])||($now > $shop_row["s_closehour"]))||($shop_row["s_status"]==0)){
                        ?>
                        <span class="badge rounded-pill bg-danger">Closed</span>
                        <?php }else{ ?>
                        <span class="badge rounded-pill bg-success">Open</span>
                        <?php }
                            if($shop_row["s_preorderstatus"]==1){
                        ?>
                        <span class="badge rounded-pill bg-success">Pre-order avaliable</span>
                        <?php }else{ ?>
                        <span class="badge rounded-pill bg-danger">Pre-order Unavaliable</span>
                        <?php } ?>
                    </li>
                    <li class=""><?php echo $shop_row["s_location"];?></li>
                    <li class="">Open hours:
                        <?php 
                            $open = explode(":",$shop_row["s_openhour"]);
                            $close = explode(":",$shop_row["s_closehour"]);
                            echo $open[0].":".$open[1]." - ".$close[0].":".$close[1];
                        ?>
                    </li>
                    <li class="">Telephone number: <?php echo "(+66) ".$shop_row["s_phoneno"];?></li>
                </ul>
                <a class="btn btn-sm btn-outline-secondary" href="admin_shop_pwd.php?s_id=<?php echo $s_id?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key"
                        viewBox="0 0 16 16">
                        <path
                            d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                        <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                    </svg>
                    Change password
                </a>
                <a class="btn btn-sm btn-primary mt-2 mt-md-0" href="admin_shop_edit.php?s_id=<?php echo $s_id?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path
                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd"
                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg>
                    Update shop profile
                </a>
                <a class="btn btn-sm btn-danger mt-2 mt-md-0" href="admin_shop_delete.php?s_id=<?php echo $s_id?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-trash" viewBox="0 0 16 16">
                        <path
                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                        <path fill-rule="evenodd"
                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                    </svg>
                    Delete this shop
                </a>
            </div>
        </div>

        <?php
            // Revenue Summary Preparation Part
            // 1: Indicate Range
            // rev_mode: 1 Today / 2 Yesterday / 3 This Week / 4 Monthly / 5 Specific Period
            $s_id = $_GET["s_id"];
            $rev_mode = $_GET["rev_mode"];
            $today = date("Y-m-d");
            $yesterday = (new Datetime()) -> sub(new DateInterval("P1D")) -> format('Y-m-d');
            $weekrange = rangeWeek(date('Y-n-j'));
            $monthrange = rangeMonth(date('Y-n-j'));
            switch($rev_mode){
                case 1: $start_date = $today; 
                        $end_date = $today; 
                        break;
                case 2: $start_date = $yesterday; 
                        $end_date = $yesterday; 
                        break;
                case 3: $start_date = (new Datetime($weekrange["start"])) -> format('Y-m-d');
                        $end_date = (new Datetime($weekrange["end"])) -> format('Y-m-d');
                        break;
                case 4: $start_date = (new Datetime($monthrange["start"])) -> format('Y-m-d');
                        $end_date = (new Datetime($monthrange["end"])) -> format('Y-m-d');
                        break;
                case 5: 
                        if(isset($_GET["start_date"])&&(isset($_GET["end_date"]))){
                            $start_date = $_GET["start_date"];
                            $end_date = $_GET["end_date"];
                        }else{
                            header("location: shop_report_select.php"); exit(1);
                        }
                        break;
                default: header("location: shop_report_select.php"); exit(1);
            }
            $formatted_start = (new Datetime($start_date)) -> format('F j, Y');
            $formatted_end = (new Datetime($end_date)) -> format('F j, Y');
        ?>

        <div class="container">
            <h3 class="border-top pt-3 my-2">
                <a class="text-decoration-none link-secondary"
                    href="admin_shop_detail.php?s_id=<?php echo $s_id?>">Menus</a>
                <span class="text-secondary">/</span>
                <a class="nav-item text-decoration-none link-secondary" href="admin_shop_order.php?s_id=<?php echo $s_id?>">Orders</a></span>
                <span class="text-secondary">/</span>
                <a class="nav-item text-decoration-none link-success"
                    href="admin_shop_revenue.php?s_id=<?php echo $s_id?>">Revenue</a></span>
            </h3>

            <a class="nav nav-item text-decoration-none text-muted my-3" href="#" onclick="history.back();">
                <i class="bi bi-arrow-left-square me-2"></i>Go back
            </a>
            <h3 class="display-6">Revenue Report</h3>
            <h4 class="fw-light">
                <?php 
                if($formatted_start==$formatted_end){
                    echo "Of {$formatted_start}";
                }else{
                    echo "From {$formatted_start} to {$formatted_end}";
                }
                $f_id =1;
            ?>
            </h4>
            <p class="fw-light">Generated on <?php echo date("F j, Y H:i")?>. This report only includes finished orders.
            </p>

            <h4 class="border-top fw-light pt-3 pb-2 mt-2">Overall Performance</h4>
            <div class="row row-cols-2 row-cols-md-4 mb-3 g-2">
                <div class="col">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                    $query = "SELECT SUM(ord.ord_amount*ord.ord_buyprice) AS rev FROM order_header orh INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
                                    WHERE orh.s_id = {$s_id} AND orh_orderstatus = 'FNSH' AND (DATE(orh_finishedtime) BETWEEN DATE('{$start_date}') AND DATE('{$end_date}'));";
                                    $result = $mysqli -> query($query) -> fetch_array();
                                    if(is_null($result["rev"])){$grandtotal = 0;} else{$grandtotal = $result["rev"];}
                                    printf("%.2f Rs.",$grandtotal);
                                ?>
                            </h5>
                            <p class="card-text small">Total revenue</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                    $query = "SELECT COUNT(*) AS cnt FROM order_header orh 
                                    WHERE orh.s_id = {$s_id} AND orh_orderstatus = 'FNSH' AND (DATE(orh_finishedtime) BETWEEN DATE('{$start_date}') AND DATE('{$end_date}'));";
                                    $result = $mysqli -> query($query) -> fetch_array();
                                    if(is_null($result["cnt"])){$num_order = 0;} else{$num_order = $result["cnt"];}
                                    printf("%d Orders",$num_order);
                                ?>
                            </h5>
                            <p class="card-text small">Number of orders</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                    $query = "SELECT COUNT(DISTINCT orh.c_id) AS cnt FROM order_header orh 
                                    WHERE orh.s_id = {$s_id} AND orh_orderstatus = 'FNSH' AND (DATE(orh_finishedtime) BETWEEN DATE('{$start_date}') AND DATE('{$end_date}'));";
                                    $result = $mysqli -> query($query) -> fetch_array();
                                    if(is_null($result["cnt"])){echo "0 Customers";} else{echo $result["cnt"]." Customers";}
                                ?>
                            </h5>
                            <p class="card-text small">Number of customers</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                    if($num_order == 0){echo "0.00 Rs.";}
                                    else{printf("%.2f Rs.",$grandtotal/$num_order);}
                                ?>
                            </h5>
                            <p class="card-text small">Averge cost per order</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                    $query = "SELECT SUM(ord.ord_amount) AS amt FROM order_header orh INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
                                    WHERE orh.s_id = {$s_id} AND orh_orderstatus = 'FNSH' AND (DATE(orh_finishedtime) BETWEEN DATE('{$start_date}') AND DATE('{$end_date}'));";
                                    $result = $mysqli -> query($query) -> fetch_array();
                                    if(is_null($result["amt"])){echo "0 plates";} else{echo $result["amt"]." plates";}
                                ?>
                            </h5>
                            <p class="card-text small">Number of plates sold</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                    $query = "SELECT f.f_name,SUM(ord.ord_amount) AS amt FROM order_header orh INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id INNER JOIN food f ON ord.f_id = f.f_id
                                    WHERE orh.s_id = {$s_id} AND orh_orderstatus = 'FNSH' AND (DATE(orh_finishedtime) BETWEEN DATE('{$start_date}') AND DATE('{$end_date}')) ORDER BY amt DESC LIMIT 0,1;";
                                    $result = $mysqli -> query($query) -> fetch_array();
                                    if(is_null($result["f_name"])){echo "-";} else{echo $result["f_name"];}
                                ?>
                            </h5>
                            <p class="card-text small">Best-Seller Menu</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                    $query = "SELECT HOUR(orh_ordertime) AS odh,COUNT(orh_id) AS cnt FROM order_header orh
                                    WHERE s_id = {$s_id} AND orh_orderstatus = 'FNSH' AND (DATE(orh_finishedtime) BETWEEN DATE('{$start_date}') AND DATE('{$end_date}')) GROUP BY odh ORDER BY cnt DESC;";
                                    $result = $mysqli -> query($query);
                                    $num_rows = $result -> num_rows;
                                    if($num_rows == 0){echo "-";}
                                    else{$result = $result->fetch_array(); echo "{$result['odh']}:00 - {$result['odh']}:59";}
                                ?>
                            </h5>
                            <p class="card-text small">Peak Ordering Hour</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                    $query = "SELECT HOUR(orh_finishedtime) AS odh,COUNT(orh_id) AS cnt FROM order_header orh
                                    WHERE s_id = {$s_id} AND orh_orderstatus = 'FNSH' AND (DATE(orh_finishedtime) BETWEEN DATE('{$start_date}') AND DATE('{$end_date}')) GROUP BY odh ORDER BY cnt DESC;";
                                    $result = $mysqli -> query($query);
                                    $num_rows = $result -> num_rows;
                                    if($num_rows == 0){echo "-";}
                                    else{$result = $result->fetch_array(); echo "{$result['odh']}:00 - {$result['odh']}:59";}
                                ?>
                            </h5>
                            <p class="card-text small">Peak Pick-Up Hour</p>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="border-top fw-light pt-3 mt-2">Menu Performance</h4>
            <?php
                $query = "SELECT f.f_name,f.f_price,SUM(ord.ord_amount) AS amount,SUM(ord.ord_amount*ord.ord_buyprice) AS subtotal FROM order_header orh INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id INNER JOIN food f ON ord.f_id = f.f_id
                WHERE orh.s_id = {$s_id} AND orh_orderstatus = 'FNSH' AND (DATE(orh_finishedtime) BETWEEN DATE('{$start_date}') AND DATE('{$end_date}'))
                GROUP BY ord.f_id ORDER BY amount DESC;";
                $result = $mysqli -> query($query);
                $num_rows = $result -> num_rows;
                if($num_rows > 0){
            ?>
            <div class="table-responsive">
                <table class="table rounded-5 table-light table-striped table-hover align-middle caption-top mb-5">
                    <caption><?php echo $num_rows;?> Menus</caption>
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">Rank</th>
                            <th scope="col">Menu name</th>
                            <th scope="col">Current Price</th>
                            <th scope="col">Amount Sold</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; while($row = $result -> fetch_array()){ ?>
                        <tr>
                            <th><?php echo $i++;?></th>
                            <td><?php echo $row["f_name"]?></td>
                            <td><?php echo $row["f_price"]." Rs."?></td>
                            <td><?php echo $row["amount"]." plates"?></td>
                            <td><?php echo $row["subtotal"]." Rs."?></td>
                        </tr>
                        <?php } ?>
                        <tr class="fw-bold table-info">
                            <td colspan="4" class="text-end">Grand Total</td>
                            <td><?php printf("%.2f Rs.",$grandtotal);?></td>
                        </tr>
                    </tbody>
                </table>
                <?php }else{ ?>
                <p class="fw-light">No records.</p>
                <?php } ?>

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