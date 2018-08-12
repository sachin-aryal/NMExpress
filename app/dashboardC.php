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
<?php include "Include/headerCustomer.php"?>  <br>
<h1 class="text-center" style="font-family: ‘Lucida Console’, Monaco, monospace;color: #3573a3;
">Welcome to Nepal Money Express (NME)</h1><br>

<div style="text-align: center">
    <a class="btn btn-success" href="processTransaction.php">Add Order</a>
</div><br>
<div class="currencyConverterBox">
    <form class="form-inline" action="Controller/changeExchangeRate.php" method="post">
        <h3 class="text-center">Today's Exchange Rate</h3>
        <div class="currencyConverterBoxBody">

            <div class="enter"></div><div class="enter"></div>
            <p><?php
                $todayRate = getExchangeRate($conn);
                ?>
                Australia <img src="Assets/Img/ausFlag.png"/>
                &nbsp;&nbsp;         <input type="text" name="audMoney" value="<?php echo "$".$todayRate["aus"] ?>" id="aus" readonly/>


            </p>
            <p class="text-center">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nepal <img src="Assets/Img/nepalFlag.png"/>
                &nbsp;&nbsp;           <input type="text" name="nepalMoney" value="<?php echo $todayRate["nrs"] ?>" id="nrs" readonly/>


            </p>

        </div>
    </form>

</div>
<br>
<?php include "Include/footer.php" ?>
</body>
</html>
