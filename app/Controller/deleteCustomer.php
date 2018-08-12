<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/19/16
 * Time: 10:30 AM
 */
require "../Common/AdminDbConnection.php";
require "../Common/CommonFunction.php";
checkSession();
adminValidator();
if(isset($_POST["customer_id"])) {

    try {
        $customer_id = addslashes($_POST["customer_id"]);
        $receiverInfo = getReceiverInfo($conn, $customer_id);

        $conn->query("delete from payment_sas where sender_id =$customer_id");
        $result = $conn->query("SELECT bank_id FROM receiver_sas WHERE customer_id = $customer_id");
        if($result) {
            $receiver_row = $result->fetch_assoc();
            $conn->query("DELETE FROM bank_sas WHERE id = " . $receiver_row["bank_id"]);
        }
        $conn->query("delete from receiver_sas where customer_id=$customer_id");

        $result = $conn->query("SELECT user_id FROM customer_sas WHERE id = $customer_id");
        $customer_row = $result->fetch_assoc();
        $user_id = $customer_row["user_id"];
        $conn->query("delete from customer_sas where id = $customer_id");
        $conn->query("delete from user_sas where id = $user_id");
        $data = array("success" => true);
        echo json_encode($data);
        return;
    }catch (Exception $e){

        $data = array("success" => false);
        echo json_encode($data);
        return;
    }
}