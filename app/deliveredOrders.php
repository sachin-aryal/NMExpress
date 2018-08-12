<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/21/16
 * Time: 3:00 PM
 */
require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
require_once "Common/PaymentFunction.php";
checkSession();
nepAgentValidator();

$deliveredPayments = getDeliveredPaymentsOfNepaliAgent($conn);
?>
<html>
<head>
    <title>
        NME
        <?php include "Include/BootstrapCss.html" ?>
    </title>
    <script>
        $(function (){
            $("#dTab2").DataTable({
                'bFilter':true
            });
        })

    </script>
    <style>
        table, th, td{

            border: 1px solid black;
        }
    </style>
</head>
<body>
<?php include_once 'Include/header.php'?>
<div class="container">
    <h2 class="text-center">Orders delivered by me</h2>
    <table id="dTab2" class="table-responsive display">
        <thead>
        <th>Sender Name</th>
        <th>Sender Contact</th>
        <th>Receiver Name</th>
        <th>MPIN Code</th>
        <th>Receiver Phone</th>
        <th>Means</th>
        <th>Amount</th>
        <th>Exchange Rate</th>
        <th>Total</th>
        </thead>
        <tbody>
        <?php
        for ($i = 0; $i < count($deliveredPayments); $i++) {

            $payment = $deliveredPayments[$i];
            ?>
            <tr>
                <td><?php echo $payment["sender_name"]; ?></td>
                <td><?php echo $payment["sender_contact"]; ?></td>
                <td><?php echo $payment["receiver_name"]; ?></td>
                <td><?php echo $payment["pin"]; ?></td>
                <td><?php echo $payment["receiver_phone"]; ?></td>
                <?php if($payment["means"] == "Bank"){?>
                    <td><a href="#" data-toggle="modal" data-target="#bankDetail<?php echo $payment["id"];?>"><?php echo $payment["means"];?></a></td>
                <?php }else{?>
                    <td><?php echo $payment["means"];?></td>
                <?php }?>
                <?php include 'bankDetails.php'?>
                <td><?php echo $payment["amount"]; ?></td>
                <td><?php echo $payment["rate"]; ?></td>
                <td><?php echo $payment["total"]; ?></td>
            </tr>
            <?php
        } ?>
        </tbody>
    </table>
</div>
</body>
</html>
