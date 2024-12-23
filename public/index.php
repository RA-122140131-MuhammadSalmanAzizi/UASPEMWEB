<?php
/**
 * File: public/index.php
 * Deskripsi: Halaman depan (Home)
 */
session_start();
?>
<?php include __DIR__ . '/../app/Views/layouts/header.php'; ?>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content container">
        <h1>Selamat Datang di Kursus Online</h1>
        <p>
            Belajar berbagai skill digital dengan bimbingan mentor berpengalaman. 
            Bergabunglah dengan ribuan peserta lain yang telah sukses meningkatkan karier!
        </p>
        <a class="btn" href="courses.php">Lihat Kursus</a>
        <a class="btn" href="register.php">Daftar Sekarang</a>
    </div>
</div>

<main class="container">
    <!-- Detail Website / Diskon Info -->
    <section class="highlights">
        <h2>Kenapa Memilih Kami?</h2>
        <div class="highlight-cards">
            <div class="highlight-card">
                <img src="assets/images/support.png" alt="Support Icon">
                <h3>Dukungan Mentor</h3>
                <p>Dapatkan pendampingan penuh dari mentor ahli di bidangnya.</p>
            </div>
            <div class="highlight-card">
                <img src="assets/images/certificate.png" alt="Certificate Icon">
                <h3>Sertifikat Resmi</h3>
                <p>Setiap peserta yang lulus akan mendapatkan sertifikat profesional.</p>
            </div>
            <div class="highlight-card">
                <img src="assets/images/discount.png" alt="Discount Icon">
                <h3>Diskon Spesial</h3>
                <p>Nikmati diskon hingga <strong>30%</strong> untuk pendaftaran sebelum akhir bulan!</p>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../app/Views/layouts/footer.php'; ?>