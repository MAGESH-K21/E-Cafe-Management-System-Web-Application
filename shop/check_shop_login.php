<?php
    session_start();
    include('../conn_db.php');

    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    $query = "SELECT s_id,s_username,s_name FROM shop WHERE
    s_username = '$username' AND s_pwd = '$pwd' LIMIT 0,1";

    $result = $mysqli -> query($query);
    if($result -> num_rows == 1){
        //customer login
        $row = $result -> fetch_array();
        $_SESSION["sid"] = $row["s_id"];
        $_SESSION["username"] = $username;
        $_SESSION["shopname"] = $row["s_name"];
        $_SESSION["utype"] = "shopowner";
        header("location: shop_home.php");
    }else{
        ?>
        <script>
            alert("Wrong username and/or password!");
            history.back();
        </script>
        <?php
    }
?>