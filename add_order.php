<?php
    session_start();
    date_default_timezone_set('Asia/Bangkok');
    include('conn_db.php');
    $pickuptime = $_POST["pickuptime"];
    $payamount = $_POST["payamount"];
    //Check which shop customer selected
    //and validate the selected pick-up time
    $shop_query = "SELECT s_id,s_openhour,s_closehour,s_status,s_preorderstatus FROM shop
    WHERE s_id = (SELECT s_id FROM cart WHERE c_id = {$_SESSION['cid']} GROUP BY c_id)";
    $shop_arr = $mysqli -> query($shop_query) -> fetch_array();
    $shop_id = $shop_arr["s_id"];
    $shop_open_arr = explode(":",$shop_arr["s_openhour"]);
    $shop_close_arr = explode(":",$shop_arr["s_closehour"]);
    $shop_open = $shop_open_arr[0].":".$shop_open_arr[1];
    $shop_close = $shop_close_arr[0].":".$shop_close_arr[1];
    $shop_today = $shop_arr["s_status"];
    $shop_preorder = $shop_arr["s_preorderstatus"];
    $pkt_arr = explode("T",$pickuptime);
    $now_date = date("Y-m-d");
    $tomorrow_date = (new Datetime($now_date)) -> add(new DateInterval("P1D")) -> format('Y-m-d');
    if(($shop_today==1 && $pkt_arr[0]==$now_date && $pkt_arr[1]>=$shop_open && $pkt_arr[1]<=$shop_close) ||
    ($shop_preorder==1 && $pkt_arr[0]==$tomorrow_date && $pkt_arr[1]>=$shop_open && $pkt_arr[1]<=$shop_close) ){
        //Order accepted.
        //Omise Payment
        require_once dirname(__FILE__).'/omise-php/lib/omise.php';
        define('OMISE_API_VERSION', '2019-05-29');
        define('OMISE_PUBLIC_KEY', 'pkey_test_5qtd0o2x3znnduisr3e');
        define('OMISE_SECRET_KEY', 'skey_test_5qtd0o2xe2gvq2isj6d');
        $charge = OmiseCharge::create(array(
            'amount' => $payamount,
            'currency' => 'THB',
            'card' => $_POST["omiseToken"]
        ));
        $pay_status = $charge['status'];
        if($pay_status=="successful"){
            $card_finance = $charge['card']['financing'];
            $card_brand = $charge['card']['brand'];
            $card_lastdigit = $charge['card']['last_digits'];
            $payment_detail = ucfirst($card_brand)." [*".$card_lastdigit."]";
            switch($card_finance){
                case "credit": $payment_type = "CRDC"; break;
                case "debit": $payment_type = "DBTC"; break;
                case "prepaid": $payment_type = "PPDC"; break;
                default: $payment_type = "UNKN";
            }
            $amt = $charge['amount']/100;
            $payment_query = "INSERT INTO payment (c_id,p_type,p_amount,p_detail) VALUES ({$_SESSION['cid']},'{$payment_type}',{$amt},'{$payment_detail}');\n";
            $payment_result = $mysqli -> query($payment_query);
            $pay_id = $mysqli -> insert_id;
            $orh_query = "INSERT INTO order_header (c_id,s_id,p_id,orh_pickuptime,orh_orderstatus) VALUES ({$_SESSION['cid']},{$shop_id},{$pay_id},'{$pickuptime}','ACPT');\n";
            $orh_result = $mysqli -> query($orh_query);
            $orh_id = $mysqli -> insert_id;
            //Generate Ref Code
            $orh_date = date("Ymd");
            //calculate leading zero
            $id_len = strlen((string)$orh_id);
            $lead0 = 7 - $id_len;
            $lead0str = "";
            for($i=0;$i<$lead0;$i++){ $lead0str .= "0";}
            $orh_refcode = $orh_date.$lead0str.$orh_id;
            $orh_upq = "UPDATE order_header SET orh_refcode = {$orh_refcode} WHERE orh_id = {$orh_id};";
            $orh_uprst = $mysqli -> query($orh_upq); 
            //Prepare detail value
            $ord_vl = "";
            $crt_query = "SELECT ct.f_id,f.f_price,ct.ct_amount,ct.ct_note FROM cart ct INNER JOIN food f ON ct.f_id = f.f_id WHERE ct.c_id = {$_SESSION['cid']} AND ct.s_id = {$shop_id};\n";
            $crt_result = $mysqli -> query($crt_query);
            $crt_row = $crt_result -> num_rows;
            $i = 0;
            while($crt_arr = $crt_result -> fetch_array()){
                $i++;
                $ord_vl .= "({$orh_id},{$crt_arr['f_id']},{$crt_arr['ct_amount']},{$crt_arr['f_price']},'{$crt_arr['ct_note']}')";
                if($i<$crt_row){
                    $ord_vl .= ",";
                }else{
                    $ord_vl .= ";";
                }
            }
            $ord_query = "INSERT INTO order_detail (orh_id,f_id,ord_amount,ord_buyprice,ord_note) VALUES {$ord_vl}\n";
            $ord_result = $mysqli -> query($ord_query);
            if($ord_result){
                $crtdlt_query = "DELETE FROM cart WHERE c_id = {$_SESSION['cid']} AND s_id = {$shop_id};\n";
                $crtdlt_result = $mysqli -> query($crtdlt_query);
                header("location: order_success.php?orh={$orh_id}");
            }else{
                header("location: order_failed.php?err={$mysqli->errno}");
            }
            exit(1);
        }else{
            $payerr_msg = $charge['failure_message'];
            header("location: order_failed.php?pmt_err={$payerr_msg}");
            exit(1);
        }            
    }
    else{
        ?>
        <script>alert("You enter the pick-up time incorrectly.\nPlease re-enter it again."); history.back();</script>
        <?php
        exit(1);
    }
?>