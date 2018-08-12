<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/29/16
 * Time: 3:02 PM
 */
require_once('../phpMailer/class.phpmailer.php');

function send_receipt_mail($pin_no, $receipt)
{
    $mail = new PHPMailer(true); // the true param means it will throw exceptions on     errors, which we need to catch

    try {

        $mail->IsHTML(true);
        $mail->SetFrom('info@nepalexpress.com.au', 'Nepal Money Express');
        $mail->AddReplyTo('info@nepalexpress.com.au', 'Nepal Money Express');
        $mail->AddAddress('info@nepalexpress.com.au');

        $mail->Subject = 'NME: Transaction Details';
        $mail->MsgHTML(
            '
<html>
<body>
    <div style="color: #3c763d;
    background-color: #dff0d8;
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #d6e9c6;
    border-radius: 4px;">
        <strong>Pending Transaction</strong><br>
        The transaction with <b>' . $pin_no . '</b> has uploaded the following receipt:<br>
        <div style="padding: 10px; text-align: center">
            <img src="cid:receipt" width="320"/>
        </div>
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
'
        );

        $mail->AddEmbeddedImage('../'. $receipt, 'receipt');
        return $mail->Send();
    } catch (phpmailerException $e) {
        //       echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
//        echo $e->getMessage(); //Boring error messages from anything else!
    }
}