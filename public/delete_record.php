<?php
require_once '../config/database.php'; // Inclusion du fichier de configuration de la base de données
require_once '../app/controllers/MedicalRecordController.php'; // Inclusion du contrôleur

// Vérifiez que l'ID du dossier médical est bien passé en paramètre
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Instanciez le contrôleur des dossiers médicaux
    $database = new Database();
    $db = $database->connect();
    $controller = new MedicalRecordController($db);

    // Supprimez le dossier médical
    if ($controller->deleteRecord($id)) {
        // Redirigez vers la page de liste des dossiers médicaux avec un message de succès
        header('Location: medical_records.php?message=deleted');
        exit;
    } else {
        // Redirigez vers la page de liste des dossiers médicaux avec un message d'erreur
        header('Location: medical_records.php?message=error');
        exit;
    }
} else {
    // Si l'ID n'est pas fourni, redirigez vers la page de liste des dossiers médicaux
    header('Location: medical_records.php');
    exit;
}
?>
