<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/4/16
 * Time: 12:20 PM
 */
require_once '../Common/DbConnection.php';
require_once '../Common/CommonFunction.php';
require_once '../Common/PaymentFunction.php';
require_once '../Common/paymentDeliveredMailSender.php';
checkSession();
nepAgentValidator();
$paymentId = addslashes($_POST["paymentId"]);
if(isset($_SESSION)){

    if($_SESSION["role"] == "ROLE_NEPAGENT"){

        if(deliverPayment($paymentId, $conn)){

            $data = getPinAndSenderEmail($conn,$paymentId);
            $senderInfo = getCustomerInfoFromId($data["sender_id"], $conn);
            send_delivered_email($_POST["email"], $_POST["amount"] * $_POST["rate"], $_POST["amount"], $_POST["receiver"], $_POST["means"], $senderInfo["f_name"]);

            echo json_encode(array("success"=> true));
        }else{

            echo json_encode(array("success"=>false));
        }
    }
}