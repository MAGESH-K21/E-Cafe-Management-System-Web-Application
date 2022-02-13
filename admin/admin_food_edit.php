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
            $s_id = $_POST["s_id"];
            $f_id = $_POST["f_id"];
            if(isset($_POST["f_todayavail"])){$f_todayavail = 1;}else{$f_todayavail = 0;}
            if(isset($_POST["f_preorderavail"])){$f_preorderavail = 1;}else{$f_preorderavail = 0;}
            $f_name = $_POST["f_name"];
            $f_price = $_POST["f_price"];
            $update_query = "UPDATE food SET f_name = '{$f_name}', f_price = '{$f_price}', f_todayavail = '{$f_todayavail}',
            f_preorderavail = '{$f_preorderavail}' WHERE f_id = {$f_id};";
            $update_result = $mysqli -> query($update_query);
            if(!empty($_FILES["f_pic"]["name"])){
                //Image upload
                $target_dir = '/img/';
                $temp = explode(".",$_FILES["f_pic"]["name"]);
                $target_newfilename = $f_id."_".$s_id.".".strtolower(end($temp));
                $target_file = $target_dir.$target_newfilename;
                if(move_uploaded_file($_FILES["f_pic"]["tmp_name"],SITE_ROOT.$target_file)){
                    $update_query = "UPDATE food SET f_pic = '{$target_newfilename}' WHERE f_id = {$f_id};";
                    $update_result = $mysqli -> query($update_query);
                }else{
                    $update_result = false;
                }
            }
            if($update_result){header("location: admin_food_detail.php?f_id={$f_id}&up_fdt=1");}
            else{header("location: admin_food_detail.php?f_id={$f_id}&up_fdt=0");}
            exit(1);
        }
        include('../head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <title>Update menu detail | EATERIO</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_admin.php')?>

    <div class="container form-signin mt-auto w-50">
        <a class="nav nav-item text-decoration-none text-muted" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        <?php 
            //Select customer record from database
            $s_id = $_GET["s_id"];
            $f_id = $_GET["f_id"];
            $query = "SELECT * FROM food WHERE f_id = {$f_id} LIMIT 0,1";
            $result = $mysqli ->query($query);
            $row = $result -> fetch_array();
        ?>
        <form method="POST" action="admin_food_edit.php" class="form-floating" enctype="multipart/form-data">
            <h2 class="mt-4 mb-3 fw-normal text-bold"><i class="bi bi-pencil-square me-2"></i>Update Menu Detail</h2>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="f_todayavail"
                name="f_todayavail" <?php if($row["f_todayavail"]){echo "checked";} ?>>
                <label class="form-check-label" for="f_todayavail">Menu avaliable for today</label>
            </div>
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="f_preorderavail" name="f_preorderavail" <?php if($row["f_preorderavail"]){echo "checked";} ?>>
                <label class="form-check-label" for="f_preorderavail">Accepting Pre-order for this menu</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="f_name" placeholder="f_name" name="f_name"
                value="<?php echo $row["f_name"];?>" required>
                <label for="f_name">Menu Name</label>
            </div>
            <div class="form-floating mb-2">
                <input type="number" step=".25" min="0.00" max="999.75" class="form-control" id="f_price" placeholder="Price (Rs.)" value="<?php echo $row["f_price"];?>" name="f_price" required>
                <label for="f_price">Price (Rs.)</label>
            </div>
            <div class="mb-2">
                <label for="formFile" class="form-label">Upload food image</label>
                <input class="form-control" type="file" id="f_pic" name="f_pic" accept="image/*">
            </div>
            <input type="hidden" name="s_id" value="<?php echo $s_id;?>">
            <input type="hidden" name="f_id" value="<?php echo $f_id;?>">
            <button class="w-100 btn btn-success mb-3" name="upd_confirm" type="submit">Update Menu Detail</button>
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