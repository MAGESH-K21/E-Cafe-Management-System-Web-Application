<!--    NAV HEADER FOR CUSTOMER SIDE PAGE
        EXCEPT LOGIN AND REGISTRATION PAGE  -->

<header class="navbar navbar-expand-md navbar-light fixed-top bg-light shadow-sm mb-auto">
    <div class="container-fluid mx-3">
        <a href="index.php">
            <img src="img/LOGO_BLACK.png" width="75" class="me-2" alt="Sai Cafe">
        </a>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link px-2 text-dark" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a href="shop_list.php" class="nav-link px-2 text-dark font-weight-bold">Shop List</a>
                </li>
                <?php if(isset($_SESSION['cid'])){ ?>
                <li class="nav-item">
                    <a href="cust_order_history.php" class="nav-link px-2 text-dark">Order History</a>
                </li>
                <?php } ?>
            </ul>
            <div class="d-flex">
                <?php if(!isset($_SESSION['cid'])){ ?>
                <a class="btn btn-primary me-2" href="cust_regist.php">Sign Up</a>
                <a class="btn btn-success" href="cust_login.php">Log In</a>
                <?php }else{ ?>


                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a type="button" class="btn btn-light" href="cust_cart.php">
                            My Cart
                            <?php
                                $incart_query = "SELECT SUM(ct_amount) AS incart_amt FROM cart WHERE c_id = {$_SESSION['cid']}";
                                $incart_result = $mysqli -> query($incart_query) -> fetch_array(); 
                                $incart_amt = $incart_result["incart_amt"];
                                if($incart_amt>0){
                            ?>
                            <span class="ms-1 badge bg-success">
                                <?php echo $incart_amt;?>
                            </span>
                            <?php }else{ ?>
                                <span class="ms-1 badge bg-secondary">0</span>
                            <?php } ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cust_profile.php" class="nav-link px-2 text-dark">
                            Welcome, <?=$_SESSION['firstname']?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="mx-2 mt-1 mt-md-0 btn btn-outline-danger" href="logout.php">Log Out</a>
                    </li>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</header>