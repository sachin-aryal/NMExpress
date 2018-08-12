<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/16/16
 * Time: 6:38 PM
 */
require_once "../Common/DbConnection.php";
require_once "../Common/CommonFunction.php";
require_once "../Common/PaymentFunction.php";
checkSession();
adminValidator();

$paymentId = addslashes($_POST["paymentId"]);
$value = addslashes($_POST["value"]);

$stmt = $conn->prepare("UPDATE payment_sas SET received = ? WHERE id = ?");
$stmt->bind_param("si", $value, $paymentId);
if($stmt->execute())
    echo true;
else
    echo false;