<?php
require_once 'C:\xampp\htdocs\Clinique\config\database.php';
require_once 'C:\xampp\htdocs\Clinique\app\models\Patient.php';

class PatientController {
    private $db;
    private $patient;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->patient = new Patient($this->db);
    }

    public function listPatients() {
        $result = $this->patient->read();
        $patients = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($patients as $patient) {
            echo 'Name: ' . $patient['name'] . ' | Email: ' . $patient['email'] . '<br>';
        }
    }

    public function createPatient($name, $email) {
        $this->patient->name = $name;
        $this->patient->email = $email;
        if ($this->patient->create()) {
            echo "Patient created successfully.";
        } else {
            echo "Error creating patient.";
        }
    }

    public function updatePatient($id, $name, $email) {
        $this->patient->id = $id;
        $this->patient->name = $name;
        $this->patient->email = $email;
        if ($this->patient->update()) {
            echo "Patient updated successfully.";
        } else {
            echo "Error updating patient.";
        }
    }

    public function deletePatient($id) {
        $this->patient->id = $id;
        if ($this->patient->delete()) {
            echo "Patient deleted successfully.";
        } else {
            echo "Error deleting patient.";
        }
    }

    public function searchPatients($keyword) {
        $result = $this->patient->search($keyword);
        $patients = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($patients as $patient) {
            echo 'Name: ' . $patient['name'] . ' | Email: ' . $patient['email'] . '<br>';
        }
    }

    public function searchAndSortPatients($criteria) {
        return $this->patient->searchAndSort($criteria);
    }

    public function getPatientsCountByMonth() {
        return $this->patient->getCountByMonth();
    }

    public function getPatientById($id) {
        $query = "SELECT * FROM patients WHERE id = :id LIMIT 0,1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();        
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);
        return $patient;
    }
}
