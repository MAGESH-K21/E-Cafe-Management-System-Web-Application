<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    session_start();
    if(!isset($_SESSION["cid"])){
        header("location: restricted.php");
        exit(1);
    }
    include("conn_db.php");
    include('head.php');
    $no_order = false;
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/menu.css" rel="stylesheet">
    <title>My Cart | SaiCafe</title>
</head>

<body class="d-flex flex-column h-100">

    <?php include('nav_header.php')?>

    <div class="container px-5 py-4" id="cart-body">
        <div class="row my-4">
            <a class="nav nav-item text-decoration-none text-muted mb-2" href="#" onclick="history.back();">
                <i class="bi bi-arrow-left-square me-2"></i>Go back
            </a>

            <?php 
            if(isset($_GET["up_crt"])){
                if($_GET["up_crt"]==1){
                    ?>
            <!-- START SUCCESSFULLY UPDATE CART -->
            <div class="row row-cols-1 notibar">
                <div class="col mt-2 ms-2 p-2 bg-success text-white rounded text-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-circle ms-2" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                    <span class="ms-2 mt-2">Successfully updated your item!</span>
                    <span class="me-2 float-end"><a class="text-decoration-none link-light" href="cust_cart.php">X</a></span>
                </div>
            </div>
            <!-- END SUCCESSFULLY UPDATE CART -->
            <?php }else{ ?>
            <!-- START FAILED UPDATE CART -->
            <div class="row row-cols-1 notibar">
                <div class="col mt-2 ms-2 p-2 bg-danger text-white rounded text-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-x-circle ms-2" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg><span class="ms-2 mt-2">Failed to update your item.</span>
                    <span class="me-2 float-end"><a class="text-decoration-none link-light" href="cust_cart.php">X</a></span>
                </div>
            </div>
            <!-- END FAILED UPDATE CART -->
            <?php } 
                } 
            if(isset($_GET["rmv_crt"])){
                if($_GET["rmv_crt"]==1){
                    ?>
            <!-- START SUCCESSFULLY DELETE ITEM FROM CART -->
            <div class="row row-cols-1 notibar">
                <div class="col mt-2 ms-2 p-2 bg-success text-white rounded text-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-circle ms-2" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                    <span class="ms-2 mt-2">Successfully remove your item!</span>
                    <span class="me-2 float-end"><a class="text-decoration-none link-light" href="cust_cart.php">X</a></span>
                </div>
            </div>
            <!-- END SUCCESSFULLY DELETE ITEM FROM CART -->
            <?php }else{ ?>
            <!-- START FAILED DELETE ITEM FROM CART -->
            <div class="row row-cols-1 notibar">
                <div class="col mt-2 ms-2 p-2 bg-danger text-white rounded text-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-x-circle ms-2" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg><span class="ms-2 mt-2">Failed to remove your item.</span>
                    <span class="me-2 float-end"><a class="text-decoration-none link-light" href="cust_cart.php">X</a></span>
                </div>
            </div>
            <!-- END FAILED DELETE ITEM FROM CART -->
            <?php } 
                }  ?>

            <h2 class="py-3 display-6 border-bottom">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-cart"
                    viewBox="0 0 16 16">
                    <path
                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </svg> My Cart
            </h2>
        </div>

        <?php 
            $ct_query = "SELECT * FROM cart WHERE c_id = {$_SESSION['cid']}";
            $cart_numrow = $mysqli -> query($ct_query) -> num_rows;
            if($cart_numrow > 0){
        ?>
        <!-- CASE: HAVE ITEM(S) IN THE CART -->
        <div class="row row-cols-1 row-cols-md-2 mb-5">
            <div class="col">
                <div class="row row-cols-1">
                    <div class="col">
                        <h5 class="fw-light">My Order</h5>
                        <p class="fw-light">From
                            <?php 
                                $cart_query = "SELECT s_id,s_name,s_openhour,s_closehour,s_status,s_preorderstatus FROM shop s WHERE s_id = (SELECT s_id FROM cart WHERE c_id = {$_SESSION['cid']} LIMIT 0,1)";
                                $cart_result = $mysqli -> query($cart_query) -> fetch_array();
                                echo $cart_result["s_name"];
                                $shop_open = $cart_result["s_openhour"];
                                $shop_close = $cart_result["s_closehour"];
                                if($cart_result["s_status"]==0 && $cart_result["s_preorderstatus"]==0){
                                    $disable_shop = true;
                                }else{
                                    $disable_shop = false;
                                    if($cart_result["s_status"]==0){
                                        $disable_today = true;
                                    }else{
                                        $disable_today = false;
                                    }
                                    if($cart_result["s_preorderstatus"]==0){
                                        $disable_preorder = true;
                                    }else{
                                        $disable_preorder = false;
                                    }
                                }
                            ?>
                        </p>
                    </div>

                    <?php
                        //calculate min max of datetime input
                        $now_time = date("H:i");
                        $now_date = date("Y-m-d");
                        $now_datetime = $now_date."T".$now_time;
                        $tomorrow_date = (new Datetime($now_date)) -> add(new DateInterval("P1D")) -> format('Y-m-d');
                        $shop_open_arr = explode(":",$shop_open);
                        $shop_open = $shop_open_arr[0].":".$shop_open_arr[1];
                        $shop_close_arr = explode(":",$shop_close);
                        $shop_close = $shop_close_arr[0].":".$shop_close_arr[1];

                        if($now_time >= $shop_open && $now_time < $shop_close){
                            $shop_opening = true;
                        }else{
                            $shop_opening = false;
                        }

                        if($no_order){
                            $min_date = $now_date; $max_date = $now_date;
                            $min_time = $now_time; $min_time = $now_time;
                        }else{
                            if($disable_preorder){
                                $min_date = $now_date; $max_date = $now_date;
                                $min_time = $now_time; $max_time = $shop_close;
                            }else if($disable_today){
                                $min_date = $tomorrow_date; $max_date = $tomorrow_date;
                                $min_time = $shop_open; $max_time = $shop_close;
                            }else{
                                $max_date = $tomorrow_date;
                                $max_time = $shop_close;
                                if($now_time<$shop_open){ 
                                    $min_date = $now_date; 
                                    $min_time = $shop_open; 
                                }else if($now_time>$shop_close){
                                    $min_date = $tomorrow_date; 
                                    $min_time = $shop_open;
                                }else{
                                    $min_date = $now_date;
                                    $min_time = $now_time;
                                }
                            }
                        }

                        $min_datetime = $min_date."T".$min_time;
                        $max_datetime = $max_date."T".$max_time;
                    ?>

                    <div class="col">
                        <ul class="list-group">
                            <!-- START CART ITEM -->
                            <?php
                                $cartdetail_query = "SELECT ct.ct_amount,ct.f_id,f_pic,f.f_name,f.f_price,ct.ct_note,f_todayavail,f_preorderavail
                                FROM cart ct INNER JOIN food f ON ct.f_id = f.f_id WHERE ct.c_id = {$_SESSION['cid']}";
                                $cartdetail_result = $mysqli -> query($cartdetail_query);
                                while($row = $cartdetail_result -> fetch_array()){
                            ?>
                            <li
                                class="list-group-item d-flex border-0 pb-3 border-bottom w-100 justify-content-between align-items-center">
                                <div class="image-parent">
                                    <img <?php
                                        if(is_null($row["f_pic"])){echo "src='img/default.png'";}
                                        else{echo "src=\"img/{$row['f_pic']}\"";}
                                    ?> class="img-fluid rounded" style="width: 100px; height:100px; object-fit:cover;"
                                        alt="quixote">
                                </div>
                                <div class="ms-3 mt-3 me-auto">
                                    <div class="fw-normal"><span class="h5"><?php echo $row["ct_amount"]?>x</span>
                                        <?php echo $row["f_name"]?>
                                        <p><?php printf("%.2f Rs. <small class='text-muted'>(%.2f Rs. each)</small>",$row["f_price"]*$row["ct_amount"],$row["f_price"])?><br />
                                            <span class="text-muted small"> <?php echo $row["ct_note"]?></span>
                                            <ul class="list-unstyled list-inline">
                                                <li>
                                                <?php
                                                    $rmv = false;
                                                    $rmv_link = false;
                                                    if($disable_shop || ($disable_preorder && !$shop_opening)){
                                                        $rmv = true;
                                                    }else{
                                                        if($row["f_todayavail"]==0 && $row["f_preorderavail"]==0){ 
                                                            $rmv = true;
                                                        ?>
                                                        <span class="badge rounded-pill bg-danger">Out of stock</span>
                                                        <?php } 
                                                        else if($row["f_todayavail"]==0){ ?>
                                                        <span class="badge rounded-pill bg-danger">Today Unavailable</span>
                                                        <?php 
                                                            if($disable_preorder){$rmv = true;}
                                                        } 
                                                        else if($row["f_preorderavail"]==0){?>
                                                        <span class="badge rounded-pill bg-danger">Pre-order Unavailable</span>
                                                        <?php 
                                                            if(!$shop_opening||$disable_today){$rmv = true;}
                                                        }
                                                    }
                                                    if($rmv){
                                                        $no_order = true; 
                                                        $rmv_link = true;
                                                    }
                                                ?>
                                                </li>
                                            </ul>
                                        </p>
                                        <?php if($rmv_link){?>
                                        <a href="remove_cart_item.php?rmv=1&s_id=<?php echo $cart_result["s_id"];?>&f_id=<?php echo $row["f_id"];?>"
                                            class="text-decoration-none text-danger nav nav-item small">Remove item</a>
                                        <?php }else {?>
                                        <a href="cust_update_cart.php?s_id=<?php echo $cart_result["s_id"];?>&f_id=<?php echo $row["f_id"];?>"
                                            class="text-decoration-none text-success nav nav-item small">Edit item</a>
                                        <?php } ?>
                                    </div>
                            </li>
                            <!-- END CART ITEM -->
                            <?php } ?>
                        </ul>
                        <div class="col my-3">
                            <ul class="list-inline justify-content-between">
                                <li class="list-item mb-2">
                                    <a href="remove_cart_all.php?rmv=1&s_id=<?php echo $cart_result["s_id"];?>"
                                        class="nav nav-item text-danger text-decoration-none small" name="rmv_all" id="rmv_all">
                                        Remove all item in cart
                                    </a>
                                </li>
                                <li class="list-inline-item fw-light me-5">Grand Total</li>
                                <li class="list-inline-item fw-bold h4">
                                    <?php
                                        $gt_query = "SELECT SUM(ct.ct_amount*f.f_price) AS grandtotal FROM cart ct INNER JOIN food f 
                                        ON ct.f_id = f.f_id WHERE ct.c_id = {$_SESSION['cid']} GROUP BY ct.c_id";
                                        $gt_arr = $mysqli -> query($gt_query) -> fetch_array();
                                        $order_cost = $gt_arr["grandtotal"];
                                        printf("%.2f Rs. ",$order_cost);
                                        if($order_cost<20){
                                            $min_cost = false;  $no_order=true;
                                        }else{
                                            $min_cost = true;
                                        }
                                    ?>
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mt-3 mt-md-0">
                <div class="row row-cols-1">
                    <div class="col mb-3">
                        <div class="card p-2 p-md-4 border-0 border-bottom">
                            <h5 class="card-title fw-light">My Information</h5>
                            <ul class="card-text list-unstyled m-0 p-0 small">
                                <?php 
                                    $cust_query = "SELECT c_email FROM customer WHERE c_id = {$_SESSION['cid']} LIMIT 0,1";
                                    $cust_arr = $mysqli -> query($cust_query) -> fetch_array();
                                ?>
                                <li>Name: <?php echo $_SESSION["firstname"]." ".$_SESSION["lastname"]; ?></li>
                                <li>Email: <?php echo $cust_arr["c_email"]?> </li>
                            </ul>
                        </div>
                    </div>
                    <form method="POST" action="add_order.php">
                        <div class="col mb-1">
                            <div class="card px-2 px-md-4 pb-1 pb-md-2 border-0">
                                <h5 class="card-title fw-light">Pick-Up Detail</h5>
                                <label for="pickuptime" class="form-label small">Pick-Up Date and Time</label>
                                <input type="datetime-local" class="form-control" name="pickuptime" id="pickuptime"
                                    min="<?php echo $min_datetime?>" max="<?php echo $max_datetime?>"
                                    value="<?php echo $min_datetime?>"
                                    <?php if($no_order){echo "disabled";}?>
                                >
                                <input type="hidden" name="payamount" value="<?php echo $order_cost*100;?>">
                                <div id="passwordHelpBlock" class="form-text smaller-font pt-2">
                                    <!-- SUBJECTED TO CHANGE LATER -->
                                    <ul class="list-unstyled">
                                        <?php 
                                            $shop_timerange = $shop_open." to ".$shop_close;
                                            if($disable_shop || ($disable_preorder && !$shop_opening)){
                                                //Case 1: Shop Closed OR (Disabled Pre-order and already close for the day)
                                        ?>
                                        <li class="list-item text-danger fw-bold">This shop is not accepting any order.</li>
                                        <?php }else{
                                                if($disable_today){
                                                //Case 2: Shop close today but accept pre-order
                                            ?>
                                        <li class="list-item text-danger fw-bold">This shop is not accepting order for today.</li>
                                        <li class="list-item">But, you can pick-up order tomorrow from <?php echo $shop_timerange;?></li>
                                        <?php } else if($disable_preorder){
                                                //Case 3: Shop open today but NOT accepting pre-order
                                        ?>
                                        <li class="list-item">You can order from this shop until<?php echo $shop_close?></li>
                                        <li class="list-item text-danger fw-bold">But, this shop is not accepting any pre-order.</li>
                                        <?php } else { 
                                                //Case 4: Shop open and accept pre-order
                                                    if($shop_opening){
                                                    //Case 4.1: Shop window is open    
                                        ?>
                                        <li class="list-item">You can order from this shop until <?php echo $shop_close?></li>
                                        <li class="list-item">Also, you can pick-up order tomorrow from <?php echo $shop_timerange;?></li>
                                        <?php       }else if($now_time<$shop_open){ 
                                                    //Case 4.2: Shop window is not open yet ?>
                                        <li class="list-item">This shop will open today from <?php echo $shop_timerange;?>.</li>
                                        <li class="list-item">You can also pick-up order tomorrow from <?php echo $shop_timerange;?></li>
                                        <?php       }else{ //Case 4.2: Shop window is already close for today ?>
                                        <li class="list-item text-danger fw-bold">This shop is already closed for today.</li>
                                        <li class="list-item">But, you can pick-up order tomorrow from <?php echo $shop_timerange;?></li>
                                        <?php }
                                                }
                                            } 
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <?php if($no_order){ ?>
                            <button type="submit" class="w-100 btn btn-danger disabled" name="place_order" id="place_order"
                                disabled>
                                <?php
                                    if(!$min_cost){
                                        echo "Your order is less than minimum amount.";
                                    }else{
                                        echo "Cannot proceed with payment";
                                    }
                                ?>
                            </button>
                            <?php }else{ ?>
                            <script type="text/javascript" src="https://cdn.omise.co/omise.js"
                                data-key="pkey_test_5qtd0o2x3znnduisr3e"
                                data-image="https://drive.google.com/file/d/1fen9-eomrWPnZhmcQ2u-sqHLRex4ir4U/view?usp=sharing"
                                data-frame-label="Sai Cafe"
                                data-button-label="Proceed with payment"
                                data-submit-label="Submit"
                                data-locale="en"
                                data-location="no"
                                data-amount="<?php echo $order_cost*100;?>"
                                data-currency="THB">
                            </script>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END CASE: HAVE ITEM(S) IN THE CART -->
        <?php }else{ ?>
        <!-- CASE: NO ITEM IN THE CART -->
        <div class="row row-cols-1 notibar">
            <div class="col mt-2 ms-2 p-2 bg-danger text-white rounded text-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-x-circle ms-2" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg><span class="ms-2 mt-2">You have no item in the cart</span>
            </div>
        </div>
        <!-- END CASE: NO ITEM IN THE CART -->
        <?php } ?>

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

<!-- Apply class to omise payment button -->
<script type="text/javascript">
    var pay_btn = document.getElementsByClassName("omise-checkout-button");
    pay_btn[0].classList.add("w-100","btn","btn-primary");
</script>
</html>