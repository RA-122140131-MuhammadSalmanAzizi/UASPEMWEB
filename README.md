# README

## DAFTAR JAWABAN DARI SOAL PEMWEB

1. [Client-side Programming](#client-side-programming)
   - [Manipulasi DOM dengan JavaScript](#manipulasi-dom-dengan-javascript)
   - [Event Handling](#event-handling)
   - [Validasi JavaScript](#validasi-javascript)
2. [Server-side Programming](#server-side-programming)
   - [Pengelolaan Data dengan PHP](#pengelolaan-data-dengan-php)
   - [Objek PHP Berbasis OOP](#objek-php-berbasis-oop)
3. [Database Management](#database-management)
   - [Pembuatan Tabel Database](#pembuatan-tabel-database)
   - [Konfigurasi Koneksi Database](#konfigurasi-koneksi-database)
   - [Manipulasi Data pada Database](#manipulasi-data-pada-database)
4. [State Management](#state-management)
   - [State Management dengan Session](#state-management-dengan-session)
   - [Pengelolaan State dengan Cookie dan Browser Storage](#pengelolaan-state-dengan-cookie-dan-browser-storage)

## Client-side Programming

### Manipulasi DOM dengan JavaScript

#### Form Input
- File: `app/Views/form_registration.php`
- Elemen Input:
  - **Teks:** `<input type="text" id="name" ...>`
  - **Email:** `<input type="email" id="email" ...>`
  - **Checkbox:** `<input type="checkbox" name="agree_terms" ...>`
  - **Radio:** `<input type="radio" name="course_id" ...>`

#### Tabel HTML
- File: `app/Views/table_registrations.php`
- Menampilkan data server menggunakan PHP:

```php
<?php foreach ($registrations as $reg): ?>
<tr data-id="<?php echo $reg['id']; ?>">
    <td><?php echo $reg['id']; ?></td>
    <td><?php echo htmlspecialchars($reg['name']); ?></td>
    <!-- Tambahan data lainnya -->
</tr>
<?php endforeach; ?>
```

### Event Handling

#### Form Submit
- File: `script.js`

```javascript
registrationForm.addEventListener("submit", (e) => {
    e.preventDefault();
    // Validasi dan fetch ke server
});
```

#### Field Email (onblur)

```javascript
emailField.addEventListener("blur", () => {
    // Cek format email
});
```

#### Tabel (Edit/Hapus) dan Tombol Hapus Semua

```javascript
tableContainer.addEventListener("click", (e) => {
    // Handle tombol Edit dan Hapus
});

deleteAllBtn.addEventListener("click", () => {
    // Handle hapus semua
});
```

### Validasi JavaScript

- Validasi dilakukan di dalam `registrationForm.addEventListener("submit", ...)`.
- Validasi elemen input seperti nama, email, dan checkbox `agree_terms` sebelum memanggil fetch ke server.

## Server-side Programming

### Pengelolaan Data dengan PHP

#### Metode POST
- Form menggunakan metode `POST`:

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Logika pengolahan data
}
```

#### Validasi Server-side

```php
$name  = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
if (empty($name) || empty($email)) {
    return ['status' => 'error', 'message' => 'Mohon lengkapi semua data!'];
}
```

#### Simpan IP dan Browser

```php
$stmt->bindValue(':ip_address', $_SERVER['REMOTE_ADDR']);
$stmt->bindValue(':browser_info', $_SERVER['HTTP_USER_AGENT']);
```

### Objek PHP Berbasis OOP

#### Class `RegistrationController`

```php
class RegistrationController {
    public function store($data) {
        // Simpan data
    }
    public function update($id, $data) {
        // Update data
    }
    public function delete($id) {
        // Hapus data
    }
}
```

#### Class `RegistrationModel`

```php
class RegistrationModel {
    public function registerParticipant($data) {
        // Logika insert data ke database
    }
    public function getAllRegistrations() {
        // Logika fetch data dari database
    }
}
```

## Database Management

### Pembuatan Tabel Database

```sql
CREATE TABLE IF NOT EXISTS courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS registrations (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  course_id INT,
  ip_address VARCHAR(45),
  browser_info TEXT,
  FOREIGN KEY (course_id) REFERENCES courses(id)
);
```

### Konfigurasi Koneksi Database

- File: `config/database.php`

```php
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

### Manipulasi Data pada Database

- **Insert:** `RegistrationModel::registerParticipant()`
- **Select:** `RegistrationModel::getAllRegistrations()`
- **Update:** `RegistrationController::update()`
- **Delete:** `RegistrationController::delete()`
- **Delete All:** `RegistrationController::deleteAll()`

## State Management

### State Management dengan Session

- Gunakan `session_start()` di setiap file yang memerlukan session.
- Simpan informasi user:

```php
if ($response['status'] === 'success') {
    $_SESSION['registered_name'] = $_POST['name'] ?? '';
    $_SESSION['registered_email'] = $_POST['email'] ?? '';
}
```

### Pengelolaan State dengan Cookie dan Browser Storage

#### Cookie

```php
if (!empty($_POST['course_id'])) {
    setcookie('last_course', $_POST['course_id'], time() + (86400 * 7));
}
```

#### Local Storage

- File: `script.js`

```javascript
if (!localStorage.getItem("visited")) {
    localStorage.setItem("visited", "true");
    console.log("Selamat datang...");
}
