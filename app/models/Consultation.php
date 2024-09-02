<?php
class Consultation {
    private $conn;
    private $table = 'consultations';

    public $id;
    public $patient_id;
    public $doctor_id;
    public $consultation_date;
    public $notes;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET patient_id = :patient_id, doctor_id = :doctor_id, consultation_date = :consultation_date, notes = :notes';
        $stmt = $this->conn->prepare($query);

        $this->patient_id = htmlspecialchars(strip_tags($this->patient_id));
        $this->doctor_id = htmlspecialchars(strip_tags($this->doctor_id));
        $this->consultation_date = htmlspecialchars(strip_tags($this->consultation_date));
        $this->notes = htmlspecialchars(strip_tags($this->notes));

        $stmt->bindParam(':patient_id', $this->patient_id);
        $stmt->bindParam(':doctor_id', $this->doctor_id);
        $stmt->bindParam(':consultation_date', $this->consultation_date);
        $stmt->bindParam(':notes', $this->notes);

        return $stmt->execute();
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET patient_id = :patient_id, doctor_id = :doctor_id, consultation_date = :consultation_date, notes = :notes WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->patient_id = htmlspecialchars(strip_tags($this->patient_id));
        $this->doctor_id = htmlspecialchars(strip_tags($this->doctor_id));
        $this->consultation_date = htmlspecialchars(strip_tags($this->consultation_date));
        $this->notes = htmlspecialchars(strip_tags($this->notes));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':patient_id', $this->patient_id);
        $stmt->bindParam(':doctor_id', $this->doctor_id);
        $stmt->bindParam(':consultation_date', $this->consultation_date);
        $stmt->bindParam(':notes', $this->notes);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    /*public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }*/

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
