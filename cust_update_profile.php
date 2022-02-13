<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        session_start(); 
        include("conn_db.php"); 

        if(!isset($_SESSION["cid"])){
            header("location: restricted.php");
            exit(1);
        }
        if(isset($_POST["upd_confirm"])){
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["email"];
            $gender = $_POST["gender"];
            $type = $_POST["type"];

            $query = "UPDATE customer SET c_firstname = '{$firstname}', c_lastname = '{$lastname}', c_email = '{$email}', c_gender = '{$gender}', c_type = '{$type}' WHERE c_id = {$_SESSION['cid']}";
            $result = $mysqli -> query($query);
            if($result){
                $_SESSION["firstname"] = $firstname;
                $_SESSION["lastname"] = $lastname;
                header("location: cust_profile.php?up_prf=1");
            }else{
                header("location: cust_profile.php?up_prf=0");
            }
            exit(1);
        }
        include('head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    <title>Update profile | SaiCafe</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header.php')?>

    <div class="container form-signin mt-auto w-50">
        <a class="nav nav-item text-decoration-none text-muted" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        <?php 
            //Select customer record from database
            $query = "SELECT c_firstname,c_lastname,c_email,c_gender,c_type FROM customer WHERE c_id = {$_SESSION['cid']} LIMIT 0,1";
            $result = $mysqli ->query($query);
            $row = $result -> fetch_array();
        ?>
        <form method="POST" action="cust_update_profile.php" class="form-floating">
            <h2 class="mt-4 mb-3 fw-normal text-bold"><i class="bi bi-pencil-square me-2"></i>Update Profile</h2>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="firstname" placeholder="First Name" name="firstname"
                value="<?php echo $row["c_firstname"];?>" required>
                <label for="firstname">First Name</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="lastname" placeholder="Last Name" value="<?php echo $row["c_lastname"];?>" name="lastname" required>
                <label for="lastname">Last Name</label>
            </div>
            <div class="form-floating mb-2">
                <input type="email" class="form-control" id="email" placeholder="E-mail" name="email" value="<?php echo $row["c_email"];?>" required>
                <label for="email">E-mail</label>
            </div>
            <div class="form-floating">
                <select class="form-select mb-2" id="gender" name="gender">
                    <option value="M" <?php if($row["c_gender"]=="M"){echo "selected";}?>>Male</option>
                    <option value="F" <?php if($row["c_gender"]=="F"){echo "selected";}?>>Female</option>
                    <option value="N" <?php if($row["c_gender"]=="N"){echo "selected";}?>>Non-binary</option>
                </select>
                <label for="gender">Your Gender</label>
            </div>
            <div class="form-floating">
                <select class="form-select mb-2" id="type" name="type">
                    <option value="STD" <?php if($row["c_type"]=="STD"){echo "selected";}?>>Student</option>
                    <option value="INS" <?php if($row["c_type"]=="INS"){echo "selected";}?>>Professor</option>
                    <option value="TAS" <?php if($row["c_type"]=="TAS"){echo "selected";}?>>Teaching Assistant</option>
                    <option value="STF" <?php if($row["c_type"]=="STF"){echo "selected";}?>>Faculty Staff</option>
                    <option value="GUE" <?php if($row["c_type"]=="GUE"){echo "selected";}?>>Visitor</option>
                    <option value="OTH" <?php if($row["c_type"]=="OTH"){echo "selected";}?>>Other</option>
                </select>
                <label for="gender">Your role</label>
            </div>
            <button class="w-100 btn btn-success mb-3" name="upd_confirm" type="submit">Update Profile</button>
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