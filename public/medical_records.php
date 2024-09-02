<?php
require_once '../config/database.php';
require_once '../app/controllers/MedicalRecordController.php';
include_once '../app/templates/header.php';

// Établir la connexion à la base de données
$database = new Database();
$db = $database->connect();

// Créer une instance du contrôleur avec la connexion à la base de données
$controller = new MedicalRecordController($db);

// Récupérer la liste des dossiers médicaux
$records = $controller->listRecords();
?>

<h2>Liste des Dossiers Médicaux</h2>
<nav>
        <ul>
            <li><a href="create_medical_record.php?action=create">Ajouter un dossier medical</a></li>
        </ul>
    </nav>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Patient ID</th>
            <th>Doctor ID</th>
            <th>Diagnostic</th>
            <th>Traitement</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($records)): ?>
            <?php foreach ($records as $record): ?>
                <tr>
                    <td><?php echo $record['id']; ?></td>
                    <td><?php echo $record['patient_id']; ?></td>
                    <td><?php echo $record['doctor_id']; ?></td>
                    <td><?php echo $record['diagnosis']; ?></td>
                    <td><?php echo $record['treatment']; ?></td>
                    <td>
                        <a href="update_record.php?id=<?php echo $record['id']; ?>">Modifier</a>
                        <a href="delete_record.php?id=<?php echo $record['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce dossier médical ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Aucun dossier médical trouvé.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
include_once '../app/templates/footer.php';
?>
