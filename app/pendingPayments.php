<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/3/16
 * Time: 3:46 PM
 */
require_once 'Common/DbConnection.php';
require_once 'Common/PaymentFunction.php';
$pendingPayments = getPendingPayments($conn);
?>

<div style="display: none;" id = "agentsDiv">
    <?php

    for($i = 0; $i < count($nepaleseAgents); $i++){

        echo "<option id = \"" . $nepaleseAgents[$i]["id"] . "\">" . $nepaleseAgents[$i]["name"] . "</option>";
    }
    ?>
</div>
<h3 class="text-center">Pending Orders</h3>
<table id="dTab1" class="table table-bordered table-responsive" style="width: ">
    <thead>
    <tr>
        <th>Order Date</th>
        <th>Sender Name</th>
        <th>Sender Contact</th>
        <th>Receiver Name</th>
        <th>Added By</th>
        <th>MPIN Code</th>
        <th>Means</th>
        <th>Amount</th>
        <th style="width: 5%">Exchange Rate</th>
        <th>Total (NPR.)</th>
        <th>Received</th>
        <th>Assign Agent</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for($i = 0; $i < count($pendingPayments); $i++){

        $payment = $pendingPayments[$i];
        ?>
        <tr>
            <td><?php echo $payment["payment_date"];?></td>
            <td><a href = "customerProfile.php?id=<?php echo $payment["sender_id"];?>"><?php echo $payment["sender_name"];?></a></td>
            <td><?php echo $payment["sender_contact"];?></td>
            <td><?php echo $payment["receiver_name"];?></td>
            <td>
                <?php
                    $added_by_id = $payment["added_by_id"];
                    if(!empty($added_by_id)) {
                        $result = $conn->query("SELECT id, CONCAT(f_name, ' ',l_name) as name FROM agent_sas WHERE user_id = $added_by_id");
                        $agent_row = $result->fetch_assoc();
                        if($agent_row) {
                ?>
                            <a href="editAgent.php?id=<?php echo $agent_row["id"]?>"><?php echo $agent_row["name"];?></a>
                <?php
                        }
                        else{

                            echo "Admin";
                        }
                    }else{
                        echo "Customer";
                    }
                ?>
            </td>
            <td><?php echo $payment["pin"];?></td>
            <?php if($payment["means"] == "Bank"){?>
                <td><a href="#" data-toggle="modal" data-target="#bankDetail<?php echo $payment["id"];?>"><?php echo $payment["means"];?></a></td>
            <?php }else{?>
                <td><?php echo $payment["means"];?></td>
            <?php }?>
            <?php include 'bankDetails.php'?>
            <td>$<?php echo $payment["amount"];?></td>
            <td><?php echo number_format($payment["rate"], 2, '.', '');?></td>
            <td><?php echo $payment["total"];?></td>
            <td>
                <script>
                    $(function(){

                        var received = "<?php echo $payment["received"];?>";

                        $("#received<?php echo $payment["id"];?>>option").map(function() {
                            if($(this).html().indexOf(received) != -1){

                                $(this).attr('selected', 'selected');
                            }
                        });
                    });
                </script>
                <select class="form-control" name="received" id = "received<?php echo $payment["id"];?>" onchange="changeReceived(this, '<?php echo $payment["id"];?>')">
                    <option>Not Received</option>
                    <option>Cash</option>
                    <option>Bank</option>
                    <option>Agent</option>
                </select>
            </td>
            <td>
                <select class = "agentClass form-control" onchange="assignAgent(this, '<?php echo $payment["id"];?>')">
                    <option>Assign an agent</option>
                </select>
            </td>
            <td>
                <a href = "editPayments.php?pID=<?php echo $payment["id"];?>"><i class="glyphicon glyphicon-pencil"></i></a> |
                <a href="#" onclick="deleteTransaction('<?php echo $payment["id"];?>')"><i class="glyphicon glyphicon-trash"></i></a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>