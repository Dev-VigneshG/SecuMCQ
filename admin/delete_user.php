<?php
session_start();
if(isset($_SESSION['name']))
{
  if($_SESSION['role']=="USER")
  {
    header("Location: ../user");
  }
  else if($_SESSION['role']=="ADMIN")
  {
    
  }
  else if($_SESSION['role']=="COUNSELOR")
  {
    header("Location: ../counselor");
  }
}
else
{
  header("Location: ../login.php");
}
?>
<?php
include("../db.php");
if (isset($_GET['id']) && isset($_GET['role'])) {
    echo "hi";
    $delete_id = $_GET['id'];
    $role = $_GET['role'];
    if ($role =='user') {
        $delete_user = "delete from user_details where USER_ID='$delete_id'";
    } else if($role =='counselor') {
        $delete_user = "delete from counselor_details where COUNSELLOR_ID='$delete_id'";
    }
    else if($role=='admin')
    {
        $delete_user = "delete from register where ID='$delete_id'";
    }
    $run_delete = mysqli_query($db, $delete_user);
    $register_delete = "delete from register where ID='$delete_id'";
    $run_register_delete = mysqli_query($db, $register_delete);
    if ($run_delete && $run_register_delete) {
        echo "<script>alert('A user has been deleted!')</script>";
        echo "<script>window.open('user.php','_self')</script>";
    }
}
