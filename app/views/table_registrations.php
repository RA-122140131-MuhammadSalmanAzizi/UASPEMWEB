<?php
/**
 * File: app/Views/table_registrations.php
 * Deskripsi: Menampilkan data pendaftaran di tabel
 */
?>
<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Kursus</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="tableContainer">
    <?php if (!empty($registrations)): ?>
        <?php foreach ($registrations as $reg): ?>
            <tr data-id="<?php echo $reg['id']; ?>">
                <td><?php echo $reg['id']; ?></td>
                <td class="editable"
                    data-original-value="<?php echo htmlspecialchars($reg['name']); ?>">
                    <?php echo htmlspecialchars($reg['name']); ?>
                </td>
                <td class="editable"
                    data-original-value="<?php echo htmlspecialchars($reg['email']); ?>">
                    <?php echo htmlspecialchars($reg['email']); ?>
                </td>
                <td class="editable"
                    data-original-value="<?php echo htmlspecialchars($reg['gender']); ?>">
                    <!-- Convert male/female ke label -->
                    <?php echo ($reg['gender'] === 'Male') ? 'Laki-laki' : 'Perempuan'; ?>
                </td>
                <td class="editable"
                    data-original-value="<?php echo htmlspecialchars($reg['course_name']); ?>">
                    <?php echo htmlspecialchars($reg['course_name']); ?>
                </td>
                <td><?php echo $reg['created_at']; ?></td>
                <td>
                    <button class="btn btn-edit">Edit</button>
                    <button class="btn btn-delete">Hapus</button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="7" align="center">Belum ada pendaftar</td></tr>
    <?php endif; ?>
    </tbody>
</table>
