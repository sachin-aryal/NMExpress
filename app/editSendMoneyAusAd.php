<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 11:52 PM
 */
require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
checkSession();
ausAgentAdminValidator();
$customerID = $_POST["customerId"];
$customerInfo = getCustomerInfoFromId($customerID, $conn);
if(isset($_POST["receiverId"])){
    $receiverId = addslashes($_POST["receiverId"]);
    $reason = addslashes($_POST["reason"]);
    $rate = addslashes($_POST["rate"]);
    $serviceCharge = $_POST["serviceCharge"];
    $sendingAmount = addslashes($_POST["amount"]);
    $receiverInfo = getReceiverInfoFromCusId($conn,$receiverId, $customerID);
    $bank_id = $receiverInfo["bank_id"];
    $payment_type = $receiverInfo["payment_type"];
    if($bank_id!=null){
        $bank_info = getBankInfo($conn,$bank_id);
    }else{
        $data = array("id"=>"", "account_name"=>"", "account_no"=>"",
            "bank_name"=>"", "branch_name"=>"");
        $bank_info = $data;
    }
}
//$serviceCharge = getServiceCharge($conn);
?>
<html>
<head>
    <title>NME</title>

    <?php include "Include/BootstrapCss.html" ?>
    <script type="text/javascript" language="javascript" src="Assets/Js/bootstrap-datepicker.min.js">
    </script>
    <script src="Assets/Js/jquery.fancybox.js"></script>
    <link href="Assets/Css/jquery.fancybox.css" rel="stylesheet"/>
    <link href="Assets/Css/bootstrap-datepicker.min.css" rel="stylesheet"/>
    <script type="text/javascript">
        $(function(){

            $('.sandbox-container').datepicker({
                format: "yyyy/mm/dd"
            });
            $("#reasonForSending").val("<?php echo $reason ?>");
            $("#idType").val("<?php echo $customerInfo['identity_type'] ?>");
            $("#type").val("<?php echo $customerInfo['type'] ?>");
            $("#zone").val("<?php echo $receiverInfo['zone']?>")
            $("#district").val("<?php echo $receiverInfo['district']?>");
            $("#state").val("<?php echo $customerInfo['state']?>");
            var which = "<?php echo $receiverInfo["payment_type"] ?>";

            $("input[name=payment_type]").find($('input[value="'+which+'"]').prop("checked",true));

            if(which=="Bank"){
                $("#bankAccountDetails").removeClass("hide");
            }

            var selectedVal = "<?php echo $customerInfo['type'] ?>";
            if(selectedVal === "Individual"){
                hideBusinessDetails();
                displayIndividualDetails();
            }else if(selectedVal === "Business"){
                hideIndividualDetails();
                displayBusinessDetails();
            }else {
                hideBusinessDetails();
                hideIndividualDetails();
            }
            $(".fancybox").fancybox();

        });
    </script>

    <script type="text/javascript">
        $(function(){
            $("#newCustomerFormDIV").hide();
            $("#newReceiverFormDIV").hide();

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

        function newChangeTransactionDetails(){

            var rate = document.getElementById('rate').value;
            changeTransactionDetailsAdmin(rate);
        }
        function changeTransactionDetailsAdmin(rate){
            $("#sendingA").removeClass("hide");
            var sendingAmount = $("#sendingAmount").val();
            var serviceCharge = $("input[name=serviceCharge]:checked").val();
            $("#sendingAmountSpan").text("Sending Amount:\n$"+sendingAmount);
            $("#todayRate").text("Exchange Rate:\n"+rate);
            if(sendingAmount>=20000){
                $("#transactionFee").text("Transaction Fee:Free");
            }else{
                $("#transactionFee").text("Transaction Fee:$" + serviceCharge);
                sendingAmount = sendingAmount- serviceCharge ;
            }
            $("#receiveAmount").text("Receive Amount:\nRs "+(rate*sendingAmount).toFixed(2));
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
                //alert(err.Description);
            }
        }
    </script>
    <script>
        function onSelectCustomerType(select){

            if(select.value === "Individual"){

                hideBusinessDetails();
                displayIndividualDetails();
            }else if(select.value === "Business"){

                hideIndividualDetails();
                displayBusinessDetails();
            }else {
                hideBusinessDetails();
                hideIndividualDetails();
            }
        }

        function displayBusinessDetails(){

            $("#businessDetailsDiv").show();
        }

        function hideBusinessDetails() {

            $("#businessDetailsDiv").hide();
        }

        function displayIndividualDetails(){

            $("#san").show();
            $("#individualDetailsDiv").show();
        }

        function hideIndividualDetails(){

            $("#san").hide();
            $("#individualDetailsDiv").hide();
        }
    </script>
    <style>
        #senderModalDialog{
            width: 60%;
        }
    </style>
