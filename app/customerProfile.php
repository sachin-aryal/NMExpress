<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/14/16
 * Time: 3:11 PM
 */
require_once "Common/CommonFunction.php";
require_once "Common/DbConnection.php";
checkReturnUrl($_SERVER['REQUEST_URI']);
checkSession();
$disabled = false;
$customerId = addslashes($_GET["id"]);
if($_SESSION["role"] == "ROLE_CUSTOMER") {
    if (getCustomerId($conn) != $_GET["id"])
        goToDashBoard("");
    else {
        $disabled = true;
        $customerId = getCustomerId($conn);
    }
}else if($_SESSION["role"] != "ROLE_ADMIN"){

    goToDashBoard("../");
}
$customerInfo = getCustomerInfoFromId($customerId, $conn);
$CustomerStatus = checkCustomerStatus($conn, $customerInfo["user_id"]);
?>

<html>
    <head>
        <title>
            NME
        </title>
        <?php include_once 'Include/BootstrapCss.html' ?>
        <script src="Assets/Js/jquery.fancybox.js"></script>
        <link href="Assets/Css/jquery.fancybox.css" rel="stylesheet"/>
        <script>
            $(function(){

                var idType = "<?php echo $customerInfo["identity_type"];?>"

                var idTypeOptions = document.getElementById("idType").childNodes;

                for(var i = 1; i < idTypeOptions.length; i+=2){

                    if(idTypeOptions[i].value == idType)
                        idTypeOptions[i].setAttribute('selected', 'selected');
                }

                var type = "<?php echo $customerInfo["type"];?>";

                var typeOptions = document.getElementById("type").childNodes;

                for(var i = 1; i < typeOptions.length; i+=2){

                    if(typeOptions[i].value == type){
                        typeOptions[i].setAttribute('selected', 'selected');
                        hideCustomerTypeDetails($("#type").val());
                    }
                }

                $(".fancybox").fancybox();

                var state = "<?php echo $customerInfo["state"];?>";

                var stateOptions = document.getElementById("state").childNodes;

                for(var i = 1; i < stateOptions.length; i+=2){

                    if(stateOptions[i].value == state){
                        stateOptions[i].setAttribute('selected', 'selected');
                    }
                }

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
    </head>
    <body>
    <?php
    include_once 'Common/notification.php';
    if($_SESSION["role"] == "ROLE_CUSTOMER")
        include_once 'Include/headerCustomer.php';
    else
        include_once 'Include/header.php';
    ?>
    <div class="selfContainer">
        <!--<h3 class="text-center">
            <?php
/*                if($disabled){
                    echo "My ";
                }else{
                    echo "Customer ";
                }
            */?> Profile
        </h3>-->
        <!--<h5 class="text-center">Reward Point : <?php /*echo $customerInfo["reward_point"]*/?></h5>-->

        <table id="dTab" class="table table-bordered" cellspacing="0" width="80%" style="display:none;">
        <thead>
        <tr>
            <th></th>
            <th>Customer Details for ID</th>
           
        </tr>
        </thead>
        <tbody>
        
            <tr>
                <td><b>Name</b></td>
                <td><?php echo $customerInfo["f_name"] ." " .$customerInfo["l_name"];?></td>
            </tr>
            <tr>
                <td><b>Mobile No.</b></td>
                <td><?php echo $customerInfo["mobile_no"]; ?></td>
            </tr>
            <tr>
                <td><b>Address</b></td>
                <td><?php echo $customerInfo["unit"] . "/".$customerInfo["street_no"] . "," . $customerInfo["street"]; ?></td>
            </tr>
            <tr>
                <td><b>Identity Type</b></td>
                <td><?php echo $customerInfo["identity_type"] ; ?></td>
            </tr>
            <tr>
                <td><b>Identity No.</b></td>
                <td><?php echo $customerInfo["identity_no"] ; ?></td>
            </tr>
            <tr>
                <td><b>ID</b></td>
                <td><img src="<?php echo $customerInfo["id_front_url"]?>" height="200" width="300"/></td>
            </tr>
            
           
        </tbody>
    </table>
    <br>
        <form <?php if(!$disabled){?> action="Customer/saveProfile.php"<?php }?> method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-3">
                            <label for="type">First Name</label>
                            <input type="text" id="firstName" name="firstName" placeholder="First Name" value="<?php echo $customerInfo["f_name"];?>" class="radius mini form-control"  <?php if($disabled){?> disabled<?php }?>/>
                            <input type="hidden" id="email" name="email" placeholder="email" value="<?php echo $customerInfo["email"];?>" class="radius mini form-control"/>
                        </div>

                        <div class="col-xs-3">
                            <label for="type">Middle Name</label>
                            <input type="text" id="middleName" name="middleName" placeholder="Middle Name" value="<?php echo $customerInfo["middle_name"];?>" class="radius mini form-control"  <?php if($disabled){?> disabled<?php }?>/>
                        </div>

                        <div class="col-xs-3">
                            <label for="type">Last Name</label>
                            <input type="text" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $customerInfo["l_name"];?>" class="radius mini form-control"  <?php if($disabled){?> disabled<?php }?>/>
                        </div>

                        <div class="col-xs-3">
                            <label for="type">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-addon">+61 </span>
                                <input type="text" id="mobileNo" name="mobileNo" placeholder="Mobile Number" value="<?php echo $customerInfo["mobile_no"];?>" class="radius mini form-control"  <?php if($disabled){?> disabled<?php }?>/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-2">
                            <label class="control-label">Unit</label>
                            <input type="text" name="unit" id="unit" class="form-control" value="<?php echo $customerInfo["unit"];?>" placeholder="Unit" <?php if($disabled){?> disabled<?php }?>/>
                        </div>
                        <div class="col-xs-2">
                            <label class="control-label">Street No.</label>
                            <input type="text" name="streetNo" id="streetNo" class="form-control" value="<?php echo $customerInfo["street_no"];?>" placeholder="Street No." <?php if($disabled){?> disabled<?php }?>/>
                        </div>
                        <div class="col-xs-4">
                            <label class="control-label">Street Name</label>
                            <input type="text" name="street" id="street" class="form-control" value="<?php echo $customerInfo["street"];?>" placeholder="Street Name"  <?php if($disabled){?> disabled<?php }?>/>
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
                        <div class="col-xs-6">
                            <label class="control-label">Post Code</label>
                            <input type="text" name="postCode" id="postCode" class="form-control" placeholder="Post Code" <?php if($disabled){?> disabled<?php }?> value="<?php echo $customerInfo["post_code"];?>"/>
                        </div>
                        <div class="col-xs-6">
                            <label class="control-label">Suburb</label>
                            <input name="city" id = "city" placeholder="Suburb" class="form-control" <?php if($disabled){?> disabled<?php }?> value="<?php echo $customerInfo["city"];?>"/>
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
                            <input type="text" id = "dob" name="dob" class="form-control autoDate" placeholder="dd-mm-yyyy" value="<?php if(isset($customerInfo["dob"]))echo date_format(new DateTime($customerInfo["dob"]),'d-m-Y');?>"  <?php if($disabled){?> disabled<?php }?>/>
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
                                <option>Photo ID</option>
                                <option>Driving License</option>
                                <option>Photo Id No.</option>
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
                            <input type="text" class="form-control autoDate" name="expiryDate" id="expiryDate" placeholder="dd-mm-yyyy" value="<?php if(isset($customerInfo["expiry_date"]))echo date_format(new DateTime($customerInfo["expiry_date"]),'d-m-Y');?>" <?php if($disabled){?> disabled<?php }?>/>
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
                            <input type="text" class="form-control autoDate" name="established_date" id="established_date" placeholder="dd-mm-yyyy" value="<?php if(isset($customerInfo["established_date"])) echo date_format(new DateTime($customerInfo["established_date"]),'d-m-Y');?>" <?php if($disabled){?> disabled<?php }?>/>
                        </div>
                    </div>
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
                <input type="submit" value="Save" attrib class="btn-primary btn" onclick="return validateCustomerProfile();">
            <?php }?>
			 <a class="btn btn-danger" target="_blank" style="cursor: pointer" onclick="deleteCustomer('<?php echo $customerId;?>')">Delete</a>
        </form>
            
            <?php if ($CustomerStatus==0){?>
                <form method="post" onsubmit="activateCustomer();">
                <input type="submit" value="Activate" id="activate_button" class="btn btn-info" user_id="<?php echo $customerInfo["user_id"]; ?>" />
            </form><?php }else{?>

            <form method="post" onsubmit="deactivateCustomer();">
                <input type="submit" value="Deactivate" id="deactivate_button" class="btn btn-warning" user_id="<?php echo $customerInfo["user_id"]; ?>" />
            </form><?php }?>

        </div><br><br>
    <?php include "Include/footer.php" ?>
    
    
    <script type="text/javascript">
        $(document).ready(function(){
            var id="<?php echo $customerInfo['id_front_url']; ?>";
            var img_path = "<img src= 'nepalexpress.com.au/app/" + id+"'/>";
			
            $("#dTab").DataTable({
                dom: 'Blfrtip',
                "bPaginate": false,
                "bInfo": false,
                "aaSorting": [[ 1, "desc" ]],
                searching: false,
                buttons: [
                    {
                        extend: 'print',
                        customize: function ( win ) {
                        $(win.document.body)
                            .css( 'margin-top', '400px','position','absolute')
                            .prepend(img_path);
                        }
                    }
                ]
            });
        });
    </script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    </body>
</html>