<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("conn_db.php"); include('head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/login.css" rel="stylesheet">

    <title>Failed to Register | SaiCafe</title>
</head>

<body class="d-flex flex-column h-100">
    <header class="navbar navbar-light fixed-top bg-light shadow-sm mb-auto">
        <div class="container-fluid mx-4">
            <a href="index.php">
                <img src="img/LOGO_BLACK.png" width="75" class="me-2" alt="Sai Cafe Logo">
            </a>
        </div>
    </header>
    <div class="mt-5"></div>
    <div class="container form-signin text-center reg-fail mt-auto">
            <i class="mt-4 bi bi-exclamation-circle text-danger h1 display-2"></i>
            <h3 class="mt-2 mb-3 fw-normal text-bold">Unable to register</h3>
            <p class="mb-3 fw-normal text-bold">Sorry, we have encountered with the error.<br/>
                <code>
                    <?php
                        $error_code = $_GET["err"];
                        if ($error_code == 1062){
                            echo "There is an account with same username or email";
                        }else{
                            echo "Error Code: {$error_code}";
                        }
                    ?>
                </code>
            </p>
            <a class="btn btn-danger btn-sm w-50" href="index.php">Return to Home</a>
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