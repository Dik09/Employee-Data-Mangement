<?php
 
error_reporting(0);

 $servername = "127.0.0.1";
 $username = "root";
 $password = "";
 $dbname = "employee";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if($conn)
{
  //echo "Connection Successefully";
}
else
{
	echo "Connection Failed".mysqli_connect_error();
}






?>