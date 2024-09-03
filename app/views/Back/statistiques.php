<?php
require_once 'C:\xampp\htdocs\Clinique\app\controllers\AppointmentController.php';
require_once 'C:\xampp\htdocs\Clinique\app\controllers\PatientController.php';
include_once 'C:\xampp\htdocs\Clinique\app\templates\header.php';

// Créer les instances des contrôleurs
$appointmentController = new AppointmentController();
$patientController = new PatientController();

// Récupérer les statistiques
$appointmentsStats = $appointmentController->getStatsByMonth();
$patientsStats = $patientController->getPatientsCountByMonth();
?>

<h2>Statistiques</h2>

<h3>Nombre de Consultations par Mois</h3>
<table border="1">
    <thead>
        <tr>
            <th>Mois</th>
            <th>Nombre de Consultations</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($appointmentsStats)): ?>
            <?php foreach ($appointmentsStats as $stat): ?>
                <tr>
                    <td><?php echo htmlspecialchars($stat['month']); ?></td>
                    <td><?php echo htmlspecialchars($stat['count']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">Aucune donnée trouvée.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<h3>Nombre de Patients par Mois</h3>
<table border="1">
    <thead>
        <tr>
            <th>Mois</th>
            <th>Nombre de Patients</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($patientsStats)): ?>
            <?php foreach ($patientsStats as $stat): ?>
                <tr>
                    <td><?php echo htmlspecialchars($stat['month']); ?></td>
                    <td><?php echo htmlspecialchars($stat['count']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">Aucune donnée trouvée.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>