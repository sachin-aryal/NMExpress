<?php
/**
 * Created by PhpStorm.
 * User: sumitshrestha
 * Date: 5/15/2016
 * Time: 8:36 PM
 */

require_once "Common/DbConnection.php";
require_once "Common/CommonFunction.php";
checkSession();
customerValidator();
?>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


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
                <li><a href="processTransaction.php">Add Order</a></li>
                <li>  <a href="myReceivers.php">My Receivers</a></li>
                <?php if($_SESSION["role"] == "ROLE_CUSTOMER") {?>
                    <li><a href="transactionHistory.php">Transaction History</a></li>
                <?php } ?>
                <li><a href="trackOrder.php">Track Order</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION["username"] ?> <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li>
                <a href="customerProfile.php?id=<?php echo getCustomerId($conn);?>">My Profile</a>
            </li>
            <li><a href="#" data-toggle="modal" data-target="#changePasswordModal">Change Password</a></li>
            <li><a href="Controller/logout.php">Logout</a></li>

        </ul>
</li>
</ul>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>

    <!-- Modal -->
    <div id="Profiles" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <form <?php if(!$disabled){?> action="saveProfile.php"<?php }?> method="post">
                        <div class="form-group">
                            <input type="hidden" value="<?php echo $_GET["id"];?>" name="id">
                            <input type="text" id="username" name="firstName" placeholder="First Name" value="<?php echo $customerInfo["f_name"];?>" class="radius mini"  <?php if($disabled){?> disabled<?php }?>/>
                            <input type="text" id="username" name="lastName" placeholder="Last Name" value="<?php echo $customerInfo["l_name"];?>" class="radius mini"  <?php if($disabled){?> disabled<?php }?>/>
                            <input type="text" id="username" name="mobileNo" placeholder="Mobile Number" value="<?php echo $customerInfo["mobile_no"];?>" class="radius mini"  <?php if($disabled){?> disabled<?php }?>/>
                            <input type="text" id="username" name="email" placeholder="Email" value="<?php echo $customerInfo["email"];?>" class="radius mini"  <?php if($disabled){?> disabled<?php }?>/>
                        </div>
                        <div class="form-group">
                            <input type="text" name="dob" placeholder="Date of Birth" value="<?php echo $customerInfo["dob"];?>"  <?php if($disabled){?> disabled<?php }?>/>

                            <label for="idType">Identity Type:</label>
                            <select name="idType" id="idType" <?php if($disabled){?> disabled<?php }?>>
                                <option>Student ID</option>
                                <option>Driving License</option>
                                <option>Citizenship No.</option>
                                <option>Australian Passport</option>
                                <option>Nepalese Passport</option>
                            </select>

                            <label for="type">I'm a/an:</label>
                            <select name="type" id="type"  <?php if($disabled){?> disabled<?php }?>>
                                <option>Select</option>
                                <option>Individual</option>
                                <option>Business</option>
                            </select>

                            <input type="text" name="idNo" placeholder="Identity Number" value="<?php echo $customerInfo["identity_no"];?>"  <?php if($disabled){?> disabled<?php }?>><br>
                            <input type="text" name="expiryDate" placeholder="Expiry Date" value="<?php echo $customerInfo["expiry_date"];?>" <?php if($disabled){?> disabled<?php }?>/>

                            <input type="text" name="location" placeholder="Address" value = "<?php echo $customerInfo["location"];?>" <?php if($disabled){?> disabled<?php }?>/>

                            <input type="checkbox" name="not" <?php if($customerInfo["is_subscriber"] == 1) echo "checked";?>  <?php if($disabled){?> disabled<?php }?>> Notify about rates daily</input>
                            <a class="fancybox" rel="gallery1" href="<?php echo $customerInfo["id_front_url"]?>"><img src="<?php echo $customerInfo["id_front_url"]?>" height="100" width="100"/></a>
                        </div>
                        <?php if(!$disabled){?>
                            <input type="submit" value="Submit" class="btn-default btn">
                        <?php }?>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
<?php include_once 'changePassword.php'?>