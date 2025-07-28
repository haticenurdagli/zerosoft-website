<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// echo "PHP çalışıyor!<br>"; // Commented out for production

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zerosoft"; // phpMyAdmin'de varsa bir veritabanı adı

// Bağlantı oluşturalım
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    // Hata durumunda sadece loglama yapın veya özel bir hata sayfası gösterin
    die("Bağlantı hatası: " . $conn->connect_error);
}
// echo "Veritabanı bağlantısı başarılı!"; // Commented out for production
?>