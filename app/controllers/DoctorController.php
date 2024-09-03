<?php
require_once 'C:\xampp\htdocs\Clinique\app\models\Doctor.php';

class DoctorController {
    private $doctor;

    public function __construct($db) {
        $this->doctor = new Doctor($db);
    }

    public function createDoctor($name, $email, $speciality) {
        return $this->doctor->createDoctor($name, $email, $speciality);
    }

    public function getAllDoctors() {
        return $this->doctor->getAllDoctors();
    }

    public function getDoctorById($id) {
        return $this->doctor->getDoctorById($id);
    }

    public function updateDoctor($id, $name, $email, $speciality) {
        return $this->doctor->updateDoctor($id, $name, $email, $speciality);
    }

    public function deleteDoctor($id) {
        return $this->doctor->deleteDoctor($id);
    }
}

?>
