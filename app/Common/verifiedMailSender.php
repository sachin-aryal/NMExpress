<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/22/16
 * Time: 12:25 AM
 */
require_once('../phpMailer/class.phpmailer.php');

function send_verified_email($email)
{
    $mail = new PHPMailer(true); // the true param means it will throw exceptions on     errors, which we need to catch

    try {

        $mail->IsHTML(true);
        $mail->SetFrom('info@nepalexpress.com.au', 'Nepal Money Express');
        $mail->AddReplyTo('info@nepalexpress.com.au', 'Nepal Money Express');
        $mail->AddAddress($email);

        $mail->Subject = 'Thank you for your registration';
        $mail->MsgHTML(
            '
<html>
<body>
<br>
    <div style="text-align: center">
    <img src="cid:logo"><br><br>
    <h2>Thanks For Registering. </h2>
    <h3>
    <br><br>
Please, give us time to verify your account and we will send you back an email after verifying your account,<br>
And then you can enjoy our online system for sending money<br>
    and tracking the status of your transfer.
    </h3>
<br><br>
<div style="text-align: center">
    <img src="cid:ad" style="width: 90%"/>
</div>
<div style="text-align: center">
    <h3> OUR FEATURES </h3>
    <table style="text-align: center;margin:0 auto;">
        <thead>
        <th style="padding-right: 100px;
            padding-left: 145px;"></th>
        <th style="padding-right: 100px;
            padding-left: 145px;"></th>
        <th style="padding-right: 100px;
            padding-left: 145px;"></th>
        </thead>
        <tbody>
        <tr>
            <td><img src="cid:track"></td>
            <td><img src="cid:easy"></td>
            <td><img src="cid:customer"></td>
        </tr>
        <tr>
            <td><img src="cid:checkAll"></td>
            <td><img src="cid:delivery"></td>
            <td><img src="cid:reward"></td>
        </tr>
        </tbody>
    </table>
</div>
<br>    <br>

<div style="text-align: center">
    <h3>
        Also contact us for sending and receiving good / items / courier via
    </h3><br>
    <img src="cid:royalLogo" style="margin: 0 auto"><br><br>
    <p style="font-size:16px;"> Cheerfully yours,<br>
        <strong>NME Team</strong><br>
        Strathfield , NSW , Australia
    <hr style="width: 100px;
            border-top:1px solid black;">
    Call us <strong>+61426602903, +61450954044</strong><br>
    E-mail: <span style="color: red;text-decoration: underline">info@nepalexpress.com.au</span>
    </p>
</div>
<br><br>
<footer style="padding: 10px;
            text-align: center;
            background-color: #ebebeb;">
    <div style="text-align: center">
        <img src="cid:logo"><br><br>
    </div>
    <em>Copyright 2016 Nepal Money Express Pty. Ltd. All rights Reserved.</em><br>
    <strong>www.nepalexpress.com.au</strong>
</footer>
</body>
</html>
        '
        );

        $mail->AddEmbeddedImage('../Registration/img/checkAll.png', 'checkAll');
        $mail->AddEmbeddedImage('../Registration/img/customer.png', 'customer');
        $mail->AddEmbeddedImage('../Registration/img/delivery.png', 'delivery');
        $mail->AddEmbeddedImage('../Registration/img/easy.png', 'easy');
        $mail->AddEmbeddedImage('../Registration/img/logo.png', 'logo');
        $mail->AddEmbeddedImage('../Registration/img/reward.png', 'reward');
        $mail->AddEmbeddedImage('../Registration/img/royalLogo.png', 'royalLogo');
        $mail->AddEmbeddedImage('../Registration/img/track.png', 'track');
        $mail->AddEmbeddedImage('../../img/slider3.jpg', 'ad');

        return $mail->Send();
    } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
    }
}

