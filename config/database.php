<?php
// Database configuration

$host="localhost";
$username ="root";
$password ="";
$database = "mini_social_network";

// Connect database using mysqli

$conn = mysqli_connect($host,$username,$password,$database);
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}

?>