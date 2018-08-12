<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/16/2016
 * Time: 2:28 PM
 */

include_once "Common/DbConnection.php";
include_once "Common/PaymentFunction.php";
include_once "Common/CommonFunction.php";
checkSession();
customerValidator();
$customerId = getCustomerId($conn);
$transactionHistory = getCustomerTransactionHistory($conn,$customerId);

?>
<html>
<head>
    <title>
        NME
    </title>
    <?php include "Include/BootstrapCss.html" ?>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#transactionHistory").DataTable({
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        "oSelectorOpts": { filter: 'applied'}
                    }
                ]
            });
        });
    </script>
</head>
<body>
<?php include "Include/headerCustomer.php" ?>

<div id="transactionHistoryDiv" style="width: 80%;margin: 0 auto">
    <table id="transactionHistory" class="table table-bordered">
        <thead>
        <tr>
            <th>Receiver Name</th>
            <th>Receiver Phone</th>
            <th>Transaction Date</th>
            <th>Delivered Date</th>
            <th>MPIN Code</th>
            <th>Means</th>
            <th>Amount</th>
            <th>Exchange Rate</th>
            <th>Total (NPR.)</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for($i = 0; $i < count($transactionHistory); $i++) {
            $transaction = $transactionHistory[$i];
            ?>
            <tr>
                <td><?php echo $transaction["receiver_name"];?></td>
                <td><?php echo $transaction["receiver_phone"];?></td>
                <td><?php echo $transaction["payment_date"];?></td>
                <td><?php if(!empty($transaction["delivered_date"]))echo $transaction["delivered_date"]; else echo "N/A";?></td>
                <td><?php echo $transaction["pin"];?></td>
                <td><?php echo $transaction["means"];?></td>
                <td>$<?php echo $transaction["amount"];?></td>
                <td><?php echo $transaction["rate"];?></td>
                <td><?php echo $transaction["total"];?></td>
                <td><?php echo $transaction["status"];?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>

    </table>
</div>
<?php include "Include/footer.php" ?>
</body>
</html>
