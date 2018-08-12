<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/12/16
 * Time: 1:38 PM
 */

require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";

$firstName = addslashes($_POST["firstName"]);
$lastName = addslashes($_POST["lastName"]);
$email = addslashes($_POST["email"]);
$mobileNo = addslashes($_POST["mobileNo"]);
$password = addslashes($_POST["password"]);

$stmt = $conn->query("SELECT id FROM user_sas WHERE username = '$email'");
if ($stmt->num_rows != 0) {

    redirect('index.php?msgError=User with supplied email already exists. Please login.');
    return;
}

if(isset($_POST["registration_session_id"])) {
   $success = true;
}

if(!$success){

    redirect('index.php?msgError=' . "Could not register. Please try again later.");
    return;
}

?>
<?php include "Include/BootstrapCss.html" ?>
<br><br><br>
<script>
    $(function(){

        $("#san").hide();
        hideBusinessDetails();
        hideIndividualDetails();

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
    .notice{

        color: red;
    }
</style>
<div class="selfContainer">
<form action="Controller/registerCustomer.php" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <div class="row">
            <div class="col-xs-3">
                <label class="control-label">First Name<span class="notice">*</span></label>
                <input name="firstName" id="firstName" value="<?php echo $firstName; ?>" class="form-control" placeholder="First Name" type="text"/>
            </div>

            <div class="col-xs-3">
                <label class="control-label">Middle Name</label>
                <input name="middleName" id = "middleName" class="form-control" placeholder="Middle Name" type="text"/>
            </div>

            <div class="col-xs-3">
                <label class="control-label">Last Name<span class="notice">*</span></label>
                <input name="lastName" id="lastName" value="<?php echo $lastName; ?>" placeholder="Last Name" class="form-control" type="text"/>
            </div>

            <div class="col-xs-3">
                <label class="control-label" for="mobileNo">Mobile Number<span class="notice">*</span></label>
                <div class = "input-group">
                	<div class="input-group-addon">+61</div>
	                <input name="mobileNo" id="mobileNo" class="form-control"  value="<?php echo $mobileNo; ?>" placeholder="Mobile Number" type="text"><br>
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
                <input name="city" id = "city" placeholder="Suburb" class="form-control"/>
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
            <div class="col-xs-4" id = "san">
                <label class="control-label">Date of Birth<span class="notice">*</span></label>
                <div class="input-group date">
                  <input type="text" class="form-control autoDate" name="dob" id="dob" placeholder="dd-mm-yyyy" readonly><span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                </div>
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
                    <option>Photo ID</option>
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
                <div class="input-group date">
                  <input type="text" class="form-control autoDate"name="expiryDate" id="expiryDate" placeholder="dd-mm-yyyy" readonly><span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                </div>
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
                
                <div class="input-group date">
                  <input type="text" class="form-control autoDate" name="established_date" id="established_date" placeholder="dd-mm-yyyy" readonly ><span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </div>
    <input name="email" id="email" type="hidden"  value = "<?php echo $email?>" placeholder="Email">
    <div class="form-group">
        <div class="row">
            <div class="col-xs-4">
                <label class="control-label">Attach Id<span class="notice">*</span></label>
                <input type="file" name="idFront" id="idFront" class="form-control"/>
            </div>
            <div class="col-xs-4">
            
            <script type="text/javascript">
                $('.input-group.date').datepicker({
                format: "dd-mm-yyyy",
                weekStart: 1
            });
            </script>
            </div>
            <div class="col-xs-4">
            </div>
        </div>
    </div>
    <br>
    <div class="col-xs-4">
        <button type="submit" onclick="return validateVerifyCustomerField()" class="btn btn-primary btn-md" >Verify</button>
    </div><br><br><br>
    <input type ="hidden" name="password" value="<?php echo $password?>"/>
</form>
</div>
<?php
/*$hash = md5( rand(0,1000) );
$msg = "
Thanks for signing up!
Your account has been created, you can login after you have activated your account by pressing the url below:"
 
echo "http://nepalexpress.com.au/verifyEmail.php?email='.$email.'&hash='.$hash.";*/

?>