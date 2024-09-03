<?php
require_once 'C:\xampp\htdocs\Clinique\app\controllers\AppointmentController.php';

$appointmentController = new AppointmentController();
$patient_id = 1; // Exemple d'ID patient, devrait être dynamiquement défini en fonction du patient connecté

// Gestion de la soumission du formulaire pour la création d'un nouveau rendez-vous
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_appointment'])) {
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];

    $appointmentController->createAppointment($patient_id, $doctor_id, $appointment_date);
}

// Récupération des rendez-vous pour le patient
$appointments = $appointmentController->getAppointmentsByPatientId($patient_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient - Mes Rendez-vous</title>
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
        <h1 class="my-4">Mes Rendez-vous</h1>
        
        <!-- Formulaire pour réserver un nouveau rendez-vous -->
        <h2 class="my-4">Réserver un Nouveau Rendez-vous</h2>
        <form action="patient_appointments.php" method="POST">
            <div class="mb-3">
                <label for="doctor_id" class="form-label">ID Médecin:</label>
                <input type="text" id="doctor_id" name="doctor_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="appointment_date" class="form-label">Date et Heure du Rendez-vous:</label>
                <input type="datetime-local" id="appointment_date" name="appointment_date" class="form-control" required>
            </div>
            <button type="submit" name="create_appointment" class="btn btn-primary">Réserver Rendez-vous</button>
        </form>

        <!-- Afficher la liste des rendez-vous actuels -->
        <h2 class="my-4">Mes Rendez-vous à Venir</h2>
        <?php
        // Vérifie si des rendez-vous ont été récupérés
        if (count($appointments) > 0) {
            echo '<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Médecin</th>
                            <th>Date et Heure</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($appointments as $appointment) {
                echo '<tr>
                        <td>' . htmlspecialchars($appointment['doctor_id']) . '</td>
                        <td>' . htmlspecialchars($appointment['appointment_date']) . '</td>
                    </tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p>Vous n\'avez aucun rendez-vous à venir.</p>';
        }
        ?>
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