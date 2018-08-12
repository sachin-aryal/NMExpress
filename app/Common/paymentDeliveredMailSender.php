<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/22/16
 * Time: 12:25 AM
 */
require_once('../phpMailer/class.phpmailer.php');

function send_delivered_email($email, $nepAmount, $amount, $receiverName, $paymentType, $senderName)
{
    $mail = new PHPMailer(true); // the true param means it will throw exceptions on     errors, which we need to catch

    try {

        $mail->IsHTML(true);
        $mail->SetFrom('info@nepalexpress.com.au', 'Nepal Money Express');
        $mail->AddReplyTo('info@nepalexpress.com.au', 'Nepal Money Express');
        $mail->AddAddress($email);

        $mail->Subject = 'Payment Delivered: Nepal Money Express';
        $mail->MsgHTML('
<html>
<body>
<div style="padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #0054a5;
    border-radius: 4px;">
    <p style="font-size: 20px;">Dear '. $senderName .',</p>
    Your payment has been successfully paid to the receiver.<br><br>
    <div style="text-align: center">
        <h4>Your Order Summary</h4>
        <table style="width: 100%;">
            <tr>
                <th style = "background-color: #ce1127;color: white;text-align: left;padding: 8px;">Receiver Name</th>
                <th style = "background-color: #ce1127;color: white;text-align: left;padding: 8px;">Payment By</th>
                <th style = "background-color: #ce1127;color: white;text-align: left;padding: 8px;">Amount</th>
            </tr>
            <tr style="background-color: #6cabe9">
                <td style = "text-align: left;padding: 8px;">'. $receiverName .'</td>
                <td style = "text-align: left;padding: 8px;">'. $paymentType .'</td>
                <td style = "text-align: left;padding: 8px;">NRS '. $nepAmount .'</td>
            </tr>
            <tr style="background-color: #f2f2f2">
                <td colspan="2"><h4 style="text-align: right">Total Amount</h4></td>
                <td style="text-align: left"><h3>$' . $amount . '</h3></td>
            </tr>
        </table>
    </div><br>
</div>
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
');
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
 //       echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
//        echo $e->getMessage(); //Boring error messages from anything else!
    }
}

function send_processing_email($email,$pin_no){

    $mail = new PHPMailer(true); // the true param means it will throw exceptions on     errors, which we need to catch

    try {

        $mail->IsHTML(true);
        $mail->SetFrom('info@nepalexpress.com.au', 'Nepal Money Express');
        $mail->AddReplyTo('info@nepalexpress.com.au', 'Nepal Money Express');
        $mail->AddAddress($email);

        $mail->Subject = 'NME: Payment Processing';
        $mail->MsgHTML('
<html>
<body>
    <br>
    <div style="text-align: center">
        <img src="cid:logo"><br><br>
    </div>
    <div style="color: #3c763d;
    background-color: #dff0d8;
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #d6e9c6;
    border-radius: 4px;">
        <strong>Transaction with pin no ' . $pin_no . ' is in Processing Mode.</strong><br>
        Thank you for working via us. 
    </div>
    <br><br>
    <div style="text-align: center">
        
        <p style="font-size:16px;"> Cheerfully yours,<br>
            <strong>NME Team</strong><br>
            Strathfield, NSW, Australia
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
    <strong>www.nepalexpress.com.au</strong>
    </footer>
</body>
</html>
');
        $mail->AddEmbeddedImage('Registration/img/logo.png', 'logo');

        return $mail->Send();
    } catch (phpmailerException $e) {
        //       echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
//        echo $e->getMessage(); //Boring error messages from anything else!
    }
}