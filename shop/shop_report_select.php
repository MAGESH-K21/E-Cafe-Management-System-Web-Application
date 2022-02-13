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
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <script type="text/javascript" src="../js/revenue_date_selection.js"></script>
    <title>Revenue Report | SaiCafe</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_shop.php'); ?>

    <div class="container form-signin">
        <a class="nav nav-item text-decoration-none text-muted" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        <form method="GET" action="shop_report_summary.php" class="form-floating">
            <h2 class="mt-4 mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                    class="bi bi-coin" viewBox="0 0 16 16">
                    <path
                        d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z" />
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                </svg> Revenue Report</h2>
            <p>Please select the option below to see your sales and revenue report.</p>
            <!-- 1 Today / 2 Yesterday / 3 This Week / 4 Monthly / 5 Specific Period -->
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rev_mode" id="rev_mode1" value="1" checked onclick="switch_disable(0)">
                <label class="form-check-label" for="rev_mode1">
                    Today<br />(<?php echo date('F j, Y');?>)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rev_mode" id="rev_mode2" value="2" onclick="switch_disable(0)">
                <label class="form-check-label" for="rev_mode2">
                    Yesterday<br />(<?php echo (new Datetime()) -> sub(new DateInterval("P1D")) -> format('F j, Y');?>)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rev_mode" id="rev_mode3" value="3" onclick="switch_disable(0)">
                <label class="form-check-label" for="rev_mode3">
                    This Week<br /> (<?php 
                    $weekrange = rangeWeek(date('Y-n-j'));
                    $week_start = (new Datetime($weekrange["start"])) -> format('F j, Y');
                    $week_end = (new Datetime($weekrange["end"])) -> format('F j, Y');
                    echo "{$week_start} - {$week_end}";
                    ?>)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rev_mode" id="rev_mode4" value="4" onclick="switch_disable(0)">
                <label class="form-check-label" for="rev_mode4">
                    This Month<br /> (<?php 
                    $monthrange = rangeMonth(date('Y-n-j'));
                    $month_start = (new Datetime($monthrange["start"])) -> format('F j, Y');
                    $month_end = (new Datetime($monthrange["end"])) -> format('F j, Y');
                    echo "{$month_start} - {$month_end}";
                    ?>)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="rev_mode" id="rev_mode5" value="5" onclick="switch_disable(1)">
                <label class="form-check-label" for="rev_mode5">
                    Specific Date<br />
                </label>
                <div class="row row-cols-2 g-0 mt-1 mb-2">
                    <div class="col">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="start_date" placeholder="Starting Date"
                                value="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d');?>" name="start_date"
                                oninput="update_minrange()" disabled>
                            <label for="start_date">Starting Date</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="end_date" placeholder="Ending Date"
                                value="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d');?>" name="end_date" disabled>
                            <label for="end_date">Ending Date</label>
                        </div>
                    </div>
                </div>
            </div>
            <button class="w-100 btn btn-outline-success my-3" type="submit">Generate Report</button>
        </form>
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