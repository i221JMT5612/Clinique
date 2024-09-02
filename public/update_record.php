<?php
require_once '../config/database.php';
require_once '../app/controllers/MedicalRecordController.php';
require_once '../app/controllers/UserController.php';
include_once '../app/templates/header.php';

$database = new Database();
$db = $database->connect();

$medicalRecordController = new MedicalRecordController($db);
$userController = new UserController($db);

// Vérifiez que l'ID du dossier médical est spécifié dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die('ID du dossier médical non spécifié.');
}

// Obtenez les informations du dossier médical pour les pré-remplir dans le formulaire
$record = $medicalRecordController->getRecordById($id);
if (!$record) {
    die('Dossier médical non trouvé.');
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
    $doctor_id = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : '';
    $diagnosis = isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '';
    $treatment = isset($_POST['treatment']) ? $_POST['treatment'] : '';

    // Validation des IDs
    $patient = $userController->getUserById($patient_id);
    $doctor = $userController->getUserById($doctor_id);

    if (!$patient || !$doctor) {
        echo "L'ID du patient ou du médecin est invalide.";
    } else {
        if ($medicalRecordController->updateRecord($id, $patient_id, $doctor_id, $diagnosis, $treatment)) {
            header("Location: medical_records.php");
            exit();
        } else {
            echo "Erreur lors de la mise à jour du dossier médical.";
        }
    }
}
?>

<h2>Mettre à jour le Dossier Médical</h2>
<form action="update_record.php?id=<?php echo $id; ?>" method="POST">
    <label for="patient_id">Patient ID:</label>
    <input type="text" id="patient_id" name="patient_id" value="<?php echo htmlspecialchars($record['patient_id']); ?>" required>
    <br>

    <label for="doctor_id">Doctor ID:</label>
    <input type="text" id="doctor_id" name="doctor_id" value="<?php echo htmlspecialchars($record['doctor_id']); ?>" required>
    <br>

    <label for="diagnosis">Diagnostic:</label>
    <textarea id="diagnosis" name="diagnosis" required><?php echo htmlspecialchars($record['diagnosis']); ?></textarea>
    <br>

    <label for="treatment">Traitement:</label>
    <textarea id="treatment" name="treatment" required><?php echo htmlspecialchars($record['treatment']); ?></textarea>
    <br>

    <input type="submit" value="Mettre à jour">
</form>

<?php
include_once '../app/templates/footer.php';
?>
