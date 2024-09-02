<?php
require_once '../config/database.php';
require_once '../app/controllers/ConsultationController.php';

$database = new Database();
$db = $database->connect();
$controller = new ConsultationController($db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($controller->deleteConsultation($id)) {
        header('Location: consultations.php?message=Consultation supprimée avec succès');
    } else {
        echo 'Erreur lors de la suppression de la consultation.';
    }
} else {
    echo 'ID de consultation non spécifié.';
}
?>
