<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 7:28 PM
 */
$bank_id = $receiverInfo["bank_id"];
?>
<script type="text/javascript">
    $(function(){
        $('#country').val("<?php echo $receiverInfo['country'] ?>");
        $('input[name=payment_type][value="<?php echo $receiverInfo['payment_type'] ?>"]').attr('checked', 'checked');
        $("input[name=payment_type]").change(function(){
            var paymentType = $("input[name=payment_type]:checked").val();
            if(paymentType=="Cash"){
                $("#bankAccountDetails").addClass("hide");
            }else{
                $("#bankAccountDetails").removeClass("hide");
            }
        });
        var paymentType = $("input[name=payment_type]:checked").val();
        if(paymentType=="Bank"){
            $("#bankAccountDetails").removeClass("hide");
        }else{
            $("#bankAccountDetails").addClass("hide");
        }
    });
</script>
<script>
    $(function(){

        var district = "<?php echo $receiverInfo['district']?>";

        $("#district>option").map(function() {
            if($(this).html().indexOf(district) != -1){

                $(this).attr('selected', 'selected');
            }
        });

        var zone = "<?php echo $receiverInfo['zone']?>";
        $("#zone>option").map(function() {
            if($(this).html().indexOf(zone) != -1){

                $(this).attr('selected', 'selected');
            }
        });
    });
</script>

<div id="collapseEditReceiver" class="collapse">
    <div class="panel-body">
        <form onsubmit="return editReceiver()" id="editReceiverForm" name="editReceiverForm">
            <div class="container">
                <div class="row overallRow">
                    <div class="col-md-4">
                        <h3 class="text-center">Contact Information</h3>
                        <hr>
                        <div class="form-group">
                            <div class="row no-pad">

                                <div class="col-xs-6">
                                    <label for="f_name">First Name</label>
                                    <input type="text" class="form-control" name="f_name" id="f_name" value="<?php echo $receiverInfo['f_name']?>"/>
                                </div>
                                <div class="col-xs-6">
                                    <label for="l_name">Last Name</label>
                                    <input type="text" name="l_name" class="form-control" id="l_name" value="<?php echo $receiverInfo['l_name']?>"/>
                                </div>


                            </div><br>
                            <div class="row no-pad">

                                <div class="col-xs-6">
                                </div>
                                <div class="col-xs-6">
                                    <label for="phone_no">Phone</label>
                                    <input type="text" class="form-control" name="phone_no" id="phone_no" value="<?php echo $receiverInfo['phone_no']?>"/>
                                </div>
                            </div><br>
                            <div class="row no-pad">


                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-center">  Address Information</h3>
                        <hr>


                        <div class="row no-pad">
                            <div class="col-xs-6">
                                <label for="city">City/Town</label>
                                <input type="text" class="form-control" name="city" id="city" value="<?php echo $receiverInfo['city']?>"/>
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
                                <label for="country">Country</label>
                                <select class="form-control" name="country" id="country">
                                    <option value="Nepal">Nepal</option>
                                    <option value="Australia">Australia</option>
                                </select>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label for="state">State</label>
                            <input type="text" name="state" id="state"/>
                        </div>-->
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
                                        <label for="account_number">Account Number</label>
                                        <input class="form-control" type="text" name="account_number" id="account_number"/>
                                    </div>

                                    <div class="col-md-5">
                                        <label for="account_name">Account Name</label>
                                        <input class="form-control" type="text" name="account_name" id="account_name"/>
                                    </div>
                                    <div class="col-md-1"></div>

                                </div>

                                <div class="row">
                                    <div class="col-md-1"></div>

                                    <div class="col-md-5">
                                        <label for="bank_name">Bank Name</label>
                                        <input class="form-control" type="text" name="bank_name" id="bank_name"/>
                                    </div>

                                    <div class="col-md-5">
                                        <label for="branch_name">Branch Name</label>
                                        <input class="form-control" type="text" name="branch_name" id="branch_name"/>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row no-pad">
                        <div class="col-md-1">
                            <input class="center-block btn btn-primary" type="submit" name="Update" id="Update" value="Update"/>
                        </div>
                        <div class="col-md-5">
                        </div>
                        <div class="col-md-6"></div>
                    </div><br>
                </div>

        </form>


    </div>

            </div>

            <!--<div class="form-group">
                <label for="email_address">Email Address</label>
                <input type="email" name="email_address" id="email_address" value="<?php /*echo $receiverInfo['email_address']*/?>"/>
            </div>-->

            <!--<div class="form-group">
                <label for="state">State</label>
                <input type="text" name="state" id="state" value="<?php /*echo $receiverInfo['state']*/?>"/>
            </div>-->



            <div class="form-group">

            </div>
            <div id="bankAccountDetails" class="hide">
                <div class="form-group">
                    <label for="account_number">Account Number</label>
                    <input type="text" name="account_number" id="account_number" value="<?php echo $bank_info['account_no']?>"/>
                </div>
                <div class="form-group">
                    <label for="account_name">Account Name</label>
                    <input type="text" name="account_name" id="account_name" value="<?php echo $bank_info['account_name']?>"/>
                </div>
                <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" name="bank_name" id="bank_name" value="<?php echo $bank_info['bank_name']?>"/>
                </div>
                <div class="form-group">
                    <label for="branch_name">Branch Name</label>
                    <input type="text" name="branch_name" id="branch_name" value="<?php echo $bank_info['branch_name']?>"/>
                </div>
            </div>
            <input type="hidden" name="bank_id" value="<?php echo $receiverInfo['bank_id']?>"/>
            <input type="hidden" name="receiver_id" value="<?php echo $receiverInfo['id']?>"/>
            <div class="form-group">
            </div>
        </form>
    </div>
</div>
