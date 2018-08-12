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
            $("input[name=payment_type]").change(function(){
                var paymentType = $("input[name=payment_type]:checked").val();
                if(paymentType=="Cash" || paymentType == "Ime"){
                    $("#bankAccountDetails").addClass("hide");
                }else{
                    $("#bankAccountDetails").removeClass("hide");
                }
            });
            setSelectOption();
        });
        function onlyAmount(e, t) {
            try {
                if (e.which !== 0 &&
                    e.which == 16 || e.which == 17
                    || e.which == 9 || e.which == 18
                    || e.which == 8 || e.which == 27
                    || (e.which >= 112 && e.which <= 123)
                ){
                    return false;
                }
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
                    $("#pages").val('');
                    return false;
                }

            }
            catch (err) {
                //alert(err.Description);
            }
        }
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
    <style>
        .notice{

            color: red;
        }
    </style>
</head>
<body>
<?php include "Include/headerCustomer.php" ?>
<div id="sendMoneyForm" class="container" style="margin-right: 0px">
    <form action="cTransaction.php" method="post"  enctype="multipart/form-data">
        <div class="form-group">
            <div class="row">
                <div class="col-xs-3 selectContainer" style="display: inline-block">
                    <label class="control-label">Whom do you want to send money?<span class="notice">*</span></label>
                    <select name="receiverId" class="form-control" id="receiverId">

                    </select>
                </div>
                <div class="col-xs-3">
                    <br>
                    <button type="button" class="btn btn-primary" id="newReceiverButton" data-toggle="collapse" data-target="#collapseNewReceiver"
                            onclick="changeText()">
                        Add New Receiver
                    </button>
                </div>
                <div class="col-xs-3">
                </div>
                <div class="col-xs-3">
                </div>
            </div>
        </div>
        <div class="form-group">
        <div class="row">
            <div class="col-xs-3">
                <label for="reasonForSending">Reason For Sending<span class="notice">*</span></label>
                <select id="reasonForSending" class="form-control" name="reasonForSending">
                    <option value="Home Assist">Home Assist</option>
                    <option value="Help">Help</option>
                    <option value="Donation">Donation</option>
                </select>
            </div>
            <div class="col-xs-3">
                <?php
                $rate = getExchangeRate($conn)["nrs"];
                ?>
                <label for="sendingAmount">Sending Amount<span class="notice">*</span></label>
                <div class="input-group">
                    <label class="input-group-addon">$</label>
                    <input type="text" placeholder="0.00" class="form-control" name="sendingAmount" id="sendingAmount" onkeyup="if(onlyAmount(event,this))changeTransactionDetails('<?php echo $rate?>')"/>
                </div>
                <input type="hidden" class="form-control" name="rate" id="rate" value="<?php echo $rate ?>"/><br>
            </div>
            <div class="col-xs-3">
                <label class="control-label">Attach Receipt<span class="notice">*</span></label>
                <input type="file" name="idFront" id="idFront" class="form-control"/>
            </div>
            <div class="col-xs-3">
            </div>
            <div class="col-xs-3">
            </div>
        </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-5">
                    <div id="sendingA" class="hide dynamicAmount">
                        <span id="sendingAmountSpan"></span><br>
                        <span id="todayRate"></span><br>
                        <span id="transactionFee"></span><br>
                        <span id="receiveAmount"></span><br>
                        <span id="totalCost"></span><br>
                        <span>
                            Please deposit the amount in our following bank account:<br><br>
                            <strong>
                                Nepal Money Express Pty. Ltd<br>
                                NAB Bank<br>
                                BSB : 082451<br>
                                A/C No: 361816275<br><br>
                            </strong>
                        </span>
                    </div>
                </div>
                <div class="col-xs-1">
                </div>
                <div class="col-xs-3">
                    <input type="submit" onclick="return validateProcessTransaction()" class="btn btn-success" value="Make Payment Now"/>
                </div>
                <div class="col-xs-3">
                </div>
            </div>
        </div>
    </form>
</div>

<?php
include "Controller/newReceiverForm.php";
?>
<?php include "Include/footer.php" ?>
</body>

</html>