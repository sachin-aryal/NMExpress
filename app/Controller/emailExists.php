<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/20/16
 * Time: 12:44 PM
 */
include_once '../Common/DbConnection.php';
$email= addslashes($_POST["email"]);
$stmt = $conn->query("SELECT id FROM user_sas WHERE username = '$email'");
if($stmt->num_rows > 0){

    echo json_encode(array("exists"=>true));
}else{

    echo json_encode(array("exists"=>false));
}