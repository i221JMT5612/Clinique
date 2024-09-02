<?php
require_once '../app/controllers/UserController.php';

$userController = new UserController();

if (isset($_GET['id'])) {
    $userController->deleteUser($_GET['id']);
    header('Location: users.php');
}
?>
