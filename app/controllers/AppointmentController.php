<?php
require_once 'C:\xampp\htdocs\Clinique\config\database.php';
require_once 'C:\xampp\htdocs\Clinique\app\models\Appointment.php';

class AppointmentController {
    private $appointment;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->appointment = new Appointment($this->db);
    }

    public function listAppointments() {
        $result = $this->appointment->read();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function createAppointment($patient_id, $doctor_id, $appointment_date) {
        $this->appointment->patient_id = $patient_id;
        $this->appointment->doctor_id = $doctor_id;
        $this->appointment->appointment_date = $appointment_date;

        if ($this->appointment->create()) {
            echo "Rendez-vous créé avec succès.";
        } else {
            echo "Erreur lors de la création du rendez-vous.";
        }
    }

    public function updateAppointment($id, $patient_id, $doctor_id, $appointment_date) {
        $this->appointment->id = $id;
        $this->appointment->patient_id = $patient_id;
        $this->appointment->doctor_id = $doctor_id;
        $this->appointment->appointment_date = $appointment_date;

        if ($this->appointment->update()) {
            echo "Rendez-vous mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour du rendez-vous.";
        }
    }

    public function deleteAppointment($id) {
        $this->appointment->id = $id;

        if ($this->appointment->delete()) {
            echo "Rendez-vous supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du rendez-vous.";
        }
    }

    public function getAppointmentById($id) {
        $this->appointment->id = $id;
        return $this->appointment->getAppointmentById();
    }

    public function getAppointmentsByPatientId($patient_id) {
        $query = "SELECT * FROM appointments WHERE patient_id = :patient_id AND appointment_date > NOW() ORDER BY appointment_date ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPastAppointmentsByPatientId($patient_id) {
        return $this->appointment->findPastByPatientId($patient_id);
    }

    public function sortAppointments($appointments, $sortBy) {
        return $this->appointment->sortAppointments($appointments, $sortBy);
    }

    public function getStatsBySpeciality() {
        return $this->appointment->getStatsBySpeciality();
    }

    /*public function searchAppointments($criter) {
        return $this->appointment->searchAppointments($criter);
    }*/
    public function searchAppointments($criteria) {
        $query = "SELECT * FROM appointments WHERE 1=1";
        
        if (!empty($criteria['patient_id'])) {
            $query .= " AND patient_id = :patient_id";
        }
        
        if (!empty($criteria['doctor_id'])) {
            $query .= " AND doctor_id = :doctor_id";
        }
        
        $stmt = $this->db->prepare($query);
        
        // Bind parameters only if they are present in the criteria
        if (!empty($criteria['patient_id'])) {
            $stmt->bindParam(':patient_id', $criteria['patient_id'], PDO::PARAM_INT);
        }
        
        if (!empty($criteria['doctor_id'])) {
            $stmt->bindParam(':doctor_id', $criteria['doctor_id'], PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getStatsByMonth() {
        return $this->appointment->getStatsByMonth();
    }
    
    public function findByPatientId($patientId) {
        return $this->appointment->findByPatientId($patientId);
    }
}
