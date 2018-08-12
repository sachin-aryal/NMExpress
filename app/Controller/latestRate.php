<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/18/16
 * Time: 10:34 AM
 */

include '../Common/DbConnection.php';
include '../Common/CommonFunction.php';

$todayRate = getExchangeRate($conn);

echo json_encode(array("todayRate"=>$todayRate["nrs"]));