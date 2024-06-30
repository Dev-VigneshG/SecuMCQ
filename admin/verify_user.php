<?php
if(isset($_GET["id"])&&isset($_GET["action"]))
{
    $action=$_GET["action"];
    $id=$_GET["id"];
    include("../db.php");
    if($action=="verify")
    {
$sql="UPDATE counselor_details SET STATUS='VERIFIED' WHERE COUNSELLOR_ID ='$id'";
mysqli_query($db,$sql);
    }
    else
    {
        $sql="UPDATE counselor_details SET STATUS='NOT VERIFIED' WHERE COUNSELLOR_ID ='$id'";
        mysqli_query($db,$sql);
    
    }

}
else
{
    echo "Invalid URL";
}
?>