function send_new_registration_to_admin($lastId,$firstName,$email)
{
    $mail = new PHPMailer(true); // the true param means it will throw exceptions on     errors, which we need to catch

    try {

        $mail->IsHTML(true);
        $mail->SetFrom($email,$firstName);
        $mail->AddAddress('info@nepalexpress.com.au', 'Nepal Money Express');

        $mail->Subject = 'New User is registered, check to activate';
        $mail->MsgHTML(
            '
<html>
<body>
<br>
    <div style="text-align: center">
    <img src="cid:logo"><br><br>
    <h2>         New User is registered check to register. </h2>
    <h3>
    <br><br>
    User named: '.$firstName.', with email: '.$email.' is registered to system<br>
    Click <a href ="http://nepalexpress.com.au/app/customerProfile.php?id='.$lastId.'" style="text-decoration:none;"> here</a> to See Details.
   
    </h3>
<br>

<footer style="padding: 10px;
            text-align: center;
            background-color: #ebebeb;">
    <div style="text-align: center">
        <img src="cid:logo"><br><br>
    </div>
    <em>Copyright 2016 Nepal Money Express Pty. Ltd. All rights Reserved.</em><br>
    <strong>www.nepalexpress.com.au</strong>
</footer>
</body>
</html>
        '
        );

        return $mail->Send();
    } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
    }
}

function send_registered_email($email,$name)
{
    $mail = new PHPMailer(true); // the true param means it will throw exceptions on     errors, which we need to catch

    try {

        $mail->IsHTML(true);
        $mail->SetFrom('info@nepalexpress.com.au', 'Nepal Money Express');
        $mail->AddReplyTo('info@nepalexpress.com.au', 'Nepal Money Express');
        $mail->AddAddress($email);

        $mail->Subject = 'Your Account has been verified';
        $mail->MsgHTML(
            '
<html>
<body>
<br>
    <div style="text-align: center">
    <img src="cid:logo"><br><br>
    <h2>Thanks For Registering. </h2>
    <h3>
    <br><br>
    Hi,'.$name.'<br>
Your account has been verified. Now you can login and use our system using your email '.$email.' as Username and your registered password <a href="http://nepalexpress.com.au/app/" style="text-decoration:none;"> here</a>
    </h3>
<br><br>
<div style="text-align: center">
    <img src="cid:ad" style="width: 90%"/>
</div>
<div style="text-align: center">
    <h3> OUR FEATURES </h3>
    <table style="text-align: center;margin:0 auto;">
        <thead>
        <th style="padding-right: 100px;
            padding-left: 145px;"></th>
        <th style="padding-right: 100px;
            padding-left: 145px;"></th>
        <th style="padding-right: 100px;
            padding-left: 145px;"></th>
        </thead>
        <tbody>
        <tr>
            <td><img src="cid:track"></td>
            <td><img src="cid:easy"></td>
            <td><img src="cid:customer"></td>
        </tr>
        <tr>
            <td><img src="cid:checkAll"></td>
            <td><img src="cid:delivery"></td>
            <td><img src="cid:reward"></td>
        </tr>
        </tbody>
    </table>
</div>
<br>    <br>

<div style="text-align: center">
    <h3>
        Also contact us for sending and receiving good / items / courier via
    </h3><br>
    <img src="cid:royalLogo" style="margin: 0 auto"><br><br>
    <p style="font-size:16px;"> Cheerfully yours,<br>
        <strong>NME Team</strong><br>
        Strathfield , NSW , Australia
    <hr style="width: 100px;
            border-top:1px solid black;">
    Call us <strong>+61426602903, +61450954044</strong><br>
    E-mail: <span style="color: red;text-decoration: underline">info@nepalexpress.com.au</span>
    </p>
</div>
<br><br>
<footer style="padding: 10px;
            text-align: center;
            background-color: #ebebeb;">
    <div style="text-align: center">
        <img src="cid:logo"><br><br>
    </div>
    <em>Copyright 2016 Nepal Money Express Pty. Ltd. All rights Reserved.</em><br>
    <strong>www.nepalexpress.com.au</strong>
</footer>
</body>
</html>
        '
        );

        $mail->AddEmbeddedImage('../Registration/img/checkAll.png', 'checkAll');
        $mail->AddEmbeddedImage('../Registration/img/customer.png', 'customer');
        $mail->AddEmbeddedImage('../Registration/img/delivery.png', 'delivery');
        $mail->AddEmbeddedImage('../Registration/img/easy.png', 'easy');
        $mail->AddEmbeddedImage('../Registration/img/logo.png', 'logo');
        $mail->AddEmbeddedImage('../Registration/img/reward.png', 'reward');
        $mail->AddEmbeddedImage('../Registration/img/royalLogo.png', 'royalLogo');
        $mail->AddEmbeddedImage('../Registration/img/track.png', 'track');
        $mail->AddEmbeddedImage('../../img/slider3.jpg', 'ad');

        return $mail->Send();
    } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
    }
}