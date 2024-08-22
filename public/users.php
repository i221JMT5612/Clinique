<?php
require_once '../config/database.php';
require_once '../app/controllers/UserController.php';
include_once '../app/templates/header.php';

$controller = new UserController();
$users = $controller->listUsers(); // Récupère la liste des utilisateurs

?>

<h2>Liste des Utilisateurs</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td>
                    <a href="update_user.php?id=<?php echo $user['id']; ?>">Modifier</a>
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
include_once '../app/templates/footer.php';
?>