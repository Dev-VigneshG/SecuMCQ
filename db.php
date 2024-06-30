<?php
$db=new mysqli("localhost","root","","secumcq");
if($db->connect_error){
    echo "Database Connection Error: ".$db->connect_error;
}

?>