<?php
// File: hms/admin/include/config.php
// Gunakan file ini sebagai pengganti config.php yang lama

// Cek apakah konstanta sudah didefinisikan, jika belum baru didefinisikan
if(!defined('DB_SERVER')) {
    define('DB_SERVER', 'localhost');
}
if(!defined('DB_USER')) {
    define('DB_USER', 'root');  // Sesuaikan dengan username database Anda
}
if(!defined('DB_PASS')) {
    define('DB_PASS', '');  // Sesuaikan dengan password database Anda
}
if(!defined('DB_NAME')) {
    define('DB_NAME', 'hms');  // Sesuaikan dengan nama database Anda
}

// Buat koneksi database jika belum ada
if(!isset($con)) {
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    
    // Cek koneksi
    if(mysqli_connect_errno()) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }
    
    // Set charset ke utf8
    mysqli_set_charset($con, "utf8");
}
?>