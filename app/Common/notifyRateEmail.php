<?php
/**
 * Created by IntelliJ IDEA.
 * User: iam
 * Date: 8/5/16
 * Time: 10:41 PM
 */

require_once('../phpMailer/class.phpmailer.php');


function send_notify_email($email,$nrs){


    $mail = new PHPMailer(true); // the true param means it will throw exceptions on     errors, which we need to catch

    try {

        $mail->IsHTML(true);
        $mail->SetFrom('info@nepalexpress.com.au', 'Nepal Money Express');
        $mail->AddReplyTo('info@nepalexpress.com.au', 'Nepal Money Express');
        $mail->AddAddress($email);

        $mail->Subject = 'Updated Rate - Nepal Money Express';
        $mail->MsgHTML('
<html>
<body>
<br>
<div style="text-align: center">
    <img src="cid:logo"><br><br>
</div>
<div style="border: 1px solid #0054a5;
  font-size: 20px;
  padding: 20px;
  text-align:center;">
    Current Rate<br><br>Today\'s Rate is <span style="font-size:35px;color: #ce1147;">'.number_format($nrs, 2, '.', '').'</span> Nepali Rupees<br>
</div><br>
<p style="margin: 0px auto; width: 100%;font-size:16px;text-align: center">
    VISIT <span style="color:red">www.nepalexpress.com.au</span> for sending your money to Nepal online and get received on same day.
</p>

<br><br>
<div style="text-align: center">
    <img src="cid:ad" style="width: 90%"/>
</div>
<div style="text-align: center">
    <h3> FEATURES </h3>
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
    <em>Copyright 2016 Nepal Money Express Pty. Ltd. All rights Reserved.</em><br>
    <strong>www.nepalexpress.com.au</strong>
</footer>
</body>
</html>
');
        $mail->AddEmbeddedImage('../Registration/img/checkAll.png', 'checkAll');
        $mail->AddEmbeddedImage('../Registration/img/customer.png', 'customer');
        $mail->AddEmbeddedImage('../Registration/img/delivery.png', 'delivery');
        $mail->AddEmbeddedImage('../Registration/img/easy.png', 'easy');
        $mail->AddEmbeddedImage('../Registration/img/logo.png', 'logo');
        $mail->AddEmbeddedImage('../Registration/img/reward.png', 'reward');
        $mail->AddEmbeddedImage('../Registration/img/royalLogo.png', 'royalLogo');
        $mail->AddEmbeddedImage('../Registration/img/track.png', 'track');
        $mail->AddEmbeddedImage('../Assets/Img/slider3.jpg', 'ad');

        return $mail->Send();
    } catch (phpmailerException $e) {
        //       echo $e->errorMessage(); //Pretty error messages from PHPMailer
        return "Error Exception: ".$e->errorMessage();
    } catch (Exception $e) {
//        echo $e->getMessage(); //Boring error messages from anything else!
        return "Error Exception: ".$e->errorMessage();
    }

}