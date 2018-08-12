<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/16/2016
 * Time: 11:37 AM
 */
require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
require_once "Common/PaymentFunction.php";
checkSession();
adminValidator();
$pendingPayments = getWholePayments($conn);
$nepaleseAgents = getAllNepaliAgents($conn);

?>
<html>
<head>
    <title>
        NME
    </title>
    <?php include "Include/BootstrapCss.html" ?>

    <script type="text/javascript">
        $(document).ready(function(){

            var table = $("#transactionReportTable").DataTable({
                dom: 'Blrtip',
                orderClasses: false,
                buttons: [
                    {
                        extend: 'excel',
                        "oSelectorOpts": { filter: 'applied'},
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7,8,9,10]
                        }
                    }
                ]
            });

            $('#senderName').on('keyup change', function(){
                table
                    .column(0)
                    .search(this.value)
                    .draw();

            });
            $('#mpinCode').on('keyup change', function(){
                table
                    .column(4)
                    .search(this.value)
                    .draw();

            });
            $('#status').on('keyup change', function(){
                table
                    .column(9)
                    .search(this.value)
                    .draw();

            });
        });
    </script>
</head>
<body>

<div style="display: none;" id = "agentsDiv">
    <?php

    for($i = 0; $i < count($nepaleseAgents); $i++){

        echo "<option id = \"" . $nepaleseAgents[$i]["id"] . "\">" . $nepaleseAgents[$i]["name"] . "</option>";
    }
    ?>
</div>

<?php include "Include/header.php"; ?>

<h3 class="text-center">Transaction Report</h3>
<div id="transactionReportDiv" style="width: 95%;margin: 0 auto;">
    <div id="searchField" style="float: right;">
        <div class="row no-pad">
            <div class="col-md-4 no-pad"><input type="text" class="form-control" id="senderName" placeholder="Search By Sender Name"/></div>
            <div class="col-md-4"> <input type="text" class="form-control" id="mpinCode" placeholder="Search By MPIN Code"/></div>
            <div class="col-md-4"><input type="text" class="form-control" id="status" placeholder="Search By Status"/></div>
        </div>
    </div>
    <table id="transactionReportTable" class="table table-bordered">
        <thead>
        <tr>
            <th>Sender Name</th>
            <th>Sender Contact</th>
            <th>Receiver Name</th>
            <th>Receiver Phone</th>
            <th>MPIN Code</th>
            <th>Means</th>
            <th>Amount</th>
            <th>Exchange Rate</th>
            <th>Total</th>
            <th>Status</th>
            <th>Received</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>


        <?php
        $nepaleseAgents = getAllNepaliAgents($conn);

        for($i = 0; $i < count($pendingPayments); $i++){

            $payment = $pendingPayments[$i];
            ?>
            <tr>
                <td><a href = "customerProfile.php?id=<?php echo $payment["sender_id"];?>"><?php echo $payment["sender_name"];?></a></td>
                <td><?php echo $payment["sender_contact"];?></td>
                <td><?php echo $payment["receiver_name"];?></td>
                <td><?php echo $payment["receiver_phone"];?></td>
                <td><?php echo $payment["pin"];?></td>
                <?php if($payment["means"] == "Bank"){?>
                    <td><a href="#" data-toggle="modal" data-target="#bankDetail<?php echo $payment["id"];?>"><?php echo $payment["means"];?></a></td>
                <?php }else{?>
                    <td><?php echo $payment["means"];?></td>
                <?php }?>
                <?php include 'bankDetails.php'?>
                <td>$<?php echo $payment["amount"];?></td>
                <td><?php echo number_format($payment["rate"], 2, '.', '');?></td>
                <td>NRS:<?php echo $payment["total"];?></td>
                <td><?php echo $payment["status"];?></td>
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
                        <option id="none">Assign an agent</option>
                        <?php
                            foreach($nepaleseAgents as $eachVal){
                                if($payment["agent_id"]==$eachVal["id"]){
                                    echo "<option id = \"" . $eachVal["id"] . "\" selected='selected'>" . $eachVal["name"] . "</option>";
                                }else{
                                    echo "<option id = \"" . $eachVal["id"] . "\">" . $eachVal["name"] . "</option>";
                                }
                            }

                        ?>
                    </select>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
