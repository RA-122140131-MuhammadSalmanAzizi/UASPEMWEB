<?php
/**
 * File: app/Views/courses_list.php
 * Menampilkan daftar kursus (grid) dengan gambar, nama kursus, harga, dsb.
 */

function formatRupiah($value) {
    return "Rp " . number_format($value, 0, ',', '.');
}

// Misal kita asumsikan diskon 20% untuk semua kursus, 
$diskon = 0.20; // 20%
?>
<h2>Daftar Kursus Kami</h2>
<p>
    Kami menawarkan berbagai paket kursus yang dirancang untuk membantu Anda mencapai tujuan karier dan pribadi Anda.
    Dari keterampilan teknis hingga pengembangan diri, pilihan kami mencakup semuanya. Pilih paket yang sesuai dengan kebutuhan Anda dan mulailah perjalanan belajar Anda hari ini! 🌟
</p>
<div class="courses-grid">
    <?php if (!empty($courses)): ?>
        <?php foreach ($courses as $course): ?>
            <?php 
                $originalPrice = $course['price'];
                // Hitung harga setelah diskon
                $discountedPrice = $originalPrice - ($originalPrice * $diskon);
            ?>
            <div class="course-card">
                <div class="course-card-img">
                    <img 
                        src="<?php echo htmlspecialchars($course['image']); ?>" 
                        alt="Image of <?php echo htmlspecialchars($course['course_name']); ?>"
                    >
                </div>
                <div class="course-card-content">
                    <h3><?php echo htmlspecialchars($course['course_name']); ?></h3>
                    <p class="course-price">
                        <span class="price-discounted">
                          <!-- Harga diskon -->
                          <?php echo formatRupiah($discountedPrice); ?>
                        </span>
                        <span class="price-original">
                          <!-- Harga asli dicoret -->
                          <s><?php echo formatRupiah($originalPrice); ?></s>
                        </span>
                    </p>
                    <p>
                        Belajar <?php echo htmlspecialchars($course['course_name']); ?> 
                        secara menyeluruh, didampingi para mentor berpengalaman.
                    </p>
                    <a class="btn" href="register.php">Daftar</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Tidak ada kursus yang tersedia saat ini.</p>
    <?php endif; ?>
</div>
