<?php
require_once 'C:\xampp\htdocs\Clinique\config\database.php';
require_once 'C:\xampp\htdocs\Clinique\app\controllers\UserController.php';

$database = new Database();
$db = $database->connect();
$userController = new UserController($db);

// Vérifiez que l'ID de l'utilisateur existe dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die('ID utilisateur non spécifié.');
}

// Initialiser la variable $user pour éviter les erreurs
$user = null;

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    if ($userController->updateUser($id, $name, $email, $password, $role)) {
        // Redirection vers la liste des utilisateurs après mise à jour
        header('Location: users.php');
        exit();
    }
} else {
    // Obtenez les informations de l'utilisateur pour les pré-remplir dans le formulaire
    $user = $userController->getUserById($id);
    if (!$user) {
        die('Utilisateur non trouvé.');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour de l'utilisateur</title>
</head>
<body>
    <h1>Mise à jour de l'utilisateur</h1>
    <form action="update_user.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
        <label for="name">Nom:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
        <br>

        <label for="password">Mot de Passe:</label>
        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['password'] ?? ''); ?>" required>
        <br>

        <label for="role">Rôle:</label>
        <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($user['role'] ?? ''); ?>" required>
        <br>

        <input type="submit" value="Mettre à jour">
    </form>
</body>
</html>
