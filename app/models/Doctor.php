<?php
class Doctor {
    private $db;
    private $table = 'doctors';

    public function __construct($db) {
        $this->db = $db;
    }

    public function createDoctor($name, $email, $speciality) {
        $query = "INSERT INTO " . $this->table . " (name, email, speciality, created_at) VALUES (:name, :email, :speciality, NOW())";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':speciality', $speciality);

        return $stmt->execute();
    }

    public function getAllDoctors() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDoctorById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateDoctor($id, $name, $email, $speciality) {
        $query = "UPDATE " . $this->table . " SET name = :name, email = :email, speciality = :speciality WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':speciality', $speciality);
        return $stmt->execute();
    }

    public function deleteDoctor($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
