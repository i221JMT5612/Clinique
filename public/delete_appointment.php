<?php
require_once '../app/controllers/AppointmentController.php';

$appointmentController = new AppointmentController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $appointmentController->deleteAppointment($id);
    header('Location: admin_appointments.php');
} else {
    echo "ID du rendez-vous non spécifié.";
}
?>
