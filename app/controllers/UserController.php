<?php
require_once '../config/database.php';
require_once '../app/models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->user = new User($this->db);
    }

    public function listUsers() {
        $result = $this->user->read();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($name, $email, $password, $role) {
        $existingUser = $this->user->findByEmail($email);
        if ($existingUser) {
            echo "L'email est déjà utilisé.";
            return false;
        }
        
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->password = $password;
        $this->user->role = $role;

        if ($this->user->create()) {
            echo "Utilisateur créé avec succès.";
        } else {
            echo "Erreur lors de la création de l'utilisateur.";
        }
    }

    public function updateUser($id, $name, $email, $password, $role) {
        $this->user->id = $id;
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->password = $password;
        $this->user->role = $role;

        if ($this->user->update()) {
            echo "Utilisateur mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour de l'utilisateur.";
        }
    }

    public function deleteUser($id) {
        $this->user->id = $id;

        if ($this->user->delete()) {
            echo "Utilisateur supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression de l'utilisateur.";
        }
    }
}

//$controller = new UserController();
//$controller->createUser('John Doe', 'john@example.com', 'password123', 'patient');
//$controller->listUsers();
//$controller->updateUser(1, 'John Smith', 'johnsmith@example.com', 'newpassword123', 'medecin');
//$controller->deleteUser(1);