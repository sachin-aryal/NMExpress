<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/3/16
 * Time: 10:11 PM
 */
require_once '../Common/DbConnection.php';
require_once '../Common/CommonFunction.php';
require_once '../Common/PaymentFunction.php';
require_once '../Common/paymentDeliveredMailSender.php';
checkSession();
adminValidator();
if($_SESSION["role"] == "ROLE_ADMIN") {
    if (isset($_POST["agentId"]) && isset($_POST["paymentId"])) {

        $agentId = addslashes($_POST["agentId"]);
        $paymentId = addslashes($_POST["paymentId"]);
        
        if(assignAgentToPayment($agentId, $paymentId, $conn)){
            $data = getPinAndSenderEmail($conn,$paymentId);
            $email = getCustomerInfoFromId($data["sender_id"],$conn)["email"];
            //send_processing_email($email,$data["pin_no"]);
            echo true;
        }else{
            echo false;
        }
    }
}