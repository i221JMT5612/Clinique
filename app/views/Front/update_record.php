<?php
require_once 'C:\xampp\htdocs\Clinique\config\database.php';
require_once 'C:\xampp\htdocs\Clinique\app\controllers\MedicalRecordController.php';
require_once 'C:\xampp\htdocs\Clinique\app\controllers\UserController.php';

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
        $message = "L'ID du patient ou du médecin est invalide.";
    } else {
        if ($medicalRecordController->updateRecord($id, $patient_id, $doctor_id, $diagnosis, $treatment)) {
            header("Location: medical_records.php");
            exit();
        } else {
            $message = "Erreur lors de la mise à jour du dossier médical.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <title>Mettre à Jour un Dossier Médical</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h1 class="m-0 text-primary"><i class="far fa-hospital me-3"></i>Klinik</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Docteur</a>
                    <div class="dropdown-menu rounded-0 rounded-bottom m-0">
                        <a href="admin_appointments.php" class="dropdown-item">Rendez-vous</a>
                        <a href="medical_records.php" class="dropdown-item">Dossier Médical</a>
                        <a href="Consultations.php" class="dropdown-item">Consultation</a>
                        <a href="recherches.php" class="dropdown-item">Recherche</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Patient</a>
                    <div class="dropdown-menu rounded-0 rounded-bottom m-0">
                        <a href="patient_appointments.php" class="dropdown-item">Rendez-vous</a>
                        <a href="patient_history.php" class="dropdown-item">Historique</a>
                    </div>
                </div>
                <a href="#" class="nav-item nav-link">Profil</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Main Content Start -->
    <div class="container mt-5">
        <h2 class="my-4">Mettre à Jour le Dossier Médical</h2>

        <?php if (isset($message)) : ?>
            <div class="alert alert-info" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="update_record.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
            <div class="mb-3">
                <label for="patient_id" class="form-label">Patient ID:</label>
                <input type="text" id="patient_id" name="patient_id" class="form-control" value="<?php echo htmlspecialchars($record['patient_id']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="doctor_id" class="form-label">Doctor ID:</label>
                <input type="text" id="doctor_id" name="doctor_id" class="form-control" value="<?php echo htmlspecialchars($record['doctor_id']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="diagnosis" class="form-label">Diagnostic:</label>
                <textarea id="diagnosis" name="diagnosis" class="form-control" required><?php echo htmlspecialchars($record['diagnosis']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="treatment" class="form-label">Traitement:</label>
                <textarea id="treatment" name="treatment" class="form-control" required><?php echo htmlspecialchars($record['treatment']); ?></textarea>
            </div>
            <input type="submit" value="Mettre à jour" class="btn btn-primary">
        </form>

        <!-- Bouton Retour -->
        <a href="medical_records.php" class="btn btn-secondary mt-3">Retour</a>
    </div>
    <!-- Main Content End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Address</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Av. Fethi Zouhir, Cebalat Ben Ammar 2083</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+ 216 54 227 887</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>klinik@sante.tn</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Quick Links</h5>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Newsletter</h5>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">2024 Klinik</a>. All Right Reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>