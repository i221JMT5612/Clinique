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

    public function getUserById($id) {
        return $this->user->findById($id);
    }
    
    public function getAllUsers($role = null) {
        $query = 'SELECT * FROM users';
        if ($role) {
            $query .= ' WHERE role = :role';
        }
        $stmt = $this->db->prepare($query);
        if ($role) {
            $stmt->bindParam(':role', $role);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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