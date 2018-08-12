<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/4/2016
 * Time: 10:28 AM
 */

if(isset($_POST["user_email"]) && isset($_POST["password"])){

    require "../Common/DbConnection.php";
    require "../Common/CommonFunction.php";
    $password = addslashes($_POST["password"]);
    $user_email = $_POST["user_email"];
    $encodedPassword = encodePassword($password);

    $resetPasswordQuery = "UPDATE user_sas SET password=? where username=?";
    $stmt = $conn->prepare($resetPasswordQuery);
    $stmt->bind_param("ss",$encodedPassword,$user_email);
    if($stmt->execute()){
        $data = array("changed"=>true);
    }else{
        $data = array("changed"=>false);
    }
    echo json_encode($data);

}
