<?php 
$host="localhost:3301";
$username= "root";
$password="";
$dbname="campuscare_hub";

$conn = new mysqli($host,$username,$password,$dbname);

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}
?>