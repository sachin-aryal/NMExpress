<?php
/**
 * Created by IntelliJ IDEA.
 * User: iam
 * Date: 8/5/16
 * Time: 10:29 PM
 */

require_once '../Common/DbConnection.php';
require_once '../Common/notifyRateEmail.php';

if($_POST["nrs"]){
    $nrs = $_POST["nrs"];
    $query = "select *from subscriber_sas";

    $result = $conn->query($query);

    while ($row = mysqli_fetch_assoc($result)){
        send_notify_email($row["email"],$nrs);
    }

}

