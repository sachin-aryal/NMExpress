<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 8/2/16
 * Time: 1:29 PM
 */

require "../Common/DbConnection.php";
require "../Common/CommonFunction.php";
checkSession();

$receiversDetailArray = searchReceiverByName($conn, $_POST["receiverName"], $_POST["senderId"]);

echo json_encode($receiversDetailArray);