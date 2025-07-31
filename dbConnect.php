<?php 
$host="localhost";
$dbname='admin';
$username='root';
$password='';

$conn=mysqli_connect($host,$username,$password,$dbname);

try {
    $conn =new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Connection successful
}
catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
    exit();
}
