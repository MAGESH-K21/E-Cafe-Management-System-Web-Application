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
        include("range_fn.php");
        $s_id = $_SESSION["sid"];
        // Revenue Summary Preparation Part
        // 1: Indicate Range
        // rev_mode: 1 Today / 2 Yesterday / 3 This Week / 4 Monthly / 5 Specific Period
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
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <title>Shop Revenue Report | SaiCafe</title>
</head>

<body class="d-flex flex-column h-100">
    <?php
        echo "<div class='noprint'>";
        include('nav_header_shop.php');
        echo "</div>";
        // Format date to human-readable
        $formatted_start = (new Datetime($start_date)) -> format('F j, Y');
        $formatted_end = (new Datetime($end_date)) -> format('F j, Y');
    ?>
    <div class="container px-5 py-4" id="shop-body">
        <div class="mt-4">
            <a class="nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
                <i class="bi bi-arrow-left-square me-2"></i>Go back
            </a>
            <h2 class="display-6">Revenue Report</h2>
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
            <p class="fw-light">Generated on <?php echo date("F j, Y H:i")?>. This report only includes finished orders.</p>

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
            </div>
            <?php }else{ ?>
                <p class="fw-light">No records.</p>
            <?php } ?>
        </div>

    </div>


    </div>
    <!-- END GRID SHOP SELECTION -->

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