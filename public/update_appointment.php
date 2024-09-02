<?php
require_once '../app/controllers/AppointmentController.php';

$appointmentController = new AppointmentController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $appointment = $appointmentController->getAppointmentById($id);

    if (!$appointment) {
        echo "Rendez-vous non trouvé.";
        exit;
    }
} else {
    echo "ID du rendez-vous non spécifié.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $status = $_POST['status'];

    $appointmentController->updateAppointment($id, $patient_id, $doctor_id, $appointment_date, $status);
    header('Location: admin_appointments.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier Rendez-vous</title>
</head>
<body>
    <h1>Modifier Rendez-vous</h1>
    <form action="update_appointment.php?id=<?php echo $id; ?>" method="POST">
        <label for="patient_id">Patient ID:</label>
        <input type="text" id="patient_id" name="patient_id" value="<?php echo htmlspecialchars($appointment['patient_id']); ?>" required>
        <br>
        <label for="doctor_id">Doctor ID:</label>
        <input type="text" id="doctor_id" name="doctor_id" value="<?php echo htmlspecialchars($appointment['doctor_id']); ?>" required>
        <br>
        <label for="appointment_date">Date et Heure:</label>
        <input type="datetime-local" id="appointment_date" name="appointment_date" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($appointment['appointment_date']))); ?>" required>
        <br>
        <label for="status">Statut:</label>
        <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($appointment['status']); ?>" required>
        <br>
        <input type="submit" value="Mettre à jour">
    </form>
</body>
</html>
