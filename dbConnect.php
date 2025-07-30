<?php 
$host="localhost";
$dbname='test1';
$username='root';
$password='';

$conn=mysqli_connect($host,$username,$password,$dbname);

try {
    $conn =new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Connection successful
}
catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
    exit();
}
