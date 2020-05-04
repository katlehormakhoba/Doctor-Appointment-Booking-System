<?php
$conn = mysqli_connect("localhost","root","","doctor");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  session_start();

$id=$_GET['edt'];

 

    $sql2="DELETE From appointment WHERE appoint_id='$id'";
    $result=mysqli_query($conn,$sql2);
    if (!$result) {
    	echo "db access denied ".mysqli_error();
    }else{
    echo '<script>alert("You Succesfully Cancelled the appointment.");window.location = "pat.php";</script>';
}


?>