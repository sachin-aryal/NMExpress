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
ausAgentAdminValidator();
$sendersDetailArray = searchSenderByName($conn, $_POST["senderName"]);

echo json_encode($sendersDetailArray);