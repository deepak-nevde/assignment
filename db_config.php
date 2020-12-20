<?php
$username="root";  
$password="";  
// $hostname = "localhost:3308";  //check your mysql port number
$hostname = "localhost";
//connection string with database  
$conn = @mysqli_connect($hostname, $username, $password, "assignment");

if (mysqli_connect_errno()) {
    printf("Connection failed: %s\n", mysqli_connect_error());
    exit();
}
?>