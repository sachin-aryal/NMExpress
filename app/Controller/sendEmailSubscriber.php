<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/19/2016
 * Time: 10:09 PM
 */
include "../Common/DbConnection.php";
include "../Common/CommonFunction.php";
adminValidator();
if(isset($_POST['subscriberList'])){
    $data = $_POST["subscriberList"];
    $message = $_POST["message"];
    $subject = $_POST["subject"];
    $result = array();
    foreach($data as $subscriberId){
        $emailAddress = getSubscriberEmail($conn,$subscriberId);
        if(mail($emailAddress,$subject, $message, header)){
            $result[$emailAddress] = "success";
        }else{
            $result[$emailAddress] = "error";
        }
    }
    echo json_encode($result);
}else{
    goToDashBoard("../");
}