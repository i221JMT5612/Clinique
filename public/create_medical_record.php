<?php
require_once '../config/database.php';
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/MedicalRecordController.php';
include_once '../app/templates/header.php';

$database = new Database();
$db = $database->connect();
$userController = new UserController($db);
$medicalRecordController = new MedicalRecordController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $diagnosis = $_POST['diagnosis'];
    $treatment = $_POST['treatment'];

    if (!is_numeric($patient_id) || !is_numeric($doctor_id)) {
        echo "Les ID doivent être numériques.";
    } else {
        // Validate existence of IDs in the database
        $patients = $userController->getUserById($patient_id);
        $doctors = $userController->getUserById($doctor_id);

        if (!$patients || !$doctors) {
            echo "L'ID du patient ou du médecin est invalide.";
        } else {
            if ($medicalRecordController->createRecord($patient_id, $doctor_id, $diagnosis, $treatment)) {
                echo "Dossier médical créé avec succès.";
            } else {
                echo "Erreur lors de la création du dossier médical.";
            }
        }
    }
}
?>

<h2>Créer un Dossier Médical</h2>
<form action="create_medical_record.php" method="POST">
    <label for="patient_id">Patient ID:</label>
    <input type="text" id="patient_id" name="patient_id" required>
    <br>

    <label for="doctor_id">Doctor ID:</label>
    <input type="text" id="doctor_id" name="doctor_id" required>
    <br>

    <label for="diagnosis">Diagnostic:</label>
    <textarea id="diagnosis" name="diagnosis" required></textarea>
    <br>

    <label for="treatment">Traitement:</label>
    <textarea id="treatment" name="treatment" required></textarea>
    <br>

    <input type="submit" value="Créer le Dossier Médical">
</form>

<?php
include_once '../app/templates/footer.php';
?>
