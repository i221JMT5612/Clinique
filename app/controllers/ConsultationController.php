<?php
require_once '../app/models/Consultation.php';

class ConsultationController {
    private $db;
    private $consultation;

    public function __construct($db) {
        $this->db = $db;
        $this->consultation = new Consultation($this->db);
    }

    public function listConsultations() {
        return $this->consultation->read();
    }

    public function createConsultation($patient_id, $doctor_id, $consultation_date, $notes) {
        $this->consultation->patient_id = $patient_id;
        $this->consultation->doctor_id = $doctor_id;
        $this->consultation->consultation_date = $consultation_date;
        $this->consultation->notes = $notes;

        return $this->consultation->create();
    }

    public function getConsultationById($id) {
        return $this->consultation->readOne($id);
    }

    public function updateConsultation($id, $patient_id, $doctor_id, $consultation_date, $notes) {
        $this->consultation->id = $id;
        $this->consultation->patient_id = $patient_id;
        $this->consultation->doctor_id = $doctor_id;
        $this->consultation->consultation_date = $consultation_date;
        $this->consultation->notes = $notes;

        return $this->consultation->update();
    }

    public function deleteConsultation($id) {
        $this->consultation->id = $id;
        return $this->consultation->delete();
    }
}
?>
