<?php
/**
 * Created by IntelliJ IDEA.
 * User: iam
 * Date: 7/21/16
 * Time: 7:31 PM
 */
require_once "../Common/DbConnection.php";
require_once "../Common/CommonFunction.php";

if(isset($_POST["senderEmail"]) && isset($_POST["pinNumber"])){


    $senderEmail = $_POST["senderEmail"];
    $pinNumber = $_POST["pinNumber"];


    $customerId = getCustomerIdByEmail($conn,$senderEmail);
    $checkPinQuery = "select *from payment_sas where pin_no='$pinNumber' AND sender_id=$customerId";
    $result = $conn->query($checkPinQuery);
    try {
        if(is_object($result)){
            if ($result->num_rows != 0) {
                $row = mysqli_fetch_assoc($result);
                $message= "<i class='fa fa-calendar'></i>&nbsp;<p id='paymentDate'>Payment Date: ".$row["payment_date"]."</p>".
                "<br><i class='fa fa-money'></i>&nbsp;<p id='paymentAmount'>Amount: $".$row["amount"]."</p>".
                "<br><i class='fa fa-question'></i>&nbsp;<p id='paymentStatus'>Status: ".$row["status"]."</p>";
                echo json_encode(array("status" => $message));
            } else {
                echo json_encode(array("status" => "<p id='trackError'>No Record Found for this PIN number and Sender Email.</p>"));
            }
        }else{
            echo json_encode(array("status" => "<p id='trackError'>No Record Found for this PIN number and Sender Email.</p>"));
        }
    }catch (Exception $e) {
        echo json_encode(array("status" => "<p id='trackError'>No Record Found for this PIN number and Sender Email.</p>"));

    }

}else{
    echo json_encode(array("status"=> "<p id='trackError'>Error Processing Request.</p>"));

}