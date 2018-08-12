<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/3/2016
 * Time: 11:52 PM
 */
require "Common/DbConnection.php";
require "Common/CommonFunction.php";
$customerInfo = getCustomerInfo($conn);
if($customerInfo["is_subscriber"]==1){
    $subscribeInfo = true;
}else{
    $subscribeInfo = false;
}
?>

<script src="Assets/Js/jquery-1.11.1.min.js"></script>
<script src="Assets/Js/bootstrap.js"></script>
<script src="Assets/Js/custom.js"></script>
<link href="Assets/Css/bootstrap.min.css" rel="stylesheet"/>

<form onsubmit="return editProfile();" id="editProfileForm">

    <input name="firstName" placeholder="First Name" type="text" value="<?php echo $customerInfo['f_name']?>"/>
    <input name="lastName" placeholder="Last Name" type="text" value="<?php echo $customerInfo['l_name']?>"/>
    <input name="mobileNo" placeholder="Mobile Number" type="text" value="<?php echo $customerInfo['mobile_no']?>"><br>

    <input name="email" type="text" placeholder="Email" value="<?php echo $customerInfo['email']?>">
    <?php
    if($subscribeInfo){
        ?>
        <input type="checkbox" name="notifyRates" id="notify" checked/>Notify me about rates daily</br>
    <?php
    }else{
    ?>
    <input type="checkbox" name="notifyRates" id="notify"/>Notify me about rates daily</br>
    <?php
    }
    ?>
    <input type="submit" value="Update">
</form>
