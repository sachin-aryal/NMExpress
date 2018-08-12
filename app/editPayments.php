<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/14/16
 * Time: 3:11 PM
 */
require_once "Common/CommonFunction.php";
require_once "Common/DbConnection.php";
checkSession();
$disabled = false;
$pID = addslashes($_GET["pID"]);
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
$payment_details = getpaymentByid($conn,$pID);
?>

<html>
    <head>
        <title>
            NME
        </title>
        <?php include_once 'Include/BootstrapCss.html' ?>
        <script src="Assets/Js/jquery.fancybox.js"></script>
        <link href="Assets/Css/jquery.fancybox.css" rel="stylesheet"/>
        
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
    <h3> Edit Payment details</h3>
    <form <?php if(!$disabled){?> action="Controller/editPaymentforID.php"<?php }?> method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-3">
                            <label for="type">Payment Id</label>
                            <input type="text" id="id" name="firstName" placeholder="id" value="<?php echo $payment_details["id"];?>" class="radius mini form-control" disabled/>
                        </div>

                        <div class="col-xs-3">
                            <label for="type">Payment Date</label>
                            <input type="text" id="date" name="date" placeholder="date" value="<?php echo $payment_details["payment_date"];?>" class="radius mini form-control" disabled/>
                        </div>

                        <div class="col-xs-3">
                            <label for="type">Pin No:</label>
                            <input type="text" id="pinno" name="pinno" placeholder="pinno" value="<?php echo $payment_details["pin_no"];?>" class="radius mini form-control" disabled/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                    <div class="col-xs-4">
                            <label class="control-label">Amount</label>
                            <input type="text" name="amount" id = "amount" placeholder="Amount" class="form-control" onkeypress="return onlyAmount(event, this)" value="<?php echo $payment_details["amount"];?>"/>
                        </div>
                        <div class="col-xs-4">
                            <label class="control-label">Rate</label>
                            <input type="text" name="rate" id="rate" class="form-control" placeholder="Reason" value="<?php echo $payment_details["rate"];?>"/>
                        </div>
                        <div class="col-xs-4">
                        <label class="control-label">Fee</label>
                            10$ <input type="radio" name="fee" id="fee" value="10" checked />
                            5$ <input type="radio" name="fee" id="fee" value="5"/>
                            Free <input type="radio" name="fee" id="fee" value="0" />
                            <input name="rate" id = "rate" placeholder="Rate" class="form-control" disabled value="<?php echo $payment_details["fee"];?>"/>
                        </div>
                    </div>
                </div>

                               
                
                <input type="hidden" value="<?php echo $_GET["pID"];?>" name="pID">
                <input type="submit" value="Save" class="btn-primary btn" onclick="return validateCustomerProfile();>
        </form>

    </div>
    <?php include "Include/footer.php" ?>
    </body>
</html>
