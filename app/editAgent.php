<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/1/16
 * Time: 3:49 PM
 */
include_once 'Common/AdminDbConnection.php';
include_once 'Common/CommonFunction.php';
checkSession();
adminValidator();
include "Include/BootstrapCss.html";
include "Include/header.php";
include "Common/notification.php";

$agent_info = getAgentInfo($conn, addslashes($_GET["id"]));
?>
<body  style = "background-image: url('Assets/Img/wallpaper.jpg');">
<style type="text/css">
    /* Adjust feedback icon position */
    #agentsForms .form-control-feedback {
        right: 15px;
    }
    #agentsForms .selectContainer .form-control-feedback {
        right: 25px;
    }
</style>
<script>
    $(function(){

        var idType = "<?php echo $agent_info["identity_type"];?>"

        $("#idType>option").map(function() {
            if($(this).html().indexOf(idType) != -1){

                $(this).attr('selected', 'selected');
            }
        });

        var type = "<?php echo $agent_info["agent_type"];?>"

        $("#type>option").map(function() {
            if($(this).html().indexOf(type) != -1){

                $(this).attr('selected', 'selected');
            }
        });
        $(".fancybox").fancybox();
    });
</script>
<div class="selfContainer">
    <h3 class="text-center">Edit Agent</h3>
    <form id="agentsForms" action="Controller/saveEditedAgent.php" method="post">
        <input type="hidden" name="id" value="<?php echo $agent_info["id"];?>">
        <div class="form-group">
            <div class="row">
                <div class="col-xs-4">
                    <label class="control-label">First Name</label>
                    <input type="text" name="firstName" placeholder="First Name" class="form-control" value="<?php echo $agent_info["f_name"];?>">
                </div>

                <div class="col-xs-4">
                    <label class="control-label">Last Number</label>
                    <input name="lastName" class="form-control" placeholder="Last Name" type="text" value="<?php echo $agent_info["l_name"]?>"/>
                </div>

                <div class="col-xs-4">
                    <label class="control-label">Phone</label>
                    <input name="phone" class="form-control" placeholder="Phone" type="text" value="<?php echo $agent_info["phone"]?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-xs-4">
                    <label class="control-label">Address</label>
                    <input name="address" class="form-control" type="text" placeholder="Address" value="<?php echo $agent_info["address"]?>">
                </div>
                <div class="col-xs-4">
                    <label class="control-label">Email</label>
                    <input name="email" class="form-control" type="text" placeholder="Email" value="<?php echo $agent_info["email"]?>"><br>
                </div>
                <div class="col-xs-4 selectContainer">
                    <label class="control-label">Agent Type</label>

                    <select name="agentType" class="form-control" id = "type">
                        <option selected="selected" disabled>Select</option>
                        <option>Australian</option>
                        <option>Nepalese</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-xs-4">
                    <label class="control-label">Company Name</label>
                    <input name="companyName" class="form-control" type="text" placeholder="Company Name" value="<?php echo $agent_info["company_name"]?>">
                </div>

                <div class="col-xs-4">
                    <label class="control-label">Company Phone</label>
                    <input name="companyPhone" class="form-control" type="text" placeholder="Company Phone" value="<?php echo $agent_info["company_phone"]?>">
                </div>

                <div class="col-xs-4">
                    <label class="control-label">Company Address</label>
                    <input name="companyAddress" class="form-control" type="text" placeholder="Company Address" value="<?php echo $agent_info["company_address"]?>"><br>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-xs-4 selectContainer">
                    <label class="control-label">Identity Type</label>

                    <select name="idType" class="form-control" id="idType">
                        <option selected="selected" disabled>Select</option>
                        <option>Student ID</option>
                        <option>Driving License</option>
                        <option>Citizenship No.</option>
                    </select>
                </div>

                <div class="col-xs-4">
                    <label class="control-label">Identity Number</label>
                    <input type="text" name="idNo" class="form-control" placeholder="Identity Number" value="<?php echo $agent_info["identity_no"]?>"><br>
                </div>

            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>


</div><br><br><br>
</body>