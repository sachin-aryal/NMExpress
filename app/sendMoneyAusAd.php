<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/12/16
 * Time: 7:03 AM
 */
require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
checkSession();
ausAgentAdminValidator();

$serviceCharge = getServiceCharge($conn);
?>
<html>
<head>
    <title>NME</title>

    <?php include "Include/BootstrapCss.html" ?>

    <script type="text/javascript">
        $(function(){
            $("#newCustomerFormDIV").hide();
            $("#newReceiverFormDIV").hide();
            $("#senderInfoDiv").hide();
            $("#receiverInfoDiv").hide();
            $("#receiver").attr('disabled', 'disabled');

            $("#addReceiverButton").prop("enabled", true);

            $("input[name=payment_type]").change(function(){
                var paymentType = $("input[name=payment_type]:checked").val();
                if(paymentType=="Cash" || paymentType == "Ime"){
                    $("#bankAccountDetails").addClass("hide");
                }else{
                    $("#bankAccountDetails").removeClass("hide");
                }
            });
            setSelectOption("<?php echo $_SESSION['username'] ?>");
$(".autoDate").on('input', function(){

                if($(this).val().charAt($(this).val().length - 1) == '-'){

                    $(this).val($(this).val().substring(0,$(this).val().length-1));
                }
                if($(this).val().split('-').length <= 2) {
                    if (($(this).val() + ' ').match(/\d{2}\s/g))
                        $(this).val($(this).val() + "-");
                }
            });
        });

        function newChangeTransactionDetails(){

            var rate = document.getElementById('rate').value;
            $("#sendingA").removeClass("hide");
            var sendingAmount = $("#sendingAmount").val();
			var serviceCharge = $("input[name=serviceCharge]:checked").val();
            $("#sendingAmountSpan").text("Sending Amount:\n$"+sendingAmount);
            $("#todayRate").text("Exchange Rate:\n"+rate);
            if(sendingAmount>=20000){
                $("#transactionFee").text("Transaction Fee:Free");
            }else{
                $("#transactionFee").text("Transaction Fee:$" + serviceCharge);
                sendingAmount = sendingAmount-serviceCharge;
            }
            $("#receiveAmount").text("Receive Amount:\nRs "+(rate*sendingAmount).toFixed(2));
        }
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
    </script>
    <script>
        $(function(){

            $("#san").hide();
            hideBusinessDetails();
            hideIndividualDetails();

            $("#sender").on('input', function(e){

                var senderName = $("#sender").val();

                $.ajax({
                    url:"Controller/searchSender.php",
                    type:"POST",
                    data:"senderName=" + senderName,
                    success:function(data){
                        var jsonData = JSON.parse(data);
                        var opts = $("#senders").children();
                        var flag = false;
                        for (var i = 0; i < opts.length; i++) {
                            if (opts[i].value === senderName) {
                                $("#senderId1").val(opts[i].id);
                                $("#senderId2").val(opts[i].id);
                                $radios = $('input:radio[name=receiverRadio]');
                                $radios.filter('[value=newReceiver]').prop('checked', true);
                                $("#addReceiverButton").removeAttr('disabled');
                                flag = true;
                                break;
                            }
                        }

                        if(!flag){

                            $("#senders").html("");
                        }

                        $.each(jsonData, function(i, obj) {
                            //use obj.id and obj.name here, for example:
                            if(senderName != jsonData[i])
                                $("#senders").append("<option id ='" + i + "'>" + jsonData[i] + "</option>");
                        });
                    }
                });
            });

            $("#receiver").on('input', function(){


                var receiverName = $("#receiver").val();
                var senderId = $("#senderId1").val();

                $.ajax({
                    url:"Controller/searchReceiver.php",
                    type:"POST",
                    data:"receiverName=" + receiverName + "&senderId=" + senderId,
                    success:function(data){
                        var jsonData = JSON.parse(data);

                        var opts = $("#receivers").children();
                        var flag = false;
                        for (var i = 0; i < opts.length; i++) {
                            if (opts[i].value === receiverName) {
                                $("#receiverId").val(opts[i].id);
                                flag = true;
                                break;
                            }
                        }

                        if(!flag){

                            $("#receivers").html("");
                        }

                        $.each(jsonData, function(i, obj) {
                            //use obj.id and obj.name here, for example:
                            if(receiverName != jsonData[i])
                                $("#receivers").append("<option id ='" + i + "'>" + jsonData[i] + "</option>");
                        });
                    }
                });
            });

            $('input[type=radio][name=senderRadio]').on('change', function(){

                if(this.value == 'newSender') {
                    $("#sender").val('');
                    $("#addSenderButton").removeAttr('disabled');
                }else if(this.value == 'oldSender'){
                    $("#senderInfoDiv").hide();
                    $("#sender").removeAttr('readOnly');
                    $("#addSenderButton").attr('disabled', 'disabled');
                }
                $("#senderId1").val('');
                $("#senderId2").val('');
                $("#senderName").val('');
                $("#newReceiverFormDIV").hide();
                $("#receiverId").val('');
                $("#receiver").val('');
                $("#receiverInfoDiv").hide();
                $("#addSenderButton").show();
                $("#addReceiverButton").show();
                $("#addReceiverButton").attr('disabled', 'disabled');
            });

            var $radios = $('input:radio[name=senderRadio]');
            if($radios.is(':checked') === false) {
                $radios.filter('[value=newSender]').prop('checked', true);
                $("#sender").attr('readOnly', 'readOnly');
            }

            $radios = $('input:radio[name=receiverRadio]');
            if($radios.is(':checked') === false) {
                $radios.filter('[value=newReceiver]').prop('checked', true);
                $("#receiver").attr('disabled', 'disabled');
            }

            $('input[type=radio][name=receiverRadio]').on('change', function(){

                if(this.value == 'newReceiver') {
                    $("#receiverId").val('');
                    $("#receiver").val('');
                    $("#receiver").attr('disabled', 'disabled');
                    if($("#senderId1").val() != '')
                        $("#addReceiverButton").removeAttr('disabled');
                }else if(this.value == 'oldReceiver'){

                    if($("#senderId1").val() != '')
                        $("#receiver").removeAttr('disabled');
                    $("#addReceiverButton").attr('disabled', 'disabled');
                }
            });
        });
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
        .notice{

            color: red;
        }
    </style>
