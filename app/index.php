<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 4/30/2016
 * Time: 4:41 PM
 */
require "Common/CommonFunction.php";
?>

<html>
<head>
    <title>NME</title>
    <?php include "Include/BootstrapCss.html" ?>
    <script type="text/javascript" src="Assets/Js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="Assets/Js/jquery.noty.packaged.min.js"></script>
    <script type="text/javascript" src="Assets/Js/validation.js"></script>
    <link rel="icon" href="Assets/Img/nepalFlag.png" type="image/gif" sizes="16x16">

    <link rel="stylesheet" href="Assets/Css/form-elements.css"/>
    <link rel="stylesheet" href="Assets/Css/styleLogin.css"/>
</head>

<body style = "background-image: url('Assets/Img/1.jpg');">
<?php


if(isset($_GET["successMessage"]))
    echo '<p style="color: green">' . $_GET["successMessage"] . '</p>';
if(isset($_GET["failedMessage"]))
    echo '<p style="color: red">' . $_GET["failedMessage"] . '</p>';

if(isset($_SESSION["username"])){
    goToDashBoard("");
    return;
}
else{
    ?>
    <!--<div class="container">
    <div class="row no-pad">
         <div class="col-md-6 no-pad">
<!--            --><?php /*/*include "login.php";*/?>
<!--         </div>
--><!--        <div class="col-md-6 no-pad">
--><!--            --><?php /*/*include "register.php";*/?>
     <!--   </div>
    </div>
        </div>-->
  <?php
}
?>
<div class="top-content">
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-box">
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Login to our site</h3>
                                <p>Enter username and password to log on</p>
                            </div>

                        </div>
                        <div class="form-bottom">
                            <?php include "login.php";?>

                        </div>
                    </div>

                </div>

                <div class="col-sm-1 middle-border"></div>
                <div class="col-sm-1"></div>

                <div class="col-sm-5">

                    <div class="form-box">
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Sign up now</h3>
                                <p>Fill in the form below to become new user</p>
                            </div>

                        </div>
                        <div class="form-bottom">
                            <?php include "register.php";?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>