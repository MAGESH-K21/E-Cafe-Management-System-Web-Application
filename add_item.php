<?php
    session_start();
    include('conn_db.php');

    if(!isset($_SESSION["cid"])){
        header("locatiom: cust_login.php");
        exit(1);
    }

    $f_id = $_POST["f_id"];
    $s_id = $_POST["s_id"];
    $c_id = $_SESSION["cid"];
    $amount = $_POST["amount"];
    $request = $_POST["request"];

    $query = "SELECT s_id FROM cart WHERE c_id = {$c_id} GROUP BY c_id";
    $result = $mysqli -> query($query);

    if($result -> num_rows == 0){
        //No item in cart
        $insert_query = "INSERT INTO cart (c_id, s_id, f_id, ct_amount, ct_note) 
        VALUES ({$c_id},{$s_id},{$f_id},{$amount},'{$request}')";
        $atc_result = $mysqli -> query($insert_query);
    }else{
        //Already have item in cart
        $result_arr = $result -> fetch_array();
        $incart_shop = $result_arr["s_id"];
        if($incart_shop == $s_id){
            //Same shop
            $cartsearch = "SELECT ct_amount FROM cart WHERE c_id = {$c_id} AND f_id = {$f_id}";
            $cartsearch_result = $mysqli -> query($cartsearch);
            $cartsearch_row = $cartsearch_result -> num_rows;
            if($cartsearch_row == 0){
                //No this item in cart yet
                $insert_query = "INSERT INTO cart (c_id, s_id, f_id, ct_amount, ct_note) 
                VALUES ({$c_id},{$s_id},{$f_id},{$amount},'{$request}')";
                $atc_result = $mysqli -> query($insert_query);
            }else{
                //Already have item in cart
                $cartsearch_arr = $cartsearch_result -> fetch_array();
                $incart_amount = $cartsearch_arr["ct_amount"];
                $new_amount = $incart_amount + $amount;
                $update_query = "UPDATE cart SET ct_amount = {$new_amount} WHERE c_id = {$c_id} AND f_id = {$f_id} AND s_id = {$s_id}";
                $atc_result = $mysqli -> query($update_query);
            }
        }else{
            //Different shop
            //Delete all items in cart from previous shop
            $delelte_query = "DELETE FROM cart WHERE c_id = {$c_id}";
            $delete_result = $mysqli -> query($delelte_query);
            if($delete_result){
                //Insert new item to cart of new shop
                $insert_query = "INSERT INTO cart (c_id, s_id, f_id, ct_amount, ct_note) 
                VALUES ({$c_id},{$s_id},{$f_id},{$amount},'{$request}')";
                $atc_result = $mysqli -> query($insert_query);
            }else{
                $atc_result = false;
            }
        }
    }
    if($atc_result){
        header("location: shop_menu.php?s_id={$s_id}&atc=1");
        exit(1);
    }else{
        header("location: shop_menu.php?s_id={$s_id}&atc=0");
        exit(1);
    }
?>