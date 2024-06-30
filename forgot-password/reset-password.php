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
                </style>
            </head>
          
<?php
include('../db.php');
$error = "";

if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"] == "reset") && !isset($_POST["action"])) {
    $key = $_GET["key"];
    $email = $_GET["email"];
    $curDate = date("Y-m-d H:i:s");
    $query = mysqli_query($db, "SELECT * FROM `password_reset_temp` WHERE `KEY`='" . $key . "' and `email`='" . $email . "';");
    $row = mysqli_num_rows($query);

    if ($row < 1) {
        $error .= '<div class="alert alert-danger" role="alert">
            <h2>Invalid Link</h2>
            <p>The link is invalid/expired. Either you did not copy the correct link
            from the email, or you have already used the key in which case it is
            deactivated.</p>
            <p><a href="http://localhost:81/wellmind/forget.php" class="alert-link">Click here</a> to reset password.</p>
        </div>';
    } else {
        $row = mysqli_fetch_assoc($query);
        $expDate = $row['expDate'];
        if ($expDate >= $curDate) {
            ?>
            
            <body>
                <div class="container">
                    <h2 class="mb-4">Reset Password</h2>
                    <form method="post" action="" name="update">
                        <input type="hidden" name="action" value="update" />
                        <div class="form-group">
                            <label for="pass1">Enter New Password:</label>
                            <input type="password" class="form-control" name="pass1" required />
                        </div>
                        <div class="form-group">
                            <label for="pass2">Re-Enter New Password:</label>
                            <input type="password" class="form-control" name="pass2" required />
                        </div>
                        <input type="hidden" name="email" value="<?php echo $email; ?>" />
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>
                </div>
            </body>
            
            </html>
        <?php
        } else {
            $error .= '<div class="alert alert-danger" role="alert">
                <h2>Link Expired</h2>
                <p>The link is expired. You are trying to use the expired link which
                was valid only 24 hours (1 day after request).</p>
            </div>';
        }
    }

    if ($error != "") {
        echo $error;
    }
} 

if (isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"] == "update")) {
    $error = "";
    $pass1 = mysqli_real_escape_string($db, $_POST["pass1"]);
    $pass2 = mysqli_real_escape_string($db, $_POST["pass2"]);
    $email = $_POST["email"];
    $curDate = date("Y-m-d H:i:s");

    if ($pass1 != $pass2) {
        $error .= '<div class="alert alert-danger" role="alert">Passwords do not match; both passwords should be the same.</div>';
    }

    if ($error != "") {
        echo $error;
    } else {
        $pass1 = $pass1;
        mysqli_query($db, "UPDATE register SET PASSWORD='$pass1' WHERE MAIL='$email'");
        mysqli_query($db, "DELETE FROM `password_reset_temp` WHERE `email`='" . $email . "';");

        echo '<div class="alert alert-success" role="alert">
                <p>Congratulations! Your password has been updated successfully.</p>
                <p><a href="http://localhost:81/wellmind/login.php" class="alert-link">Click here</a> to Login.</p>
              </div>';
    }
}
?>
