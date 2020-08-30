<?php
session_start();
$servername = "localhost";
$server_user = "root";
$server_pass = "";
$dbname = "digitalticket";
if(isset($_SESSION['name']) && isset($_SESSION['role'])){
    $name = $_SESSION['name'];
$role = $_SESSION['role'];
}
else{
    echo '';
}
$con = new mysqli($servername, $server_user, $server_pass, $dbname);
?>