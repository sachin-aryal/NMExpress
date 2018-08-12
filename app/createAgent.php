<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/1/16
 * Time: 3:49 PM
 */
include_once "Common/CommonFunction.php";
adminValidator();
?>

<?php include "Include/BootstrapCss.html" ?>

<?php include "Include/header.php" ?>

<body>
<style type="text/css">
    /* Adjust feedback icon position */
    #agentsForms .form-control-feedback {
        right: 15px;
    }
    #agentsForms .selectContainer .form-control-feedback {
        right: 25px;
    }
</style>
<div class="selfContainer">
<h3 class="text-center">Create Agent</h3>
<form id="agentsForms" action="Controller/saveAgent.php" method="post">
    <div class="form-group">
        <div class="row">
            <div class="col-xs-4">
                <label class="control-label">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="First Name" class="form-control">
            </div>

            <div class="col-xs-4">
                <label class="control-label">Last Name</label>
                <input name="lastName" id="lastName" class="form-control" placeholder="Last Name" type="text"/>
            </div>

            <div class="col-xs-4">
                <label class="control-label">Phone</label>
                <input name="phone" id="phone" class="form-control" placeholder="Phone" type="text">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-xs-4">
                <label class="control-label">Address</label>
                <input name="address" id="address" class="form-control" type="text" placeholder="Address">
            </div>
            <div class="col-xs-4">
                <label class="control-label">Email</label>
                <input name="email" id="email" class="form-control" type="text" placeholder="Email"><br>
            </div>
            <div class="col-xs-4 selectContainer">
                <label class="control-label">Agent Type</label>

                <select name="agentType" id="agentType" class="form-control">
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
                <input name="companyName" id="companyName" class="form-control" type="text" placeholder="Company Name">
            </div>

            <div class="col-xs-4">
                <label class="control-label">Company Phone</label>
                <input name="companyPhone" id="companyPhone" class="form-control" type="text" placeholder="Company Phone">
            </div>

            <div class="col-xs-4">
                <label class="control-label">Company Address</label>
                <input name="companyAddress" id="companyAddress" class="form-control" type="text" placeholder="Company Address"><br>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-xs-4 selectContainer">
                <label class="control-label">Identity Type</label>

                <select name="idType" id="idType" class="form-control" id="idType">
                    <option selected="selected" disabled>Select</option>
                    <option>Student ID</option>
                    <option>Driving License</option>
                    <option>Citizenship No.</option>
                </select>
            </div>

            <div class="col-xs-4">
                <label class="control-label">Identity Number</label>
                <input type="text" name="idNo" id="idNo" class="form-control" placeholder="Identity Number"><br>
            </div>

        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-xs-4 selectContainer">
                <label class="control-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
            </div>

            <div class="col-xs-4">
                <label class="control-label">Repeat Password</label>
                <input type="password" id ="repassword" class="form-control" placeholder="Repeat Password"/><br>
            </div>

        </div>
    </div>
    <button type="submit" onclick="return validateCreateAgent()" class="btn btn-primary">Submit</button>
</form>


</div>
</body>