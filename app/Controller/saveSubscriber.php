<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/19/2016
 * Time: 2:27 PM
 */
require_once "../Common/DbConnection.php";
if(isset($_POST["email"])){
    $email = addslashes($_POST["email"]);
    $addedDate = date("Y-m-d");

    $result = $conn->query("SELECT id FROM subscriber_sas WHERE email = '$email'");
    if($result->fetch_assoc()){

        echo json_encode(array("success"=>true));
        return;
    }
    $addSubscriber = "INSERT into subscriber_sas(email,added_date) VALUES ('$email','$addedDate')";
    if($conn->query($addSubscriber)){
        echo json_encode(array("success"=>true));
    }else{
        echo json_encode(array("success"=>false));
    }
}