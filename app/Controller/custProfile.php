<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/20/2016
 * Time: 8:39 AM
 */
?>
<script>
    $(function(){

        var idType = "<?php echo $customerInfo["identity_type"];?>"

        $("#idType>option").map(function() {
            if($(this).html().indexOf(idType) != -1){

                $(this).attr('selected', 'selected');
            }
        });

        var type = "<?php echo $customerInfo["type"];?>";

        $("#type>option").map(function() {
            if($(this).html().indexOf(type) != -1){

                $(this).attr('selected', 'selected');
                hideCustomerTypeDetails($("#type").val());
            }
        });
        $(".fancybox").fancybox();

        var state = "<?php echo $customerInfo["state"];?>";

        $("#state>option").map(function() {
            if($(this).html().indexOf(state) != -1){

                $(this).attr('selected', 'selected');
            }
        });
        $(".fancybox").fancybox();
    });
</script>
<script>
    function onSelectCustomerType(select){

        hideCustomerTypeDetails(select.value);
    }

    function hideCustomerTypeDetails(value){

        if(value === "Individual"){

            hideBusinessDetails();
            displayIndividualDetails();
        }else if(value === "Business"){

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
<style type="text/css">
    /* Adjust feedback icon position */
    #agentsForms .form-control-feedback {
        right: 15px;
    }
    #agentsForms .selectContainer .form-control-feedback {
        right: 25px;
    }
</style>
<script type="text/javascript">
    $(function(){

        $('.sandbox-container').datepicker({
            format: "yyyy/mm/dd"
        });
    });
</script>


<form <?php if(!$disabled){?> action="Customer/saveProfile.php"<?php }?> method="post">
    <div class="form-group">
        <div class="row">
            <div class="col-xs-4">
                <label for="type">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="First Name" value="<?php echo $customerInfo["f_name"];?>" class="radius mini form-control"  <?php if($disabled){?> disabled<?php }?>/>
            </div>

            <div class="col-xs-4">
                <label for="type">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $customerInfo["l_name"];?>" class="radius mini form-control"  <?php if($disabled){?> disabled<?php }?>/>
            </div>

            <div class="col-xs-4">
                <label for="type">Phone Number</label>
                <input type="text" id="mobileNo" name="mobileNo" placeholder="Mobile Number" value="<?php echo $customerInfo["mobile_no"];?>" class="radius mini form-control"  <?php if($disabled){?> disabled<?php }?>/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-xs-4">
                <label class="control-label">Unit</label>
                <input type="text" name="unit" id="unit" class="form-control" value="<?php echo $customerInfo["unit"];?>" placeholder="Unit" <?php if($disabled){?> disabled<?php }?>/>
            </div>
            <div class="col-xs-4">
                <label class="control-label">Street</label>
                <input type="text" name="street" id="street" class="form-control" value="<?php echo $customerInfo["street"];?>" placeholder="Street"  <?php if($disabled){?> disabled<?php }?>/>
            </div>
            <div class="col-xs-4">
                <label class="control-label">State</label>
                <select name="state" id = "state" class="form-control"  <?php if($disabled){?> disabled<?php }?>>
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
            <div class="col-xs-4">
                <label for="type">I am a/an: </label>
                <select class="form-control" name="type" id="type" onchange="onSelectCustomerType(this);" <?php if($disabled){?> disabled<?php }?>>
                    <option>Select</option>
                    <option>Individual</option>
                    <option>Business</option>
                </select>
            </div>
            <div class="col-xs-4" id = "san">
                <label for="type">Date Of Birth</label>
                <input type="text" id = "dob" name="dob" class="form-control sandbox-container" placeholder="Date of Birth" value="<?php echo $customerInfo["dob"];?>"  <?php if($disabled){?> disabled<?php }?>/>
            </div>
            <div class="col-xs-4">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row" id = "individualDetailsDiv">
            <div class="col-xs-4">
                <label class="control-label">Identity Type</label>
                <select class="form-control" name="idType" id="idType" <?php if($disabled){?> disabled<?php }?>>
                    <option>Select</option>
                    <option>Student ID</option>
                    <option>Driving License</option>
                    <option>Citizenship No.</option>
                    <option>Australian Passport</option>
                    <option>Nepalese Passport</option>
                </select>
            </div>

            <div class="col-xs-4">
                <label class="control-label">Identity Number</label>
                <input type="text" class="form-control" name="idNo" id="idNo" placeholder="Identity Number" value="<?php echo $customerInfo["identity_no"];?>" <?php if($disabled){?> disabled<?php }?>><br>
            </div>

            <div class="col-xs-4">
                <label class="control-label">Expiry Date</label>
                <input type="text" class="form-control sandbox-container" name="expiryDate" id="expiryDate" placeholder="Expiry Date" value="<?php echo $customerInfo["expiry_date"];?>" <?php if($disabled){?> disabled<?php }?>/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row" id = "businessDetailsDiv">
            <div class="col-xs-4">
                <label class="control-label">Business Name</label>
                <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Business Name" value="<?php if(isset($customerInfo["business_name"])) echo $customerInfo["business_name"];?>" <?php if($disabled){?> disabled<?php }?>><br>
            </div>

            <div class="col-xs-4">
                <label class="control-label">Registration Number</label>
                <input type="text" class="form-control" name="registration_no" id="registrationNo" placeholder="Registration Number" value="<?php if(isset($customerInfo["registration_no"])) echo $customerInfo["registration_no"];?>" <?php if($disabled){?> disabled<?php }?>><br>
            </div>

            <div class="col-xs-4">
                <label class="control-label">Established Date</label>
                <input type="text" class="form-control sandbox-container" name="established_date" id="established_date" placeholder="Established Date" value="<?php if(isset($customerInfo["established_date"]))echo $customerInfo["established_date"];?>" <?php if($disabled){?> disabled<?php }?>/>
            </div>
        </div><br>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-xs-4">
                <a class="fancybox" rel="gallery1" href="<?php echo $customerInfo["id_front_url"]?>"><img src="<?php echo $customerInfo["id_front_url"]?>" height="100" width="100"/></a>
            </div>
            <div class="col-xs-4">
            </div>
            <div class="col-xs-4">

            </div>
        </div><br>
    </div>
    <input type="hidden" value="<?php echo $_GET["id"];?>" name="id">
    <?php if(!$disabled){?>
        <input type="submit" value="Save" class="btn-primary btn" onclick="return validateCustomerProfile();">
    <?php }?>
</form>
