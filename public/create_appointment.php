<?php
require_once '../config/database.php';
require_once '../app/controllers/AppointmentController.php';
include_once '../app/templates/header.php';

$database = new Database();
$db = $database->connect();
$appointmentController = new AppointmentController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $status = $_POST['status'];

    $appointmentController->createAppointment($patient_id, $doctor_id, $appointment_date, $status);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Créer un Rendez-vous</title>
</head>
<body>
    <h1>Créer un Rendez-vous</h1>
    <form action="create_appointment.php" method="POST">
        <label for="patient_id">Patient ID:</label>
        <input type="text" id="patient_id" name="patient_id" required>
        <br>
        <label for="doctor_id">Doctor ID:</label>
        <input type="text" id="doctor_id" name="doctor_id" required>
        <br>
        <label for="appointment_date">Date et Heure:</label>
        <input type="datetime-local" id="appointment_date" name="appointment_date" required>
        <br>
        <label for="status">Statut:</label>
        <input type="text" id="status" name="status" required>
        <br>
        <input type="submit" value="Créer">
    </form>
</body>
</html>
