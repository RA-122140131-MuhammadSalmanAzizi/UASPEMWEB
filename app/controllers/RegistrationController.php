<?php
/**
 * File: app/Controllers/RegistrationController.php
 * Deskripsi: Controller untuk CRUD data pendaftaran
 */
require_once __DIR__ . '/../../app/Models/RegistrationModel.php';

class RegistrationController
{
    private $pdo;   // Menyimpan instance PDO
    private $model; // Model

    public function __construct($pdo)
    {
        $this->pdo   = $pdo;                       
        $this->model = new RegistrationModel($pdo);
    }

    /**
     * Menyimpan data pendaftaran baru
     */
    public function store()
    {
        // Ambil data POST
        $name     = $_POST['name']     ?? '';
        $email    = $_POST['email']    ?? '';
        $gender   = $_POST['gender']   ?? '';
        $courseId = $_POST['course_id'] ?? '';
        $agree    = isset($_POST['agree_terms']) ? 1 : 0;

        // Validasi sederhana
        if (empty($name) || empty($email) || empty($gender) || empty($courseId)) {
            return [
                'status'  => 'error',
                'message' => 'Mohon lengkapi semua data!'
            ];
        }

        // Dapatkan IP & Browser
        $ip      = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN_IP';
        $browser = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN_BROWSER';

        // Insert ke database via model
        $result = $this->model->registerParticipant(
            $name, $email, $gender, (int)$courseId, $agree, $ip, $browser
        );

        if ($result) {
            return [
                'status'  => 'success',
                'message' => 'Pendaftaran berhasil!'
            ];
        }

        return [
            'status'  => 'error',
            'message' => 'Terjadi kesalahan saat mendaftar.'
        ];
    }

    /**
     * Mendapatkan semua data pendaftaran
     */
    public function index()
    {
        return $this->model->getAllRegistrations();
    }

    /**
     * Update data pendaftaran
     */
    public function update($data)
    {
        $id        = $data['id'];
        $name      = $data['name'];
        $email     = $data['email'];
        $gender    = $data['gender'];
        $course_id = $data['course_id'];

        // Validasi sederhana
        if (empty($id) || empty($name) || empty($email) || empty($gender) || empty($course_id)) {
            return ['status' => 'error', 'message' => 'Data tidak lengkap'];
        }

        // Lakukan Update
        try {
            $stmt = $this->pdo->prepare("
                UPDATE registrations
                SET name = :name, 
                    email = :email, 
                    gender = :gender, 
                    course_id = :course_id
                WHERE id = :id
            ");
            $stmt->execute([
                ':id'        => $id,
                ':name'      => $name,
                ':email'     => $email,
                ':gender'    => $gender,
                ':course_id' => $course_id
            ]);

            return ['status' => 'success', 'message' => 'Data berhasil diperbarui'];
        } catch (PDOException $e) {
            return [
                'status'  => 'error',
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Hapus data pendaftaran
     */
    public function delete($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM registrations WHERE id = :id");
            $stmt->execute([':id' => $id]);

            return ['status' => 'success', 'message' => 'Data berhasil dihapus'];
        } catch (PDOException $e) {
            return [
                'status'  => 'error',
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ];
        }
    }


    public function deleteAll()
{
    try {
        // Pilihan A: TRUNCATE (mengosongkan + reset Auto Increment)
        // $stmt = $this->pdo->prepare("TRUNCATE TABLE registrations");
        
        // Pilihan B: DELETE semua baris
        $stmt = $this->pdo->prepare("DELETE FROM registrations");
        
        $stmt->execute();
        return [
            'status'  => 'success',
            'message' => 'Semua data berhasil dihapus'
        ];
    } catch (PDOException $e) {
        return [
            'status'  => 'error',
            'message' => 'Gagal menghapus semua data: ' . $e->getMessage()
        ];
    }
}


}
