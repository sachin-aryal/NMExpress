<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 11:04 PM
 */
if(isset($_POST["activate"])){
    require_once "../Common/DbConnection.php";
    require_once "../Common/CommonFunction.php";
    require_once "../Common/verifiedMailSender.php";

        $id = $_POST["id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $result = $conn->query("UPDATE user_sas SET activated=1 WHERE id=$id");
        send_registered_email($email,$name);
        
}

if(isset($_POST["deactivate"])){
    require_once "../Common/DbConnection.php";
    require_once "../Common/CommonFunction.php";

        $id = $_POST["id"];
        $result = $conn->query("UPDATE user_sas SET activated=0 WHERE id=$id");
}