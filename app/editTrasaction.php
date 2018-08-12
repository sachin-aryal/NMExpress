<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/1/2016
 * Time: 10:53 AM
 */
require "Common/CommonFunction.php";
require "Common/DbConnection.php";
checkSession();
customerValidator();
$serviceCharge = getServiceCharge($conn);
?>
<html>
<head>
    <title>NME</title>
    <?php include "Include/BootstrapCss.html" ?>
    <script type="text/javascript">
        $(function(){
            <?php
            $rate = $_POST["rate"];
            ?>
            setSelectOptionWithSelected("<?php echo $_POST['receiverId'] ?>");
            $("#reasonForSending").val("<?php echo $_POST['reasonForSend'] ?>");
            $("#sendingAmount").val(<?php echo $_POST['sendingAmount'] ?>);
            changeTransactionDetails(<?php echo $rate?>)

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
        function onlyAmount(e, t) {
            try {
                if (window.event) {
                    var intCode = window.event.keyCode;
                }
                else if (e) {
                    var intCode = e.which;
                }
                else { return true; }
                if (((intCode >=48   && intCode <= 57) || intCode == 46)){
                    return true;
                }

                else{
                    notify('error', 'Invalid Amount')
                    $("#pages").val('');
                    return false;
                }

            }
            catch (err) {
                alert(err.Description);
            }
        }
    </script>
</head>
<body>
<?php include "Include/headerCustomer.php" ?>
<div id="sendMoneyForm" class="container">
    <form action="cTransaction.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-xs-4 selectContainer" style="display: inline-block">
                    <label class="control-label">Whom do you want to send money ?</label>
                    <select name="receiverId" class="form-control" id="receiverId">

                    </select>
                    <br>
                    <input type="submit" onclick="return validateProcessTransaction()" class="btn btn-success" value="Make Payment Now"/>
                </div>
                <div class="col-xs-4">
                    <label for="reasonForSending">Reason For Sending</label>
                    <select id="reasonForSending" class="form-control" name="reasonForSending">
                        <option value="Home Assist">Home Assist</option>
                        <option value="Help">Help</option>
                        <option value="Donation">Donation</option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <label for="sendingAmount">Sending Amount</label>
                    <input type="text" class="form-control" name="sendingAmount" id="sendingAmount" onkeypress="return onlyAmount(event,this)" onkeyup="changeTransactionDetails('<?php echo $rate?>')"/>
                    <input type="hidden" class="form-control" name="rate" id="rate" value="<?php echo $rate ?>"/><br>
                    <div id="sendingA" class="hide dynamicAmount">
                        <span id="sendingAmountSpan"></span><br>
                        <span id="todayRate"></span><br>
                        <span id="transactionFee"></span><br>
                        <span id="receiveAmount"></span><br>
                        <span id="totalCost"></span><br>
                    </div>
                    <input type="hidden" name="receiptFile" value="<?php echo $_POST["receiptFile"];?>"/>
                </div>
            </div>
        </div>
    </form>
</div>

</body>

</html>

