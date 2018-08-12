<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 2:35 PM
 */
include_once 'Common/CommonFunction.php';
include_once 'Common/DbConnection.php';
checkSession();
?>
<html>
<head>
    <title>NME</title>
    <?php include "Include/BootstrapCss.html" ?>
</head>
<body>
<?php
if($_SESSION["role"]=="ROLE_CUSTOMER"){
    include_once "Include/headerCustomer.php";
}else
    include_once "Include/header.php";
?>
<div class="container">
    <fieldset>
        <?php
        if($_POST["pin_no"]){
        $success = $_POST["result"];
        if($success) {?>

        <div class="alert alert-success">
            <strong>Your order has been placed.</strong><br>
            The pin code for the order is <b><?php echo $_POST["pin_no"] ?></b>
        </div>
<?php
                if($_SESSION["role"] == "ROLE_CUSTOMER") { ?>
                    <div class="alert alert-info">
                        Thank you for working via us. We will inform you once the money has been delivered.
                    </div>
                <?php }
            }else{?>
            <div class="alert alert-info">
               <h3>Error while making transaction.</h3>
            </div>
           <?php }
        }
        ?>
    </fieldset>
</div>
<?php include "Include/footer.php" ?>
</body>
</html>