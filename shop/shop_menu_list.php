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
        $s_id = $_SESSION["sid"];
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <title>Shop Menu List | SaiCafe</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_shop.php'); ?>

    <div class="container px-5 pt-4" id="shop-body">
        <div class="mt-4 border-bottom">
            <a class="nav nav-item text-decoration-none text-muted mb-2" href="#" onclick="history.back();">
                <i class="bi bi-arrow-left-square me-2"></i>Go back
            </a>

            <?php
            if(isset($_GET["dsb_fdt"])){
                if($_GET["dsb_fdt"]==1){
                    ?>
            <!-- START SUCCESSFULLY DELETE MENU -->
            <div class="row row-cols-1 notibar">
                <div class="col mt-2 ms-2 p-2 bg-success text-white rounded text-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-circle ms-2" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                    <span class="ms-2 mt-2">Successfully removed menu.</span>
                    <span class="me-2 float-end"><a class="text-decoration-none link-light" href="shop_menu_list.php">X</a></span>
                </div>
            </div>
            <!-- END SUCCESSFULLY DELETE MENU -->
            <?php }else{ ?>
            <!-- START FAILED DELETE MENU -->
            <div class="row row-cols-1 notibar">
                <div class="col mt-2 ms-2 p-2 bg-danger text-white rounded text-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-x-circle ms-2" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg><span class="ms-2 mt-2">Failed to remove menu.</span>
                    <span class="me-2 float-end"><a class="text-decoration-none link-light" href="shop_menu_list.php">X</a></span>
                </div>
            </div>
            <!-- END FAILED DELETE MENU -->
            <?php }
                }
            if(isset($_GET["add_fdt"])){
                if($_GET["add_fdt"]==1){
                    ?>
            <!-- START SUCCESSFULLY FOOD MENU -->
            <div class="row row-cols-1 notibar">
                <div class="col mt-2 ms-2 p-2 bg-success text-white rounded text-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-circle ms-2" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                    <span class="ms-2 mt-2">Successfully add new menu.</span>
                    <span class="me-2 float-end"><a class="text-decoration-none link-light" href="shop_menu_list.php">X</a></span>
                </div>
            </div>
            <!-- END SUCCESSFULLY FOOD MENU -->
            <?php }else{ ?>
            <!-- START FAILED FOOD MENU -->
            <div class="row row-cols-1 notibar">
                <div class="col mt-2 ms-2 p-2 bg-danger text-white rounded text-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-x-circle ms-2" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg><span class="ms-2 mt-2">Failed to add new menu.</span>
                    <span class="me-2 float-end"><a class="text-decoration-none link-light" href="shop_menu_list.php">X</a></span>
                </div>
            </div>
            <!-- END FAILED FOOD MENU -->
            <?php }
                }
            ?>

            <h2 class="pt-3 display-6">Menu List</h2>
            <form class="form-floating mb-3" method="GET" action="shop_menu_list.php">
                <div class="row g-2">
                    <div class="col">
                        <input type="text" class="form-control" id="f_name" name="f_name" placeholder="Food name"
                            <?php if(isset($_GET["search"])){?>value="<?php echo $_GET["f_name"];?>" <?php } ?>>
                    </div>
                    <div class="col-auto">
                        <button type="submit" name="search" class="btn btn-success">Search</button>
                        <button type="reset" class="btn btn-danger"
                            onclick="javascript: window.location='shop_menu_list.php'">Clear</button>
                        <a href="shop_menu_add.php" class="btn btn-primary">Add new menu</a>
                    </div>
                </div>
            </form>
        </div>
    <div class="pt-2" id="cust-table">

        <?php
            if(!isset($_GET["search"])){
                $search_query = "SELECT * FROM food f WHERE s_id = {$s_id};";
            }else{
                $search_fn=$_GET["f_name"];
                $search_query = "SELECT * FROM food f WHERE s_id = {$s_id} AND f_name LIKE '%{$search_fn}%';";
            }
            $search_result = $mysqli -> query($search_query);
            $search_numrow = $search_result -> num_rows;
            if($search_numrow == 0){
        ?>
        <div class="row">
            <div class="col mt-2 ms-2 p-2 bg-danger text-white rounded text-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-x-circle ms-2" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg><span class="ms-2 mt-2">No shop found!</span>
                <a href="shop_menu_list.php" class="text-white">Clear Search Result</a>
            </div>
        </div>
        <?php } else{ ?>
        <div class="table-responsive">
        <table class="table rounded-5 table-light table-striped table-hover align-middle caption-top mb-5">
            <caption><?php echo $search_numrow;?> menu(s) <?php if(isset($_GET["search"])){?><br /><a
                    href="shop_menu_list.php" class="text-decoration-none text-danger">Clear Search
                    Result</a><?php } ?></caption>
            <thead class="bg-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Menu name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Menu Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; while($row = $search_result -> fetch_array()){ ?>
                <tr>
                    <th><?php echo $i++;?></th>
                    <td><img 
                            <?php
                                if(is_null($row["f_pic"])){echo "src='../img/default.png'";}
                                else{echo "src=\"../img/{$row['f_pic']}\"";}
                            ?> 
                            style="width:75%; height:125px; object-fit:cover;"
                            class="img-fluid rounded" alt="<?php echo $food_row["f_name"]?>">
                    </td>
                    <td><?php echo $row["f_name"];?></td>
                    <td><?php echo $row["f_price"]." Rs.";?></td>
                    <td>
                    <?php 
                        if($row["f_todayavail"]==1){
                        ?>
                        <span class="badge rounded-pill bg-success">Available</span>
                        <?php }else{ ?>
                        <span class="badge rounded-pill bg-danger">Out of Order</span>
                        <?php }
                            if($row["f_preorderavail"]==1){
                        ?>
                        <span class="badge rounded-pill bg-success">Pre-order Available</span>
                        <?php }else{ ?>
                        <span class="badge rounded-pill bg-danger">Pre-order UnAvailable</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="shop_menu_detail.php?f_id=<?php echo $row["f_id"]?>"
                            class="btn btn-sm btn-primary">View</a>
                        <a href="shop_menu_edit.php?f_id=<?php echo $row["f_id"]?>"
                            class="btn btn-sm btn-outline-success">Edit</a>
                        <a href="shop_menu_delete.php?f_id=<?php echo $row["f_id"]?>"
                            class="btn btn-sm btn-outline-danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
        <?php }
            $search_result -> free_result();
        ?>
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