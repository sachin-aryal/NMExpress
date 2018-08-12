<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/1/2016
 * Time: 6:11 PM
 */
require "Common/DbConnection.php";
require "Common/CommonFunction.php";

$customerID = $_POST["senderId1"];
$customerInfo = getCustomerInfoFromId($customerID, $conn);
if(isset($_POST["receiverId"])){
    $receiverId = addslashes($_POST["receiverId"]);
    $reason = addslashes($_POST["reasonForSending"]);
    $rate = addslashes($_POST["rate"]);
    $serviceCharge = $_POST["serviceCharge"];
    $sendingAmount = addslashes($_POST["sendingAmount"]);
    $receiverInfo = getReceiverInfoFromCusId($conn,$receiverId, $customerID);
    $bank_id = $receiverInfo["bank_id"];
    $payment_type = $receiverInfo["payment_type"];
    if($bank_id!=null){
        $bank_info = getBankInfo($conn,$bank_id);
    }
}
//$serviceCharge = getServiceCharge($conn);

?>
<?php include "Include/BootstrapCss.html";?>
<html>
<head>
    <title>NME</title>
    <script src="Assets/Js/jquery-1.11.1.min.js"></script>
    <script src="Assets/Js/custom.js"></script>
    <script src="Assets/Js/jquery.noty.packaged.min.js"></script>
    <script type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            changeTransactionDetailsAdmin("<?php echo $rate ?>")
        });
        function changeTransactionDetailsAdmin(rate){
            $("#sendingA").removeClass("hide");
            var sendingAmount = $("#sendingAmount").val();
            var serviceCharge = $("#serviceCharge").val();
            $("#sendingAmountSpan").text("Sending Amount:\n$"+sendingAmount);
            $("#todayRate").text("Exchange Rate:\n"+rate);
            if(sendingAmount>=20000){
                $("#transactionFee").text("Transaction Fee:Free");
            }else{
                $("#transactionFee").text("Transaction Fee:$" + serviceCharge );
                sendingAmount = sendingAmount- serviceCharge ;
            }
            $("#receiveAmount").text("Receive Amount:\nRs "+(rate*sendingAmount).toFixed(2));
        }
    </script>
</head>
<body>
<?php include_once 'Include/header.php'?>
<div class="container">
<div id="paymentProcess">
    <fieldset>
        <legend>Sender Details:</legend>
        <span><?php echo "First Name: ".$customerInfo['f_name'] ?></span></br>
        <span><?php echo "Last Name: ".$customerInfo['l_name'] ?></span></br>
        <span><?php echo "Email Address: ".$customerInfo['email'] ?></span></br>
        <span><?php echo "Mobile Number: ".$customerInfo['mobile_no'] ?></span></br>
    </fieldset>
    <fieldset>
        <legend>Receiver Info</legend>
        <span><?php echo "First Name: ".$receiverInfo['f_name'] ?></span></br>
        <span><?php if(isset($receiverInfo["m_name"]))echo "Middle Name: ".$receiverInfo['m_name'] ."</br>" ?></span>
        <span><?php echo "Last Name: ".$receiverInfo['l_name'] ?></span></br>
        <span><?php echo "Phone Number: ".$receiverInfo['phone_no'] ?></span></br>
        <span><?php echo "City: ".$receiverInfo['city'] ?></span></br>
        <span><?php echo "Zone: ".$receiverInfo['zone'] ?></span></br>
        <span><?php echo "District: ".$receiverInfo['district'] ?></span></br>
        <span><?php echo "Country: ".$receiverInfo['country'] ?></span></br>
    </fieldset>
    <fieldset>
        <legend>Payment Details</legend>
            <span><?php
                echo "Payment Type: ".$payment_type;
                ?></span></br>

        <input type="hidden" name="sendingAmount" id="sendingAmount" value="<?php echo $sendingAmount ?>"/>
        <input type="hidden" name="serviceCharge" id="serviceCharge" value="<?php echo $serviceCharge ?>"/>
        <div id="sendingA" class="hide">
            <span id="sendingAmountSpan"></span><br>
            <span id="todayRate"></span><br>
            <span id="transactionFee"></span><br>
            <span id="receiveAmount"></span><br>
            <span id="totalCost"></span><br>
        </div>
        <?php
        if($bank_id!=null){
            ?>
            <fieldset>
                <legend>Bank Details:</legend>
                <span><?php echo "Account Number: ".$bank_info["account_no"] ?></span></br>
                <span><?php echo "Account Name: ".$bank_info["account_name"] ?></span></br>
                <span><?php echo "Bank Name: ".$bank_info["bank_name"] ?></span></br>
                <span><?php echo "Branch Name: ".$bank_info["branch_name"] ?></span></br>
            </fieldset>
            <?php
        }
        ?>
    </fieldset>
    <form action="Controller/saveManualTransaction.php" method="post"
          id="transactionForm">
        <input type="hidden" name="receiverId" value="<?php echo $receiverId; ?>"/>
        <input type="hidden" name="customerId" value="<?php echo $customerID;?>"/>
        <input type="hidden" name="rate" value="<?php echo $rate ?>"/>
        <input type="hidden" name="serviceCharge" value="<?php echo $serviceCharge ?>"/>
        <input type="hidden" name="amount" value="<?php echo $sendingAmount ?>"/>
        <input type="hidden" name="reason" value="<?php echo $reason ?>"/>
    </form>
    <button class="btn btn-primary" onclick="return confirmTransaction();">Confirm</button>
    <button onclick="editManualTransaction()">Edit</button>
</div>
</div>
</body>
</html>
