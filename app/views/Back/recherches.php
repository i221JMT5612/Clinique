<?php
require_once 'C:\xampp\htdocs\Clinique\app\controllers\AppointmentController.php';
require_once 'C:\xampp\htdocs\Clinique\app\controllers\PatientController.php';

// Créer les instances des contrôleurs
$appointmentController = new AppointmentController();
$patientController = new PatientController();

// Gestion des critères de recherche et de tri
$criteria = [];
if (isset($_GET['search_patient'])) {
    $criteria['name'] = $_GET['name'] ?? '';
    $criteria['created_at'] = $_GET['created_at'] ?? '';
}

if (isset($_GET['search_appointment'])) {
    $criteria['patient_id'] = $_GET['patient_id'] ?? '';
    $criteria['doctor_id'] = $_GET['doctor_id'] ?? '';
}

// Recherche et tri des patients
$patients = $patientController->searchAndSortPatients($criteria);
$appointments = $appointmentController->searchAppointments($criteria);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Klinik - Clinic Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h1 class="m-0 text-primary"><i class="far fa-hospital me-3"></i>Klinik</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="users.php" class="nav-item nav-link">Utilisateur</a>
                <a href="statistiques.php" class="nav-item nav-link">Statistique</a>
                <a href="recherches.php" class="nav-item nav-link active">Recherche</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <div class="container mt-5">
        <h2>Recherche et Tri des Patients</h2>
        <form action="recherches.php" method="GET">
            <h3>Rechercher des Patients</h3>
            <div class="mb-3">
                <label for="name" class="form-label">Nom:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($criteria['name'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="created_at" class="form-label">Date d'inscription:</label>
                <input type="date" id="created_at" name="created_at" class="form-control" value="<?php echo htmlspecialchars($criteria['created_at'] ?? ''); ?>">
            </div>
            <button type="submit" name="search_patient" class="btn btn-primary">Rechercher Patients</button>
        </form>
        <br>
        <br>
        <h3>Résultats de la Recherche des Patients</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Date d'inscription</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($patients)): ?>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($patient['id']); ?></td>
                            <td><?php echo htmlspecialchars($patient['name']); ?></td>
                            <td><?php echo htmlspecialchars($patient['email']); ?></td>
                            <td><?php echo htmlspecialchars($patient['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Aucun patient trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br>
        <br>
        <h2>Recherche et Tri des Consultations</h2>
        <form action="recherches.php" method="GET">
            <h3>Rechercher des Consultations</h3>
            <div class="mb-3">
                <label for="patient_id" class="form-label">ID Patient:</label>
                <input type="text" id="patient_id" name="patient_id" class="form-control" value="<?php echo htmlspecialchars($criteria['patient_id'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="doctor_id" class="form-label">ID Médecin:</label>
                <input type="text" id="doctor_id" name="doctor_id" class="form-control" value="<?php echo htmlspecialchars($criteria['doctor_id'] ?? ''); ?>">
            </div>
            <button type="submit" name="search_appointment" class="btn btn-primary">Rechercher Consultations</button>
        </form>
        <br>
        <br>
        <h3>Résultats de la Recherche des Consultations</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Patient</th>
                    <th>ID Médecin</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($appointments)): ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['id']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['patient_id']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['doctor_id']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Aucune consultation trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer mt-5 pt-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Address</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Av. Fethi Zouhir, Cebalat Ben Ammar 2083</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+ 216 54 227 887</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>klinik@sante.tn</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social rounded-circle" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href="#"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Quick Links</h5>
                    <a class="btn btn-link" href="#">About Us</a>
                    <a class="btn btn-link" href="#">Contact Us</a>
                    <a class="btn btn-link" href="#">Our Services</a>
                    <a class="btn btn-link" href="#">Terms & Condition</a>
                    <a class="btn btn-link" href="#">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Newsletter</h5>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary rounded-circle position-absolute top-0 end-0 mt-2 me-2" style="right: 0; top: 0;">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
