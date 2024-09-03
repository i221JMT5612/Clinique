<?php
require_once 'C:\xampp\htdocs\Clinique\config\database.php';
require_once 'C:\xampp\htdocs\Clinique\app\controllers\UserController.php';
include_once 'C:\xampp\htdocs\Clinique\app\templates\header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new UserController();
    $controller->createUser($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role']);
}
?>

<h2>Créer un Nouvel Utilisateur</h2>
<form action="create_user.php" method="POST">
    <label for="name">Nom:</label>
    <input type="text" name="name" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <br>
    <label for="password">Mot de passe:</label>
    <input type="password" name="password" required>
    <br>
    <label for="role">Rôle:</label>
    <select name="role">
        <option value="patient">Patient</option>
        <option value="medecin">Médecin</option>
        <option value="admin">Administrateur</option>
    </select>
    <br>
    <button type="submit">Créer l'Utilisateur</button>
</form>