</head>
<body>
<?php include "Include/header.php" ?>

<div id="sendMoneyForm" style="margin:0px auto;width: 50%">
    <form action="manualTransaction.php" method="post" autocomplete="off">
        <div class="form-group">
            <div class="row">
                <div class="col-xs-4">
                    <div id="senderInfoDiv">
                        <label for="senderName">Sender: </label>
                        <input type="text" id="senderName" class="form-control"
                        value="<?php echo $customerInfo['f_name']." ".$customerInfo['l_name'] ?>" readonly>
                    </div><br>
                    <button type="button" onclick="showAddSender()" class="btn btn-success btn-md"  id = "addSenderButton" data-toggle="modal"  data-target="#addSenderModal" >Edit Sender</button>
                </div>

                <div class="col-xs-4">
                    <div id="receiverInfoDiv">
                        <label for="receiverName">Receiver: </label>
                        <input type="text" id="receiverName" class="form-control"
                               value="<?php echo $receiverInfo['f_name']." ".$receiverInfo['l_name'] ?>" readonly>
                    </div><br>
                    <button type="button" onclick="showAddReceiver()"  class="btn btn-success btn-md" id = "addReceiverButton" data-toggle="modal" data-target="#addReceiver">Edit Receiver</button>
                </div>

                <div class="col-xs-4">
                    <label for="reasonForSending">Reason For Sending</label>
                    <select class="form-control" id="reasonForSending" name="reasonForSending">
                        <option selected="selected" disabled> Select </option>
                        <option value="Home Assist">Home Assist</option>
                        <option value="Help">Help</option>
                        <option value="Donation">Donation</option>
                    </select>
                </div>
            </div>
        </div>
        <input type="hidden" name = "senderId1" id = "senderId1" value="<?php echo $customerID ?>"/>
        <input type="hidden" name = "receiverId" id = "receiverId" value="<?php echo $receiverId ?>"/>


        <div class="form-group">
            <div class="row">
                <div class="col-xs-4">
                    <label for="sendingAmount">Sending Amount</label>
                    <input type="text" class="form-control" name="sendingAmount" id="sendingAmount" onkeypress="return
                     onlyAmount(event,this)" onkeyup="newChangeTransactionDetails()" value="<?php echo $sendingAmount ?>"/>
                </div>
                <div class="col-xs-4">
                </div>
                <div class="col-xs-4">
                    <label for="rate">Rate in NRS:(For 1 AUD)</label>
                    <input type="text" class="form-control" name="rate" id="rate" onkeypress="return onlyAmount(event,this)"
                           onkeyup="newChangeTransactionDetails()" value="<?php echo $rate ?>"/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-xs-7">
                <label for="rate">Charge: </label>
                10$ <input type="radio" name="serviceCharge" id="serviceCharge" value="10" onchange="newChangeTransactionDetails()" checked />
                5$ <input type="radio" name="serviceCharge" id="serviceCharge" value="5" onchange="newChangeTransactionDetails()" />
                Free <input type="radio" name="serviceCharge" id="serviceCharge" value="0" onchange="newChangeTransactionDetails()" />    
                    <button type="submit" onclick="return validateSendMoneyAusAd()" class="btn btn-primary btn-md" >Make Payment Now</button>
                </div>

                <div class="col-xs-4">
                    <div id="sendingA" class="hide dynamicAmount">
                        <span id="sendingAmountSpan"></span><br>
                        <span id="todayRate"></span><br>
                        <span id="transactionFee"></span><br>
                        <span id="receiveAmount"></span><br>
                        <span id="totalCost"></span><br>
                    </div>
                </div>


                <div class="col-xs-4">
                </div>
            </div>
        </div>
    </form>
