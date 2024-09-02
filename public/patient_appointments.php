<?php
require_once '../app/controllers/AppointmentController.php';
include_once '../app/templates/header.php';

$appointmentController = new AppointmentController();
$patient_id = 1; // Exemple d'ID patient, devrait être dynamiquement défini en fonction du patient connecté

// Gestion de la soumission du formulaire pour la création d'un nouveau rendez-vous
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_appointment'])) {
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $status = 'scheduled'; // Statut par défaut

    $appointmentController->createAppointment($patient_id, $doctor_id, $appointment_date, $status);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient - Mes Rendez-vous</title>
</head>
<body>
    <h1>Mes Rendez-vous</h1>
    
    <!-- Formulaire pour réserver un nouveau rendez-vous -->
    <h2>Réserver un Nouveau Rendez-vous</h2>
    <form action="patient_appointments.php" method="POST">
        <label for="doctor_id">ID Médecin:</label>
        <input type="text" id="doctor_id" name="doctor_id" required>
        <br>
        <label for="appointment_date">Date et Heure du Rendez-vous:</label>
        <input type="datetime-local" id="appointment_date" name="appointment_date" required>
        <br>
        <input type="submit" name="create_appointment" value="Réserver Rendez-vous">
    </form>

    <!-- Afficher la liste des rendez-vous actuels -->
    <h2>Mes Rendez-vous à Venir</h2>
    <?php
    // Appelle la méthode pour récupérer les rendez-vous
    $result = $appointmentController->getAppointmentsByPatientId($patient_id);

    // Vérifie si des rendez-vous ont été récupérés
    if ($result && $result->rowCount() > 0) {
        echo '<table border="1">
                <tr>
                    <th>ID Médecin</th>
                    <th>Date et Heure</th>
                    <th>Statut</th>
                </tr>';
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['doctor_id']) . '</td>
                    <td>' . htmlspecialchars($row['appointment_date']) . '</td>
                    <td>' . htmlspecialchars($row['status']) . '</td>
                </tr>';
        }
        echo '</table>';
    } else {
        echo '<p>Vous n\'avez aucun rendez-vous à venir.</p>';
    }
    ?>
</body>
</html>
