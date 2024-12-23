<?php
/**
 * File: public/api.php
 * Deskripsi: Endpoint untuk store, update, delete satu data, dan delete semua data pendaftar
 */
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Controllers/RegistrationController.php';

// Buat instance controller
$controller = new RegistrationController($pdo);

// Hanya terima method POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';

    // 1. Menyimpan data (store)
    if ($action === 'store') {
        $response = $controller->store();

        // Jika sukses, simpan data ke session
        if ($response['status'] === 'success') {
            $_SESSION['registered_name']  = $_POST['name']  ?? '';
            $_SESSION['registered_email'] = $_POST['email'] ?? '';
        }

        // Set cookie kursus terakhir
        if (!empty($_POST['course_id'])) {
            setcookie('last_course', $_POST['course_id'], time() + (86400 * 7));
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // 2. Memperbarui data (update)
    if ($action === 'update') {
        // Baca data dari body (JSON)
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id'], $data['name'], $data['email'], $data['gender'], $data['course_id'])) {
            $response = $controller->update($data);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            // Data tidak lengkap
            header('Content-Type: application/json');
            echo json_encode([
                'status'  => 'error',
                'message' => 'Data tidak lengkap untuk update'
            ]);
            exit;
        }
    }

    // 3. Menghapus satu data (delete)
    if ($action === 'delete') {
        $id = $_GET['id'] ?? 0;
        $response = $controller->delete($id);

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // 4. Menghapus semua data (delete_all)
    if ($action === 'delete_all') {
        $response = $controller->deleteAll();

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

// Jika bukan POST
http_response_code(405);
header('Content-Type: application/json');
echo json_encode([
    'status'  => 'error',
    'message' => 'Metode HTTP tidak diizinkan'
]);
exit;
