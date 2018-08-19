<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 4/30/2016
 * Time: 5:09 PM
 */
require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
checkSession();
adminValidator();
?>
<html>
<head>
    <title>
        NME
    </title>

    <?php include_once "Include/BootstrapCss.html" ?>
    <script>
        $(function(){
            $(".active-order-nav").click();
        });

        function onlyAmount(e, t) {
            try {
                if (window.event) {
                    var intCode = window.event.keyCode;
                }
                else if (e) {
                    var intCode = e.which;
                }
                else { return true; }
                if (((intCode >=48   && intCode <= 57) || intCode == 46)){
                    return true;
                }

                else{
                    notify('error', 'Invalid Amount')
                    $("#pages").val('');
                    return false;
                }

            }
            catch (err) {
                alert(err.Description);
            }
        }

    </script>
    <script type="text/javascript" language="javascript" src="Assets/Js/validation.js"></script>
    <style>
        .container{

            width: 1321px
        }
        #dTab1 tr{
            height: 35px;
        }
    </style>
</head>
<body>
<?php include_once "Include/header.php"; ?>
<?php

if (!empty($_GET["failedMessage"])) {
    $message = $_GET["failedMessage"];
    echo '<p style="color:red">' . $message . '</p>';
}
if (!empty($_GET["successMessage"])) {
    $message = $_GET["successMessage"];
    echo '<p style="color:green">' . $message . '</p>';
}
$todayRate = getExchangeRate($conn);
$buyerRate = getBuyerRate($conn);

$agents = getAllAgents($conn);
$nepaleseAgents = getAllNepaliAgents($conn);


if(isset($_SESSION["sendRateChangeEmail"])){
    echo '<script type="text/javascript">
                        $(function(){
                        console.log("Sending Ajax Request.")
                            $.ajax({
                                type:"POST",
                                url:"Controller/notifySubscribers.php",
                                data:{nrs:' . $todayRate["nrs"] . '},
                                success:function(data){
                                    
                                },error:function(err){

                                }
                            });
                        });
            </script>';
    $_SESSION["sendRateChangeEmail"] = null;
}

?>
<!--<span style="z-index: 5;position: absolute;top:367px;left:132px;color:#ffffff" class="glyphicon glyphicon-download-alt"></span>-->

<div class="container">
    <div class="row">
        <div class="col-xs-2">
        </div>
        <div class="currencyConverterBoxAdmin col-xs-3">
            <h3 class="media-heading text-center">Selling Rate</h3>
            <form class="form-inline" action="Controller/changeExchangeRate.php" method="post">

                <div class="currencyConverterBoxBody">

                    <div class="enter"></div><div class="enter"></div>
                    <p>
                        Australia <img src="Assets/Img/ausFlag.png"/>
                        &nbsp;&nbsp;        <input type="text" name="audMoney" value="<?php echo $todayRate["aus"];?>" id="aus" readonly/>

                    </p>
                    <p class="text-center">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nepal <img src="Assets/Img/nepalFlag.png"/>
                        &nbsp;&nbsp;        <input type="text" name="nepalMoney" value="<?php echo $todayRate["nrs"] ?>" id="nrs"/>

                    </p>
                    <p>

                        <button type="submit" onclick = "return validateDashboardAd()" class="btn btn-primary">Save</button>

                    </p>
                </div>
            </form>

        </div>
        <div class="col-xs-1">
        </div>
        <div class="col-xs-1">
        </div>
        <div class="currencyConverterBoxAdmin col-xs-3">
            <h3 class="media-heading text-center">Buyer Rate</h3>
            <form class="form-inline" action="Controller/changeBuyerRate.php" method="post">

                <div class="currencyConverterBoxBody">

                    <div class="enter"></div><div class="enter"></div>
                    <p>
                        Australia <img src="Assets/Img/ausFlag.png"/>
                        &nbsp;&nbsp;        <input type="text" name="audMoney" value="<?php echo $buyerRate["aus"];?>" id="aus" readonly/>

                    </p>
                    <p class="text-center">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nepal <img src="Assets/Img/nepalFlag.png"/>
                        &nbsp;&nbsp;        <input type="text" name="nepalMoney" value="<?php echo $buyerRate["nrs"] ?>" id="nrs"/>

                    </p>
                    <p>

                        <button type="submit" onclick = "return validateDashboardAd()" class="btn btn-primary">Save</button>

                    </p>
                </div>
            </form>
        </div>
        <div class="col-xs-2">
        </div>
    </div>
    <div class="row">
        <div class="col-md-8" id="orders-div">
            <div class="col-md-12" id="orders">
                <h3>Orders in Nepal Money Express</h3>
                <ul id="order-nav">
                    <li class="active-order-nav" onclick="fetchOrder(this, 'Recent')">Recent Orders</li>
                    <li onclick="fetchOrder(this, 'Pending')">Pending Orders</li>
                    <li onclick="fetchOrder(this, 'Processing')">Processing Orders</li>
                    <li onclick="fetchOrder(this, 'Completed')">Completed Orders</li>
                </ul>
            </div>
            <div class="col-md-12" id="orders-display">

            </div>
        </div>
    </div>
</div>
</body>
</html>
