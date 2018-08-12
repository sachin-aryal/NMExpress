<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/20/2016
 * Time: 11:22 AM
 */
include_once '../Common/AdminDbConnection.php';
require "../Common/CommonFunction.php";
checkSession();
adminValidator();
if(isset($_POST["id"])){
    $id = addslashes($_POST["id"]);
    $deleteQuery = "DELETE from subscriber_sas where id = $id";
    if($conn->query($deleteQuery)){
        echo json_encode(array("success"=>true));
    }else{
        echo json_encode(array("success"=>false));
    }
}else{
    goToDashBoard("../");
}