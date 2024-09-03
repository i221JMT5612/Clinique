<?php
require_once 'C:\xampp\htdocs\Clinique\config\database.php'; 
require_once 'C:\xampp\htdocs\Clinique\app\models\Consultation.php';
require_once 'C:\xampp\htdocs\Clinique\app\models\Patient.php';

// Gestionnaire de base de données
$database = new Database();
$db = $database->connect();

// Obtenir les données des patients et consultations
$consultation = new Consultation($db);
$patient = new Patient($db);

$consultations = $consultation->read()->fetchAll(PDO::FETCH_ASSOC);
$patients = $patient->read()->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Tableau de bord Administrateur</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Tableau de bord Administrateur</h1>
    
        <h2>Rechercher des Patients</h2>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Nom du patient">
            <button type="submit">Rechercher</button>
        </form>

        <h2>Liste des Patients</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?php echo $patient['name']; ?></td>
                        <td><?php echo $patient['email']; ?></td>
                        <td><a href="view_patient.php?id=<?php echo $patient['id']; ?>">Voir</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Statistiques des Consultations</h2>
        <p>Nombre total de consultations : <?php echo count($consultations); ?></p>

    </body>
</html>
