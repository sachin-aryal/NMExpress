<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 10:19 AM
 */

require '../Common/DbConnection.php';
require '../Common/CommonFunction.php';
if($_POST["whichRequest"]) {
    $request = $_POST["whichRequest"];

    if ($request == "withPin") {
        $pin_no = $_POST["pin_no"];
        $customerId = getCustomerId($conn);
        $query = "select *from payment_sas where pin_no = '$pin_no' AND sender_id = $customerId";
        $result = $conn->query($query);
        if($result){
        $row = mysqli_fetch_assoc($result);
        if($row){
            $receiverInfo = getReceiverInfo($conn, $row["receiver_id"]);
            $senderInfo = getCustomerInfo($conn);
            if($senderInfo) {
                $agent_id = $row["agent_id"];
                if ($agent_id != null) {
                    $agentInfo = getAgentInfo($conn, $agent_id);
                }
                ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#withPin').DataTable({
                            bFilter: false,
                            bPaginate: false
                        })
                    });
                </script>
                </br>
                </br>
                <table id="withPin" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Sender Name</th>
                        <th>Sender Contact</th>
                        <th>Receiver Name</th>
                        <th>Receiver Phone</th>
                        <th>Means</th>
                        <?php
                        if (isset($row["agent_id"])) {
                            echo '<th>Agent</th>';
                        }
                        ?>
                        <th>Amount</th>
                        <th>Exchange Rate</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo $senderInfo['f_name'] . " " . $senderInfo['l_name'] ?></td>
                        <td><?php echo $senderInfo['mobile_no'] ?></td>
                        <td><?php echo $receiverInfo['f_name'] . " " . $receiverInfo['l_name'] ?></td>
                        <td><?php echo $receiverInfo['phone_no'] ?></td>
                        <td><?php echo $receiverInfo['payment_type'] ?></td>
                        <?php
                        if (isset($row["agent_id"])) {
                            echo '<td>' . $agentInfo["f_name"] . " " . $agentInfo["l_name"] . '</td>';
                        }
                        ?>
                        <td><?php echo $row['amount'] ?></td>
                        <td><?php echo $row['rate'] ?></td>
                        <td><?php echo $row['rate'] * $row['amount'] ?></td>
                        <td><?php echo $row['status'] ?></td>

                    </tr>
                    </tbody>
                </table>

                <?php
            }
        }
    }else{
     echo "</br>";
                echo "</br>";
            echo "<h1 style='margin-left: 380px;'>No Result Found.</h1>";
    }
    }
}
?>