</head>
<body>
<?php include "Include/header.php" ?>

<div id="sendMoneyForm" style="margin:0px auto;width: 50%">
    <form action="manualTransaction.php" method="post" autocomplete="off">
        <div class="form-group">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12">
                        <label>Sender:</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-1">
                        <input type="radio" name="senderRadio" value="newSender"/>
                    </div>
                    <div class = "col-xs-3">
                        <button type="button" onclick="showAddSender()" class="btn btn-success btn-md"  id = "addSenderButton" data-toggle="modal"  data-target="#addSenderModal" >New Sender</button>
                        <div id="senderInfoDiv">
                            <input type="text" id="senderName" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-1">
                        <input type="radio" name="senderRadio" value="oldSender"/>
                    </div>
                    <div class="col-xs-7">
                        <input type = "text" list="senders" id = "sender" name = "senderName" class="form-control" placeholder="Search Old Sender" width="100%"/>
                        <datalist id = "senders">
						<select>
						</select>
                        </datalist>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12">
                        <label>Receiver:</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-1">
                        <input type="radio" name="receiverRadio" value="newReceiver"/>
                    </div>
                    <div class = "col-xs-3">
                        <button type="button" onclick="showAddReceiver()"  class="btn btn-success btn-md" id = "addReceiverButton" data-toggle="modal" data-target="#addReceiver" disabled>New Receiver</button>
                        <div id="receiverInfoDiv">
                            <input type="text" id="receiverName" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-1">
                        <input type="radio" name="receiverRadio" value="oldReceiver"/>
                    </div>
                    <div class="col-xs-7">
                        <input type = "text" list="receivers" id = "receiver" name = "receiverName" class="form-control" placeholder="Search Old Receiver" width="100%"/>
                        <datalist id = "receivers">
                        </datalist>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <label for="reasonForSending">Reason For Sending</label>
                    <select class="form-control" id="reasonForSending" name="reasonForSending">
                        <option selected="selected" disabled> Select </option>
                        <option value="Home Assist">Home Assist</option>
                        <option value="Help">Help</option>
                        <option value="Donation">Donation</option>
                    </select>
                </div>
                <div class="col-xs-4">

                </div>

                <div class="col-xs-4">

                </div>
            </div>
        </div>
        <input type="hidden" name = "senderId1" id = "senderId1"/>
        <input type="hidden" name = "receiverId" id = "receiverId"/>
        <?php
        $rate = getExchangeRate($conn)["nrs"];
        ?>

        <div class="form-group">
            <div class="row">
                <div class="col-xs-4">
                    <label for="sendingAmount">Sending Amount (in AUD):</label>
                    <input type="text" class="form-control" name="sendingAmount" id="sendingAmount" onkeypress="return onlyAmount(event, this)"
                           onkeyup="if(onlyAmount(event,this) && $('#rate').val().length > 0)newChangeTransactionDetails()"/>
                </div>
                <div class="col-xs-4">
                    <label for="rate">Current Rate in NRS:</label>
                    <input type="text" class="form-control" name="rate" id="rate" onkeypress="return onlyAmount(event, this)" onkeyup="if(onlyAmount(event,this) && $('#sendingAmount').val().length > 0)newChangeTransactionDetails()" value="<?php echo $rate ?>"/>
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
<form onsubmit="return saveReceiver()" id="newReceiverForm" name="newReceiverForm">
<div class="container">
    <div class="row overallRow">
        <div class="col-md-4">
            <h3 class="text-center">Contact Information</h3>
            <hr>
            <div class="form-group">
                <div class="row no-pad">
                    <input type="hidden" name = "senderId2" id = "senderId2"/>
                    <div class="col-xs-4">
                        <label for="f_name">First Name<span class="notice">*</span></label>
                        <input class="form-control" type="text" name="f_name" id="f_name"/>
                    </div>
                    <div class="col-xs-4">
                        <label for="f_name">Middle Name</label>
                        <input class="form-control" type="text" name="m_name" id="m_name"/>
                    </div>
                    <div class="col-xs-4">
                        <label for="l_name">Last Name<span class="notice">*</span></label>
                        <input class="form-control" type="text" name="l_name" id="l_name"/>
                    </div>


                </div><br>
                <div class="row no-pad">
                    <div class="col-xs-6">
                        <label for="email_address">Email Address</label>
                        <input type="email" class="form-control" name="email_address" id="email_address"/>
                    </div>
                    <div class="col-xs-6">
                        <label for="phone_no">Phone<span class="notice">*</span></label>
                        <input type="text" class="form-control" name="phone_no" id="phone_no"/>
                    </div>
                </div><br>
            </div>
        </div>
        <div class="col-md-4">
            <h3 class="text-center">  Address Information</h3>
            <hr>


            <div class="row no-pad">
                <div class="col-xs-6">
                    <label for="city">Suburb<span class="notice">*</span></label>
                    <input type="text" class="form-control" name="city" id="city"/>
                </div>
                <div class="col-xs-6 selectContainer">
                    <label for="zone">Zone<span class="notice">*</span></label>
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
                    <label for="district">District<span class="notice">*</span></label>
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
                    <input type="radio" name="payment_type" id="payment_type1" value="Cash" checked/>Cash
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
                            <label for="account_number">Account Number<span class="notice">*</span></label>
                            <input class="form-control" type="text" name="account_number" id="account_number"/>
                        </div>

                        <div class="col-md-5">
                            <label for="account_name">Account Name<span class="notice">*</span></label>
                            <input class="form-control" type="text" name="account_name" id="account_name"/>
                        </div>
                        <div class="col-md-1"></div>

                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>

                        <div class="col-md-5">
                            <label for="bank_name">Bank Name<span class="notice">*</span></label>
                            <input class="form-control" type="text" name="bank_name" id="bank_name"/>
                        </div>

                        <div class="col-md-5">
                            <label for="branch_name">Branch Name<span class="notice">*</span></label>
                            <input class="form-control" type="text" name="branch_name" id="branch_name"/>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-1">
                <input class="center-block btn btn-primary" type="submit"  onclick="return validateReceiverInformation()" name="Save" id="Save" value="Save"/>
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
                    <form onsubmit="return addCustomer()"
                          name="newCustomerForm"
                          enctype="multipart/form-data"
                          id = "newCustomerForm">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-3">
                                    <label class="control-label">First Name<span class="notice">*</span></label>
                                    <input type="text" name="firstName" id="firstName" placeholder="First Name" class="form-control">
                                </div>

                                <div class="col-xs-3">
                                    <label class="control-label">Middle Name</label>
                                    <input name="middleName" id = "middleName" class="form-control" placeholder="Middle Name" type="text"/>
                                </div>

                                <div class="col-xs-3">
                                    <label class="control-label">Last Name<span class="notice">*</span></label>
                                    <input name="lastName" id = "lastName" class="form-control" placeholder="Last Name" type="text"/>
                                </div>

                                <div class="col-xs-3">
                                    <label class="control-label">Phone<span class="notice">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon">+61 </span>
                                        <input name="mobileNo" id = "mobileNo" class="form-control" placeholder="Phone" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-2">
                                    <label class="control-label">Unit<span class="notice">*</span></label>
                                    <input type="text" name="unit" id="unit" class="form-control" placeholder="Unit"/>
                                </div>
                                <div class="col-xs-2">
                                    <label class="control-label">Street No.<span class="notice">*</span></label>
                                    <input type="text" name="streetNo" id="streetNo" class="form-control" placeholder="Street No."/>
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">Street Name<span class="notice">*</span></label>
                                    <input type="text" name="street" id="street" class="form-control" placeholder="Street Name"/>
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">State<span class="notice">*</span></label>
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
                                    <label class="control-label">Post Code<span class="notice">*</span></label>
                                    <input type="text" name="postCode" id="postCode" class="form-control" placeholder="Post Code"/>
                                </div>
                                <div class="col-xs-6">
                                    <label class="control-label">Suburb<span class="notice">*</span></label>
                                    <input name="city" id = "senderCity" placeholder="Suburb" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label class="control-label">I'm a/an:<span class="notice">*</span></label>
                                    <select class="form-control" name="type" id="type" onchange="onSelectCustomerType(this);">
                                        <option>Select</option>
                                        <option>Individual</option>
                                        <option>Business</option>
                                    </select>
                                </div>
                                <div class="col-xs-4 selectContainer" id = "san">
                                    <label class="control-label">Birth Date<span class="notice">*</span></label>
                                    <input type="text" id = "dob" name="dob" class="form-control autoDate" placeholder="dd-mm-yyyy"/>
                                </div>
                                <div class="col-xs-4">
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id = "individualDetailsDiv">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label class="control-label">Identity Type<span class="notice">*</span></label>
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
                                    <label class="control-label">Identity Number<span class="notice">*</span></label>
                                    <input type="text" class="form-control" name="idNo" id="idNo" placeholder="Identity Number"><br>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Expiry Date<span class="notice">*</span></label>
                                    <input type="text" class="form-control autoDate" name="expiryDate" id="expiryDate" placeholder="dd-mm-yyyy"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id = "businessDetailsDiv">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label class="control-label">Business Name<span class="notice">*</span></label>
                                    <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Business Name"><br>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Registration Number<span class="notice">*</span></label>
                                    <input type="text" class="form-control" name="registration_no" id="registrationNo" placeholder="Registration Number"><br>
                                </div>

                                <div class="col-xs-4">
                                    <label class="control-label">Established Date<span class="notice">*</span></label>
                                    <input type="text" class="form-control autoDate" name="established_date" id="established_date" placeholder="dd-mm-yyyy"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label class="control-label">Email<span class="notice">*</span></label>
                                    <input name="email" id = "email" class="form-control" type="text" placeholder="Email"><br>
                                </div>
                                <div class="col-xs-4">
                                    <label class="control-label">Attach Id<span class="notice">*</span></label>
                                    <input type="file" name="idFront" id="idFront" class="form-control"/>
                                </div>
                                <div class="col-xs-4">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" onclick="return validateSenderInformation('save');">Save</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>



</body>
</html>