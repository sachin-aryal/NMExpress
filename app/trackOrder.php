<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/19/16
 * Time: 1:39 AM
 */
?>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 4/30/2016
 * Time: 5:09 PM
 */
require "Common/CommonFunction.php";
require "Common/DbConnection.php";
checkSession();
customerValidator();
?>
<html>
<head>
    <title>NME</title>
    <?php include "Include/BootstrapCss.html"?>
</head>
<body>
<?php include "Include/headerCustomer.php"?>
<div id="trackRecord" style="width: 20%;margin: 0 auto;">
    <fieldset>
        <legend>Track Order:</legend>
        <label for="pin_no">Pin No:</label>
        <input type="text" name="pin_no" id="pin_no" class="form-control"/><br>
        <button class="btn btn-primary" onclick="fetchTrackOrder()">Submit</button>
    </fieldset>

</div>
<div id="trackRecordResult" style="width: 90%;margin: 0 auto"></div>
<?php include "Include/footer.php" ?>
</body>
</html>
