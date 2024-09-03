<?php
class MedicalRecord {
    private $conn;
    private $table = 'medical_records';

    public $id;
    public $patient_id;
    public $doctor_id;
    public $diagnosis;
    public $treatment;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($patient_id, $doctor_id, $diagnosis, $treatment) {
        $patientCheckQuery = "SELECT COUNT(*) FROM patients WHERE id = :patient_id";
        $stmt = $this->conn->prepare($patientCheckQuery);
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->execute();
        $patientExists = $stmt->fetchColumn();
        if (!$patientExists) {
            throw new Exception("Le patient avec ID $patient_id n'existe pas.");
        }
        $doctorCheckQuery = "SELECT COUNT(*) FROM doctors WHERE id = :doctor_id";
        $stmt = $this->conn->prepare($doctorCheckQuery);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->execute();
        $doctorExists = $stmt->fetchColumn();
        if (!$doctorExists) {
            throw new Exception("Le médecin avec ID $doctor_id n'existe pas.");
        }
        $query = "INSERT INTO " . $this->table . " (patient_id, doctor_id, diagnosis, treatment) VALUES (:patient_id, :doctor_id, :diagnosis, :treatment)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':diagnosis', $diagnosis);
        $stmt->bindParam(':treatment', $treatment);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function update() {
        $query = "UPDATE " . $this->table . " SET patient_id = :patient_id, doctor_id = :doctor_id, diagnosis = :diagnosis, treatment = :treatment WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':patient_id', $this->patient_id);
        $stmt->bindParam(':doctor_id', $this->doctor_id);
        $stmt->bindParam(':diagnosis', $this->diagnosis);
        $stmt->bindParam(':treatment', $this->treatment);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
