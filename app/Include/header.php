<?php
/**
 * Created by PhpStorm.
 * User: sumitshrestha
 * Date: 5/14/2016
 * Time: 5:25 PM
 */

require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
checkSession();
$oldServiceCharge = getServiceCharge($conn);
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><img src="Assets/Img/smallLogo.png"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php if($_SESSION["role"] == "ROLE_ADMIN") {?>
                    
<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Customer <?php if(getUnactiveCustomer($conn)>0){echo "<span class=' badge badge-pink'>" . getUnactiveCustomer($conn) . "</span>";}?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="customers.php">Customers</a></li>
                            <li><a href="new_customers.php">New Customers <?php if(getUnactiveCustomer($conn)>0){echo "<span class=' badge badge-pink'>" . getUnactiveCustomer($conn) . "</span>";}?></a></li>
                        </ul>
                    </li>

                    <li><a href="agentList.php">Agents</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="subscriberList.php">Subscribers</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="PLReport.php">Profit Loss Report</a></li>
                            <li><a href="transactionReport.php">Transaction Report</a></li>
                            <li><a href="serviceChargeReport.php">Service Charge Report</a></li>
                            <li><a href="collectionReport.php">Collection Report</a></li>
                            <li><a href="reportGenerator/reportGenerator.php?reportType=austracReport">Download Austrac Report</a></li>
							<li><a href="austracreport.php">Austrac Report</a></li>
                        </ul>
                    </li>
                    <li><a href="#" data-toggle="modal" data-target="#changeServiceCharge">Change Service Charge</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#changeAdmin">Change Admin</a></li>
                <?php } ?>

                <?php if($_SESSION["role"] == "ROLE_NEPAGENT") {?>
                    <li><a href="deliveredOrders.php">Delivered Orders</a></li>
                <?php } ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if($_SESSION["role"] == "ROLE_AUSAGENT" || $_SESSION["role"] == "ROLE_ADMIN"){?>
                    <li><a href="sendMoneyAusAd.php">Add Order</a></li>
                <?php }?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION["username"] ?> <span class="caret"></span></a>
<ul class="dropdown-menu">
    <li><a href="#" data-toggle="modal" data-target="#changePasswordModal">Change Password</a></li>
    <li><a href="Controller/logout.php">Logout</a></li>
</ul>
</li>
</ul>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
<?php include_once 'changePassword.php'?>
<?php if($_SESSION["role"] == "ROLE_ADMIN") {?>
<div id="changeServiceCharge" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="Controller/changeServiceCharge.php" method="post">
            <div class="modal-header">
                <button type="button" id = "changeServiceChargeClose" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Change Service Charge</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-8">
                    <label for="newPassword">New Service Charge</label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" name="serviceCharge" value="<?php echo $oldServiceCharge; ?>" id="newServiceCharge" class="form-control"/>
                    </div>
                </div>
            </div>
            <br><br><br>
            <div class="modal-footer">
                <input type="submit" value="Change"  class="btn btn-primary"/>
            </div>
            </form>
        </div>
    </div>
</div>
<div id="changeAdmin" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form method="post" onsubmit="return changeAdmin();">
                <div class="modal-header">
                    <button type="button" id = "changeAdminClose" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Change Admin</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" value="<?php echo $_SESSION["username"]; ?>" id="oldUsername"/>
                        <div class="col-xs-6">
                            <label for="newAdminUsername">New Username</label>
                            <input type="text" name="username" value="<?php echo $_SESSION["username"]; ?>" id="newAdminUsername" class="form-control"/><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <label for="newAdminPassword">New Password</label>
                            <input type="password" name="password" id="newAdminPassword" class="form-control"/><br>
                        </div>
                        <div class="col-xs-6">
                            <label for="newPassword">Repeat Password</label>
                            <input type="password" id="repeatAdminPassword" class="form-control"/><br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Change" class="btn btn-primary"/>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>