</div>
<div id = "newReceiverFormDIV">
    <h2 class="text-center">Receiver Information</h2>
    <div class="panel-body">
        <form onsubmit="return updateReceiver()" id="newReceiverForm" name="newReceiverForm">
            <div class="container">
                <div class="row overallRow">
                    <div class="col-md-4">
                        <h3 class="text-center">Contact Information</h3>
                        <hr>
                        <div class="form-group">
                            <div class="row no-pad">
                                <input type="hidden" name = "id" id = "id" value="<?php echo $receiverId ?>"/>
                                <input type="hidden" name = "bank_id" id = "id" value="<?php echo $bank_id ?>"/>
                                <div class="col-xs-4">
                                    <label for="f_name">First Name</label>
                                    <input class="form-control" type="text" name="f_name" id="f_name"
                                    value="<?php echo $receiverInfo['f_name'] ?>"/>
                                </div>
                                <div class="col-xs-4">
                                    <label for="f_name">Middle Name</label>
                                    <input class="form-control" type="text" name="m_name" id="m_name"
                                           value="<?php echo $receiverInfo['m_name'] ?>"/>
                                </div>
                                <div class="col-xs-4">
                                    <label for="l_name">Last Name</label>
                                    <input class="form-control" type="text" name="l_name" id="l_name"
                                           value="<?php echo $receiverInfo['l_name'] ?>"/>
                                </div>


                            </div><br>
                            <div class="row no-pad">
                                <div class="col-xs-6">
                                    <label for="email_address">Email Address</label>
                                    <input type="email" class="form-control" name="email_address" id="email_address"
                                           value=""/>
                                </div>
                                <div class="col-xs-6">
                                    <label for="phone_no">Phone</label>
                                    <input type="text" class="form-control" name="phone_no" id="phone_no"
                                           value="<?php echo $receiverInfo['phone_no'] ?>"/>
                                </div>
                            </div><br>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-center">  Address Information</h3>
                        <hr>


                        <div class="row no-pad">
                            <div class="col-xs-6">
                                <label for="city">City/Town</label>
                                <input type="text" class="form-control" name="city" id="city"
                                       value="<?php echo $receiverInfo['city'] ?>"/>
                            </div>
                            <div class="col-xs-6 selectContainer">
                                <label for="zone">Zone</label>
                                <select class="form-control" name = "zone" id = "zone">
                                    <option>Select</option>
                                    <option>Mechi</option>
                                    <option>Koshi</option>
                                    <option>Sagarmatha</option>
                                    <option>Janakpur</option>
                                    <option>Bagmati</option>
                                    <option>Narayani</option>
                                    <option>Gandaki</option>
                                    <option>Dhawalagiri</option>
                                    <option>Lumbini</option>
                                    <option>Rapti</option>
                                    <option>Bheri</option>
                                    <option>Karnali</option>
                                    <option>Seti</option>
                                    <option>Mahakali</option>
                                </select>

                            </div>

                        </div>
                        <br>
                        <div class="row no-pad">
                            <div class="col-xs-6">
                                <label for="district">District</label>
                                <select class="form-control" name="district" id = "district">
                                    <option>Select</option>
                                    <option>Achham</option>
                                    <option>Arghakhanchi</option>
                                    <option>Baglung</option>
                                    <option>Baitadi</option>
                                    <option>Bajhang</option>
                                    <option>Bajura</option>
                                    <option>Banke</option>
                                    <option>Bara</option>
                                    <option>Bardiya</option>
                                    <option>Bhaktapur</option>
                                    <option>Bhojpur</option>
                                    <option>Chitwan</option>
                                    <option>Dadeldhura</option>
                                    <option>Dailekh</option>
                                    <option>Dang</option>
                                    <option>Darchula</option>
                                    <option>Dhading</option>
                                    <option>Dhankuta</option>
                                    <option>Dhanusa</option>
                                    <option>Dholkha</option>
                                    <option>Dolpa</option>
                                    <option>Doti</option>
                                    <option>Gorkha</option>
                                    <option>Gulmi</option>
                                    <option>Humla</option>
                                    <option>Ilam</option>
                                    <option>Jajarkot</option>
                                    <option>Jhapa</option>
                                    <option>Jumla</option>
                                    <option>Kailali</option>
                                    <option>Kalikot</option>
                                    <option>Kanchanpur</option>
                                    <option>Kapilvastu</option>
                                    <option>Kaski</option>
                                    <option>Kathmandu</option>
                                    <option>Kavrepalanchok</option>
                                    <option>Khotang</option>
                                    <option>Lalitpur</option>
                                    <option>Lamjung</option>
                                    <option>Mahottari</option>
                                    <option>Makwanpur</option>
                                    <option>Manang</option>
                                    <option>Morang</option>
                                    <option>Mugu</option>
                                    <option>Mustang</option>
                                    <option>Myagdi</option>
                                    <option>Nawalparasi</option>
                                    <option>Nuwakot</option>
                                    <option>Okhaldhunga</option>
                                    <option>Palpa</option>
                                    <option>Panchthar</option>
                                    <option>Parbat</option>
                                    <option>Parsa</option>
                                    <option>Pyuthan</option>
                                    <option>Ramechhap</option>
                                    <option>Rasuwa</option>
                                    <option>Rautahat</option>
                                    <option>Rolpa</option>
                                    <option>Rukum</option>
                                    <option>Rupandehi</option>
                                    <option>Salyan</option>
                                    <option>Sankhuwasabha</option>
                                    <option>Saptari</option>
                                    <option>Sarlahi</option>
                                    <option>Sindhuli</option>
                                    <option>Sindhupalchok</option>
                                    <option>Siraha</option>
                                    <option>Solukhumbu</option>
                                    <option>Sunsari</option>
                                    <option>Surkhet</option>
                                    <option>Syangja</option>
                                    <option>Tanahu</option>
                                    <option>Taplejung</option>
                                    <option>Terhathum</option>
                                    <option>Udayapur</option>
                                </select>
                            </div>

                            <div class="col-xs-6">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row no-pad">

                            <h3 class="text-center">Payment Type</h3>
                            <hr>
                            <div class="col-md-4">
                                <input type="radio" name="payment_type" id="payment_type1" value="Cash"/>Cash
                            </div>
                            <div class="col-md-4">
                                <input type="radio" name="payment_type" id="payment_type2" value="Bank"/>Bank<br>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" name="payment_type" id="payment_type3" value="Ime"/>IME<br>
                            </div>

                            <div id="bankAccountDetails" class="hide no-pad">
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-5">
                                        <label for="account_number">Account Number</label>
                                        <input class="form-control" type="text" name="account_number" id="account_number"
                                               value="<?php echo $bank_info['account_no'] ?>"/>
                                    </div>

                                    <div class="col-md-5">
                                        <label for="account_name">Account Name</label>
                                        <input class="form-control" type="text" name="account_name" id="account_name"
                                               value="<?php echo $bank_info['account_name'] ?>"/>
                                    </div>
                                    <div class="col-md-1"></div>

                                </div>

                                <div class="row">
                                    <div class="col-md-1"></div>

                                    <div class="col-md-5">
                                        <label for="bank_name">Bank Name</label>
                                        <input class="form-control" type="text" name="bank_name" id="bank_name"
                                               value="<?php echo $bank_info['bank_name'] ?>"/>
                                    </div>

                                    <div class="col-md-5">
                                        <label for="branch_name">Branch Name</label>
                                        <input class="form-control" type="text" name="branch_name" id="branch_name"
                                               value="<?php echo $bank_info['branch_name'] ?>"/>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-1">
                            <input class="center-block btn btn-primary" type="submit"  onclick="return validateReceiverInformation()" name="Save" id="Save" value="Update"/>
                        </div>
                        <div class="col-md-5">
                        </div>
                        <div class="col-md-6"></div>
                    </div><br>
                </div>
            </div>

        </form>

    </div>
