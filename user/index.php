<?php
session_start();
if(isset($_SESSION['name']))
{

  if($_SESSION['role']=="USER")
  {
    
  }
  else if($_SESSION['role']=="ADMIN")
  {
    header("Location: ../admin");
  }
 
}
else
{
  header("Location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<style>
  iframe{
    width: 80%;
    position: absolute;
    top:8.5%;
    left:19.5%;
    height: 1200px;
    border: 1px solid red;}
body{background-size:1400px 900px;background-repeat:no-repeat}

 h2{
      color: pink;
      font-size:15px;
      text-decoration: none;
      
    }
      
</style>

  <meta charset="utf-8">
  <script src="https://kit.fontawesome.com/1b38070603.js" crossorigin="anonymous"></script>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>wellmind</title>
  <!-- font wesome stylesheet -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

  <title>User page</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Vendor CSS Files 
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">-->

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
<link href="css/styleuser.css" rel="stylesheet" />
</head>
<body>
  <div class="hero_area">
  <!-- ======= Mobile nav toggle button ======= -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>       
  <header id="header">
<img src="images/logo.png" alt=""><br><h2 style="margin-left: 30px">SecuMCQ</h2>
    <div class="d-flex flex-column">
<br><br><br>
      <nav id="navbar" class="nav-menu navbar">

        <ul>
          <li><a href="quiz" target="main" class="nav-link scrollto active"><i class="fa-solid fa-list-check" style="color: #FFD43B;"></i> <span> Assessment</span></a></li>
          <li><a href="quiz" target="main" class="nav-link scrollto active"><i class="fa-solid fa-ranking-star" style="color: #FFD43B;"></i> <span> LeaderBoard</span></a></li>
          
        </ul>
      </nav><!-- .nav-menu -->
    </div>
  </header>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
          <li class="nav-item active" style="margin-right: 20px;color:white">
          <a class="nav-link" href="about.html" target="main" style="font-size:20px;color:white">About Us <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item" style="margin-right:20px">
          <a class="nav-link" href="service.html" target="main" style="font-size:20px;color:white">Service</a>
        </li>
      
        <li class="nav-item" style="margin-right: 20px">
  <a class="nav-link" href="#" style="font-size:20px;color:white"><?php echo "Hello " . $_SESSION["name"]; ?></a>
</li>
        <li class="nav-item" style="margin-right: 20px">
          <a class="nav-link" href="../logout.php" style="font-size:20px;color:white">Logout</a>
        </li>
      </ul>
    </div>
  </nav>

      </div>
    </section><!-- End Breadcrumbs -->
</main>
</div>
<section class="inner-page" align="right">
      <!-- <div class="container" align="left">
        <p align="right">
          Example inner page template
        </p> 
        
      </div> -->
      <iframe name="main" ></iframe>

    </section>
</body>
</html>

 