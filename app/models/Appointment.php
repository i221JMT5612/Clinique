<?php
class Appointment {
    private $conn;
    private $table = 'appointments';

    public $id;
    public $patient_id;
    public $doctor_id;
    public $appointment_date;

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
        $query = 'INSERT INTO ' . $this->table . ' SET patient_id = :patient_id, doctor_id = :doctor_id, appointment_date = :appointment_date';
        $stmt = $this->conn->prepare($query);
        $this->patient_id = htmlspecialchars(strip_tags($this->patient_id));
        $this->doctor_id = htmlspecialchars(strip_tags($this->doctor_id));
        $this->appointment_date = htmlspecialchars(strip_tags($this->appointment_date));
        $stmt->bindParam(':patient_id', $this->patient_id);
        $stmt->bindParam(':doctor_id', $this->doctor_id);
        $stmt->bindParam(':appointment_date', $this->appointment_date);
        return $stmt->execute();
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET patient_id = :patient_id, doctor_id = :doctor_id, appointment_date = :appointment_date WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->patient_id = htmlspecialchars(strip_tags($this->patient_id));
        $this->doctor_id = htmlspecialchars(strip_tags($this->doctor_id));
        $this->appointment_date = htmlspecialchars(strip_tags($this->appointment_date));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':patient_id', $this->patient_id);
        $stmt->bindParam(':doctor_id', $this->doctor_id);
        $stmt->bindParam(':appointment_date', $this->appointment_date);
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

    public function findPastByPatientId($patient_id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE patient_id = :patient_id AND appointment_date < NOW() ORDER BY appointment_date DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchAppointments($criter = []) {
        $query = 'SELECT appointments.*, patients.name AS patient_name, doctors.name AS doctor_name, doctors.speciality AS doctor_speciality
                  FROM appointments
                  JOIN patients ON appointments.patient_id = patients.id
                  JOIN doctors ON appointments.doctor_id = doctors.id
                  WHERE 1=1';
        if (!empty($criter['patient_name'])) {
            $query .= ' AND patients.name LIKE :patient_name';
        }
        if (!empty($criter['doctor_speciality'])) {
            $query .= ' AND doctors.speciality LIKE :doctor_speciality';
        }
        if (!empty($criter['appointment_date'])) {
            $query .= ' AND appointments.appointment_date = :appointment_date';
        }
        $stmt = $this->conn->prepare($query);
        if (!empty($criter['patient_name'])) {
            $stmt->bindValue(':patient_name', '%' . $criter['patient_name'] . '%');
        }
        if (!empty($criter['doctor_speciality'])) {
            $stmt->bindValue(':doctor_speciality', '%' . $criter['doctor_speciality'] . '%');
        }
        if (!empty($criter['appointment_date'])) {
            $stmt->bindValue(':appointment_date', $criter['appointment_date']);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function sortAppointments($appointments, $sortBy) {
        usort($appointments, function ($a, $b) use ($sortBy) {
            return strcmp($a[$sortBy], $b[$sortBy]);
        });
        return $appointments;
    }
    
    public function getStatsBySpeciality() {
        $query = 'SELECT doctors.speciality, COUNT(appointments.id) as count
                  FROM appointments
                  JOIN doctors ON appointments.doctor_id = doctors.id
                  GROUP BY doctors.speciality';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function getStatsByMonth() {
        $query = 'SELECT DATE_FORMAT(appointment_date, "%Y-%m") as month, COUNT(id) as count FROM appointments GROUP BY month';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByPatientId($patientId) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE patient_id = :patient_id ORDER BY appointment_date DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':patient_id', $patientId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
