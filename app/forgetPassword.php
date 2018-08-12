<!--/**
 * Created by IntelliJ IDEA.
 * User: sachin
 * Date: 5/4/2016
 * Time: 9:30 AM
 */-->
<!--<form method="POST" action="forgetPassword.php">
    <input type="text" name="user_email"/>
    <input type="submit" value="Request"/>
</form>-->

<?php
require "Common/DbConnection.php";
require "Common/CommonFunction.php";
require_once('phpMailer/class.phpmailer.php');


if(isset($_POST["user_email"])){
    $user_email = addslashes($_POST["user_email"]);
    $result = $conn->query("select id from user_sas where username='$user_email'");
    if($result->num_rows!=0){

        $emailValue = str_rot13($user_email);
        $emailKey = str_rot13("email");
        $message = resetPasswordUrl.$emailKey."=".$emailValue;

        $mail = new PHPMailer(true); // the true param means it will throw exceptions on     errors, which we need to catch

        try {

            $mail->SetFrom('info@nepalexpress.com.au', 'Nepal Money Express');
            $mail->AddReplyTo('info@nepalexpress.com.au', 'Nepal Money Express');
            $mail->AddAddress($user_email);
            $mail->Subject = 'Reset Password';
            $mail->Body=$message;
            if($mail->send()){
                redirect("index.php?msgSuccess=Reset link has been sent to your email.");
            }else{
                redirect("index.php?msgError=Sorry Email Address does not exist.");
            }
        }catch (Exception $er){
            redirect("index.php?msgError=Sorry Email Address does not exist.");

        }
    }else{
        redirect("index.php?msgError=Email Address do not exist.");
    }
}

?>