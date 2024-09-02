<?php
require_once '../config/database.php';
require_once '../app/models/Appointment.php';

class AppointmentController {
    private $appointment;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->appointment = new Appointment($db);
    }

    /*public function listAppointments() {
        $result = $this->appointment->read();
        $appointments = $result->fetchAll(PDO::FETCH_ASSOC);

        if ($appointments) {
            foreach ($appointments as $appointment) {
                echo "<tr>";
                echo "<td>{$appointment['id']}</td>";
                echo "<td>{$appointment['patient_id']}</td>";
                echo "<td>{$appointment['doctor_id']}</td>";
                echo "<td>{$appointment['appointment_date']}</td>";
                echo "<td>{$appointment['status']}</td>";
                echo "<td><a href='update_appointment.php?id={$appointment['id']}'>Modifier</a> <a href='delete_appointment.php?id={$appointment['id']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce rendez-vous ?\");'>Supprimer</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Aucun rendez-vous trouvé.</td></tr>";
        }
    }*/

    public function listAppointments() {
        $result = $this->appointment->read();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function createAppointment($patient_id, $doctor_id, $appointment_date, $status) {
        $this->appointment->patient_id = $patient_id;
        $this->appointment->doctor_id = $doctor_id;
        $this->appointment->appointment_date = $appointment_date;
        $this->appointment->status = $status;

        if ($this->appointment->create()) {
            echo "Rendez-vous créé avec succès.";
        } else {
            echo "Erreur lors de la création du rendez-vous.";
        }
    }

    public function updateAppointment($id, $patient_id, $doctor_id, $appointment_date, $status) {
        $this->appointment->id = $id;
        $this->appointment->patient_id = $patient_id;
        $this->appointment->doctor_id = $doctor_id;
        $this->appointment->appointment_date = $appointment_date;
        $this->appointment->status = $status;

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
        $this->appointment->patient_id = $patient_id;
        return $this->appointment->findByPatientId();
    }
}
