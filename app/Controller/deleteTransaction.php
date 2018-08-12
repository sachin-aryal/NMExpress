<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/19/16
 * Time: 11:48 PM
 */
include_once '../Common/AdminDbConnection.php';
include_once '../Common/CommonFunction.php';
checkSession();
adminValidator();
$paymentId = addslashes($_POST["paymentId"]);

if(isset($paymentId)){

    if($conn->query("DELETE FROM payment_sas WHERE id = $paymentId")){

        echo json_encode(array("success"=>true));
    }else{

        echo json_encode(array("error"=>true));
    }
}