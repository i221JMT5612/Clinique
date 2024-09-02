<?php
require_once '../config/database.php';
require_once '../app/controllers/ConsultationController.php';
include_once '../app/templates/header.php';

$database = new Database();
$db = $database->connect();
$consultationController = new ConsultationController($db);

// Vérifiez l'action demandée
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'create':
        // Créer une nouvelle consultation
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
            $doctor_id = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : '';
            $consultation_date = isset($_POST['consultation_date']) ? $_POST['consultation_date'] : '';
            $notes = isset($_POST['notes']) ? $_POST['notes'] : '';

            if ($consultationController->createConsultation($patient_id, $doctor_id, $consultation_date, $notes)) {
                echo 'Consultation ajoutée avec succès.';
                header('Location: consultations.php');
                exit();
            } else {
                echo 'Erreur lors de l\'ajout de la consultation.';
            }
        }
        break;

    case 'update':
        // Mettre à jour une consultation
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
                $doctor_id = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : '';
                $consultation_date = isset($_POST['consultation_date']) ? $_POST['consultation_date'] : '';
                $notes = isset($_POST['notes']) ? $_POST['notes'] : '';

                if ($consultationController->updateConsultation($id, $patient_id, $doctor_id, $consultation_date, $notes)) {
                    header('Location: consultations.php');
                    exit();
                } else {
                    echo 'Erreur lors de la mise à jour de la consultation.';
                }
            } else {
                $consultation = $consultationController->getConsultationById($id);
                if (!$consultation) {
                    die('Consultation non trouvée.');
                }
            }
        }
        break;

    case 'delete':
        // Supprimer une consultation
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($consultationController->deleteConsultation($id)) {
                header('Location: consultations.php');
                exit();
            } else {
                echo 'Erreur lors de la suppression de la consultation.';
            }
        }
        break;

    default:
        // Afficher la liste des consultations
        $consultations = $consultationController->listConsultations();
        break;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Consultations</title>
</head>
<body>
    <h1>Gestion des Consultations</h1>
    <nav>
        <ul>
            <li><a href="consultations.php?action=create">Ajouter une consultation</a></li>
        </ul>
    </nav>

    <?php if ($action === 'create' || $action === 'update'): ?>
        <h2><?php echo $action === 'create' ? 'Ajouter une consultation' : 'Modifier une consultation'; ?></h2>
        <form action="consultations.php?action=<?php echo $action; ?><?php echo isset($id) ? '&id=' . htmlspecialchars($id) : ''; ?>" method="POST">
            <label for="patient_id">ID Patient:</label>
            <input type="text" id="patient_id" name="patient_id" value="<?php echo htmlspecialchars($consultation['patient_id'] ?? ''); ?>" required>
            <br>

            <label for="doctor_id">ID Médecin:</label>
            <input type="text" id="doctor_id" name="doctor_id" value="<?php echo htmlspecialchars($consultation['doctor_id'] ?? ''); ?>" required>
            <br>

            <label for="consultation_date">Date de Consultation:</label>
            <input type="date" id="consultation_date" name="consultation_date" value="<?php echo htmlspecialchars($consultation['consultation_date'] ?? ''); ?>" required>
            <br>

            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes" required><?php echo htmlspecialchars($consultation['notes'] ?? ''); ?></textarea>
            <br>

            <input type="submit" value="<?php echo $action === 'create' ? 'Ajouter' : 'Mettre à jour'; ?>">
        </form>
    <?php else: ?>
        <?php if (is_array($consultations) || is_object($consultations)): ?>
            <h2>Liste des Consultations</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Patient</th>
                        <th>ID Médecin</th>
                        <th>Date de Consultation</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultations as $consultation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($consultation['id']); ?></td>
                            <td><?php echo htmlspecialchars($consultation['patient_id']); ?></td>
                            <td><?php echo htmlspecialchars($consultation['doctor_id']); ?></td>
                            <td><?php echo htmlspecialchars($consultation['consultation_date']); ?></td>
                            <td><?php echo htmlspecialchars($consultation['notes']); ?></td>
                            <td>
                                <a href="consultations.php?action=update&id=<?php echo htmlspecialchars($consultation['id']); ?>">Modifier</a>
                                <a href="delete_consultation.php?id=<?php echo $consultation['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette consultation ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune consultation trouvée.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
