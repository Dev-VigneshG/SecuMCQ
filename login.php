<?php
// Connect to the database
$db = new mysqli("localhost", "root", "", "secumcq");
// Check connection error
if ($db->connect_error) {
    echo "Database Connection Error: " . $db->connect_error;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit'])) {
        $mail = $_POST["mail"];
        $password = $_POST["password"];
        
        // Validate user credentials
        $result = mysqli_query($db, "SELECT * FROM register WHERE MAIL='$mail' AND BINARY PASSWORD='$password'");
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_array($result);
            $id = $row["ID"];
            // Start session and set session variables
            session_start();
            $_SESSION["id"] = $id;
            $_SESSION["userid"] = $id;
            $_SESSION["name"] = $row["NAME"];
            $_SESSION["mail"] = $row["MAIL"];
            $_SESSION["role"] = $row["ROLE"];
            // Redirect based on user role
            if ($row["ROLE"] == "USER") {
                header("Location: user");
            } else if ($row["ROLE"] == "ADMIN") {
                header("Location: admin");
            } 
            exit; // Ensure script stops after redirect
        } else {
            echo "<p class='error'>Incorrect Mail id Or Password. Please Try Again 😢</p>";
            echo "<script> setTimeout(function(){
                var error=document.querySelector('.error');
                if(error){error.style.display='none';}
            }, 4000);</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />
    <style>
    .signup-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin-top: 5%;
            margin-left:40%;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .success, .error {
            position: absolute;
            top: 12%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #ffe6e6;
            color: #f44336;
            padding: 15px;
            margin-top: 20px;
            border-left: 6px solid #f44336;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            line-height: 1.5;
        }

        .success {
            background-color: #e6ffe6;
            color: #4caf50;
            border-left-color: #4caf50;
        }

        .headers {
            text-align: center;
            margin-bottom: 40px;
        }

        .headers h1 {
            font-size: 32px;
            color: #333;
            margin: 0;
        }

        .headers p {
            color: #777;
            margin: 8px 0 0;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .signup-container {
                width: 90%;
            }

            .success, .error {
                width: 90%;
            }
        }
        
    </style>
</head>

<body>

<div class="hero_area">
    <header class="header_section">
        <div class="container">
            <nav class="navbar navbar-expand-lg custom_nav-container pt-3">
                <a class="navbar-brand mr-5" href="index.html">
                    <span>SecuMCQ</span>
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="index.html">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.html">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="service.html">Service</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="signup.php">Signup</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="login.php">Login <span class="sr-only">(current)</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- end header section -->
</div>

<div class="signup-container">
    <div class="headers">
        <h1>Login</h1>
        <p>Enter your credentials</p>
    </div>
    <form method="post">
        <div class="form-group">
            <label for="mail">Mail Id:</label>
            <input type="text" id="mail" name="mail" placeholder="Mail Id" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <input name="submit" type="submit" value="Login" />
    </form>
    <div class="login-link">
        <p>Don't have an account? <a href="signup.php">Signup</a></p>
        <p>Forgot password? <a href="forget.php">Reset</a></p>
    </div>
</div>

</body>

</html>
