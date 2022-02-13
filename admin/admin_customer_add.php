<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    session_start(); 
    include("../conn_db.php"); 
    include('../head.php');
    if($_SESSION["utype"]!="ADMIN"){
        header("location: ../restricted.php");
        exit(1);
    }
    if(isset($_POST["btn_add"])){
        $pwd = $_POST["pwd"];
        $cfpwd = $_POST["cfpwd"];
        if($pwd != $cfpwd){
            ?>
        <script>
            alert('The password is not match.\nPlease enter it again.');
            history.back();
        </script>
        <?php
            exit(1);
        }else{
            $username = $_POST["username"];
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $gender = $_POST["gender"];
            $email = $_POST["email"];
            $type = $_POST["type"];
            if($gender == "-" || $type == "-"){
            ?>
                <script>
                    alert('You didn\'t select your gender or role yet.\nPlease select again');
                    history.back();
                </script>
            <?php
                exit(1);
            }
            //Check for duplicating username
            $query = "SELECT c_username FROM customer WHERE c_username = '$username';";
            $result = $mysqli -> query($query);
            if($result -> num_rows >= 1){
                ?>
                <script>
                    alert('The username is already taken!');
                    history.back();
                </script>
            <?php
            }
            $result -> free_result();
            //Check for duplicating email
            $query = "SELECT c_email FROM customer WHERE c_email = '$email';";
            $result = $mysqli -> query($query);
            if($result -> num_rows >= 1){
            ?>
                <script>
                    alert('The email is already in use!');
                    history.back();
                </script>
            <?php
            }
            $result -> free_result();
            $query = "INSERT INTO customer (c_username,c_pwd,c_firstname,c_lastname,c_email,c_gender,c_type)
            VALUES ('$username','$pwd','$firstname','$lastname','$email','$gender','$type');";
            $result = $mysqli -> query($query);
            if($result){
                header("location: admin_customer_list.php?add_cst=1");
            }else{
                header("location: admin_customer_list.php?add_cst=0");
            }
        }
        exit(1);
    }

    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/login.css" rel="stylesheet">
    <title>Add New Customer | EATERIO</title>
</head>

<body class="d-flex flex-column">
    <?php include('nav_header_admin.php');?>
    <div class="container mt-4"></div>
    <div class="container form-signin mt-auto">
        <a class="nav nav-item text-decoration-none text-muted" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        <form method="POST" action="admin_customer_add.php" class="form-floating">
            <h2 class="mt-4 mb-3 fw-normal text-bold"><i class="bi bi-person-plus me-2"></i>Add New Customer</h2>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="username" placeholder="Username" name="username"
                    minlength="5" maxlength="45" required>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="pwd" placeholder="Password" name="pwd" minlength="8"
                    maxlength="45" required>
                <label for="pwd">Password</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="cfpwd" placeholder="Confirm Password" minlength="8"
                    maxlength="45" name="cfpwd" required>
                <label for="cfpwd">Confirm Password</label>
                <div id="passwordHelpBlock" class="form-text smaller-font">
                    Password must be at least 8 characters long.
                </div>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="firstname" placeholder="First Name" name="firstname"
                    required>
                <label for="firstname">First Name</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="lastname" placeholder="Last Name" name="lastname" required>
                <label for="lastname">Last Name</label>
            </div>
            <div class="form-floating mb-2">
                <input type="email" class="form-control" id="email" placeholder="E-mail" name="email" required>
                <label for="email">E-mail</label>
            </div>
            <div class="form-floating">
                <select class="form-select mb-2" id="gender" name="gender">
                    <option selected value="-">---</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="N">Non-binary</option>
                </select>
                <label for="gender"> Gender</label>
            </div>
            <div class="form-floating">
                <select class="form-select mb-2" id="type" name="type">
                    <option selected value="-">---</option>
                    <option value="STD">Student</option>
                    <option value="INS">Professor</option>
                    <option value="TAS">Teaching Assistant</option>
                    <option value="STF">Faculty Staff</option>
                    <option value="GUE">Visitor</option>
                    <option value="ADM">Admin</option>
                    <option value="OTH">Other</option>
                </select>
                <label for="gender">Role</label>
            </div>
            <button class="w-100 btn btn-success mb-3" type="submit" name="btn_add">Add new customer</button>
        </form>
    </div>
    <div class="container mt-4"></div>
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