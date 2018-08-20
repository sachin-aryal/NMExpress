<?php

require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
require_once "Common/PaymentFunction.php";
checkSession();
adminValidator();
$limit = 10;
if (isset($_GET["page"]))
{
    $page  = $_GET["page"];
}
else {
    $page=1;
};
$start_from = ($page-1) * $limit;
$payments = getFullPayment($conn, $limit, $start_from);
$nepaleseAgents = getAllNepaliAgents($conn);
$options = array("Not Received", "Bank", "Agent", "Cash");
$total_records = getPaymentCount($conn);
$total_pages = ceil($total_records / $limit);

function getPageRange($current, $max, $total_pages = 10) {
    $desired_pages = $max < $total_pages ? $max : $total_pages;
    $middle = ceil($desired_pages/2);
    if ($current <= $middle){
        return [1, $desired_pages];
    }
    if ($current > $middle && $current <= ($max - $middle)) {
        return [
            $current - $middle,
            $current + $middle
        ];
    }
    else{
        return [
            $current - ($desired_pages - 1),
            $max
        ];
    }

}

?>
<html>
<head>
    <title>
        NME
    </title>
    <?php include "Include/BootstrapCss.html" ?>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#dTab1").DataTable({
                dom: 'Blfrtip',
                orderClasses: false,
                searching: false,
                paging: false,
                buttons: [

                ],
                responsive: {
                    details: {
                        renderer: function ( api, rowIdx, columns ) {
                            var data = $.map( columns, function ( col, i ) {
                                return col.hidden ?
                                    '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                    '<td style="width: 150px">'+col.title+':'+'</td> '+
                                    '<td style="text-align: right;width: 150px">'+col.data+'</td>'+
                                    '</tr>' :
                                    '';
                            } ).join('');
                            return data ?
                                $('<table/>').append( data ) :
                                false;
                        }
                    }
                }
            });
        });
    </script>
</head>
<body>
<?php include "Include/header.php"; ?>
<div id="agentList" class="container">
    <a class="btn btn-primary" href="sendMoneyAusAd.php">Add Order</a>
    <h3 class="text-center">Order List</h3>
    <table id="dTab1" class="display nowrap" style="width: 100%">
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
            <th>Status</th>
            <th>Received</th>
            <th>Assign Agent</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for($i = 0; $i < count($payments); $i++){

            $payment = $payments[$i];
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
                <td><?php echo $payment["status"];?></td>
                <td>
                    <select class="form-control" name="received" id = "received<?php echo $payment["id"];?>" onchange="changeReceived(this, '<?php echo $payment["id"];?>')">
                        <?php
                        foreach ($options as $op){
                            if($payment["received"] == $op){
                                echo "<option value='$op' selected='selected'>$op</option>";
                            }else{
                                echo "<option value='$op'>$op</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select class = "agentClass form-control" onchange="assignAgent(this, '<?php echo $payment["id"];?>')">
                        <option>Assign an agent</option>
                        <?php
                        foreach($nepaleseAgents as $np_agent){
                            $agent_id = $np_agent["id"];
                            $agent_name = $np_agent["name"];
                            if($agent_id == $payment["agent_id"]){
                                echo "<option selected='selected' value = '$agent_id'>$agent_name</option>";
                            }else{
                                echo "<option value = '$agent_id'>$agent_name</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <a href = "editPayments.php?pID=<?php echo $payment["id"];?>">Edit</a> |
                    <a href="#" onclick="deleteTransaction('<?php echo $payment["id"];?>')">Delete</a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <div class="row">
        <?php
        $pagLink = "<div class='pagination col-md-4'><ul>";
        list($min,$max) = getPageRange($page, $total_pages);
        foreach (range($min, $max) as $number) {
            $pagLink .="<li><a href=\"orders.php?page=".$number."\" >". $number. "</a></li>";
        }
        echo $pagLink . "</ul></div>";
        ?>
        <div class="col-md-4" id="page-form">
            <form method="GET" action="orders.php">
                <input type="text" name="page" placeholder="Page Number"/>
                <input type="submit" value="Go"/>
            </form>
            <span class="text text-info">Total Pages: <?php echo $total_pages ?></span>
        </div>
    </div>
</div>
</body>
</html>

