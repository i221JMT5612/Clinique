<?php
require_once 'C:\xampp\htdocs\Clinique\app\controllers\UserController.php';

$userController = new UserController();

if (isset($_GET['id'])) {
    $userController->deleteUser($_GET['id']);
    header('Location: users.php');
}
?>
