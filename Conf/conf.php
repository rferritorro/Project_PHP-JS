<?php
$hostanme = 'localhost';
$user = 'rafaferri';
$user_password = 'rafaferri123';
$BD = 'concessionaire';
global $conn;
$conn = mysqli_connect($hostanme,$user,$user_password,$BD);

if (!$conn) {
    die("Connection failed:" .mysqli_connect_error());
}
?>