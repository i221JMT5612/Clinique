<?php
require_once '../app/models/MedicalRecord.php';

class MedicalRecordController {
    private $db;
    private $record;

    public function __construct($db) {
        $this->db = $db;
        $this->record = new MedicalRecord($this->db);
    }

    public function listRecords() {
        return $this->record->read();
    }

    public function createRecord($patient_id, $doctor_id, $diagnosis, $treatment) {
        $this->record->patient_id = $patient_id;
        $this->record->doctor_id = $doctor_id;
        $this->record->diagnosis = $diagnosis;
        $this->record->treatment = $treatment;

        if ($this->record->create()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateRecord($id, $patient_id, $doctor_id, $diagnosis, $treatment) {
        $this->record->id = $id;
        $this->record->patient_id = $patient_id;
        $this->record->doctor_id = $doctor_id;
        $this->record->diagnosis = $diagnosis;
        $this->record->treatment = $treatment;

        if ($this->record->update()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteRecord($id) {
        $this->record->id = $id;

        if ($this->record->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public function getRecordById($id) {
        return $this->record->findById($id);
    }
}
