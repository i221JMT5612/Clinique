<?php
class Appointment {
    private $conn;
    private $table = 'appointments';

    public $id;
    public $patient_id;
    public $doctor_id;
    public $appointment_date;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY appointment_date DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET patient_id = :patient_id, doctor_id = :doctor_id, appointment_date = :appointment_date, status = :status';
        $stmt = $this->conn->prepare($query);

        $this->patient_id = htmlspecialchars(strip_tags($this->patient_id));
        $this->doctor_id = htmlspecialchars(strip_tags($this->doctor_id));
        $this->appointment_date = htmlspecialchars(strip_tags($this->appointment_date));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(':patient_id', $this->patient_id);
        $stmt->bindParam(':doctor_id', $this->doctor_id);
        $stmt->bindParam(':appointment_date', $this->appointment_date);
        $stmt->bindParam(':status', $this->status);

        return $stmt->execute();
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET patient_id = :patient_id, doctor_id = :doctor_id, appointment_date = :appointment_date, status = :status WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->patient_id = htmlspecialchars(strip_tags($this->patient_id));
        $this->doctor_id = htmlspecialchars(strip_tags($this->doctor_id));
        $this->appointment_date = htmlspecialchars(strip_tags($this->appointment_date));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':patient_id', $this->patient_id);
        $stmt->bindParam(':doctor_id', $this->doctor_id);
        $stmt->bindParam(':appointment_date', $this->appointment_date);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function getAppointmentById() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByPatientId() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE patient_id = :patient_id ORDER BY appointment_date DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':patient_id', $this->patient_id);
        $stmt->execute();
        return $stmt; // Retourne PDOStatement pour être utilisé avec rowCount() et fetch()
    }
    
}
