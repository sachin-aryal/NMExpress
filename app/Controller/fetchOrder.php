<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/3/16
 * Time: 3:46 PM
 */
require_once '../Common/DbConnection.php';
require_once '../Common/PaymentFunction.php';
require_once '../Common/CommonFunction.php';
$order_type = $_POST["orderType"];
$limit = 100;
$paymentByStatus = getPaymentByStatus($conn, $order_type, $limit);
$nepaleseAgents = getAllNepaliAgents($conn);
$options = array("Not Received", "Bank", "Agent", "Cash");
?>
<?php include_once "../Include/BootstrapCss.html" ?>
<script type="text/javascript">
    $(function(){

        $("#dTab1").DataTable({
            dom: 'Blfrtip',
            orderClasses: false,
            buttons: [
                {
                    extend: 'excel',
                    "oSelectorOpts": { filter: 'applied'},
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
                    }
                }
            ],
            responsive: {
                details: {
                    renderer: function ( api, rowIdx, columns ) {
                        var data = $.map( columns, function ( col, i ) {
                            return col.hidden ?
                                '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                '<td>'+col.title+':'+'</td> '+
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
<h3 class="text-center"><?php echo $order_type ?> Orders</h3>
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
        <th>Received</th>
        <th>Assign Agent</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for($i = 0; $i < count($paymentByStatus); $i++){

        $payment = $paymentByStatus[$i];
        ?>
        <tr>
            <td><?php echo $payment["payment_date"];?></td>
            <td><a href = "../customerProfile.php?id=<?php echo $payment["sender_id"];?>"><?php echo $payment["sender_name"];?></a></td>
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
                        <a href="../editAgent.php?id=<?php echo $agent_row["id"]?>"><?php echo $agent_row["name"];?></a>
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
            <?php include '../bankDetails.php'?>
            <td>$<?php echo $payment["amount"];?></td>
            <td><?php echo number_format($payment["rate"], 2, '.', '');?></td>
            <td><?php echo $payment["total"];?></td>
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
                <a href = "../editPayments.php?pID=<?php echo $payment["id"];?>">Edit</a> |
                <a href="#" onclick="deleteTransaction('<?php echo $payment["id"];?>')">Delete</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>