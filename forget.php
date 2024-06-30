<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 50px;
        }

        .error {
            margin-top: 20px;
        }
    </style>
</head>

<?php

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;      
include("db.php");

date_default_timezone_set('Asia/Karachi');
$error = "";

if (isset($_POST["email"]) && (!empty($_POST["email"]))) {

    $email = $_POST["email"];
    if (!$email) {
        $error .= "<p class='alert alert-danger'>Invalid email address. Please enter a valid email address!</p>";
    } else {
        $sel_query = "SELECT * FROM register WHERE MAIL='" . $email . "'";
        $results = mysqli_query($db, $sel_query);
        $row = mysqli_num_rows($results);
        if ($row < 1) {
            $error .= "<p class='alert alert-danger'>No user is registered with this email address!</p>";
        }
    }
    if ($error != "") {
        echo "<div class='error'>" . $error . "</div>
        <br /><a href='javascript:history.go(-1)' class='btn btn-secondary'>Go Back</a>";
    } else {
        $expFormat = mktime(
            date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y")
        );
        $expDate = date("Y-m-d H:i:s", $expFormat);
        $key = md5('2418*2' . $email);
        $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
        $key = $key . $addKey;
        mysqli_query($db, "DELETE FROM password_reset_temp WHERE email='" . $email . "';");
        mysqli_query($db, "INSERT INTO  password_reset_temp VALUES ('$email', '$key','$expDate')");

        $output = '<p>Dear user,</p>';
        $output .= '<p>Please click on the following link to reset your password.</p>';
        $output .= '<p>-------------------------------------------------------------</p>';
        $output .= '<p><a href="http://localhost:81/wellmind/forgot-password/reset-password.php?key=' . $key . '&email=' . $email . '&action=reset" target="_blank">
        http://localhost:81/wellmind/forgot-password/reset-password.php
        ?key=' . $key . '&email=' . $email . '&action=reset</a></p>';
        $output .= '<p>-------------------------------------------------------------</p>';
        $output .= '<p>Please be sure to copy the entire link into your browser.
        The link will expire after 1 day for security reason.</p>';
        $output .= '<p>If you did not request this forgotten password email, no action
        is needed, your password will not be reset. However, you may want to log into
        your account and change your security password as someone may have guessed it.</p>';
        $output .= '<p>Thanks,</p>';
        $output .= '<p>WELLMIND</p>';
        $body = $output;
        $subject = "Password Recovery - WELLMIND";

        $email_to = $email;

        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "noreplywellmind@gmail.com";
        $mail->Password = "haothaqfebpevmao";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->IsHTML(true);
        $mail->From = "noreplywellmind@gmail.com";
        $mail->FromName = "Wellmind";
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($email);
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "<div class='alert alert-success'>
            <p>An email has been sent to you with instructions on how to reset your password.</p>
            </div><br /><br /><br />";
        }
    }
} else {
?>

<body>
    <div class="container">
        <h2 class="mb-4">Reset Password</h2>
        <form method="post" name="reset">
            <div class="form-group">
                <label for="email">Enter Your Email Address:</label>
                <input type="email" class="form-control" name="email" placeholder="username@email.com" />
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>
</body>

</html>
<?php } ?>
