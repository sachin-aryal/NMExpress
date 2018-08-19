<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 4/30/2016
 * Time: 5:07 PM
 */
require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
require_once "Common/PaymentFunction.php";
checkSession();
nepAgentValidator();
$todayRate = getExchangeRate($conn);

$agentId = getAgentMainId($conn);
$processingPayments = getProcessingPaymentsByAgent($conn, $agentId);
?>
<html>
<head>
    <title>
        NME
    </title>
    <?php include "Include/BootstrapCss.html" ?>
 <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script>
        $(function(){
            $("#dTab2").DataTable({
                dom: 'Blfrtip',
                "bPaginate": false,
                "bInfo": false,
                buttons: [
                    {
                        extend: 'print'
                    }
                ]
            });
            $("#dTab2_wrapper").attr('style', "width: 103%");
        });
        function deliverPayment(rate, paymentId, email, amount, receiver, means){

            $.ajax({
                type: "POST",
                url: 'Controller/deliverPayment.php',
                data: 'rate=' + rate + '&paymentId=' + paymentId + '&email=' + email + '&amount=' + amount + '&receiver=' + receiver + '&means=' + means
            }).success(function(result){

                var resultJSON = JSON.parse(result);
                if(resultJSON.success) {
                    notify("success", "Payment Successfully Delivered");
                }else{
                    notify("error", "Payment could not be delivered");
                }
            });

            location.reload();
        }
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
    <div class="row">
        <div class="col-xs-4">
        </div>
        <div class="currencyConverterBox col-xs-4">
            <h3 class="media-heading text-center">Current Exchange Rate</h3>
            <form class="form-inline">

                <div class="currencyConverterBoxBody">

                    <div class="enter"></div><div class="enter"></div>
                    <p>
                        Australia <img src="Assets/Img/ausFlag.png"/>
                        &nbsp;&nbsp;        <input type="text" name="audMoney" value="<?php echo $todayRate["aus"];?>" id="aus" readonly/>

                    </p>
                    <p class="text-center">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nepal <img src="Assets/Img/nepalFlag.png"/>
                        &nbsp;&nbsp;        <input type="text" name="nepalMoney" value="<?php echo $todayRate["nrs"] ?>" id="nrs" readonly/>

                    </p>
                </div>
            </form>
        </div>
        <div class="col-xs-4">
        </div>
    </div>

    <h2 class="text-center">Orders assigned to me</h2>
    <table id="dTab2" class="table-responsive display">
        <thead>
        <th>Order Date</th>
        <th>Sender Name</th>
        <th>Sender Contact</th>
        <th>Receiver Name</th>
        <th>MPIN Code</th>
        <th>Receiver Phone</th>
        <th>Means</th>
        <th>Amount</th>
        <th>Exchange Rate</th>
        <th>Total</th>
        <th>Status</th>
        </thead>
        <tbody>
        <?php
        for ($i = 0; $i < count($processingPayments); $i++) {

            $payment = $processingPayments[$i];
            ?>
            <tr>
                <td><?php echo $payment["payment_date"]; ?></td>
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
                <td>
                    <select onchange="deliverPayment('<?php echo $payment["rate"]; ?>','<?php echo $payment["id"]; ?>', '<?php echo $payment["sender_email"]; ?>', '<?php echo $payment["amount"]; ?>', '<?php echo $payment["receiver_name"]; ?>', '<?php echo $payment["means"]; ?>')" class="form-control">
                        <option>Processing</option>
                        <option>Delivered</option>
                    </select>
                </td>
            </tr>
            <?php
        } ?>
        </tbody>
    </table>
    </div>
</body>
</html>