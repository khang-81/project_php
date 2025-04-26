<?php
$tenmaychu = 'localhost';
$tentaikhoan = 'root';
$pass = '';
$csdl = 'webphukiendt';

// Create a connection using mysqli
$conn = mysqli_connect($tenmaychu, $tentaikhoan, $pass, $csdl);

// Check if the connection was successful
if (!$conn) {
    die('Kết nối thất bại: ' . mysqli_connect_error());
}

// Set character encoding to UTF-8 to support Vietnamese characters
mysqli_set_charset($conn, 'utf8mb4');

?>