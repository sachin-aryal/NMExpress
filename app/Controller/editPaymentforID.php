<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 8:26 PM
 */
require '../Common/DbConnection.php';
require '../Common/CommonFunction.php';
$pID = addslashes($_POST["pID"]);
$rate = addslashes($_POST["rate"]);
$fee = addslashes($_POST["fee"]);
$amount = addslashes($_POST["amount"]);

$updatePayment = "update payment_sas set rate='$rate',fee='$fee', amount='$amount' where id=$pID";


if($conn->query($updatePayment)){
    $data = array("success"=>true);
    echo json_encode($data);
    redirect('../editPayments.php?pID='.$pID . '&msgSuccess=Payment Successfully Edited');
}else{
    $data = array("success"=>false);
    echo json_encode($data);
    redirect('../editPayments.php?pID='.$pID . '&msgError=Payment Couldn\'t be edited');
}