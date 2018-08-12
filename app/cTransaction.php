<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/1/2016
 * Time: 6:11 PM
 */
require "Common/DbConnection.php";
require "Common/CommonFunction.php";
customerValidator();
$serviceCharge = getServiceCharge($conn);
$rate = getExchangeRate($conn)["nrs"];
if(isset($_POST["receiverId"])){
    $receiverId = addslashes($_POST["receiverId"]);
    $reason = addslashes($_POST["reasonForSending"]);
    $rate = addslashes($_POST["rate"]);
    $sendingAmount = addslashes($_POST["sendingAmount"]);
    $receiverInfo = getReceiverInfo($conn,$receiverId);
    $customerInfo = getCustomerInfo($conn);
    $bank_id = $receiverInfo["bank_id"];
    if($bank_id!=null){
        $bank_info = getBankInfo($conn,$bank_id);
    }

    $target_dir = "receipts/";
    $target_file = "";

    // Check if image file is a actual image or fake image
    if(!isset($_POST["receiptFile"])) {
        if (isset($_FILES["idFront"])) {
            $uploadOk = 1;
            $imageFileType = pathinfo(basename($_FILES["idFront"]["name"]), PATHINFO_EXTENSION);
            $target_file = $target_dir . $receiverId . '.' . $imageFileType;

            $check1 = getimagesize($_FILES["idFront"]["tmp_name"]);
            if (($check1) !== false) {
                $uploadOk = 1;

                if (!move_uploaded_file($_FILES["idFront"]["tmp_name"], $target_file)) {
                    redirect('dashboardC.php?msgError=' . "Error making transaction. Please try again.");
                    return;
                }
            } else {
                $uploadOk = 0;
                redirect('dashboardC.php?msgError=' . "Error making transaction. Please try again.");
                return;
            }
        } else {

            redirect('dashboardC.php?msgError=' . "Error making transaction. Please try again.");
            return;
        }
    }else{

        $target_file = $_POST["receiptFile"];
    }
}


?>
<html>
<head>
    <title>NME</title>
    <?php include "Include/BootstrapCss.html" ?>
    <script type="text/javascript">
        $(function(){
            changeTransactionDetails("<?php echo $rate ?>")
        });
        function changeTransactionDetails(rate){
            $("#sendingA").removeClass("hide");
            var sendingAmount = $("#sendingAmount").val();
            $("#sendingAmountSpan").text("Sending Amount:\n$"+sendingAmount);
            $("#todayRate").text("Exchange Rate:\n"+rate);
            $("#transactionFee").text("Transaction Fee:$" + "<?php echo $serviceCharge; ?>");
            sendingAmount = sendingAmount-<?php echo $serviceCharge; ?>;
            /*if(sendingAmount>=20000){
             $("#transactionFee").text("Transaction Fee:Free");
             }else{

             }*/
            $("#receiveAmount").text("Receive Amount:\nRs "+(rate*sendingAmount).toFixed(2));
            //$("#totalCost").text("Your total transaction cost will be: Rs "+rate*sendingAmount)
        }
    </script>
</head>
<body>

<?php include "Include/headerCustomer.php" ?>

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
                if($bank_id==null){
                    $payment_type = "Cash";
                }else{
                    $payment_type = "Bank";
                }
                echo "Payment Type: ".$payment_type;
                ?></span></br>
        <input type="hidden" name="sendingAmount" id="sendingAmount" value="<?php echo $sendingAmount ?>"
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
    <div class="form-group">
        <form action="Controller/saveTransactionDetails.php" method="post"
              id="transactionForm">
            <input type="hidden" name="receiverId" value="<?php echo $receiverId ?>"/>
            <input type="hidden" name="rate" value="<?php echo $rate ?>"/>
            <input type="hidden" name="amount" value="<?php echo $sendingAmount ?>"/>
            <input type="hidden" name="reason" value="<?php echo $reason ?>"/>
            <input type="hidden" name="receipt" value="<?php echo $target_file; ?>"/>
        </form>
        <form method="post" action="editTrasaction.php">
            <input type="hidden" name="receiverId" value="<?php echo $receiverId ?>"/>
            <input type="hidden" name="sendingAmount" value="<?php echo $sendingAmount ?>"/>
            <input type="hidden" name="reasonForSend" value="<?php echo $reason ?>"/>
            <input type="hidden" name="receiptFile" value="<?php echo $target_file ?>"/>
            <input type="hidden" name="rate" value="<?php echo $rate ?>"/>
            <button type="button" class="btn btn-success" onclick="return confirmTransaction();">Confirm</button>
            <button class="btn btn-danger">Edit</button>
        </form>
    </div>
</div>
    </div>

<?php include "Include/footer.php" ?>
</body>
</html>
