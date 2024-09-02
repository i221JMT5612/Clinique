<?php
require_once '../app/controllers/AppointmentController.php';
include_once '../app/templates/header.php';

$appointmentController = new AppointmentController();
$appointments = $appointmentController->listAppointments();
?>

<h2>Liste des Rendez-vous</h2>
<nav>
    <ul>
        <li><a href="create_appointment.php?action=create">Ajouter un Rendez-vous</a></li>
    </ul>
</nav>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Patient</th>
            <th>ID Médecin</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($appointments)): ?>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?php echo $appointment['id']; ?></td>
                    <td><?php echo $appointment['patient_id']; ?></td>
                    <td><?php echo $appointment['doctor_id']; ?></td>
                    <td><?php echo $appointment['appointment_date']; ?></td>
                    <td><?php echo $appointment['status']; ?></td>
                    <td>
                        <a href="update_appointment.php?id=<?php echo $appointment['id']; ?>">Modifier</a>
                        <a href="delete_appointment.php?id=<?php echo $appointment['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Aucun rendez-vous trouvé.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include_once '../app/templates/footer.php'; ?>
