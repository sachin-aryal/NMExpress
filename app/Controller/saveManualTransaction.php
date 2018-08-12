<script src="../Assets/Js/jquery-1.11.1.min.js"></script>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/2/2016
 * Time: 9:25 PM
 */
require "../Common/DbConnection.php";
require "../Common/CommonFunction.php";
require_once '../Common/transactionDetailsMailSender.php';
if(isset($_POST["receiverId"])) {
    $receiverId = addslashes($_POST["receiverId"]);
    $rate = addslashes($_POST["rate"]);
    $amount = addslashes($_POST["amount"]);
    $status = "Pending";
    $reason = addslashes($_POST["reason"]);
    $customerID = addslashes($_POST["customerId"]);
    $pin = getRandomPin($conn);
    $fullAmount = $amount;
    // $feeOfAgent = getServiceCharge($conn);
    $feeOfAgent  = $_POST["serviceCharge"];
    $amount = $amount-$feeOfAgent;
    $agentId = null;
    $ausAgentId = getAusAgentUserId($conn);
    $todaysDate = date('Y-m-d');
    $received = "Not Received";

    $savePayment = "INSERT INTO payment_sas(added_by_id, agent_id,fee, payment_date, pin_no,reason,received,status,amount,rate,receiver_id,sender_id)
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($savePayment);
    $stmt->bind_param("iissssssddii", $ausAgentId, $agentId,$feeOfAgent, $todaysDate, $pin, $reason, $received, $status, $amount, $rate, $receiverId, $customerID);
    if ($stmt->execute()) {
        $senderInfo = getCustomerInfoFromId($customerID, $conn);
        $success = true;
    } else {
        $success = false;
        echo mysqli_stmt_error($stmt);
    }
$result = $conn->query("SELECT CONCAT(f_name, ' ', m_name,' ', l_name) as r_fullname, payment_type FROM receiver_sas WHERE id = " . $receiverId);
    $receiver_row = $result->fetch_assoc();
    send_transaction_details($senderInfo["email"], $pin, $amount * $rate, $amount, $receiver_row["r_fullname"], $receiver_row["payment_type"], $senderInfo["f_name"]);

    echo "<form action='../transactionDetails.php' method='POST' id='transactionDetailsForm'>";
    echo '<input type="hidden" name="pin_no" value="'.$pin.'"\>';
    echo '<input type="hidden" name="sender_email" value="'.$senderInfo["email"].'"\>';
    echo '<input type="hidden" name="result" value="'.$success.'"\>';
    echo '<input type="hidden" name="amount" value="'.$fullAmount.'"\>';
    echo "</form>";
    echo "
            <script type=\"text/javascript\">
                        $(function(){
                            $(\"#transactionDetailsForm\").submit();
                        });
            </script>
        ";
}
?>