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
        if(isset($_POST["add_confirm"])){
            if(isset($_POST["s_status"])){$s_status = 1;}else{$s_status = 0;}
            if(isset($_POST["s_preorderstatus"])){$s_preorderstatus = 1;}else{$s_preorderstatus = 0;}
            $s_name = $_POST["s_name"];
            $s_username = $_POST["s_username"];
            $s_location = $_POST["s_location"];
            $s_email = $_POST["s_email"];
            $s_phoneno = $_POST["s_phoneno"];
            $s_openhour = $_POST["s_openhour"];
            $s_closehour = $_POST["s_closehour"];
            $insert_query = "INSERT INTO shop (s_username,s_name,s_location,s_openhour,s_closehour,s_email,s_phoneno,s_status,s_preorderstatus) 
            VALUES ('{$s_username}','{$s_name}','{$s_location}','{$s_openhour}','{$s_closehour}','{$s_email}','{$s_phoneno}',{$s_status},{$s_preorderstatus});";
            $insert_result = $mysqli -> query($insert_query);
            if(!empty($_FILES["s_pic"]["name"]) && $insert_result){
                //Image upload
                $s_id = $mysqli -> insert_id;
                $target_dir = '/img/';
                $temp = explode(".",$_FILES["s_pic"]["name"]);
                $target_newfilename = "shop".$s_id.".".strtolower(end($temp));
                $target_file = $target_dir.$target_newfilename;
                if(move_uploaded_file($_FILES["s_pic"]["tmp_name"],SITE_ROOT.$target_file)){
                    $insert_query = "UPDATE shop SET s_pic = '{$target_newfilename}' WHERE s_id = {$s_id};";
                    $insert_result = $mysqli -> query($insert_query);
                }else{
                    $insert_result = false;
                }
            }
            if($insert_result){header("location: admin_shop_list.php?add_shp=1");}
            else{header("location: admin_shop_list.php?add_shp=0");}
            exit(1);
        }
        include('../head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <title>Add new shop | EATERIO</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_admin.php')?>

    <div class="container form-signin mt-auto w-50">
        <a class="nav nav-item text-decoration-none text-muted" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        <form method="POST" action="admin_shop_add.php" class="form-floating" enctype="multipart/form-data">
            <h2 class="mt-4 mb-3 fw-normal text-bold"><i class="bi bi-pencil-square me-2"></i>Add New Shop</h2>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="shopstatus"
                name="s_status" checked>
                <label class="form-check-label" for="shopstatus">Opening for today</label>
            </div>
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="shoppreorderstatus" name="s_preorderstatus" checked>
                <label class="form-check-label" for="shoppreorderstatus">Accepting Pre-Order</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="shopusername" placeholder="Username" name="s_username"
                required>
                <label for="shopname">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="shopname" placeholder="Shop Name" name="s_name" required>
                <label for="shopname">Shop Name</label>
            </div>
            <div class="form-floating mb-2">
                <input type="email" class="form-control" id="email" placeholder="E-mail" name="s_email" required>
                <label for="email">E-mail</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="shoplocation" placeholder="Location" name="s_location" required>
                <label for="shoplocation">Shop Location</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="shopphoneno" placeholder="Phone Number" name="s_phoneno" required>
                <label for="shopphoneno">Phone Number</label>
            </div>
            <div class="row row-cols-2 g-2 mb-2">
                <div class="col">
                    <div class="form-floating">
                        <input type="time" class="form-control" id="shopopenhour" placeholder="Open Hour" name="s_openhour" required>
                        <label for="shopopenhour">Open Hour</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <input type="time" class="form-control" id="shopclosehour" placeholder="Close Hour" name="s_closehour" required>
                        <label for="shopopenhour">Close Hour</label>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <label for="formFile" class="form-label">Upload shop image</label>
                <input class="form-control" type="file" id="s_pic" name="s_pic" accept="image/*">
            </div>
            <button class="w-100 btn btn-success mb-3" name="add_confirm" type="submit">Add new shop</button>
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