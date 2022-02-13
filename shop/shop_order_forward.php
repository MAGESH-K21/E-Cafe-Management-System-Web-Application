<?php
    session_start();
    if($_SESSION["utype"]!="shopowner"){
        header("location: ../restricted.php");
        exit(1);
    }
    include('../conn_db.php');
    $orh_id = $_GET["orh_id"];
    $cur_stage = $_GET["cur_stage"];
    switch($cur_stage){
        case 1: $next_stage = "PREP"; $tme = NULL; break;
        case 2: $next_stage = "RDPK"; $tme = NULL; break;
        case 3: $next_stage = "FNSH"; $tme = date("Y-m-d\TH:i:s"); break;
        default: header("location: shop_order_list?up_ods=0"); exit(1);
    }
    $update_query = "UPDATE order_header SET orh_orderstatus = '{$next_stage}',orh_finishedtime = '{$tme}' WHERE orh_id = {$orh_id};";
    $update_result = $mysqli -> query($update_query);
    if($update_query){
        header("location: shop_order_list.php?up_ods=1");
    }else{
        header("location: shop_order_list.php?up_ods=0");
    }
    exit(1);
?>