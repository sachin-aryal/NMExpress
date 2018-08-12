<?php
/**
 * Created by PhpStorm.
 * User: asim
 * Date: 5/29/16
 * Time: 3:02 PM
 */
require_once('app/phpMailer/class.phpmailer.php');
$mail = new PHPMailer(true); // the true param means it will throw exceptions on     errors, which we need to catch

$name = $_POST["name"];
$contact = $_POST["contact"];
$address = $_POST["address"];
$for = $_POST["for"];
$message = $_POST["message"];

try {

    $mail->IsHTML(true);
    $mail->SetFrom('info@nepalexpress.com.au', 'Nepal Money Express');
    $mail->AddAddress('info@nepalexpress.com.au');

    $mail->Subject = 'Inquiry';
    $mail->MsgHTML(
        '
<html>
<body>
<p>
    Name: ' . $name . '<br><br>
    Address: ' . $address . '<br><br>
    Contact: ' . $contact . '<br><br>
    Inquiry For: ' . $for . '<br><br>
    Message: ' . $message . '<br><br>
</p>
</body>
</html>'
    );


    return $mail->Send();
} catch (phpmailerException $e) {
    //       echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
//        echo $e->getMessage(); //Boring error messages from anything else!
}
?>
