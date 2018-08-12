<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 4/30/2016
 * Time: 7:13 PM
 */
include_once 'Common/notification.php';

//store registration session id for security
$login_session_id = bin2hex(openssl_random_pseudo_bytes(20));
$_SESSION["login_session_id"] = $login_session_id;


?>
<!--<form action="Controller/validateLogin.php" method="post">
    <input type="text" name="username" placeholder="Username" id="username"/>
    <input type="password" name="password" placeholder="Password" id="password">
    <input type="submit" value="Login"/>
    <a href='forgetPassword.php'>Forgot Password</a>;
</form>-->


<div class="loginbox radius">
    <h2 class="text-center">Login</h2>

    <div class="loginform">

        <form id="login" action="Controller/validateLogin.php" method="post">
            <p>
                <input type="text" id="username" name="username" placeholder="Username" value="" class="form-control"/><br>
                <input type="password" name="password" placeholder="Password" value="" id="password" class="form-control">
            </p>

            <p>
                <button onclick="return validateLoginField()" class="btn">Sign In</button>
            </p> <p class="text-center">
                <a  data-toggle="modal" data-target="#forgot">Forgot Password</a>
            </p>
            <input type="hidden" name = "login_session_id" value="<?php echo $login_session_id;?>">
        </form>

    </div><!--loginform-->
</div><!--loginboxinner-->


<!-- Modal -->
<div id="forgot" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Forgot Password</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="forgetPassword.php">
                  Email  <input type="text" name="user_email"/>
                    <input type="submit" class="btn btn-primary" value="Request"/>
                </form>
            </div>

        </div>

    </div>
</div>