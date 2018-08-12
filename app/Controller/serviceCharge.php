<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 8/6/16
 * Time: 8:35 AM
 */
include '../Common/DbConnection.php';
include '../Common/CommonFunction.php';

echo json_encode(array("serviceCharge"=>round(getServiceCharge($conn))));