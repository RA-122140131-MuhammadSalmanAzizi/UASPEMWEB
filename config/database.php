<?php
/**
 * File: config/database.php
 * Deskripsi: Koneksi ke database (PDO)
 */

$host = 'localhost';
$dbname = 'db_kursus';
$user = 'root';
$pass = '';

try {
    // Inisialisasi koneksi PDO
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass
    );
    // Set error mode agar muncul exception saat terjadi error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
