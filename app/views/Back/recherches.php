<?php
require_once 'C:\xampp\htdocs\Clinique\app\controllers\AppointmentController.php';
require_once 'C:\xampp\htdocs\Clinique\app\controllers\PatientController.php';
include_once 'C:\xampp\htdocs\Clinique\app\templates\header.php';

// Créer les instances des contrôleurs
$appointmentController = new AppointmentController();
$patientController = new PatientController();

// Gestion des critères de recherche et de tri
$criteria = [];
if (isset($_GET['search_patient'])) {
    $criteria['name'] = $_GET['name'] ?? '';
    $criteria['created_at'] = $_GET['created_at'] ?? '';
}

if (isset($_GET['search_appointment'])) {
    $criteria['patient_id'] = $_GET['patient_id'] ?? '';
    $criteria['doctor_id'] = $_GET['doctor_id'] ?? '';
}

// Recherche et tri des patients
$patients = $patientController->searchAndSortPatients($criteria);
$appointments = $appointmentController->searchAppointments($criteria);
?>

<h2>Recherche et Tri des Patients</h2>
<form action="recherches.php" method="GET">
    <h3>Rechercher des Patients</h3>
    <label for="name">Nom:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($criteria['name'] ?? ''); ?>">
    <br>
    <label for="created_at">Date d'inscription:</label>
    <input type="date" id="created_at" name="created_at" value="<?php echo htmlspecialchars($criteria['created_at'] ?? ''); ?>">
    <br>
    <input type="submit" name="search_patient" value="Rechercher Patients">
</form>

<h3>Résultats de la Recherche des Patients</h3>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Date d'inscription</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($patients)): ?>
            <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?php echo $patient['id']; ?></td>
                    <td><?php echo htmlspecialchars($patient['name']); ?></td>
                    <td><?php echo htmlspecialchars($patient['email']); ?></td>
                    <td><?php echo htmlspecialchars($patient['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Aucun patient trouvé.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<h2>Recherche et Tri des Consultations</h2>
<form action="recherches.php" method="GET">
    <h3>Rechercher des Consultations</h3>
    <label for="patient_id">ID Patient:</label>
    <input type="text" id="patient_id" name="patient_id" value="<?php echo htmlspecialchars($criteria['patient_id'] ?? ''); ?>">
    <br>
    <label for="doctor_id">ID Médecin:</label>
    <input type="text" id="doctor_id" name="doctor_id" value="<?php echo htmlspecialchars($criteria['doctor_id'] ?? ''); ?>">
    <br>
    <input type="submit" name="search_appointment" value="Rechercher Consultations">
</form>

<h3>Résultats de la Recherche des Consultations</h3>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Patient</th>
            <th>ID Médecin</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($appointments)): ?>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?php echo $appointment['id']; ?></td>
                    <td><?php echo htmlspecialchars($appointment['patient_id']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['doctor_id']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Aucune consultation trouvée.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>