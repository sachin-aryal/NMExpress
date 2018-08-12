<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 1:56 PM
 */
if($_GET["receiver_id"]){
    require 'Common/CommonFunction.php';
    require 'Common/DbConnection.php';
    $receiverId = addslashes($_GET["receiver_id"]);
    $receiverInfo = getReceiverInfo($conn,$receiverId);
    if(count($receiverInfo) == 0)
        goToDashBoard('');
    $bank_id = $receiverInfo["bank_id"];
    if($bank_id!=null){
        $bank_info = getBankInfo($conn,$bank_id);
    }else{
        $data = array("id"=>"", "account_name"=>"", "account_no"=>"",
            "bank_name"=>"", "branch_name"=>"");
        $bank_info = $data;
    }
}
?>
<html>
<head>
    <title>NME</title>
    <?php include "Include/BootstrapCss.html" ?>
    <script>
        $(function(){

            var zone = "<?php echo $receiverInfo['zone'] ?>";

            $("#zone>option").map(function() {
                if($(this).html().indexOf(zone) != -1){

                    $(this).attr('selected', 'selected');
                }
            });

            var district = "<?php echo $receiverInfo['district'] ?>";

            $("#district>option").map(function() {
                if($(this).html().indexOf(district) != -1){

                    $(this).attr('selected', 'selected');
                }
            });

            var payment_type = "<?php echo $receiverInfo['payment_type'] ?>";

            $("#payment_type>option").map(function() {
                if($(this).html().indexOf(payment_type) != -1){

                    $(this).attr('selected', 'selected');
                }
            });
        });

        function hidePaymentTypeDetails(value){

            if(value === "Cash" || value === "IME"){

                $("#bankDetails").addClass("hide");
            }else{

                $("#bankDetails").removeClass("hide");
            }
        }
    </script>
</head>
<body><?php include "Include/headerCustomer.php" ?>
<div class="selfContainer">
    <h3 class="text-center">Receiver Info</h3>
    <form onsubmit="return updateReceiver()" id="newReceiverForm" name="newReceiverForm">
        <input type="hidden" name="id" value="<?php echo $receiverInfo["id"]?>">
    <div class="form-group">
        <div class="row">
            <div class="col-xs-4">
                <label class="control-label">First Name</label>
                <input type="text" id="f_name" name="f_name" placeholder="First Name" class="form-control" value="<?php echo $receiverInfo['f_name'] ?>" >
            </div>

            <div class="col-xs-4">
                <label class="control-label">Last Name</label>
                <input name="l_name" id="l_name" class="form-control" placeholder="Last Name" type="text" value="<?php echo $receiverInfo['l_name'] ?>" />
            </div>

            <div class="col-xs-4">
                <label class="control-label">Phone</label>
                <input name="phone_no" id="phone_no" class="form-control" placeholder="Phone" type="text" value="<?php echo $receiverInfo['phone_no'] ?>" >
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-xs-4">
                <label class="control-label">City</label>
                <input name="city" id="city" class="form-control" type="text" placeholder="City" value="<?php echo $receiverInfo['city'] ?>" >
            </div>
            <div class="col-xs-4">
                <label class="control-label">Country</label>
                <input name="country" id="country" class="form-control" type="text" placeholder="Country" value="<?php echo $receiverInfo['country'] ?>" ><br>
            </div>
            <div class="col-xs-4">
                <label class="control-label">District</label>
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

        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-xs-4">
                <label class="control-label">Zone</label>
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
            <div class="col-xs-4">
                <label class="control-label">Payment Type</label>
                <select id = "payment_type" name="payment_type" class="form-control" onchange="hidePaymentTypeDetails(this.value)">
                    <option>Cash</option>
                    <option>Bank</option>
                    <option>IME</option>
                </select>
            </div>
        </div>
    </div>
    <?php
        if($bank_id!=null) {
    ?>
            <script>
                $(function(){

                    $("#bankDetails").removeClass("hide");
                });
            </script>
            <input type="hidden" name="bank_id" value="<?php echo $bank_id;?>">
    <?php
        }
    ?>
        <hr>
        <div class="form-group hide" id = "bankDetails">
            <h4 class="text-center">Bank Details</h4>
            <div class="row">
                <div class="col-xs-3">
                    <label class="control-label">Account Number</label>
                    <input type="text" name="account_number" id="accountNo" class="form-control" placeholder="Account Number" value="<?php echo $bank_info["account_no"] ?>" />
                </div>

                <div class="col-xs-3">
                    <label class="control-label">Account Name</label>
                    <input type="text" name="account_name" id="accountName" class="form-control" placeholder="Account Name" value="<?php echo $bank_info["account_name"] ?>" />
                </div>

                <div class="col-xs-3">
                    <label class="control-label">Branch Name</label>
                    <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Account Number" value="<?php echo $bank_info["bank_name"] ?>" />
                </div>

                <div class="col-xs-3">
                    <label class="control-label">Branch Name</label>
                    <input type="text" name="branch_name" id="branch_name" class="form-control" placeholder="Branch Name" value="<?php echo $bank_info["branch_name"] ?>" />
                </div>
            </div>
        </div>
        <input class="center-block btn btn-primary" onclick="return validateReceiverInformation()" type="submit" name="Save" id="Save" value="Update"/>
    </form>
</div>
</body>
</html>