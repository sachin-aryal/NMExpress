<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/1/2016
 * Time: 8:07 AM
 */
?>
<?php

if(is_null($_SESSION)) {
    $_SESSION = array();
}

//store registration session id for security
$registration_session_id = bin2hex(openssl_random_pseudo_bytes(20));
$_SESSION["registration_session_id"] = $registration_session_id;
include 'captcha-plugin/captcha.php';
$_SESSION["captcha"] = captcha(
    array(
        'min_length' => 5,
        'max_length' => 5,
        'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
        'min_font_size' => 28,
        'max_font_size' => 35,
        'color' => '#666',
        'angle_min' => 0,
        'angle_max' => 10,
        'shadow' => true,
        'shadow_color' => '#666666',
        'shadow_offset_x' => -1,
        'shadow_offset_y' => 1
    )
);
?>

<div class="loginbox radius">
    <h2 class="text-center">Register</h2>

        <div class="loginform">

            <form id="registerForm" action="verifyCustomer.php" method="post">
               <div class="row ">
                   <p>
                       <div class="col-md-6">
                       <input type="text" id="firstName" name="firstName" placeholder="First Name" value="" class="form-control" />
                   </div>
                       <div class="col-md-6">
                           <input type="text" id="lastName" name="lastName" placeholder="Last Name" value="" class="form-control" />

                       </div>
                </p>
                   </div>

                <div class="row">
                <p><div class="col-md-12">
                    <div class="input-group">
                        <div class="input-group-addon">+61</div>
                        <input type="text" id="mobileNo" name="mobileNo" placeholder="Mobile Number" value="" class="form-control" />
                    </div></div>
                   
                </p>
                    </div>
                    <div class="row">
                <p> <div class="col-md-12">
                     <input type="text" id="email" name="email" placeholder="Email" value="" class="form-control" />
                        </div>
                </p>
                    </div>

                <div class="row">
                <p>
                    <div class="col-md-6">
                        <input type="password" id="rpassword" name="password" placeholder="Password" value="" class="form-control" />
                   </div>
                    <div class="col-md-6">
                        <input type="password" id="repassword" placeholder="Confirm Password" value="" class="form-control" />
                </div>
                        </p>
                    </div>

                <br>
                <input type="hidden" value="<?php echo $registration_session_id;?>" name="registration_session_id">
                    
                <p>
                    <button type="button" onclick="validateRegisterField();" class="btn">Sign Up</button>
                </p>
            </form>
        </div><!--loginform-->
    </div><!--loginboxinner-->