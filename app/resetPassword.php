<script src="Assets/Js/jquery-1.11.1.min.js"></script>
<script src="Assets/Js/custom.js"></script>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/4/2016
 * Time: 10:16 AM
 */

$emailKey = str_rot13("email");

if(isset($_GET[$emailKey])){
    echo "<label for='newPass'>New Password</label>";
    echo "<input type='password' name='newPassword' id='newPassword'/>";
    $user_email =  str_rot13($_GET[$emailKey]);
    echo "<input type='hidden' name='user_email' id='user_email' value='$user_email'/>";
    echo "<button onclick='resetPassword()'>Save</button>";
}