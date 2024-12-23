<?php
/**
 * File: public/courses.php
 * Deskripsi: Halaman untuk menampilkan daftar kursus
 */
session_start();
require_once __DIR__ . '/../config/database.php';

// --- Contoh data statis (bisa diganti hasil query DB) ---
$courses = [
    [
        'id' => 1,
        'course_name' => 'Web Development',
        'image' => 'assets/images/webdev.jpg',
        'price' => 800000,  // Dalam rupiah, misal 800.000
    ],
    [
        'id' => 2,
        'course_name' => 'Data Science',
        'image' => 'assets/images/datascience.jpg',
        'price' => 900000,  // 900.000
    ],
    [
        'id' => 3,
        'course_name' => 'Mobile Apps',
        'image' => 'assets/images/mobileapps.jpg',
        'price' => 750000,  // 750.000
    ],
    [
        'id' => 4,
        'course_name' => 'UI/UX Design',
        'image' => 'assets/images/uiux.jpg',
        'price' => 700000,  // 700.000
    ],
];

// Sertakan file header layout
include __DIR__ . '/../app/Views/layouts/header.php';
?>
<main class="container">
    <?php 
    // Sertakan file courses_list.php 
    // (di dalamnya kita akan looping data $courses dan menampilkan gambar & harga)
    include __DIR__ . '/../app/Views/courses_list.php';
    ?>
</main>
<?php
// Sertakan file footer layout
include __DIR__ . '/../app/Views/layouts/footer.php';
