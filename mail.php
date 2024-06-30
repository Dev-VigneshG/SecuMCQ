<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true); // Passing `true` enables exceptions

try {
    // Enable verbose debug output
    
    $mail->SMTPDebug = 2;

    // Set mailer to use SMTP
    $mail->isSMTP();

    // Specify main and backup SMTP servers
    $mail->Host = 'smtp.gmail.com';

    // Enable SMTP authentication
    $mail->SMTPAuth = true;

    // SMTP username and password
    $mail->Username = "noreplywellmind@gmail.com";
    $mail->Password = "eszqaykkaxkvyixj";
  

    // Enable TLS encryption, `ssl` also accepted
    $mail->SMTPSecure = 'tls';

    // TCP port to connect to
    $mail->Port = 587;

    // Sender information
    $mail->setFrom("noreplywellmind@gmail.com", "Wellmind");
    $mail->addAddress('21sucs43@students.tcarts.in','PRIYAVARSHNINI M');

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Wellmind Testing Mail From Php';
    $mail->Body = 'Message from php';

    // Send the message
    $mail->send();
    echo 'Message sent!';
} catch (Exception $e) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}?>
