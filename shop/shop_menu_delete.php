<?php
    session_start();
    if($_SESSION["utype"]!="shopowner"){
        header("location: ../restricted.php");
        exit(1);
    }
    include('../conn_db.php');
    $f_id = $_GET["f_id"];
    //DISABLE FOOD ITEM INSTEAD OF DELETE IT
    $delete_query = "DELETE FROM food WHERE f_id = '{$f_id}';";
    $delete_result = $mysqli -> query($delete_query);
    if($delete_result){
        header("location: shop_menu_list.php?dsb_fdt=1");
    }else{
        header("location: shop_menu_list.php?dsb_fdt=0");
    }
?>