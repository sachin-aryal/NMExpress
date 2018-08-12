<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 11:04 PM
 */

if($_POST["oldPassword"]){

    require_once "../Common/DbConnection.php";
    require_once "../Common/CommonFunction.php";

    $oldPassword = addslashes($_POST["oldPassword"]);
    $newPassword = addslashes($_POST["newPassword"]);

    $username = addslashes($_SESSION["username"]);

    $stmt = $conn->prepare('SELECT * FROM user_sas WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();

    $result = $stmt->get_result();//phenol69
    $user_row = $result->fetch_assoc();

    if(password_verify($oldPassword, $user_row["password"])) {

        $encodedPassword = encodePassword($newPassword);

        $stmt1 = $conn->prepare('UPDATE user_sas SET password=? WHERE username=?');
        $stmt1->bind_param('ss',$encodedPassword, $username);

        if($stmt1->execute()){
            $data = array("change"=>true,"message"=>"Password Changed Successfully");
        }else{
            $data = array("change"=>false,"message"=>"Failed to Change Password.");
        }
    }else{
        $data = array("change"=>false,"message"=>"Old Password did not match.");
    }
    echo json_encode($data);
}