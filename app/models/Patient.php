<?php
class Patient {
    private $conn;
    private $table = 'patients';

    public $id;
    public $name;
    public $email;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . '
                  SET name = :name, email = :email';
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . '
                  SET name = :name, email = :email
                  WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function search($keyword) {
        $query = 'SELECT * FROM ' . $this->table . ' 
                  WHERE name LIKE :keyword OR email LIKE :keyword';
        $stmt = $this->conn->prepare($query);
        $keyword = htmlspecialchars(strip_tags($keyword));
        $keyword = "%{$keyword}%";
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        return $stmt;
    }    

    public function searchAndSort($criteria) {
        $query = 'SELECT * FROM patients WHERE 1=1';
        if (!empty($criteria['name'])) {
            $query .= ' AND name LIKE :name';
        }
        if (!empty($criteria['created_at'])) {
            $query .= ' AND created_at LIKE :created_at';
        }
        $query .= ' ORDER BY name, created_at';
        $stmt = $this->conn->prepare($query);
        if (!empty($criteria['name'])) {
            $stmt->bindValue(':name', '%' . $criteria['name'] . '%');
        }
        if (!empty($criteria['created_at'])) {
            $stmt->bindValue(':created_at', $criteria['created_at'] . '%');
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountByMonth() {
        $query = 'SELECT DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(id) as count FROM patients GROUP BY month';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}