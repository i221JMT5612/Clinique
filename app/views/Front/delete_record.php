<?php
require_once 'C:\xampp\htdocs\Clinique\config\database.php';
require_once 'C:\xampp\htdocs\Clinique\app\controllers\MedicalRecordController.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->connect();
    $controller = new MedicalRecordController($db);

    if ($controller->deleteRecord($id)) {
        header('Location: medical_records.php?message=deleted');
        exit;
    } else {
        header('Location: medical_records.php?message=error');
        exit;
    }
} else {
    header('Location: medical_records.php');
    exit;
}
?>
