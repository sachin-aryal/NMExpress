<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/20/2016
 * Time: 11:14 AM
 */
require_once "../Common/DbConnection.php";
if(isset($_POST["id"]) && isset($_POST["email"])){
    $id = addslashes($_POST["id"]);
    $email = addslashes($_POST["email"]);

    $editQuery = "UPDATE subscriber_sas set email='$email' where id=$id";
    if($conn->query($editQuery)){
        echo json_encode(array("success"=>true));
    }else{
        echo json_encode(array("success"=>false));
    }
}