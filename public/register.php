<?php
/**
 * File: public/register.php
 * Deskripsi: Halaman memuat form pendaftaran + tabel pendaftar,
 *            serta tombol "Hapus Semua Data".
 */
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Controllers/RegistrationController.php';

// Buat instance controller
$controller = new RegistrationController($pdo);

// Ambil semua data pendaftar
$registrations = $controller->index();

// Sertakan file layout header
include __DIR__ . '/../app/Views/layouts/header.php';
?>
<main class="container">
    <h2>Pendaftaran Kursus</h2>

    <!-- Form Pendaftaran -->
    <?php include __DIR__ . '/../app/Views/form_registration.php'; ?>

    <!-- Tabel Data Pendaftar -->
    <h2>Data Pendaftar</h2>
    <div id="tableContainer">
        <?php include __DIR__ . '/../app/Views/table_registrations.php'; ?>
    </div>

    <!-- Tombol Hapus Semua Data -->
    <button class="btn btn-delete-all" id="btnDeleteAll" style="margin-top: 20px;">
        Hapus Semua Data
    </button>
</main>
<?php
// Sertakan file layout footer
include __DIR__ . '/../app/Views/layouts/footer.php';
