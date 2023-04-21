<?php
// Connecting to the database
$host = "localhost";
$user = "root";
$password = ""; 
$database = "sampledatabase";
// database has a table with username, email, password(encrypted) and date and timestamp of registration
$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else{
  //  echo 'connection established successfully';
}
