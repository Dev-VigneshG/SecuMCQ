<?php
//connect with db
$db = new mysqli("localhost", "root", "", "secumcq");
//check connection error
if ($db->connect_error) {
    echo "Database Connection Error: " . $db->connect_error;
}

//if user clicks the signup button post method will run
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit'])) {
        $name = $_POST["name"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $cpassword=$_POST["cpassword"];
        //check user is already registered or not
        if($password!=$cpassword)
        {
            echo "<p class='error'>Password and Confirm Password Must Be Same</p>";
            echo "<script>setTimeout(function() {
                var error = document.querySelector('.error');
                if (error) {
                    error.style.display = 'none';
                }
            }, 2000);</script>";
        }
        else{
        if (mysqli_num_rows(mysqli_query($db, "SELECT * FROM register WHERE MAIL='$email'")) > 0) {
            echo "<p class='error'>You are already registered with us. Please login!</p>";
            echo "<script type='text/javascript'>setTimeout(function(){ window.location.href = 'login.php'; }, 2000);</script>";

        } else {
            //if user does not exist, insert data into register table
            mysqli_query($db, "INSERT INTO register(NAME, MAIL, PASSWORD) VALUES('$name', '$email', '$password')");
            echo "<p class='success'>Thank you for registering with us. Please login.</p>";
            //redirect user to login page after 2 seconds
            echo "<script type='text/javascript'>setTimeout(function(){ window.location.href = 'login.php'; }, 2000);</script>";
        }
    }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
     <!-- custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
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
                <li class="nav-item active">
                  <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
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
                <li class="nav-item">
                  <a class="nav-link" href="login.php">Login</a>
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
            <h1>Signup</h1>
            <p>Create your account</p>
        </div>
        <form method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="cpassword">Confirm Password:</label>
                <input type="password" id="cpassword" name="cpassword" required>
            </div>
            <input name="submit" type="submit" value="Signup" />
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>

</body>

</html>
