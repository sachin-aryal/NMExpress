<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 8/6/16
 * Time: 7:27 AM
 */
include_once '../Common/DbConnection.php';
include_once '../Common/CommonFunction.php';
checkSession();
adminValidator();

$newServiceCharge = addslashes($_POST["serviceCharge"]);

$conn->query("UPDATE service_charge SET value = $newServiceCharge");

redirect('../dashboardAd.php');