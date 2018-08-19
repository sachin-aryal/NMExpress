<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 4/30/2016
 * Time: 4:47 PM
 */
require_once "../Common/DbConnection.php";
require_once "../Common/CommonFunction.php";

$username = addslashes($_POST["username"]);
$password = addslashes($_POST["password"]);
$stmt = $conn->prepare('SELECT id, password, role, activated FROM user_sas WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
mysqli_stmt_bind_result($stmt, $id, $dbPassword, $role, $activated);
mysqli_stmt_fetch($stmt);

if(password_verify($password, $dbPassword)) {
    //if($activated==0){
        //redirect("../index.php?msgError=You are still not actived to the system, contact admin for more details");
        //return;
    //}
    if($role == "ROLE_CUSTOMER") {
        //check if customer exists for the user
        mysqli_stmt_close($stmt);
        $result = $conn->query("SELECT id FROM customer_sas WHERE user_id = $id");
        if ($result->num_rows == 0) {

            mysqli_close($conn);
            $message = "Login failed. Username or Password did not match.";
            redirect("../index.php?msgError=" . $message);
            return;
        }
    }
    
    $_SESSION["username"] = $username;
    $_SESSION["role"] = $role;
    mysqli_close($conn);
    if(isset($_SESSION["returnUrl"])) {
            $returnUrl = $_SESSION["returnUrl"];
           unset($_SESSION["returnUrl"]);
           redirect($returnUrl);
           return;
    }
    else{
        goToDashBoard("../");
        return;
    }
    
}
else {
    mysqli_close($conn);
    $message = "Login failed. Username or Password did not match.";
    redirect("../index.php?msgError=" . $message);
    return;
}