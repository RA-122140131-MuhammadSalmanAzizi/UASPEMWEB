<?php
/**
 * File: app/Views/form_registration.php
 * Deskripsi: Form pendaftaran kursus
 */
?>
<div class="form-container">
    <form id="registrationForm" class="form" method="POST" action="api.php">
        <!-- Input text -->
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap" required>
        </div>

        <!-- Input email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="example@mail.com" required>
        </div>

        <!-- Select (Gender) -->
        <div class="form-group">
            <label for="gender">Jenis Kelamin</label>
            <select id="gender" name="gender" required>
                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                <option value="Male">Laki-laki</option>
                <option value="Female">Perempuan</option>
            </select>
        </div>

        <!-- Radio (course_id) -->
        <div class="form-group">
            <label>Pilih Kursus</label>
            <label>
                <input type="radio" name="course_id" value="1" required> Web Development
            </label>
            <label>
                <input type="radio" name="course_id" value="2"> Data Science
            </label>
            <label>
                <input type="radio" name="course_id" value="3"> Mobile Apps
            </label>
            <label>
                <input type="radio" name="course_id" value="4"> UI/UX Design
            </label>
        </div>

        <!-- Checkbox -->
        <div class="form-group">
            <label>
                <input type="checkbox" name="agree_terms" id="agree_terms" value="1">
                Saya setuju dengan Syarat & Ketentuan
            </label>
        </div>

        <button type="submit" id="btnSubmit">Daftar Kursus</button>

        <div id="feedbackMessage" class="feedback"></div>
    </form>
</div>
