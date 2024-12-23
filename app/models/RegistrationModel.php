<?php
/**
 * File: app/Models/RegistrationModel.php
 * Deskripsi: Model untuk mengelola data pendaftar
 */

class RegistrationModel
{
    private $conn;

    public function __construct($pdo)
    {
        $this->conn = $apdo;
    }

    /**
     * Menyimpan data pendaftaran
     */
    public function registerParticipant($name, $email, $gender, $courseId, $agree, $ip, $browser)
    {
        // Generate ID (bisa pakai Auto Increment juga)
        $timeId = date('ymdHis');  // misal "230101123045"

        $sql = "INSERT INTO registrations 
                (id, name, email, gender, course_id, agree_terms, ip_address, browser_info)
                VALUES (:id, :name, :email, :gender, :course_id, :agree_terms, :ip_address, :browser_info)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $timeId);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':gender', $gender);
        $stmt->bindValue(':course_id', $courseId);
        $stmt->bindValue(':agree_terms', $agree);
        $stmt->bindValue(':ip_address', $ip);
        $stmt->bindValue(':browser_info', $browser);

        return $stmt->execute();
    }

    /**
     * Mendapatkan semua data pendaftar (join ke tabel courses)
     */
    public function getAllRegistrations()
    {
        $sql = "
            SELECT r.*, c.course_name 
            FROM registrations r
            JOIN courses c ON r.course_id = c.id
            ORDER BY r.created_at ASC
        ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
