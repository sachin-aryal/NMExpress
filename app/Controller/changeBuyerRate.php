<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/19/16
 * Time: 11:02 AM
 */
require_once '../Common/DbConnection.php';
require_once '../Common/CommonFunction.php';
checkSession();
adminValidator();
echo (isset($_POST["audMoney"]) && isset($_POST["nepalMoney"]));
if(isset($_POST["audMoney"]) && isset($_POST["nepalMoney"])) {

    if (isset($_POST["audMoney"]) && isset($_POST["nepalMoney"]) && $_SESSION["role"] == "ROLE_ADMIN") {

        $aud = 1;
        $nrs = $_POST["nepalMoney"];

        $user_id = 0;
        if (!is_numeric($aud) || !is_numeric($nrs)) {
            goToDashBoard('../');
        }
        $result = $conn->query("SELECT id FROM user_sas where username='" . $_SESSION["username"] . "'");
        if ($user_row = $result->fetch_assoc()) {
            $user_id = $user_row["id"];
        }
        $stmt2 = $conn->prepare("INSERT INTO buyer_rate_sas(aus, last_updated, nrs, updated_by_id) VALUES(?, ?, ?, ?)");

        $currentDateTime = date("Y-m-d H:i:s");
        $stmt2->bind_param('ssss', $aud, $currentDateTime, $nrs, $user_id);
        if ($stmt2->execute())
            goToDashBoard('../');
        else
            goToDashBoard('../');
    } else {
        goToDashBoard('../');
    }
}
?>