</div>

<!-- Modal -->
<div id="addSenderModal" class="modal fade" role="dialog">
    <div class="modal-dialog" id="senderModalDialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id = "closeAddSenderButton">&times;</button>
                <h4 class="modal-title">Sender Information </h4>
            </div>
            <div class="modal-body">

                <div id = "newCustomerFormDIV">
                    <form onsubmit="return updateCustomer()"
                          name="newCustomerForm"
                          enctype="multipart/form-data"
                          id = "newCustomerForm">
                        <input type="hidden" name = "id" id = "id" value="<?php echo $customerID ?>"/>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-3">
                                    <label class="control-label">First Name*</label>
                                    <input type="text" name="firstName" id="firstName" placeholder="First Name"
                                           class="form-control" value="<?php echo $customerInfo['f_name'] ?>">
                                </div>

                                <div class="col-xs-3">
                                    <label class="control-label">Middle Name</label>
                                    <input name="middleName" id = "middleName" class="form-control" value="<?php echo $customerInfo['middle_name'];?>" placeholder="Middle Name" type="text"/>
                                </div>

                                <div class="col-xs-3">
                                    <label class="control-label">Last Name*</label>
                                    <input name="lastName" id = "lastName" class="form-control" placeholder="Last Name"
                                           type="text" value="<?php echo $customerInfo['l_name'] ?>"/>
                                </div>

                                <div class="col-xs-3">
                                    <label class="control-label">Phone*</label>
                                    <input name="mobileNo" id = "mobileNo" class="form-control" placeholder="Phone"
                                           type="text" value="<?php echo $customerInfo['mobile_no'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-2">
                                    <label class="control-label">Unit*</label>
                                    <input type="text" name="unit" id="unit" class="form-control"
                                           value="<?php echo $customerInfo['unit'] ?>"/>
                                </div>
                                <div class="col-xs-2">
                                    <label class="control-label">Street No.*</label>
                                    <input type="text" id = "streetNo" name="unit" id="unit" class="form-control"
                                           value="<?php echo $customerInfo['street_no'] ?>"/>
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">Street Name*</label>
                                    <input type="text" name="street" id="street" class="form-control"
                                           value="<?php echo $customerInfo['street'] ?>"/>
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">State*</label>
                                    <select name="state" id = "state" class="form-control">
                                        <option>Select</option>
                                        <option>Australian Capital Territory</option>
                                        <option>New South Wales</option>
                                        <option>Northern Territory</option>
                                        <option>Queensland</option>
                                        <option>South Australia</option>
                                        <option>Tasmania</option>
                                        <option>Victoria</option>
                                        <option>Western Australia</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label class="control-label">Post Code*</label>
                                    <input type="text" name="postCode" id="postCode" class="form-control" value="<?php echo $customerInfo['post_code'];?>" placeholder="Post Code"/>
                                </div>
                                <div class="col-xs-6">
                                    <label class="control-label">City/Town*</label>
                                    <input name="city" id = "senderCity" placeholder="City/Town" value="<?php echo $customerInfo['city'];?>" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label class="control-label">I'm a/an:*</label>
                                    <select class="form-control" name="type" id="type" onchange="onSelectCustomerType(this);">
                                        <option>Select</option>
                                        <option>Individual</option>
                                        <option>Business</option>
                                    </select>
                                </div>
                                <div class="col-xs-4 selectContainer" id = "san">
                                    <label class="control-label">Birth Date*</label>
                                    <input type="text" id = "dob" name="dob" class="form-control sandbox-container"
                                           placeholder="Birth Date" value="<?php echo date_format(new DateTime($customerInfo['dob']),'d-m-Y'); ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id = "individualDetailsDiv">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label class="control-label">Identity Type*</label>
                                    <select class="form-control" name="idType" id="idType">
                                        <option>Select</option>
                                        <option>Student ID</option>
                                        <option>Driving License</option>
                                        <option>Photo Id No.</option>
                                        <option>Australian Passport</option>
                                        <option>Nepalese Passport</option>
                                    </select>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Identity Number*</label>
                                    <input type="text" class="form-control" name="idNo" id="idNo"
                                           placeholder="Identity Number" value="<?php echo $customerInfo['identity_no'] ?>"><br>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Expiry Date*</label>
                                    <input type="text" class="form-control sandbox-container" name="expiryDate"
                                           id="expiryDate" placeholder="Expiry Date" value="<?php echo date_format(new DateTime($customerInfo['expiry_date']),'d-m-Y'); ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id = "businessDetailsDiv">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label class="control-label">Business Name*</label>
                                    <input type="text" class="form-control" name="business_name" id="business_name"
                                           placeholder="Business Name" value="<?php echo $customerInfo['business_name'] ?>"><br>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Registration Number*</label>
                                    <input type="text" class="form-control" name="registration_no" id="registrationNo"
                                           placeholder="Registration Number" value="<?php echo $customerInfo['registration_no'] ?>"><br>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Established Date*</label>
                                    <input type="text" class="form-control sandbox-container" name="established_date"
                                           id="established_date" placeholder="Established Date"
                                           value="<?php echo date_format(new DateTime($customerInfo['established_date']),'d-m-Y');?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label class="control-label">Email*</label>
                                    <input name="email" id = "email" class="form-control" type="text"
                                           placeholder="Email" value="<?php echo $customerInfo['email'] ?>"><br>
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">Attach Id*</label>
                                    <input type="file" name="idFront" id="idFront" class="form-control"
                                    value=""/>
                                </div>
                                <div class="col-xs-4">
                                    <a class="fancybox" rel="gallery1" href="<?php echo $customerInfo["id_front_url"]?>"><img src="<?php echo $customerInfo["id_front_url"]?>" height="100" width="100"/></a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="isAjax" value="yes"/>
                        <button type="submit" class="btn btn-primary" onclick="return validateSenderInformation('editMoney');">Update</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>



</body>
</html>